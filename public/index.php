<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../src/bootstrap.php';

/*
|--------------------------------------------------------------------------
| Parse URI
|--------------------------------------------------------------------------
*/

$rawPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$path = rtrim($rawPath, '/');
$path = $path === '' ? '/' : $path;
$queryString = $_SERVER['QUERY_STRING'] ?? '';
$lowerPath = strtolower($path);
$hasTrailingSlash = $rawPath !== '/' && str_ends_with($rawPath, '/');

/*
|--------------------------------------------------------------------------
| System routes
|--------------------------------------------------------------------------
*/

if ($path === '/') {
    redirect('/ru/');
}

if ($path === '/sitemap.xml') {
    header('Content-Type: application/xml; charset=utf-8');

    $languages = ['ru', 'en'];
    $urls = [];

    foreach ($languages as $language) {

        // Pages
        $stmt = db()->prepare(
            'SELECT p.slug
             FROM pages p
             JOIN page_translations pt ON pt.page_id = p.id
             WHERE pt.language = ?
               AND pt.indexable = 1
               AND p.status = "published"'
        );
        $stmt->execute([$language]);

        foreach ($stmt->fetchAll() as $page) {
            $urls[] = '/' . $language . '/' . ($page['slug'] === 'home' ? '' : $page['slug'] . '/');
        }

        // Categories
        $stmt = db()->prepare(
            'SELECT c.slug
             FROM categories c
             JOIN category_translations ct ON ct.category_id = c.id
             WHERE ct.language = ?
               AND ct.indexable = 1
               AND c.status = "published"'
        );
        $stmt->execute([$language]);

        foreach ($stmt->fetchAll() as $category) {
            $urls[] = '/' . $language . '/products/' . $category['slug'] . '/';
        }

        // Products
        $stmt = db()->prepare(
            'SELECT p.slug
             FROM products p
             JOIN product_translations pt ON pt.product_id = p.id
             WHERE pt.language = ?
               AND pt.indexable = 1
               AND p.status = "published"'
        );
        $stmt->execute([$language]);

        foreach ($stmt->fetchAll() as $product) {
            $urls[] = '/' . $language . '/product/' . $product['slug'] . '/';
        }
    }

    $urls = array_unique($urls);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($urls as $url) {
        echo '<url><loc>' . htmlspecialchars(config('base_url') . $url, ENT_QUOTES) . '</loc></url>';
    }

    echo '</urlset>';
    exit;
}

if ($path === '/robots.txt') {
    header('Content-Type: text/plain; charset=utf-8');

    echo "User-agent: *\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /ru/products\n";
    echo "Disallow: /en/products\n";
    echo "Sitemap: " . config('base_url') . "/sitemap.xml\n";
    exit;
}

/*
|--------------------------------------------------------------------------
| Reject invalid/system paths
|--------------------------------------------------------------------------
*/

$blockedPrefixes = ['sdk', 'api', 'wp', 'wordpress'];

foreach ($blockedPrefixes as $prefix) {
    if ($lowerPath === '/' . $prefix || str_starts_with($lowerPath, '/' . $prefix . '/')) {
        http_response_code(404);
        echo 'Not Found';
        exit;
    }
}

if (preg_match('/\.php(?:\/|$)/i', $path) === 1) {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

/*
|--------------------------------------------------------------------------
| Split segments
|--------------------------------------------------------------------------
*/

$segments = explode('/', trim($path, '/'));

/*
|--------------------------------------------------------------------------
| Language detection
|--------------------------------------------------------------------------
*/

$language = $segments[0] ?? 'ru';

$allowedLanguages = ['ru', 'en'];

if (!in_array($language, $allowedLanguages, true)) {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

/*
|--------------------------------------------------------------------------
| Normalize language URL (force trailing slash)
|--------------------------------------------------------------------------
*/

if ($path === '/' . $language && !$hasTrailingSlash) {
    redirect('/' . $language . '/');
}

/*
|--------------------------------------------------------------------------
| Cache
|--------------------------------------------------------------------------
*/

$cacheKey = md5($language . '|' . $path . '?' . $queryString);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($cached = cache_get($cacheKey)) {
        echo $cached;
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
*/

$route = $segments[1] ?? '';
$param = $segments[2] ?? null;

/*
|--------------------------------------------------------------------------
| Products index
|--------------------------------------------------------------------------
*/

if ($route === 'products' && $param === null) {

    $stmt = db()->prepare(
        'SELECT c.id, c.slug, ct.name, ct.description, ct.h1, ct.meta_title, ct.meta_description
         FROM categories c
         JOIN category_translations ct ON ct.category_id = c.id
         WHERE ct.language = ?
           AND c.status = "published"'
    );
    $stmt->execute([$language]);

    $page = [
        'title' => t('products.title', $language),
        'h1' => t('products.h1', $language),
        'meta_title' => t('products.meta_title', $language),
        'meta_description' => t('products.meta_description', $language),
        'language' => $language,
        'slug' => 'products',
    ];

    ob_start();
    render('category-index', [
        'language' => $language,
        'page' => $page,
        'categories' => $stmt->fetchAll(),
    ]);
    $content = ob_get_clean();

    cache_put($cacheKey, $content);
    echo $content;
    exit;
}

/*
|--------------------------------------------------------------------------
| Category page
|--------------------------------------------------------------------------
*/

if ($route === 'products' && $param !== null) {

    $stmt = db()->prepare(
        'SELECT c.id, c.slug, ct.*
         FROM categories c
         JOIN category_translations ct ON ct.category_id = c.id
         WHERE c.slug = ?
           AND ct.language = ?
           AND c.status = "published"'
    );
    $stmt->execute([$param, $language]);

    $category = $stmt->fetch();

    if (!$category) {
        http_response_code(404);
        render('404', ['language' => $language]);
        exit;
    }

    $search = trim($_GET['q'] ?? '');
    $sort = $_GET['sort'] ?? 'name';

    $query = '
        SELECT p.id, p.slug, p.sku, pt.name, pt.short_description
        FROM products p
        JOIN product_translations pt ON pt.product_id = p.id
        WHERE p.category_id = ?
          AND pt.language = ?
          AND p.status = "published"
    ';

    $params = [$category['id'], $language];

    if ($search !== '') {
        $query .= ' AND (pt.name LIKE ? OR p.sku LIKE ?)';
        $like = '%' . $search . '%';
        $params[] = $like;
        $params[] = $like;
    }

    $query .= $sort === 'new'
        ? ' ORDER BY p.id DESC'
        : ' ORDER BY pt.name';

    $stmt = db()->prepare($query);
    $stmt->execute($params);

    $products = $stmt->fetchAll();
    $productFacts = [];
    $productIds = array_column($products, 'id');
    if ($productIds) {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $specStmt = db()->prepare(
            "SELECT product_id, label, value, unit
             FROM product_specs
             WHERE language = ?
               AND product_id IN ($placeholders)
             ORDER BY sort_order"
        );
        $specStmt->execute(array_merge([$language], $productIds));
        foreach ($specStmt->fetchAll() as $spec) {
            if (count($productFacts[$spec['product_id']] ?? []) >= 6) {
                continue;
            }
            $productFacts[$spec['product_id']][] = trim($spec['label'] . ': ' . trim($spec['value'] . ' ' . $spec['unit']));
        }
    }

    ob_start();
    render('category-show', [
        'language' => $language,
        'category' => $category,
        'products' => $products,
        'productFacts' => $productFacts,
        'search' => $search,
        'sort' => $sort,
    ]);
    $content = ob_get_clean();

    cache_put($cacheKey, $content);
    echo $content;
    exit;
}

/*
|--------------------------------------------------------------------------
| Product page
|--------------------------------------------------------------------------
*/

if ($route === 'product' && $param !== null) {

    $stmt = db()->prepare(
        'SELECT p.id, p.slug, p.sku, pt.*
         FROM products p
         JOIN product_translations pt ON pt.product_id = p.id
         WHERE p.slug = ?
           AND pt.language = ?
           AND p.status = "published"'
    );
    $stmt->execute([$param, $language]);

    $product = $stmt->fetch();

    if (!$product) {
        http_response_code(404);
        render('404', ['language' => $language]);
        exit;
    }

    $images = db()->prepare(
        'SELECT file_path, alt_text
         FROM product_images
         WHERE product_id = ? AND language = ?
         ORDER BY sort_order'
    );
    $images->execute([$product['id'], $language]);

    $documents = db()->prepare(
        'SELECT d.title, d.file_path
         FROM document_products dp
         JOIN documents d ON d.id = dp.document_id
         WHERE dp.product_id = ?
           AND d.scope = "product"
           AND d.language = ?
           AND d.is_active = 1
         ORDER BY dp.sort_order, d.sort_order'
    );
    $documents->execute([$product['id'], $language]);

    $faqs = db()->prepare(
        'SELECT question, answer
         FROM product_faqs
         WHERE product_id = ? AND language = ?
         ORDER BY sort_order'
    );
    $faqs->execute([$product['id'], $language]);

    $specs = db()->prepare(
        'SELECT label, value, unit, type
         FROM product_specs
         WHERE product_id = ? AND language = ?
         ORDER BY sort_order'
    );
    $specs->execute([$product['id'], $language]);

    $related = db()->prepare(
        'SELECT p.slug, pt.name
         FROM products p
         JOIN product_translations pt ON pt.product_id = p.id
         WHERE p.category_id = (
             SELECT category_id FROM products WHERE id = ?
         )
           AND pt.language = ?
           AND p.id != ?'
    );
    $related->execute([$product['id'], $language, $product['id']]);

    $partners = product_partners((int) $product['id'], $language);

    ob_start();
    render('product-show', [
        'language' => $language,
        'product' => $product,
        'images' => $images->fetchAll(),
        'documents' => $documents->fetchAll(),
        'faqs' => $faqs->fetchAll(),
        'specs' => $specs->fetchAll(),
        'related' => $related->fetchAll(),
        'productPartners' => $partners,
    ]);
    $content = ob_get_clean();

    cache_put($cacheKey, $content);
    echo $content;
    exit;
}

/*
|--------------------------------------------------------------------------
| Static pages
|--------------------------------------------------------------------------
*/

$slug = $route !== '' ? $route : 'home';

$stmt = db()->prepare(
    'SELECT p.id, p.slug, pt.*
     FROM pages p
     JOIN page_translations pt ON pt.page_id = p.id
     WHERE p.slug = ?
       AND pt.language = ?
       AND p.status = "published"'
);
$stmt->execute([$slug, $language]);

$page = $stmt->fetch();

if (!$page) {
    http_response_code(404);
    render('404', ['language' => $language]);
    exit;
}

$blocks = db()->prepare(
    'SELECT block_key, title, body
     FROM page_blocks
     WHERE page_id = ?
       AND language = ?
     ORDER BY sort_order'
);
$blocks->execute([$page['id'], $language]);

ob_start();
render('page', [
    'language' => $language,
    'page' => $page,
    'blocks' => $blocks->fetchAll(),
]);
$content = ob_get_clean();

cache_put($cacheKey, $content);
echo $content;
