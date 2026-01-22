<?php

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ContentService.php';

session_start();

$db = Database::instance()->pdo();
$service = new ContentService($db);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
if ($uri === '') {
    $uri = '/';
}

function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

function render(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);
    include __DIR__ . '/../templates/' . $template . '.php';
}

function adminLoggedIn(): bool
{
    return !empty($_SESSION['admin_id']);
}

function requireAdmin(): void
{
    if (!adminLoggedIn()) {
        redirect('/admin/login');
    }
}

if (strpos($uri, '/admin') === 0) {
    $adminPath = trim(substr($uri, strlen('/admin')), '/');
    $adminPath = $adminPath ?: 'dashboard';

    if ($adminPath === 'login') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $db->prepare('SELECT id, password_hash FROM admins WHERE username = :username');
            $stmt->execute(['username' => $_POST['username'] ?? '']);
            $admin = $stmt->fetch();
            if ($admin && password_verify($_POST['password'] ?? '', $admin['password_hash'])) {
                $_SESSION['admin_id'] = $admin['id'];
                redirect('/admin');
            }
            $error = true;
        }
        render('admin/login', ['error' => $error ?? false]);
        exit;
    }

    if ($adminPath === 'logout') {
        session_destroy();
        redirect('/admin/login');
    }

    requireAdmin();

    if ($adminPath === 'dashboard') {
        $stats = [
            'pages' => (int) $db->query('SELECT COUNT(*) FROM pages')->fetchColumn(),
            'categories' => (int) $db->query('SELECT COUNT(*) FROM categories')->fetchColumn(),
            'products' => (int) $db->query('SELECT COUNT(*) FROM products')->fetchColumn(),
        ];
        render('admin/dashboard', ['stats' => $stats]);
        exit;
    }

    if ($adminPath === 'settings') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['settings'] ?? [] as $lang => $values) {
                foreach ($values as $key => $value) {
                    $stmt = $db->prepare('UPDATE settings SET setting_value = :value WHERE lang = :lang AND setting_key = :key');
                    $stmt->execute(['value' => $value, 'lang' => $lang, 'key' => $key]);
                }
            }
        }
        $settingsRu = $service->getSettings('ru');
        $settingsEn = $service->getSettings('en');
        render('admin/settings', ['settingsRu' => $settingsRu, 'settingsEn' => $settingsEn]);
        exit;
    }

    if ($adminPath === 'pages') {
        $pages = $db->query('SELECT id, slug FROM pages ORDER BY id ASC')->fetchAll();
        render('admin/pages', ['pages' => $pages]);
        exit;
    }

    if (preg_match('#^pages/(\d+)$#', $adminPath, $matches)) {
        $pageId = (int) $matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (['ru', 'en'] as $lang) {
                $payload = $_POST[$lang] ?? [];
                $stmt = $db->prepare(
                    'UPDATE page_translations
                     SET title = :title, h1 = :h1, body = :body, seo_title = :seo_title, seo_description = :seo_description,
                         seo_canonical = :seo_canonical, seo_robots = :seo_robots
                     WHERE page_id = :page_id AND lang = :lang'
                );
                $stmt->execute([
                    'title' => $payload['title'] ?? '',
                    'h1' => $payload['h1'] ?? '',
                    'body' => $payload['body'] ?? '',
                    'seo_title' => $payload['seo_title'] ?? '',
                    'seo_description' => $payload['seo_description'] ?? '',
                    'seo_canonical' => $payload['seo_canonical'] ?? '',
                    'seo_robots' => $payload['seo_robots'] ?? '',
                    'page_id' => $pageId,
                    'lang' => $lang,
                ]);
            }
        }
        $stmt = $db->prepare('SELECT slug FROM pages WHERE id = :id');
        $stmt->execute(['id' => $pageId]);
        $page = $stmt->fetch();
        $stmt = $db->prepare('SELECT * FROM page_translations WHERE page_id = :page_id');
        $stmt->execute(['page_id' => $pageId]);
        $translations = [];
        foreach ($stmt->fetchAll() as $row) {
            $translations[$row['lang']] = $row;
        }
        render('admin/page_edit', ['page' => $page, 'translations' => $translations]);
        exit;
    }

    if ($adminPath === 'categories') {
        $categories = $db->query('SELECT id, slug FROM categories ORDER BY sort_order ASC')->fetchAll();
        render('admin/categories', ['categories' => $categories]);
        exit;
    }

    if (preg_match('#^categories/(\d+)$#', $adminPath, $matches)) {
        $categoryId = (int) $matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (['ru', 'en'] as $lang) {
                $payload = $_POST[$lang] ?? [];
                $stmt = $db->prepare(
                    'UPDATE category_translations
                     SET title = :title, h1 = :h1, description = :description, seo_title = :seo_title,
                         seo_description = :seo_description, seo_robots = :seo_robots
                     WHERE category_id = :category_id AND lang = :lang'
                );
                $stmt->execute([
                    'title' => $payload['title'] ?? '',
                    'h1' => $payload['h1'] ?? '',
                    'description' => $payload['description'] ?? '',
                    'seo_title' => $payload['seo_title'] ?? '',
                    'seo_description' => $payload['seo_description'] ?? '',
                    'seo_robots' => $payload['seo_robots'] ?? '',
                    'category_id' => $categoryId,
                    'lang' => $lang,
                ]);
            }
        }
        $stmt = $db->prepare('SELECT slug FROM categories WHERE id = :id');
        $stmt->execute(['id' => $categoryId]);
        $category = $stmt->fetch();
        $stmt = $db->prepare('SELECT * FROM category_translations WHERE category_id = :category_id');
        $stmt->execute(['category_id' => $categoryId]);
        $translations = [];
        foreach ($stmt->fetchAll() as $row) {
            $translations[$row['lang']] = $row;
        }
        render('admin/category_edit', ['category' => $category, 'translations' => $translations]);
        exit;
    }

    if ($adminPath === 'products') {
        $products = $db->query('SELECT id, slug, sku FROM products ORDER BY sort_order ASC')->fetchAll();
        render('admin/products', ['products' => $products]);
        exit;
    }

    if (preg_match('#^products/(\d+)$#', $adminPath, $matches)) {
        $productId = (int) $matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (['ru', 'en'] as $lang) {
                $payload = $_POST[$lang] ?? [];
                $stmt = $db->prepare(
                    'UPDATE product_translations
                     SET title = :title, h1 = :h1, short_description = :short_description, description = :description,
                         seo_title = :seo_title, seo_description = :seo_description, seo_robots = :seo_robots
                     WHERE product_id = :product_id AND lang = :lang'
                );
                $stmt->execute([
                    'title' => $payload['title'] ?? '',
                    'h1' => $payload['h1'] ?? '',
                    'short_description' => $payload['short_description'] ?? '',
                    'description' => $payload['description'] ?? '',
                    'seo_title' => $payload['seo_title'] ?? '',
                    'seo_description' => $payload['seo_description'] ?? '',
                    'seo_robots' => $payload['seo_robots'] ?? '',
                    'product_id' => $productId,
                    'lang' => $lang,
                ]);
            }
        }
        $stmt = $db->prepare('SELECT slug, sku FROM products WHERE id = :id');
        $stmt->execute(['id' => $productId]);
        $product = $stmt->fetch();
        $stmt = $db->prepare('SELECT * FROM product_translations WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        $translations = [];
        foreach ($stmt->fetchAll() as $row) {
            $translations[$row['lang']] = $row;
        }
        render('admin/product_edit', ['product' => $product, 'translations' => $translations]);
        exit;
    }

    http_response_code(404);
    render('admin/404');
    exit;
}

if ($uri === '/') {
    redirect('/ru/');
}

$segments = array_values(array_filter(explode('/', $uri)));
$lang = $segments[0] ?? 'ru';

if (!in_array($lang, ['ru', 'en'], true)) {
    http_response_code(404);
    $seo = [
        'robots' => 'noindex, nofollow',
        'hreflang' => [],
    ];
    $settings = $service->getSettings('ru');
    $nav = $service->getPagesForNav('ru');
    render('404', ['lang' => 'ru', 'settings' => $settings, 'nav' => $nav, 'seo' => $seo]);
    exit;
}

$route = $segments[1] ?? 'home';
$settings = $service->getSettings($lang);
$nav = $service->getPagesForNav($lang);
$partner = $service->getPartner();

$seo = [
    'title' => '',
    'description' => '',
    'robots' => '',
    'canonical' => '',
    'hreflang' => [
        'ru' => '/ru' . ($uri === '/ru' ? '/' : substr($uri, 3)),
        'en' => '/en' . ($uri === '/en' ? '/' : substr($uri, 3)),
    ],
];

if ($route === 'home') {
    $page = $service->getPageBySlug('home', $lang);
    if (!$page) {
        $seo['robots'] = 'noindex, nofollow';
    } else {
        $seo['title'] = $page['seo_title'] ?: $page['title'];
        $seo['description'] = $page['seo_description'];
        $seo['robots'] = $page['seo_robots'] ?: 'index, follow';
        $seo['canonical'] = $page['seo_canonical'] ?: "/{$lang}/";
    }
    $blocks = $page ? $service->getPageBlocks($page['id'], $lang) : [];
    render('home', [
        'lang' => $lang,
        'settings' => $settings,
        'nav' => $nav,
        'page' => $page,
        'blocks' => $blocks,
        'seo' => $seo,
        'partner' => $partner,
    ]);
    exit;
}

if ($route === 'products' && count($segments) === 2) {
    $page = $service->getPageBySlug('products', $lang);
    $categories = $service->getCategories($lang);
    $seo['title'] = $page['seo_title'] ?? ($page['title'] ?? '');
    $seo['description'] = $page['seo_description'] ?? '';
    $seo['robots'] = $page['seo_robots'] ?? 'index, follow';
    $seo['canonical'] = $page['seo_canonical'] ?? "/{$lang}/products/";
    render('products', [
        'lang' => $lang,
        'settings' => $settings,
        'nav' => $nav,
        'page' => $page,
        'categories' => $categories,
        'seo' => $seo,
        'partner' => $partner,
    ]);
    exit;
}

if ($route === 'products' && isset($segments[2])) {
    $category = $service->getCategoryBySlug($segments[2], $lang);
    if (!$category) {
        $seo['robots'] = 'noindex, nofollow';
        render('404', ['lang' => $lang, 'settings' => $settings, 'nav' => $nav, 'seo' => $seo]);
        exit;
    }
    $products = $service->getProductsByCategory($category['id'], $lang);
    $highlights = $service->getCategoryHighlights($category['id'], $lang);
    $faqs = $service->getFaqs('category', $category['id'], $lang);
    $seo['title'] = $category['seo_title'] ?: $category['title'];
    $seo['description'] = $category['seo_description'];
    $seo['robots'] = $category['seo_robots'] ?: 'index, follow';
    $seo['canonical'] = "/{$lang}/products/{$category['slug']}/";
    render('category', [
        'lang' => $lang,
        'settings' => $settings,
        'nav' => $nav,
        'category' => $category,
        'products' => $products,
        'highlights' => $highlights,
        'faqs' => $faqs,
        'seo' => $seo,
        'partner' => $partner,
    ]);
    exit;
}

if ($route === 'product' && isset($segments[2])) {
    $product = $service->getProductBySlug($segments[2], $lang);
    if (!$product) {
        $seo['robots'] = 'noindex, nofollow';
        render('404', ['lang' => $lang, 'settings' => $settings, 'nav' => $nav, 'seo' => $seo]);
        exit;
    }
    $category = $service->getCategoryById((int) ($product['category_id'] ?? 0), $lang);
    $images = $service->getProductImages($product['id']);
    $specs = $service->getProductSpecs($product['id'], $lang);
    $docs = $service->getProductDocs($product['id'], $lang);
    $faqs = $service->getFaqs('product', $product['id'], $lang);
    $seo['title'] = $product['seo_title'] ?: $product['title'];
    $seo['description'] = $product['seo_description'];
    $seo['robots'] = $product['seo_robots'] ?: 'index, follow';
    $seo['canonical'] = "/{$lang}/product/{$product['slug']}/";
    render('product', [
        'lang' => $lang,
        'settings' => $settings,
        'nav' => $nav,
        'product' => $product,
        'category' => $category,
        'images' => $images,
        'specs' => $specs,
        'docs' => $docs,
        'faqs' => $faqs,
        'partner' => $partner,
        'seo' => $seo,
    ]);
    exit;
}

$page = $service->getPageBySlug($route, $lang);
if (!$page) {
    http_response_code(404);
    render('404', ['lang' => $lang, 'settings' => $settings, 'nav' => $nav, 'seo' => $seo]);
    exit;
}
$blocks = $service->getPageBlocks($page['id'], $lang);
$seo['title'] = $page['seo_title'] ?: $page['title'];
$seo['description'] = $page['seo_description'];
$seo['robots'] = $page['seo_robots'] ?: 'index, follow';
$seo['canonical'] = $page['seo_canonical'] ?: "/{$lang}/{$page['slug']}/";

render('page', [
    'lang' => $lang,
    'settings' => $settings,
    'nav' => $nav,
    'page' => $page,
    'blocks' => $blocks,
    'seo' => $seo,
    'partner' => $partner,
]);
