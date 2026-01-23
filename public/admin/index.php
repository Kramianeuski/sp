<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../../src/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/admin';
$path = rtrim($path, '/');

if ($path === '/admin') {
    redirect('/admin/pages');
}

if ($path === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    render_partial('admin/login', ['language' => 'ru']);
    exit;
}

if ($path === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('SELECT id, password_hash FROM admins WHERE username = ?');
    $stmt->execute([$_POST['username'] ?? '']);
    $admin = $stmt->fetch();
    if ($admin && password_verify($_POST['password'] ?? '', $admin['password_hash'])) {
        $_SESSION[config('admin.session_key')] = $admin['id'];
        redirect('/admin/pages');
    }

    render_partial('admin/login', ['language' => 'ru', 'error' => t('admin.login_failed', 'ru')]);
    exit;
}

if ($path === '/admin/logout') {
    unset($_SESSION[config('admin.session_key')]);
    redirect('/admin/login');
}

require_admin();

if ($path === '/admin/pages') {
    $stmt = db()->query('SELECT p.id, p.slug, pt.language, pt.h1 FROM pages p JOIN page_translations pt ON pt.page_id = p.id ORDER BY p.id, pt.language');
    $pages = $stmt->fetchAll();
    render_partial('admin/pages', ['pages' => $pages]);
    exit;
}

if ($path === '/admin/pages/edit' && isset($_GET['id'], $_GET['lang'])) {
    $stmt = db()->prepare('SELECT p.id, p.slug, pt.* FROM pages p JOIN page_translations pt ON pt.page_id = p.id WHERE p.id = ? AND pt.language = ?');
    $stmt->execute([$_GET['id'], $_GET['lang']]);
    $page = $stmt->fetch();
    if (!$page) {
        redirect('/admin/pages');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE page_translations SET title = ?, h1 = ?, meta_title = ?, meta_description = ?, canonical = ?, robots = ?, og_title = ?, og_description = ?, indexable = ? WHERE id = ?');
        $update->execute([
            $_POST['title'] ?? '',
            $_POST['h1'] ?? '',
            $_POST['meta_title'] ?? '',
            $_POST['meta_description'] ?? '',
            $_POST['canonical'] ?? '',
            $_POST['robots'] ?? '',
            $_POST['og_title'] ?? '',
            $_POST['og_description'] ?? '',
            isset($_POST['indexable']) ? 1 : 0,
            $page['id'],
        ]);
        redirect('/admin/pages');
    }

    render_partial('admin/page-edit', ['page' => $page]);
    exit;
}

if ($path === '/admin/blocks' && isset($_GET['page_id'], $_GET['lang'])) {
    $stmt = db()->prepare('SELECT * FROM page_blocks WHERE page_id = ? AND language = ? ORDER BY sort_order');
    $stmt->execute([$_GET['page_id'], $_GET['lang']]);
    $blocks = $stmt->fetchAll();
    render_partial('admin/blocks', ['blocks' => $blocks, 'page_id' => $_GET['page_id'], 'lang' => $_GET['lang']]);
    exit;
}

if ($path === '/admin/blocks/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT * FROM page_blocks WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $block = $stmt->fetch();
    if (!$block) {
        redirect('/admin/pages');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE page_blocks SET title = ?, body = ?, sort_order = ? WHERE id = ?');
        $update->execute([
            $_POST['title'] ?? '',
            $_POST['body'] ?? '',
            (int) ($_POST['sort_order'] ?? 0),
            $block['id'],
        ]);
        redirect('/admin/blocks?page_id=' . $block['page_id'] . '&lang=' . $block['language']);
    }

    render_partial('admin/block-edit', ['block' => $block]);
    exit;
}

if ($path === '/admin/categories') {
    $stmt = db()->query('SELECT c.id, c.slug, ct.language, ct.name FROM categories c JOIN category_translations ct ON ct.category_id = c.id ORDER BY c.id, ct.language');
    $categories = $stmt->fetchAll();
    render_partial('admin/categories', ['categories' => $categories]);
    exit;
}

if ($path === '/admin/categories/edit' && isset($_GET['id'], $_GET['lang'])) {
    $stmt = db()->prepare('SELECT c.id, c.slug, ct.* FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE c.id = ? AND ct.language = ?');
    $stmt->execute([$_GET['id'], $_GET['lang']]);
    $category = $stmt->fetch();
    if (!$category) {
        redirect('/admin/categories');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE category_translations SET name = ?, h1 = ?, description = ?, meta_title = ?, meta_description = ?, seo_text = ?, official_seller = ?, faq = ?, indexable = ? WHERE id = ?');
        $update->execute([
            $_POST['name'] ?? '',
            $_POST['h1'] ?? '',
            $_POST['description'] ?? '',
            $_POST['meta_title'] ?? '',
            $_POST['meta_description'] ?? '',
            $_POST['seo_text'] ?? '',
            $_POST['official_seller'] ?? '',
            $_POST['faq'] ?? '',
            isset($_POST['indexable']) ? 1 : 0,
            $category['id'],
        ]);
        redirect('/admin/categories');
    }

    render_partial('admin/category-edit', ['category' => $category]);
    exit;
}

if ($path === '/admin/products') {
    $stmt = db()->query('SELECT p.id, p.slug, p.sku, pt.language, pt.name FROM products p JOIN product_translations pt ON pt.product_id = p.id ORDER BY p.id, pt.language');
    $products = $stmt->fetchAll();
    render_partial('admin/products', ['products' => $products]);
    exit;
}

if ($path === '/admin/products/edit' && isset($_GET['id'], $_GET['lang'])) {
    $stmt = db()->prepare('SELECT p.id, p.slug, p.sku, pt.* FROM products p JOIN product_translations pt ON pt.product_id = p.id WHERE p.id = ? AND pt.language = ?');
    $stmt->execute([$_GET['id'], $_GET['lang']]);
    $product = $stmt->fetch();
    if (!$product) {
        redirect('/admin/products');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updateProduct = db()->prepare('UPDATE products SET sku = ?, slug = ? WHERE id = ?');
        $updateProduct->execute([
            $_POST['sku'] ?? '',
            $_POST['slug'] ?? '',
            $product['id'],
        ]);

        $updateTranslation = db()->prepare('UPDATE product_translations SET name = ?, h1 = ?, short_description = ?, description = ?, meta_title = ?, meta_description = ?, indexable = ? WHERE id = ?');
        $updateTranslation->execute([
            $_POST['name'] ?? '',
            $_POST['h1'] ?? '',
            $_POST['short_description'] ?? '',
            $_POST['description'] ?? '',
            $_POST['meta_title'] ?? '',
            $_POST['meta_description'] ?? '',
            isset($_POST['indexable']) ? 1 : 0,
            $product['id'],
        ]);
        redirect('/admin/products');
    }

    render_partial('admin/product-edit', ['product' => $product]);
    exit;
}

if ($path === '/admin/products/specs' && isset($_GET['id'], $_GET['lang'])) {
    $stmt = db()->prepare('SELECT * FROM product_specs WHERE product_id = ? AND language = ? ORDER BY sort_order');
    $stmt->execute([$_GET['id'], $_GET['lang']]);
    $specs = $stmt->fetchAll();
    render_partial('admin/product-specs', ['specs' => $specs, 'product_id' => $_GET['id'], 'lang' => $_GET['lang']]);
    exit;
}

if ($path === '/admin/translations') {
    $stmt = db()->query('SELECT * FROM translations ORDER BY language, `key`');
    $translations = $stmt->fetchAll();
    render_partial('admin/translations', ['translations' => $translations]);
    exit;
}

if ($path === '/admin/translations/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT * FROM translations WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $translation = $stmt->fetch();
    if (!$translation) {
        redirect('/admin/translations');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE translations SET `value` = ? WHERE id = ?');
        $update->execute([
            $_POST['value'] ?? '',
            $translation['id'],
        ]);
        redirect('/admin/translations');
    }

    render_partial('admin/translation-edit', ['translation' => $translation]);
    exit;
}

if ($path === '/admin/files' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = db()->query('SELECT * FROM files ORDER BY id DESC');
    $files = $stmt->fetchAll();
    render_partial('admin/files', ['files' => $files]);
    exit;
}

if ($path === '/admin/files' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['file']['tmp_name'])) {
        $name = basename($_FILES['file']['name']);
        $target = __DIR__ . '/../../storage/uploads/' . $name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            $stmt = db()->prepare('INSERT INTO files (file_name, file_path) VALUES (?, ?)');
            $stmt->execute([$name, '/storage/uploads/' . $name]);
        }
    }
    redirect('/admin/files');
}

http_response_code(404);
render_partial('admin/404', []);
