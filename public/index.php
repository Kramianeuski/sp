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
        $stmt = db()->prepare(
            'SELECT p.slug AS page_slug, sm.slug AS seo_slug
             FROM pages p
             JOIN seo_meta sm ON sm.entity_type = "page" AND sm.entity_id = p.id AND sm.locale = ?
             WHERE p.status = "published"'
        );
        $stmt->execute([$language]);

        foreach ($stmt->fetchAll() as $page) {
            $slug = $page['seo_slug'] ?: $page['page_slug'];
            $urls[] = '/' . $language . '/' . ($slug === 'home' ? '' : $slug . '/');
        }

        $stmt = db()->prepare(
            'SELECT c.id, sm.slug
             FROM categories c
             JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ?
             WHERE c.is_active = 1'
        );
        $stmt->execute([$language]);

        foreach ($stmt->fetchAll() as $category) {
            $urls[] = '/' . $language . '/products/' . $category['slug'] . '/';
        }

        $stmt = db()->prepare(
            'SELECT p.id, sm.slug AS product_slug
             FROM products p
             JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ?
             WHERE p.is_active = 1'
        );
        $stmt->execute([$language]);

        foreach ($stmt->fetchAll() as $product) {
            $urls[] = '/' . $language . '/product/' . $product['product_slug'] . '/';
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
    echo "Allow: /\n";
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

$route = $segments[1] ?? '';
$param = $segments[2] ?? null;
$subparam = $segments[3] ?? null;

/*
|--------------------------------------------------------------------------
| Lead form handling
|--------------------------------------------------------------------------
*/

if ($route === 'custom-production' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $fullName = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telegram = trim($_POST['telegram'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $channels = [];
    foreach (['phone', 'telegram', 'whatsapp', 'email'] as $channel) {
        if (isset($_POST['channel_' . $channel])) {
            $channels[] = $channel;
        }
    }
    $preferredContact = implode(',', $channels);
    $message = trim($_POST['message'] ?? '');
    $consent = isset($_POST['consent']) ? 1 : 0;
    $honeypot = trim($_POST['website'] ?? '');
    $captchaAnswer = trim($_POST['captcha_answer'] ?? '');
    $captchaExpected = $_SESSION['captcha_answer'] ?? null;

    if ($honeypot !== '') {
        $errors['form'] = t('form.error.spam', $language);
    }

    if (!$consent) {
        $errors['consent'] = t('form.error.consent', $language);
    }

    if ($fullName === '') {
        $errors['full_name'] = t('form.error.full_name', $language);
    }

    if ($email === '') {
        $errors['email'] = t('form.error.email_required', $language);
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = t('form.error.email', $language);
    }

    if (empty($channels)) {
        $errors['channels'] = t('form.error.contact', $language);
    }

    if (in_array('phone', $channels, true) && $phone === '') {
        $errors['phone'] = t('form.error.contact', $language);
    }

    if (in_array('whatsapp', $channels, true) && $whatsapp === '') {
        $errors['whatsapp'] = t('form.error.contact', $language);
    }

    if (in_array('telegram', $channels, true)) {
        if ($telegram === '') {
            $errors['telegram'] = t('form.error.contact', $language);
        } elseif (!str_starts_with($telegram, '@')) {
            $errors['telegram'] = t('form.error.telegram', $language);
        }
    }

    if ($message === '') {
        $errors['message'] = t('form.error.message', $language);
    }

    if ($captchaExpected === null || $captchaAnswer === '' || (int) $captchaAnswer !== (int) $captchaExpected) {
        $errors['captcha'] = t('form.error.captcha', $language);
    }

    $lastLeadTime = $_SESSION['last_lead_time'] ?? 0;
    if (time() - (int) $lastLeadTime < 20) {
        $errors['form'] = t('form.error.rate_limit', $language);
    }

    if (empty($errors)) {
        $stmt = db()->prepare(
            'INSERT INTO leads (type, full_name, company, phone, email, telegram, whatsapp, preferred_contact, message, status, created_at)
             VALUES ("custom_production", ?, ?, ?, ?, ?, ?, ?, ?, "new", NOW())'
        );
        $stmt->execute([
            $fullName,
            null,
            $phone ?: null,
            $email ?: null,
            $telegram ?: null,
            $whatsapp ?: null,
            $preferredContact,
            $message,
        ]);
        $_SESSION['last_lead_time'] = time();
        $_SESSION['lead_success'] = true;
        redirect('/' . $language . '/custom-production/');
    }

    $_SESSION['lead_errors'] = $errors;
    $_SESSION['lead_old'] = [
        'full_name' => $fullName,
        'phone' => $phone,
        'email' => $email,
        'telegram' => $telegram,
        'whatsapp' => $whatsapp,
        'channels' => $channels,
        'message' => $message,
        'consent' => $consent,
    ];
    redirect('/' . $language . '/custom-production/');
}

/*
|--------------------------------------------------------------------------
| Products index
|--------------------------------------------------------------------------
*/

if ($route === 'products' && $param === null) {
    $stmt = db()->prepare(
        'SELECT c.id, c.code, ci.name, ci.description, sm.slug
         FROM categories c
         JOIN category_i18n ci ON ci.category_id = c.id AND ci.locale = ?
         JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ?
         WHERE c.is_active = 1
         ORDER BY c.id'
    );
    $stmt->execute([$language, $language]);

    $pageStmt = db()->prepare('SELECT id FROM pages WHERE slug = "products" LIMIT 1');
    $pageStmt->execute();
    $pageId = (int) $pageStmt->fetchColumn();
    $seo = [];
    if ($pageId) {
        $seoStmt = db()->prepare('SELECT * FROM seo_meta WHERE entity_type = "page" AND entity_id = ? AND locale = ?');
        $seoStmt->execute([$pageId, $language]);
        $seo = $seoStmt->fetch() ?: [];
    }

    $page = [
        'title' => $seo['title'] ?? t('products.title', $language),
        'h1' => $seo['h1'] ?? t('products.title', $language),
        'meta_title' => $seo['title'] ?? t('products.title', $language),
        'meta_description' => $seo['description'] ?? t('products.text', $language),
        'canonical' => $seo['canonical'] ?? (config('base_url') . '/' . $language . '/products/'),
        'og_title' => $seo['og_title'] ?? ($seo['title'] ?? ''),
        'og_description' => $seo['og_description'] ?? ($seo['description'] ?? ''),
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

if ($route === 'products' && $param !== null && $subparam === null) {
    $stmt = db()->prepare(
        'SELECT c.id, c.code, ci.name, ci.description, ci.is_html, sm.title, sm.description AS meta_description, sm.h1, sm.slug
         FROM categories c
         JOIN category_i18n ci ON ci.category_id = c.id AND ci.locale = ?
         JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ?
         WHERE sm.slug = ?
           AND c.is_active = 1'
    );
    $stmt->execute([$language, $language, $param]);
    $category = $stmt->fetch();

    if (!$category) {
        $productStmt = db()->prepare(
            'SELECT sm.slug
             FROM products p
             JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ?
             WHERE sm.slug = ?
               AND p.is_active = 1'
        );
        $productStmt->execute([$language, $param]);
        $productSlug = $productStmt->fetchColumn();
        if ($productSlug) {
            redirect('/' . $language . '/product/' . $productSlug . '/', 301);
        }
        http_response_code(404);
        render('404', ['language' => $language]);
        exit;
    }

    $search = trim($_GET['q'] ?? '');
    $sort = $_GET['sort'] ?? 'name';
    $filters = $_GET['filters'] ?? [];
    if (!is_array($filters)) {
        $filters = [];
    }

    $query = '
        SELECT p.id, p.sku, pi.name, pi.short_description, sm.slug
        FROM products p
        JOIN product_i18n pi ON pi.product_id = p.id AND pi.locale = ?
        JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ?
        WHERE p.category_id = ?
          AND p.is_active = 1
    ';

    $params = [$language, $language, $category['id']];

    if ($search !== '') {
        $query .= ' AND (pi.name LIKE ? OR p.sku LIKE ?)';
        $like = '%' . $search . '%';
        $params[] = $like;
        $params[] = $like;
    }

    $activeFilters = [];
    foreach ($filters as $specKey => $values) {
        if (!is_array($values)) {
            $values = [$values];
        }
        $values = array_values(array_filter(array_map('trim', $values), static fn($value) => $value !== ''));
        if (!$values) {
            continue;
        }
        $activeFilters[$specKey] = $values;
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $query .= " AND EXISTS (\n            SELECT 1 FROM product_specs psf\n            JOIN product_specs_i18n psfi ON psfi.product_spec_id = psf.id AND psfi.locale = ?\n            WHERE psf.product_id = p.id\n              AND psf.spec_key = ?\n              AND psfi.value IN ($placeholders)\n        )";
        $params[] = $language;
        $params[] = $specKey;
        array_push($params, ...$values);
    }

    $query .= $sort === 'new'
        ? ' ORDER BY p.id DESC'
        : ' ORDER BY pi.name';

    $stmt = db()->prepare($query);
    $stmt->execute($params);

    $products = $stmt->fetchAll();
    $productFacts = [];
    $productIds = array_column($products, 'id');
    $productImages = [];
    if ($productIds) {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $specStmt = db()->prepare(
            "SELECT ps.product_id, psi.name, psi.value
             FROM product_specs ps
             JOIN product_specs_i18n psi ON psi.product_spec_id = ps.id AND psi.locale = ?
             WHERE ps.product_id IN ($placeholders)
             ORDER BY ps.sort_order"
        );
        $specStmt->execute(array_merge([$language], $productIds));
        foreach ($specStmt->fetchAll() as $spec) {
            if (count($productFacts[$spec['product_id']] ?? []) >= 6) {
                continue;
            }
            $productFacts[$spec['product_id']][] = trim($spec['name'] . ': ' . $spec['value']);
        }

        $mediaStmt = db()->prepare(
            "SELECT pm.product_id, m.path, m.alt_key
             FROM product_media pm
             JOIN media m ON m.id = pm.media_id
             WHERE pm.product_id IN ($placeholders)
             ORDER BY pm.is_primary DESC, pm.sort_order ASC"
        );
        $mediaStmt->execute($productIds);
        foreach ($mediaStmt->fetchAll() as $media) {
            if (!isset($productImages[$media['product_id']])) {
                $productImages[$media['product_id']] = $media;
            }
        }
    }

    $availableFilters = [];
    $specListStmt = db()->prepare(
        'SELECT ps.spec_key, psi.name, psi.value
         FROM product_specs ps
         JOIN product_specs_i18n psi ON psi.product_spec_id = ps.id AND psi.locale = ?
         JOIN products p ON p.id = ps.product_id
         WHERE p.category_id = ?
           AND p.is_active = 1
         ORDER BY psi.name, psi.value'
    );
    $specListStmt->execute([$language, $category['id']]);
    foreach ($specListStmt->fetchAll() as $row) {
        $specKey = $row['spec_key'];
        if (!isset($availableFilters[$specKey])) {
            $availableFilters[$specKey] = [
                'name' => $row['name'],
                'values' => [],
            ];
        }
        if (!in_array($row['value'], $availableFilters[$specKey]['values'], true)) {
            $availableFilters[$specKey]['values'][] = $row['value'];
        }
    }

    ob_start();
    render('category-show', [
        'language' => $language,
        'page' => [
            'title' => $category['title'] ?? $category['name'],
            'h1' => $category['h1'] ?? $category['name'],
            'meta_title' => $category['title'] ?? $category['name'],
            'meta_description' => $category['meta_description'] ?? $category['description'],
            'canonical' => config('base_url') . '/' . $language . '/products/' . $category['slug'] . '/',
            'robots' => 'index,follow',
            'og_title' => $category['title'] ?? $category['name'],
            'og_description' => $category['meta_description'] ?? $category['description'],
            'slug' => $category['slug'],
        ],
        'category' => $category,
        'products' => $products,
        'productFacts' => $productFacts,
        'productImages' => $productImages,
        'availableFilters' => $availableFilters,
        'activeFilters' => $activeFilters,
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
| Legacy product URL redirect
|--------------------------------------------------------------------------
*/

if ($route === 'products' && $param !== null && $subparam !== null) {
    $stmt = db()->prepare(
        'SELECT sm.slug
         FROM products p
         JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ?
         WHERE sm.slug = ?
           AND p.is_active = 1'
    );
    $stmt->execute([$language, $subparam]);
    $productSlug = $stmt->fetchColumn();
    if ($productSlug) {
        redirect('/' . $language . '/product/' . $productSlug . '/', 301);
    }
    http_response_code(404);
    render('404', ['language' => $language]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Product page (new URL)
|--------------------------------------------------------------------------
*/

if ($route === 'product' && $param !== null && $subparam === null) {
    $stmt = db()->prepare(
        'SELECT p.id, p.sku, p.category_id, pi.name, pi.short_description, pi.description, pi.is_html, sm.title, sm.description AS meta_description, sm.h1, sm.slug
         FROM products p
         JOIN product_i18n pi ON pi.product_id = p.id AND pi.locale = ?
         JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ?
         WHERE sm.slug = ?
           AND p.is_active = 1'
    );
    $stmt->execute([$language, $language, $param]);
    $product = $stmt->fetch();

    if (!$product) {
        http_response_code(404);
        render('404', ['language' => $language]);
        exit;
    }

    $product['display_name'] = format_product_name($product['name'], $product['sku'] ?? null);
    $product['title'] = $product['display_name'];
    $product['h1'] = $product['display_name'];
    $product['short_description'] = clean_product_text($product['short_description'] ?? '');
    $product['description'] = clean_product_text($product['description'] ?? '');

    $categoryStmt = db()->prepare(
        'SELECT c.id, c.code, ci.name, sm.slug
         FROM categories c
         JOIN category_i18n ci ON ci.category_id = c.id AND ci.locale = ?
         JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ?
         WHERE c.id = ?'
    );
    $categoryStmt->execute([$language, $language, $product['category_id']]);
    $category = $categoryStmt->fetch();

    $images = db()->prepare(
        'SELECT m.path, m.alt_key
         FROM product_media pm
         JOIN media m ON m.id = pm.media_id
         WHERE pm.product_id = ?
         ORDER BY pm.sort_order'
    );
    $images->execute([$product['id']]);

    $specs = db()->prepare(
        'SELECT psi.name, psi.value
         FROM product_specs ps
         JOIN product_specs_i18n psi ON psi.product_spec_id = ps.id AND psi.locale = ?
         WHERE ps.product_id = ?
         ORDER BY ps.sort_order'
    );
    $specs->execute([$language, $product['id']]);

    $slugStmt = db()->prepare('SELECT locale, slug FROM seo_meta WHERE entity_type = "product" AND entity_id = ? AND locale IN ("ru", "en")');
    $slugStmt->execute([$product['id']]);
    $slugs = ['ru' => $product['slug'], 'en' => $product['slug']];
    foreach ($slugStmt->fetchAll() as $row) {
        $slugs[$row['locale']] = $row['slug'];
    }

    ob_start();
    render('product-show', [
        'language' => $language,
        'page' => [
            'title' => $product['title'] ?? $product['display_name'],
            'h1' => $product['h1'] ?? $product['display_name'],
            'meta_title' => $product['title'] ?? $product['display_name'],
            'meta_description' => $product['meta_description'] ?? $product['short_description'],
            'canonical' => config('base_url') . '/' . $language . '/product/' . $product['slug'] . '/',
            'og_title' => $product['title'] ?? $product['display_name'],
            'og_description' => $product['meta_description'] ?? $product['short_description'],
            'slug' => $product['slug'],
            'hreflang' => [
                'ru' => '/ru/product/' . $slugs['ru'] . '/',
                'en' => '/en/product/' . $slugs['en'] . '/',
            ],
        ],
        'category' => $category,
        'product' => $product,
        'images' => $images->fetchAll(),
        'specs' => $specs->fetchAll(),
        'partnerLinks' => product_partner_links((int) $product['id'], $language),
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
    'SELECT p.id, p.slug, p.status
     FROM pages p
     WHERE p.slug = ?
       AND p.status = "published"'
);
$stmt->execute([$slug]);

$page = $stmt->fetch();

if (!$page) {
    http_response_code(404);
    render('404', ['language' => $language]);
    exit;
}

$seoStmt = db()->prepare('SELECT * FROM seo_meta WHERE entity_type = "page" AND entity_id = ? AND locale = ?');
$seoStmt->execute([$page['id'], $language]);
$seo = $seoStmt->fetch() ?: [];

$pageData = [
    'id' => $page['id'],
    'slug' => $page['slug'],
    'title' => $seo['title'] ?? '',
    'h1' => $seo['h1'] ?? '',
    'meta_title' => $seo['title'] ?? '',
    'meta_description' => $seo['description'] ?? '',
    'canonical' => $seo['canonical'] ?? '',
    'og_title' => $seo['og_title'] ?? $seo['title'] ?? '',
    'og_description' => $seo['og_description'] ?? $seo['description'] ?? '',
    'og_image_id' => $seo['og_image_id'] ?? null,
];

$sectionsStmt = db()->prepare(
    'SELECT section_key, template, data_json
     FROM page_sections
     WHERE page_id = ?
     ORDER BY sort_order'
);
$sectionsStmt->execute([$page['id']]);

$sections = $sectionsStmt->fetchAll();

if ($page['slug'] === 'custom-production') {
    $a = random_int(2, 9);
    $b = random_int(2, 9);
    $_SESSION['captcha_answer'] = $a + $b;
    $captchaPrompt = $a . ' + ' . $b;
} else {
    $captchaPrompt = null;
}

ob_start();
render('page', [
    'language' => $language,
    'page' => $pageData,
    'sections' => $sections,
    'captchaPrompt' => $captchaPrompt,
]);
$content = ob_get_clean();

cache_put($cacheKey, $content);
echo $content;
