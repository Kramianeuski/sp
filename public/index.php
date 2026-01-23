<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../src/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

if ($path === '/') {
    redirect('/ru/');
}

if ($path === '/sitemap.xml') {
    header('Content-Type: application/xml; charset=utf-8');
    $languages = ['ru', 'en'];
    $urls = [];
    foreach ($languages as $language) {
        $pages = db()->prepare('SELECT p.slug FROM pages p JOIN page_translations pt ON pt.page_id = p.id WHERE pt.language = ? AND pt.indexable = 1');
        $pages->execute([$language]);
        foreach ($pages->fetchAll() as $page) {
            $urls[] = '/' . $language . '/' . ($page['slug'] === 'home' ? '' : $page['slug'] . '/');
        }
        $categories = db()->prepare('SELECT c.slug FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE ct.language = ? AND ct.indexable = 1');
        $categories->execute([$language]);
        foreach ($categories->fetchAll() as $category) {
            $urls[] = '/' . $language . '/products/' . $category['slug'] . '/';
        }
        $products = db()->prepare('SELECT p.slug FROM products p JOIN product_translations pt ON pt.product_id = p.id WHERE pt.language = ? AND pt.indexable = 1');
        $products->execute([$language]);
        foreach ($products->fetchAll() as $product) {
            $urls[] = '/' . $language . '/product/' . $product['slug'] . '/';
        }
    }

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
    echo "Disallow: /ru/products/?\n";
    echo "Disallow: /en/products/?\n";
    echo "Sitemap: " . config('base_url') . "/sitemap.xml\n";
    exit;
}

$cacheKey = md5($path);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cached = cache_get($cacheKey);
    if ($cached) {
        echo $cached;
        exit;
    }
}

$language = current_language($path);
$segments = array_values(array_filter(explode('/', trim($path, '/'))));

if (count($segments) === 1 && ($segments[0] === 'ru' || $segments[0] === 'en') && $path !== '/' . $segments[0] . '/') {
    redirect('/' . $language . '/');
}

if ($segments[1] ?? '' === 'products' && !isset($segments[2])) {
    $stmt = db()->prepare('SELECT c.id, c.slug, ct.name, ct.description, ct.h1, ct.meta_title, ct.meta_description FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE ct.language = ?');
    $stmt->execute([$language]);
    $categories = $stmt->fetchAll();

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
        'categories' => $categories,
    ]);
    $content = ob_get_clean();
    cache_put($cacheKey, $content);
    echo $content;
    exit;
}

if ($segments[1] ?? '' === 'products' && isset($segments[2])) {
    $slug = $segments[2];
    $stmt = db()->prepare('SELECT c.id, c.slug, ct.name, ct.description, ct.h1, ct.meta_title, ct.meta_description, ct.seo_text, ct.official_seller, ct.faq FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE c.slug = ? AND ct.language = ?');
    $stmt->execute([$slug, $language]);
    $category = $stmt->fetch();
    if (!$category) {
        http_response_code(404);
        render('404', ['language' => $language]);
        exit;
    }

    $products = db()->prepare('SELECT p.id, p.slug, pt.name, pt.short_description FROM products p JOIN product_translations pt ON pt.product_id = p.id WHERE p.category_id = ? AND pt.language = ?');
    $products->execute([$category['id'], $language]);

    ob_start();
    render('category-show', [
        'language' => $language,
        'category' => $category,
        'products' => $products->fetchAll(),
    ]);
    $content = ob_get_clean();
    cache_put($cacheKey, $content);
    echo $content;
    exit;
}

if ($segments[1] ?? '' === 'product' && isset($segments[2])) {
    $slug = $segments[2];
    $stmt = db()->prepare('SELECT p.id, p.slug, p.sku, pt.name, pt.short_description, pt.description, pt.meta_title, pt.meta_description, pt.h1 FROM products p JOIN product_translations pt ON pt.product_id = p.id WHERE p.slug = ? AND pt.language = ?');
    $stmt->execute([$slug, $language]);
    $product = $stmt->fetch();
    if (!$product) {
        http_response_code(404);
        render('404', ['language' => $language]);
        exit;
    }

    $images = db()->prepare('SELECT file_path, alt_text FROM product_images WHERE product_id = ? AND language = ? ORDER BY sort_order');
    $images->execute([$product['id'], $language]);

    $documents = db()->prepare('SELECT title, file_path FROM product_documents WHERE product_id = ? AND language = ? ORDER BY sort_order');
    $documents->execute([$product['id'], $language]);

    $faqs = db()->prepare('SELECT question, answer FROM product_faqs WHERE product_id = ? AND language = ? ORDER BY sort_order');
    $faqs->execute([$product['id'], $language]);

    $specs = db()->prepare('SELECT label, value, unit, type FROM product_specs WHERE product_id = ? AND language = ? ORDER BY sort_order');
    $specs->execute([$product['id'], $language]);

    $related = db()->prepare('SELECT p.slug, pt.name FROM products p JOIN product_translations pt ON pt.product_id = p.id WHERE p.category_id = (SELECT category_id FROM products WHERE id = ?) AND pt.language = ? AND p.id != ?');
    $related->execute([$product['id'], $language, $product['id']]);

    ob_start();
    render('product-show', [
        'language' => $language,
        'product' => $product,
        'images' => $images->fetchAll(),
        'documents' => $documents->fetchAll(),
        'faqs' => $faqs->fetchAll(),
        'specs' => $specs->fetchAll(),
        'related' => $related->fetchAll(),
    ]);
    $content = ob_get_clean();
    cache_put($cacheKey, $content);
    echo $content;
    exit;
}

$slug = $segments[1] ?? 'home';
if ($slug === '') {
    $slug = 'home';
}

$stmt = db()->prepare('SELECT p.id, p.slug, pt.title, pt.h1, pt.meta_title, pt.meta_description, pt.canonical, pt.robots, pt.og_title, pt.og_description, pt.indexable FROM pages p JOIN page_translations pt ON pt.page_id = p.id WHERE p.slug = ? AND pt.language = ?');
$stmt->execute([$slug, $language]);
$page = $stmt->fetch();
if (!$page) {
    http_response_code(404);
    render('404', ['language' => $language]);
    exit;
}

$blocks = db()->prepare('SELECT block_key, title, body FROM page_blocks WHERE page_id = ? AND language = ? ORDER BY sort_order');
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
