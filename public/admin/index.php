<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../../src/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/admin';
$path = rtrim($path, '/');
header('X-Robots-Tag: noindex, nofollow');

if ($path === '/admin') {
    redirect('/admin/pages');
}

if ($path === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    render_partial('admin/login', ['language' => 'ru', 'email' => '']);
    exit;
}

if ($path === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        $errors['form'] = 'Недействительный токен безопасности. Обновите страницу и попробуйте снова.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email.';
    }

    if ($password === '') {
        $errors['password'] = 'Введите пароль.';
    }

    if (empty($errors)) {
        $stmt = db()->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        $now = date('Y-m-d H:i:s');
        $locked = $admin && !empty($admin['locked_until']) && strtotime($admin['locked_until']) > time();

        if ($admin && $locked) {
            $errors['form'] = 'Слишком много попыток входа. Попробуйте позже.';
            admin_log_attempt($email, false);
        } elseif ($admin && (int) $admin['is_active'] === 1 && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $update = db()->prepare('UPDATE admins SET failed_attempts = 0, locked_until = NULL, last_login_at = ? WHERE id = ?');
            $update->execute([$now, $admin['id']]);
            admin_log_attempt($email, true);
            $redirectTo = $_SESSION['admin_redirect_to'] ?? '/admin/';
            unset($_SESSION['admin_redirect_to']);
            redirect($redirectTo);
        } else {
            if ($admin) {
                $failedAttempts = (int) $admin['failed_attempts'] + 1;
                $lockedUntil = null;
                if ($failedAttempts >= 7) {
                    $lockedUntil = date('Y-m-d H:i:s', time() + 15 * 60);
                }
                $update = db()->prepare('UPDATE admins SET failed_attempts = ?, locked_until = ? WHERE id = ?');
                $update->execute([$failedAttempts, $lockedUntil, $admin['id']]);
            }
            admin_log_attempt($email, false);
            $errors['form'] = 'Неверный email или пароль.';
        }
    }

    render_partial('admin/login', [
        'language' => 'ru',
        'error' => $errors['form'] ?? null,
        'errors' => $errors,
        'email' => $email,
    ]);
    exit;
}

if ($path === '/admin/logout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(400);
        echo 'Invalid CSRF token';
        exit;
    }
    unset($_SESSION['admin_id'], $_SESSION['admin_email']);
    session_regenerate_id(true);
    redirect('/admin/login/');
}

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    http_response_code(400);
    echo 'Invalid CSRF token';
    exit;
}

function detect_csv_delimiter(string $line): string
{
    $delimiters = [',', ';', "\t"];
    $bestDelimiter = ',';
    $bestCount = 0;
    foreach ($delimiters as $delimiter) {
        $count = substr_count($line, $delimiter);
        if ($count > $bestCount) {
            $bestDelimiter = $delimiter;
            $bestCount = $count;
        }
    }

    return $bestDelimiter;
}

function parse_csv_rows(string $path): array
{
    $handle = fopen($path, 'rb');
    if (!$handle) {
        return [];
    }
    $firstLine = fgets($handle);
    if ($firstLine === false) {
        fclose($handle);
        return [];
    }
    $delimiter = detect_csv_delimiter($firstLine);
    rewind($handle);
    $rows = [];
    while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
        $rows[] = $data;
    }
    fclose($handle);

    return $rows;
}

function column_letter_to_index(string $letters): int
{
    $letters = strtoupper($letters);
    $index = 0;
    for ($i = 0; $i < strlen($letters); $i++) {
        $index = $index * 26 + (ord($letters[$i]) - 64);
    }

    return $index - 1;
}

function parse_xlsx_rows(string $path): array
{
    $zip = new ZipArchive();
    if ($zip->open($path) !== true) {
        return [];
    }

    $sharedStrings = [];
    $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
    if ($sharedXml) {
        $sharedDoc = simplexml_load_string($sharedXml);
        if ($sharedDoc && isset($sharedDoc->si)) {
            foreach ($sharedDoc->si as $si) {
                $text = '';
                if (isset($si->t)) {
                    $text = (string) $si->t;
                } elseif (isset($si->r)) {
                    foreach ($si->r as $run) {
                        $text .= (string) $run->t;
                    }
                }
                $sharedStrings[] = $text;
            }
        }
    }

    $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
    $zip->close();
    if (!$sheetXml) {
        return [];
    }

    $sheetDoc = simplexml_load_string($sheetXml);
    if (!$sheetDoc || !isset($sheetDoc->sheetData)) {
        return [];
    }

    $rows = [];
    $maxCol = 0;
    foreach ($sheetDoc->sheetData->row as $row) {
        $rowData = [];
        foreach ($row->c as $cell) {
            $ref = (string) $cell['r'];
            $colLetters = preg_replace('/\d+/', '', $ref);
            $colIndex = column_letter_to_index($colLetters);
            $value = (string) $cell->v;
            $type = (string) $cell['t'];
            if ($type === 's') {
                $value = $sharedStrings[(int) $value] ?? '';
            }
            $rowData[$colIndex] = $value;
            $maxCol = max($maxCol, $colIndex);
        }
        $normalized = [];
        for ($i = 0; $i <= $maxCol; $i++) {
            $normalized[$i] = $rowData[$i] ?? '';
        }
        $rows[] = $normalized;
    }

    return $rows;
}

function load_spreadsheet_rows(string $path): array
{
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if ($extension === 'xlsx') {
        return parse_xlsx_rows($path);
    }

    return parse_csv_rows($path);
}

if ($path === '/admin/pages/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pageId = (int) ($_POST['id'] ?? 0);
    if ($pageId > 0) {
        $stmt = db()->prepare('DELETE FROM pages WHERE id = ?');
        $stmt->execute([$pageId]);
    }
    redirect('/admin/pages');
}

if ($path === '/admin/categories/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = (int) ($_POST['id'] ?? 0);
    if ($categoryId > 0) {
        $stmt = db()->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$categoryId]);
    }
    redirect('/admin/categories');
}

if ($path === '/admin/products/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (int) ($_POST['id'] ?? 0);
    if ($productId > 0) {
        $stmt = db()->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$productId]);
    }
    redirect('/admin/products');
}

if ($path === '/admin/pages') {
    $stmt = db()->query("SELECT p.id, p.slug, p.status,
        MAX(CASE WHEN pt.language = 'ru' THEN pt.h1 END) AS h1_ru,
        MAX(CASE WHEN pt.language = 'en' THEN pt.h1 END) AS h1_en
        FROM pages p
        LEFT JOIN page_translations pt ON pt.page_id = p.id
        GROUP BY p.id
        ORDER BY p.id");
    $pages = $stmt->fetchAll();
    render_partial('admin/pages', ['pages' => $pages]);
    exit;
}

if ($path === '/admin/pages/create') {
    $errors = [];
    $slug = trim($_POST['slug'] ?? '');
    $status = $_POST['status'] ?? 'published';
    $translations = [
        'ru' => [
            'title' => trim($_POST['title_ru'] ?? ''),
            'h1' => trim($_POST['h1_ru'] ?? ''),
            'meta_title' => trim($_POST['meta_title_ru'] ?? ''),
            'meta_description' => trim($_POST['meta_description_ru'] ?? ''),
            'canonical' => trim($_POST['canonical_ru'] ?? ''),
            'robots' => trim($_POST['robots_ru'] ?? ''),
            'og_title' => trim($_POST['og_title_ru'] ?? ''),
            'og_description' => trim($_POST['og_description_ru'] ?? ''),
            'custom_html' => $_POST['custom_html_ru'] ?? '',
            'custom_css' => $_POST['custom_css_ru'] ?? '',
            'use_layout' => isset($_POST['use_layout_ru']) ? 1 : 0,
            'replace_styles' => isset($_POST['replace_styles_ru']) ? 1 : 0,
            'indexable' => isset($_POST['indexable_ru']) ? 1 : 0,
        ],
        'en' => [
            'title' => trim($_POST['title_en'] ?? ''),
            'h1' => trim($_POST['h1_en'] ?? ''),
            'meta_title' => trim($_POST['meta_title_en'] ?? ''),
            'meta_description' => trim($_POST['meta_description_en'] ?? ''),
            'canonical' => trim($_POST['canonical_en'] ?? ''),
            'robots' => trim($_POST['robots_en'] ?? ''),
            'og_title' => trim($_POST['og_title_en'] ?? ''),
            'og_description' => trim($_POST['og_description_en'] ?? ''),
            'custom_html' => $_POST['custom_html_en'] ?? '',
            'custom_css' => $_POST['custom_css_en'] ?? '',
            'use_layout' => isset($_POST['use_layout_en']) ? 1 : 0,
            'replace_styles' => isset($_POST['replace_styles_en']) ? 1 : 0,
            'indexable' => isset($_POST['indexable_en']) ? 1 : 0,
        ],
    ];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        foreach (['ru', 'en'] as $language) {
            $translations[$language]['use_layout'] = 1;
            $translations[$language]['indexable'] = 1;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($slug === '') {
            $errors['slug'] = 'Укажите слаг страницы.';
        }
        $existing = db()->prepare('SELECT id FROM pages WHERE slug = ? LIMIT 1');
        $existing->execute([$slug]);
        if ($slug !== '' && $existing->fetch()) {
            $errors['slug'] = 'Слаг уже используется.';
        }

        if (empty($errors)) {
            $pdo = db();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO pages (slug, status) VALUES (?, ?)');
            $stmt->execute([$slug, $status]);
            $pageId = (int) $pdo->lastInsertId();
            $insertTranslation = $pdo->prepare('INSERT INTO page_translations (page_id, language, title, h1, meta_title, meta_description, canonical, robots, og_title, og_description, custom_html, custom_css, use_layout, replace_styles, indexable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            foreach (['ru', 'en'] as $language) {
                $data = $translations[$language];
                $insertTranslation->execute([
                    $pageId,
                    $language,
                    $data['title'],
                    $data['h1'],
                    $data['meta_title'],
                    $data['meta_description'],
                    $data['canonical'],
                    $data['robots'],
                    $data['og_title'],
                    $data['og_description'],
                    $data['custom_html'],
                    $data['custom_css'],
                    $data['use_layout'],
                    $data['replace_styles'],
                    $data['indexable'],
                ]);
            }
            $pdo->commit();
            redirect('/admin/pages/edit?id=' . $pageId);
        }
    }

    render_partial('admin/page-create', [
        'errors' => $errors,
        'slug' => $slug,
        'status' => $status,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/pages/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT id, slug, status FROM pages WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $page = $stmt->fetch();
    if (!$page) {
        redirect('/admin/pages');
    }

    $translationsStmt = db()->prepare('SELECT * FROM page_translations WHERE page_id = ?');
    $translationsStmt->execute([$page['id']]);
    $translations = ['ru' => null, 'en' => null];
    foreach ($translationsStmt->fetchAll() as $translation) {
        $translations[$translation['language']] = $translation;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatePage = db()->prepare('UPDATE pages SET slug = ?, status = ? WHERE id = ?');
        $updatePage->execute([
            $_POST['slug'] ?? '',
            $_POST['status'] ?? 'published',
            $page['id'],
        ]);

        $updateTranslation = db()->prepare('UPDATE page_translations SET title = ?, h1 = ?, meta_title = ?, meta_description = ?, canonical = ?, robots = ?, og_title = ?, og_description = ?, custom_html = ?, custom_css = ?, use_layout = ?, replace_styles = ?, indexable = ? WHERE id = ?');
        foreach (['ru', 'en'] as $language) {
            $translation = $translations[$language];
            if (!$translation) {
                continue;
            }
            $updateTranslation->execute([
                $_POST['title_' . $language] ?? '',
                $_POST['h1_' . $language] ?? '',
                $_POST['meta_title_' . $language] ?? '',
                $_POST['meta_description_' . $language] ?? '',
                $_POST['canonical_' . $language] ?? '',
                $_POST['robots_' . $language] ?? '',
                $_POST['og_title_' . $language] ?? '',
                $_POST['og_description_' . $language] ?? '',
                $_POST['custom_html_' . $language] ?? '',
                $_POST['custom_css_' . $language] ?? '',
                isset($_POST['use_layout_' . $language]) ? 1 : 0,
                isset($_POST['replace_styles_' . $language]) ? 1 : 0,
                isset($_POST['indexable_' . $language]) ? 1 : 0,
                $translation['id'],
            ]);
        }
        redirect('/admin/pages');
    }

    render_partial('admin/page-edit', ['page' => $page, 'translations' => $translations]);
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
    $stmt = db()->query("SELECT c.id, c.slug, c.status,
        MAX(CASE WHEN ct.language = 'ru' THEN ct.name END) AS name_ru,
        MAX(CASE WHEN ct.language = 'en' THEN ct.name END) AS name_en
        FROM categories c
        LEFT JOIN category_translations ct ON ct.category_id = c.id
        GROUP BY c.id
        ORDER BY c.id");
    $categories = $stmt->fetchAll();
    render_partial('admin/categories', ['categories' => $categories]);
    exit;
}

if ($path === '/admin/categories/create') {
    $errors = [];
    $slug = trim($_POST['slug'] ?? '');
    $status = $_POST['status'] ?? 'published';
    $translations = [
        'ru' => [
            'name' => trim($_POST['name_ru'] ?? ''),
            'h1' => trim($_POST['h1_ru'] ?? ''),
            'description' => trim($_POST['description_ru'] ?? ''),
            'seo_text' => trim($_POST['seo_text_ru'] ?? ''),
            'faq' => trim($_POST['faq_ru'] ?? ''),
            'meta_title' => trim($_POST['meta_title_ru'] ?? ''),
            'meta_description' => trim($_POST['meta_description_ru'] ?? ''),
            'indexable' => isset($_POST['indexable_ru']) ? 1 : 0,
        ],
        'en' => [
            'name' => trim($_POST['name_en'] ?? ''),
            'h1' => trim($_POST['h1_en'] ?? ''),
            'description' => trim($_POST['description_en'] ?? ''),
            'seo_text' => trim($_POST['seo_text_en'] ?? ''),
            'faq' => trim($_POST['faq_en'] ?? ''),
            'meta_title' => trim($_POST['meta_title_en'] ?? ''),
            'meta_description' => trim($_POST['meta_description_en'] ?? ''),
            'indexable' => isset($_POST['indexable_en']) ? 1 : 0,
        ],
    ];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        foreach (['ru', 'en'] as $language) {
            $translations[$language]['indexable'] = 1;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($slug === '') {
            $errors['slug'] = 'Укажите слаг категории.';
        }
        $existing = db()->prepare('SELECT id FROM categories WHERE slug = ? LIMIT 1');
        $existing->execute([$slug]);
        if ($slug !== '' && $existing->fetch()) {
            $errors['slug'] = 'Слаг уже используется.';
        }

        if (empty($errors)) {
            $pdo = db();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO categories (slug, status) VALUES (?, ?)');
            $stmt->execute([$slug, $status]);
            $categoryId = (int) $pdo->lastInsertId();
            $insertTranslation = $pdo->prepare('INSERT INTO category_translations (category_id, language, name, h1, description, meta_title, meta_description, seo_text, official_seller, faq, indexable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            foreach (['ru', 'en'] as $language) {
                $data = $translations[$language];
                $insertTranslation->execute([
                    $categoryId,
                    $language,
                    $data['name'],
                    $data['h1'],
                    $data['description'],
                    $data['meta_title'],
                    $data['meta_description'],
                    $data['seo_text'],
                    '',
                    $data['faq'],
                    $data['indexable'],
                ]);
            }
            $pdo->commit();
            redirect('/admin/categories/edit?id=' . $categoryId);
        }
    }

    render_partial('admin/category-create', [
        'errors' => $errors,
        'slug' => $slug,
        'status' => $status,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/categories/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT id, slug, status FROM categories WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $category = $stmt->fetch();
    if (!$category) {
        redirect('/admin/categories');
    }

    $translationsStmt = db()->prepare('SELECT * FROM category_translations WHERE category_id = ?');
    $translationsStmt->execute([$category['id']]);
    $translations = ['ru' => null, 'en' => null];
    foreach ($translationsStmt->fetchAll() as $translation) {
        $translations[$translation['language']] = $translation;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updateCategory = db()->prepare('UPDATE categories SET slug = ?, status = ? WHERE id = ?');
        $updateCategory->execute([
            $_POST['slug'] ?? '',
            $_POST['status'] ?? 'published',
            $category['id'],
        ]);

        $updateTranslation = db()->prepare('UPDATE category_translations SET name = ?, h1 = ?, description = ?, meta_title = ?, meta_description = ?, seo_text = ?, official_seller = ?, faq = ?, indexable = ? WHERE id = ?');
        foreach (['ru', 'en'] as $language) {
            $translation = $translations[$language];
            if (!$translation) {
                continue;
            }
            $officialSeller = $_POST['official_seller_' . $language] ?? $translation['official_seller'] ?? '';
            $updateTranslation->execute([
                $_POST['name_' . $language] ?? '',
                $_POST['h1_' . $language] ?? '',
                $_POST['description_' . $language] ?? '',
                $_POST['meta_title_' . $language] ?? '',
                $_POST['meta_description_' . $language] ?? '',
                $_POST['seo_text_' . $language] ?? '',
                $officialSeller,
                $_POST['faq_' . $language] ?? '',
                isset($_POST['indexable_' . $language]) ? 1 : 0,
                $translation['id'],
            ]);
        }
        redirect('/admin/categories');
    }

    render_partial('admin/category-edit', ['category' => $category, 'translations' => $translations]);
    exit;
}

if ($path === '/admin/products') {
    $stmt = db()->query("SELECT p.id, p.slug, p.sku, p.status,
        MAX(CASE WHEN pt.language = 'ru' THEN pt.name END) AS name_ru,
        MAX(CASE WHEN pt.language = 'en' THEN pt.name END) AS name_en
        FROM products p
        LEFT JOIN product_translations pt ON pt.product_id = p.id
        GROUP BY p.id
        ORDER BY p.id");
    $products = $stmt->fetchAll();
    render_partial('admin/products', ['products' => $products]);
    exit;
}

if ($path === '/admin/products/create') {
    $errors = [];
    $slug = trim($_POST['slug'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $categoryId = (int) ($_POST['category_id'] ?? 0);
    $status = $_POST['status'] ?? 'draft';
    $translations = [
        'ru' => [
            'name' => trim($_POST['name_ru'] ?? ''),
            'h1' => trim($_POST['h1_ru'] ?? ''),
            'short_description' => trim($_POST['short_description_ru'] ?? ''),
            'description' => $_POST['description_ru'] ?? '',
            'meta_title' => trim($_POST['meta_title_ru'] ?? ''),
            'meta_description' => trim($_POST['meta_description_ru'] ?? ''),
            'indexable' => isset($_POST['indexable_ru']) ? 1 : 0,
        ],
        'en' => [
            'name' => trim($_POST['name_en'] ?? ''),
            'h1' => trim($_POST['h1_en'] ?? ''),
            'short_description' => trim($_POST['short_description_en'] ?? ''),
            'description' => $_POST['description_en'] ?? '',
            'meta_title' => trim($_POST['meta_title_en'] ?? ''),
            'meta_description' => trim($_POST['meta_description_en'] ?? ''),
            'indexable' => isset($_POST['indexable_en']) ? 1 : 0,
        ],
    ];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        foreach (['ru', 'en'] as $language) {
            $translations[$language]['indexable'] = 1;
        }
    }

    $stmt = db()->prepare('SELECT c.id, c.slug, ct.name FROM categories c LEFT JOIN category_translations ct ON ct.category_id = c.id AND ct.language = ? ORDER BY c.slug');
    $stmt->execute(['ru']);
    $categories = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($slug === '') {
            $errors['slug'] = 'Укажите слаг продукта.';
        }
        if ($sku === '') {
            $errors['sku'] = 'Укажите артикул.';
        }
        if ($categoryId <= 0) {
            $errors['category_id'] = 'Выберите категорию.';
        }
        $existing = db()->prepare('SELECT id FROM products WHERE slug = ? LIMIT 1');
        $existing->execute([$slug]);
        if ($slug !== '' && $existing->fetch()) {
            $errors['slug'] = 'Слаг уже используется.';
        }

        if (empty($errors)) {
            $pdo = db();
            $pdo->beginTransaction();
            $insertProduct = $pdo->prepare('INSERT INTO products (category_id, slug, sku, status) VALUES (?, ?, ?, ?)');
            $insertProduct->execute([$categoryId, $slug, $sku, $status]);
            $productId = (int) $pdo->lastInsertId();
            $insertTranslation = $pdo->prepare('INSERT INTO product_translations (product_id, language, name, h1, short_description, description, meta_title, meta_description, indexable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            foreach (['ru', 'en'] as $language) {
                $data = $translations[$language];
                $insertTranslation->execute([
                    $productId,
                    $language,
                    $data['name'],
                    $data['h1'],
                    $data['short_description'],
                    $data['description'],
                    $data['meta_title'],
                    $data['meta_description'],
                    $data['indexable'],
                ]);
            }
            $pdo->commit();
            redirect('/admin/products/edit?id=' . $productId);
        }
    }

    render_partial('admin/product-create', [
        'errors' => $errors,
        'slug' => $slug,
        'sku' => $sku,
        'category_id' => $categoryId,
        'categories' => $categories,
        'status' => $status,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/products/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT id, slug, sku, status, category_id FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
    if (!$product) {
        redirect('/admin/products');
    }

    $translationsStmt = db()->prepare('SELECT * FROM product_translations WHERE product_id = ?');
    $translationsStmt->execute([$product['id']]);
    $translations = ['ru' => null, 'en' => null];
    foreach ($translationsStmt->fetchAll() as $translation) {
        $translations[$translation['language']] = $translation;
    }

    $stmt = db()->prepare('SELECT c.id, c.slug, ct.name FROM categories c LEFT JOIN category_translations ct ON ct.category_id = c.id AND ct.language = ? ORDER BY c.slug');
    $stmt->execute(['ru']);
    $categories = $stmt->fetchAll();

    $partnersStmt = db()->prepare('SELECT p.id, p.type, pt.name FROM partners p JOIN partner_translations pt ON pt.partner_id = p.id AND pt.language = ? ORDER BY p.sort_order, p.id');
    $partnersStmt->execute(['ru']);
    $partners = $partnersStmt->fetchAll();
    $partnerSelectionsStmt = db()->prepare('SELECT partner_id FROM product_partners WHERE product_id = ?');
    $partnerSelectionsStmt->execute([$product['id']]);
    $partnerSelections = array_map('intval', array_column($partnerSelectionsStmt->fetchAll(), 'partner_id'));

    $documentsStmt = db()->prepare('SELECT id, title, language FROM documents WHERE scope = "product" ORDER BY language, sort_order, id');
    $documentsStmt->execute();
    $documentsByLanguage = ['ru' => [], 'en' => []];
    foreach ($documentsStmt->fetchAll() as $doc) {
        $documentsByLanguage[$doc['language']][] = $doc;
    }
    $documentSelectionsStmt = db()->prepare('SELECT document_id, sort_order FROM document_products WHERE product_id = ?');
    $documentSelectionsStmt->execute([$product['id']]);
    $documentSelections = [];
    foreach ($documentSelectionsStmt->fetchAll() as $row) {
        $documentSelections[(int) $row['document_id']] = (int) $row['sort_order'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $pdo->beginTransaction();
        $updateProduct = $pdo->prepare('UPDATE products SET sku = ?, slug = ?, category_id = ?, status = ? WHERE id = ?');
        $updateProduct->execute([
            $_POST['sku'] ?? '',
            $_POST['slug'] ?? '',
            (int) ($_POST['category_id'] ?? 0),
            $_POST['status'] ?? 'draft',
            $product['id'],
        ]);

        $updateTranslation = $pdo->prepare('UPDATE product_translations SET name = ?, h1 = ?, short_description = ?, description = ?, meta_title = ?, meta_description = ?, indexable = ? WHERE id = ?');
        foreach (['ru', 'en'] as $language) {
            $translation = $translations[$language];
            if (!$translation) {
                continue;
            }
            $updateTranslation->execute([
                $_POST['name_' . $language] ?? '',
                $_POST['h1_' . $language] ?? '',
                $_POST['short_description_' . $language] ?? '',
                $_POST['description_' . $language] ?? '',
                $_POST['meta_title_' . $language] ?? '',
                $_POST['meta_description_' . $language] ?? '',
                isset($_POST['indexable_' . $language]) ? 1 : 0,
                $translation['id'],
            ]);
        }

        $deletePartners = $pdo->prepare('DELETE FROM product_partners WHERE product_id = ?');
        $deletePartners->execute([$product['id']]);
        $partnerIds = array_map('intval', $_POST['partner_ids'] ?? []);
        if ($partnerIds) {
            $insertPartner = $pdo->prepare('INSERT INTO product_partners (product_id, partner_id, sort_order) VALUES (?, ?, ?)');
            foreach ($partnerIds as $partnerId) {
                $insertPartner->execute([$product['id'], $partnerId, 0]);
            }
        }

        $deleteDocuments = $pdo->prepare('DELETE FROM document_products WHERE product_id = ?');
        $deleteDocuments->execute([$product['id']]);
        $insertDocument = $pdo->prepare('INSERT INTO document_products (document_id, product_id, sort_order) VALUES (?, ?, ?)');
        foreach (['ru', 'en'] as $language) {
            $docIds = array_map('intval', $_POST['document_ids_' . $language] ?? []);
            $docSorts = $_POST['document_sort_' . $language] ?? [];
            foreach ($docIds as $docId) {
                $sortOrder = (int) ($docSorts[$docId] ?? 0);
                $insertDocument->execute([$docId, $product['id'], $sortOrder]);
            }
        }

        $pdo->commit();
        redirect('/admin/products');
    }

    render_partial('admin/product-edit', [
        'product' => $product,
        'translations' => $translations,
        'categories' => $categories,
        'partners' => $partners,
        'partnerSelections' => $partnerSelections,
        'documentsByLanguage' => $documentsByLanguage,
        'documentSelections' => $documentSelections,
    ]);
    exit;
}

if ($path === '/admin/products/specs' && isset($_GET['id'], $_GET['lang'])) {
    $stmt = db()->prepare('SELECT * FROM product_specs WHERE product_id = ? AND language = ? ORDER BY sort_order');
    $stmt->execute([$_GET['id'], $_GET['lang']]);
    $specs = $stmt->fetchAll();
    render_partial('admin/product-specs', ['specs' => $specs, 'product_id' => $_GET['id'], 'lang' => $_GET['lang']]);
    exit;
}

if ($path === '/admin/products/import') {
    $previewRows = [];
    $columns = [];
    $fileToken = '';
    $importResult = null;
    $fieldMap = [
        'category_slug' => 'category_slug',
        'sku' => 'sku',
        'product_slug' => 'product_slug',
        'name_ru' => 'name_ru',
        'name_en' => 'name_en',
        'short_description_ru' => 'short_description_ru',
        'short_description_en' => 'short_description_en',
        'description_ru' => 'description_ru',
        'description_en' => 'description_en',
        'specs_json_ru' => 'specs_json_ru',
        'specs_json_en' => 'specs_json_en',
        'images' => 'images',
        'documents_ru' => 'documents_ru',
        'documents_en' => 'documents_en',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $importsDir = __DIR__ . '/../../storage/imports';
        if (!is_dir($importsDir)) {
            mkdir($importsDir, 0775, true);
        }

        if (!empty($_POST['run_import']) && !empty($_POST['file_token'])) {
            $fileToken = basename($_POST['file_token']);
            $filePath = $importsDir . '/' . $fileToken;
            $rows = load_spreadsheet_rows($filePath);
            $columns = $rows[0] ?? [];
            $mapping = $_POST['mapping'] ?? [];
            $mode = $_POST['mode'] ?? 'create_new';
            $importResult = ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => []];

            $pdo = db();
            $categoryStmt = $pdo->prepare('SELECT id FROM categories WHERE slug = ? LIMIT 1');
            $productBySkuStmt = $pdo->prepare('SELECT id FROM products WHERE sku = ? LIMIT 1');
            $insertProduct = $pdo->prepare('INSERT INTO products (category_id, slug, sku, status) VALUES (?, ?, ?, ?)');
            $updateProduct = $pdo->prepare('UPDATE products SET category_id = ?, slug = ?, status = ? WHERE id = ?');
            $insertTranslation = $pdo->prepare('INSERT INTO product_translations (product_id, language, name, h1, short_description, description, meta_title, meta_description, indexable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $updateTranslation = $pdo->prepare('UPDATE product_translations SET name = ?, h1 = ?, short_description = ?, description = ? WHERE product_id = ? AND language = ?');
            $deleteSpecs = $pdo->prepare('DELETE FROM product_specs WHERE product_id = ? AND language = ?');
            $insertSpec = $pdo->prepare('INSERT INTO product_specs (product_id, language, label, value, unit, type, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $deleteImages = $pdo->prepare('DELETE FROM product_images WHERE product_id = ?');
            $insertImage = $pdo->prepare('INSERT INTO product_images (product_id, language, file_path, alt_text, sort_order) VALUES (?, ?, ?, ?, ?)');
            $insertDocument = $pdo->prepare('INSERT INTO documents (scope, language, title, file_path, doc_type, sort_order, is_active) VALUES ("product", ?, ?, ?, "", ?, 1)');
            $insertDocumentLink = $pdo->prepare('INSERT INTO document_products (document_id, product_id, sort_order) VALUES (?, ?, ?)');

            $rows = array_slice($rows, 1);
            foreach ($rows as $rowIndex => $row) {
                $getValue = static function (string $key) use ($mapping, $row): string {
                    if (!isset($mapping[$key]) || $mapping[$key] === '') {
                        return '';
                    }
                    $index = (int) $mapping[$key];
                    return trim((string) ($row[$index] ?? ''));
                };

                $categorySlug = $getValue('category_slug');
                $sku = $getValue('sku');
                $productSlug = $getValue('product_slug') ?: $sku;
                $nameRu = $getValue('name_ru');
                $nameEn = $getValue('name_en');

                if ($categorySlug === '' || $sku === '' || $productSlug === '' || $nameRu === '' || $nameEn === '') {
                    $importResult['errors'][] = 'Row ' . ($rowIndex + 2) . ': missing required fields.';
                    continue;
                }

                $categoryStmt->execute([$categorySlug]);
                $categoryId = $categoryStmt->fetchColumn();
                if (!$categoryId) {
                    $importResult['errors'][] = 'Row ' . ($rowIndex + 2) . ': category not found.';
                    continue;
                }

                $productBySkuStmt->execute([$sku]);
                $existingId = $productBySkuStmt->fetchColumn();

                if ($existingId) {
                    if ($mode === 'skip_existing') {
                        $importResult['skipped']++;
                        continue;
                    }
                    if ($mode === 'create_new') {
                        $importResult['errors'][] = 'Row ' . ($rowIndex + 2) . ': SKU already exists.';
                        continue;
                    }
                }

                $pdo->beginTransaction();
                if ($existingId) {
                    $updateProduct->execute([(int) $categoryId, $productSlug, 'published', $existingId]);
                    $updateTranslation->execute([$nameRu, $nameRu, $getValue('short_description_ru'), $getValue('description_ru'), $existingId, 'ru']);
                    $updateTranslation->execute([$nameEn, $nameEn, $getValue('short_description_en'), $getValue('description_en'), $existingId, 'en']);
                    $productId = (int) $existingId;
                    $importResult['updated']++;
                } else {
                    $insertProduct->execute([(int) $categoryId, $productSlug, $sku, 'published']);
                    $productId = (int) $pdo->lastInsertId();
                    $insertTranslation->execute([$productId, 'ru', $nameRu, $nameRu, $getValue('short_description_ru'), $getValue('description_ru'), '', '', 1]);
                    $insertTranslation->execute([$productId, 'en', $nameEn, $nameEn, $getValue('short_description_en'), $getValue('description_en'), '', '', 1]);
                    $importResult['created']++;
                }

                foreach (['ru', 'en'] as $lang) {
                    $specJson = $getValue('specs_json_' . $lang);
                    if ($specJson !== '') {
                        $deleteSpecs->execute([$productId, $lang]);
                        $specData = json_decode($specJson, true);
                        if (is_array($specData)) {
                            $order = 0;
                            foreach ($specData as $spec) {
                                $insertSpec->execute([
                                    $productId,
                                    $lang,
                                    $spec['label'] ?? '',
                                    $spec['value'] ?? '',
                                    $spec['unit'] ?? '',
                                    $spec['type'] ?? '',
                                    $order++,
                                ]);
                            }
                        }
                    }
                }

                $imagesValue = $getValue('images');
                if ($imagesValue !== '') {
                    $deleteImages->execute([$productId]);
                    $images = preg_split('/\\r?\\n|,|;/', $imagesValue);
                    $images = array_filter(array_map('trim', $images));
                    $order = 0;
                    foreach ($images as $imagePath) {
                        foreach (['ru', 'en'] as $lang) {
                            $insertImage->execute([$productId, $lang, $imagePath, $nameRu, $order]);
                        }
                        $order++;
                    }
                }

                $docsProvided = $getValue('documents_ru') !== '' || $getValue('documents_en') !== '';
                if ($docsProvided) {
                    $pdo->prepare('DELETE FROM document_products WHERE product_id = ?')->execute([$productId]);
                }

                foreach (['ru', 'en'] as $lang) {
                    $docsValue = $getValue('documents_' . $lang);
                    if ($docsValue === '') {
                        continue;
                    }
                    $docs = preg_split('/\\r?\\n|,|;/', $docsValue);
                    $docs = array_filter(array_map('trim', $docs));
                    $order = 0;
                    foreach ($docs as $docPath) {
                        $title = basename($docPath);
                        $insertDocument->execute([$lang, $title, $docPath, $order]);
                        $documentId = (int) $pdo->lastInsertId();
                        $insertDocumentLink->execute([$documentId, $productId, $order]);
                        $order++;
                    }
                }

                $pdo->commit();
            }
        } elseif (!empty($_FILES['file']['tmp_name'])) {
            $name = uniqid('import_', true) . '-' . basename($_FILES['file']['name']);
            $target = $importsDir . '/' . $name;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $fileToken = $name;
                $rows = load_spreadsheet_rows($target);
                if ($rows) {
                    $columns = $rows[0];
                    $previewRows = array_slice($rows, 1, 20);
                }
            }
        }
    }

    render_partial('admin/product-import', [
        'previewRows' => $previewRows,
        'columns' => $columns,
        'fileToken' => $fileToken,
        'fieldMap' => $fieldMap,
        'importResult' => $importResult,
    ]);
    exit;
}

if ($path === '/admin/partners/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $partnerId = (int) ($_POST['id'] ?? 0);
    if ($partnerId > 0) {
        $stmt = db()->prepare('DELETE FROM partners WHERE id = ?');
        $stmt->execute([$partnerId]);
    }
    redirect('/admin/partners');
}

if ($path === '/admin/partners') {
    $stmt = db()->prepare('SELECT p.*, pt.name FROM partners p JOIN partner_translations pt ON pt.partner_id = p.id AND pt.language = ? ORDER BY p.sort_order, p.id');
    $stmt->execute(['ru']);
    $partners = $stmt->fetchAll();
    render_partial('admin/partners', ['partners' => $partners]);
    exit;
}

if ($path === '/admin/partners/create') {
    $partner = [
        'type' => 'official_distributor',
        'url' => '',
        'city' => '',
        'lat' => '',
        'lng' => '',
        'sort_order' => 0,
        'is_active' => 1,
    ];
    $translations = ['ru' => ['name' => '', 'description' => ''], 'en' => ['name' => '', 'description' => '']];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $pdo->beginTransaction();
        $insertPartner = $pdo->prepare('INSERT INTO partners (type, url, logo_path, city, lat, lng, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $logoPath = '';
        if (!empty($_FILES['logo']['tmp_name'])) {
            $name = basename($_FILES['logo']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
                $logoPath = '/storage/uploads/' . $name;
            }
        }
        $insertPartner->execute([
            $_POST['type'] ?? 'official_distributor',
            $_POST['url'] ?? '',
            $logoPath,
            $_POST['city'] ?? '',
            $_POST['lat'] ?? '',
            $_POST['lng'] ?? '',
            isset($_POST['is_active']) ? 1 : 0,
            (int) ($_POST['sort_order'] ?? 0),
        ]);
        $partnerId = (int) $pdo->lastInsertId();
        $insertTranslation = $pdo->prepare('INSERT INTO partner_translations (partner_id, language, name, description) VALUES (?, ?, ?, ?)');
        foreach (['ru', 'en'] as $language) {
            $insertTranslation->execute([
                $partnerId,
                $language,
                $_POST['name_' . $language] ?? '',
                $_POST['description_' . $language] ?? '',
            ]);
        }
        $pdo->commit();
        redirect('/admin/partners');
    }

    render_partial('admin/partner-create', [
        'partner' => $partner,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/partners/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT * FROM partners WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $partner = $stmt->fetch();
    if (!$partner) {
        redirect('/admin/partners');
    }

    $translationsStmt = db()->prepare('SELECT * FROM partner_translations WHERE partner_id = ?');
    $translationsStmt->execute([$partner['id']]);
    $translations = ['ru' => null, 'en' => null];
    foreach ($translationsStmt->fetchAll() as $translation) {
        $translations[$translation['language']] = $translation;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $logoPath = $partner['logo_path'] ?? '';
        if (!empty($_FILES['logo']['tmp_name'])) {
            $name = basename($_FILES['logo']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
                $logoPath = '/storage/uploads/' . $name;
            }
        }

        $updatePartner = db()->prepare('UPDATE partners SET type = ?, url = ?, logo_path = ?, city = ?, lat = ?, lng = ?, is_active = ?, sort_order = ? WHERE id = ?');
        $updatePartner->execute([
            $_POST['type'] ?? 'official_distributor',
            $_POST['url'] ?? '',
            $logoPath,
            $_POST['city'] ?? '',
            $_POST['lat'] ?? '',
            $_POST['lng'] ?? '',
            isset($_POST['is_active']) ? 1 : 0,
            (int) ($_POST['sort_order'] ?? 0),
            $partner['id'],
        ]);

        $updateTranslation = db()->prepare('UPDATE partner_translations SET name = ?, description = ? WHERE partner_id = ? AND language = ?');
        foreach (['ru', 'en'] as $language) {
            $updateTranslation->execute([
                $_POST['name_' . $language] ?? '',
                $_POST['description_' . $language] ?? '',
                $partner['id'],
                $language,
            ]);
        }

        redirect('/admin/partners');
    }

    render_partial('admin/partner-edit', [
        'partner' => $partner,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/documents/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $docId = (int) ($_POST['id'] ?? 0);
    if ($docId > 0) {
        $stmt = db()->prepare('DELETE FROM documents WHERE id = ?');
        $stmt->execute([$docId]);
    }
    redirect('/admin/documents');
}

if ($path === '/admin/documents') {
    $stmt = db()->query('SELECT * FROM documents ORDER BY scope, language, sort_order, id');
    $documents = $stmt->fetchAll();
    render_partial('admin/documents', ['documents' => $documents]);
    exit;
}

if ($path === '/admin/documents/create') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filePath = $_POST['file_path'] ?? '';
        if (!empty($_FILES['file']['tmp_name'])) {
            $name = basename($_FILES['file']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $filePath = '/storage/uploads/' . $name;
            }
        }
        $stmt = db()->prepare('INSERT INTO documents (scope, language, title, file_path, doc_type, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $_POST['scope'] ?? 'brand',
            $_POST['language'] ?? 'ru',
            $_POST['title'] ?? '',
            $filePath,
            $_POST['doc_type'] ?? '',
            (int) ($_POST['sort_order'] ?? 0),
            isset($_POST['is_active']) ? 1 : 0,
        ]);
        redirect('/admin/documents');
    }

    render_partial('admin/document-create', []);
    exit;
}

if ($path === '/admin/documents/edit' && isset($_GET['id'])) {
    $stmt = db()->prepare('SELECT * FROM documents WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $document = $stmt->fetch();
    if (!$document) {
        redirect('/admin/documents');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filePath = $_POST['file_path'] ?? $document['file_path'];
        if (!empty($_FILES['file']['tmp_name'])) {
            $name = basename($_FILES['file']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $filePath = '/storage/uploads/' . $name;
            }
        }
        $update = db()->prepare('UPDATE documents SET scope = ?, language = ?, title = ?, file_path = ?, doc_type = ?, sort_order = ?, is_active = ? WHERE id = ?');
        $update->execute([
            $_POST['scope'] ?? $document['scope'],
            $_POST['language'] ?? $document['language'],
            $_POST['title'] ?? $document['title'],
            $filePath,
            $_POST['doc_type'] ?? $document['doc_type'],
            (int) ($_POST['sort_order'] ?? $document['sort_order']),
            isset($_POST['is_active']) ? 1 : 0,
            $document['id'],
        ]);
        redirect('/admin/documents');
    }

    render_partial('admin/document-edit', ['document' => $document]);
    exit;
}

if ($path === '/admin/home-hero') {
    $settingsStmt = db()->prepare('SELECT language, `key`, `value` FROM site_settings WHERE `key` IN ("hero_title", "hero_subtitle", "hero_cta_primary_label", "hero_cta_primary_url", "hero_cta_secondary_label", "hero_cta_secondary_url", "hero_video_autoplay", "hero_video_path", "hero_video_poster")');
    $settingsStmt->execute();
    $settings = [
        'ru' => [],
        'en' => [],
        'hero_video_autoplay' => '0',
        'hero_video_path' => '',
        'hero_video_poster' => '',
    ];
    foreach ($settingsStmt->fetchAll() as $row) {
        if ($row['key'] === 'hero_video_autoplay' || $row['key'] === 'hero_video_path' || $row['key'] === 'hero_video_poster') {
            $settings[$row['key']] = $row['value'];
        } else {
            $settings[$row['language']][$row['key']] = $row['value'];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $updateSetting = $pdo->prepare('INSERT INTO site_settings (language, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)');
        foreach (['ru', 'en'] as $language) {
            $updateSetting->execute([$language, 'hero_title', $_POST['hero_title_' . $language] ?? '']);
            $updateSetting->execute([$language, 'hero_subtitle', $_POST['hero_subtitle_' . $language] ?? '']);
            $updateSetting->execute([$language, 'hero_cta_primary_label', $_POST['hero_cta_primary_label_' . $language] ?? '']);
            $updateSetting->execute([$language, 'hero_cta_primary_url', $_POST['hero_cta_primary_url_' . $language] ?? '']);
            $updateSetting->execute([$language, 'hero_cta_secondary_label', $_POST['hero_cta_secondary_label_' . $language] ?? '']);
            $updateSetting->execute([$language, 'hero_cta_secondary_url', $_POST['hero_cta_secondary_url_' . $language] ?? '']);
        }

        $updateSetting->execute(['ru', 'hero_video_autoplay', isset($_POST['hero_autoplay']) ? '1' : '0']);
        $updateSetting->execute(['en', 'hero_video_autoplay', isset($_POST['hero_autoplay']) ? '1' : '0']);

        if (!empty($_FILES['hero_video']['tmp_name'])) {
            $name = basename($_FILES['hero_video']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['hero_video']['tmp_name'], $target)) {
                $updateSetting->execute(['ru', 'hero_video_path', '/storage/uploads/' . $name]);
                $updateSetting->execute(['en', 'hero_video_path', '/storage/uploads/' . $name]);
            }
        }
        if (!empty($_FILES['hero_poster']['tmp_name'])) {
            $name = basename($_FILES['hero_poster']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['hero_poster']['tmp_name'], $target)) {
                $updateSetting->execute(['ru', 'hero_video_poster', '/storage/uploads/' . $name]);
                $updateSetting->execute(['en', 'hero_video_poster', '/storage/uploads/' . $name]);
            }
        }

        redirect('/admin/home-hero');
    }

    render_partial('admin/home-hero', [
        'settings' => $settings,
    ]);
    exit;
}

if ($path === '/admin/translations') {
    $search = trim($_GET['q'] ?? '');
    $params = [];
    $where = '';
    if ($search !== '') {
        $where = 'WHERE `key` LIKE ?';
        $params[] = '%' . $search . '%';
    }
    $stmt = db()->prepare("SELECT `key`,
        MAX(CASE WHEN language = 'ru' THEN `value` END) AS ru_value,
        MAX(CASE WHEN language = 'en' THEN `value` END) AS en_value
        FROM translations
        $where
        GROUP BY `key`
        ORDER BY `key`");
    $stmt->execute($params);
    $translations = $stmt->fetchAll();
    render_partial('admin/translations', ['translations' => $translations, 'search' => $search]);
    exit;
}

if ($path === '/admin/translations/edit' && isset($_GET['key'])) {
    $key = $_GET['key'];
    $stmt = db()->prepare('SELECT language, `value` FROM translations WHERE `key` = ?');
    $stmt->execute([$key]);
    $values = ['ru' => '', 'en' => ''];
    foreach ($stmt->fetchAll() as $row) {
        $values[$row['language']] = $row['value'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $upsert = $pdo->prepare('INSERT INTO translations (language, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)');
        foreach (['ru', 'en'] as $language) {
            $upsert->execute([
                $language,
                $key,
                $_POST['value_' . $language] ?? '',
            ]);
        }
        redirect('/admin/translations');
    }

    render_partial('admin/translation-edit', ['key' => $key, 'values' => $values]);
    exit;
}

if ($path === '/admin/footer') {
    $settingsStmt = db()->prepare('SELECT language, `key`, `value` FROM site_settings WHERE `key` IN ("footer_text", "footer_copyright", "footer_contacts")');
    $settingsStmt->execute();
    $settings = [
        'ru' => ['footer_text' => '', 'footer_copyright' => '', 'footer_contacts' => ''],
        'en' => ['footer_text' => '', 'footer_copyright' => '', 'footer_contacts' => ''],
    ];
    foreach ($settingsStmt->fetchAll() as $row) {
        $settings[$row['language']][$row['key']] = $row['value'];
    }

    $linksStmt = db()->prepare('SELECT * FROM footer_links WHERE language = ? ORDER BY sort_order');
    $linksStmt->execute(['ru']);
    $linksRu = $linksStmt->fetchAll();
    $linksStmt->execute(['en']);
    $linksEn = $linksStmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $updateSetting = $pdo->prepare('INSERT INTO site_settings (language, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)');
        foreach (['ru', 'en'] as $language) {
            $updateSetting->execute([$language, 'footer_text', $_POST['footer_text_' . $language] ?? '']);
            $updateSetting->execute([$language, 'footer_copyright', $_POST['footer_copyright_' . $language] ?? '']);
            $updateSetting->execute([$language, 'footer_contacts', $_POST['footer_contacts_' . $language] ?? '']);
        }

        foreach (['ru', 'en'] as $language) {
            $delete = $pdo->prepare('DELETE FROM footer_links WHERE language = ?');
            $delete->execute([$language]);
            $labels = $_POST['footer_links_label_' . $language] ?? [];
            $urls = $_POST['footer_links_url_' . $language] ?? [];
            $orders = $_POST['footer_links_sort_' . $language] ?? [];
            $insert = $pdo->prepare('INSERT INTO footer_links (language, label, url, sort_order) VALUES (?, ?, ?, ?)');
            foreach ($labels as $index => $label) {
                $label = trim($label);
                $url = trim($urls[$index] ?? '');
                if ($label === '' || $url === '') {
                    continue;
                }
                $sortOrder = (int) ($orders[$index] ?? 0);
                $insert->execute([$language, $label, $url, $sortOrder]);
            }
        }

        redirect('/admin/footer');
    }

    render_partial('admin/footer', [
        'settings' => $settings,
        'links_ru' => $linksRu,
        'links_en' => $linksEn,
    ]);
    exit;
}

if ($path === '/admin/header') {
    $settingsStmt = db()->prepare('SELECT language, `key`, `value` FROM site_settings WHERE `key` IN ("header_show_logo", "header_logo_link", "header_logo_alt", "header_logo_path")');
    $settingsStmt->execute();
    $settings = [
        'ru' => ['header_show_logo' => '0', 'header_logo_link' => '/ru/', 'header_logo_alt' => '', 'header_logo_path' => ''],
        'en' => ['header_show_logo' => '0', 'header_logo_link' => '/en/', 'header_logo_alt' => '', 'header_logo_path' => ''],
    ];
    foreach ($settingsStmt->fetchAll() as $row) {
        $settings[$row['language']][$row['key']] = $row['value'];
    }

    $navStmt = db()->prepare('SELECT * FROM navigation_items WHERE language = ? ORDER BY sort_order');
    $navStmt->execute(['ru']);
    $navRu = $navStmt->fetchAll();
    $navStmt->execute(['en']);
    $navEn = $navStmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $updateSetting = $pdo->prepare('INSERT INTO site_settings (language, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)');
        foreach (['ru', 'en'] as $language) {
            $updateSetting->execute([$language, 'header_show_logo', isset($_POST['header_show_logo_' . $language]) ? '1' : '0']);
            $updateSetting->execute([$language, 'header_logo_link', $_POST['header_logo_link_' . $language] ?? '']);
            $updateSetting->execute([$language, 'header_logo_alt', $_POST['header_logo_alt_' . $language] ?? '']);
        }

        foreach (['ru', 'en'] as $language) {
            $delete = $pdo->prepare('DELETE FROM navigation_items WHERE language = ?');
            $delete->execute([$language]);
            $labels = $_POST['header_links_label_' . $language] ?? [];
            $urls = $_POST['header_links_url_' . $language] ?? [];
            $orders = $_POST['header_links_sort_' . $language] ?? [];
            $insert = $pdo->prepare('INSERT INTO navigation_items (language, label, url, sort_order) VALUES (?, ?, ?, ?)');
            foreach ($labels as $index => $label) {
                $label = trim($label);
                $url = trim($urls[$index] ?? '');
                if ($label === '' || $url === '') {
                    continue;
                }
                $sortOrder = (int) ($orders[$index] ?? 0);
                $insert->execute([$language, $label, $url, $sortOrder]);
            }
        }

        if (!empty($_FILES['header_logo']['tmp_name'])) {
            $name = basename($_FILES['header_logo']['name']);
            $target = __DIR__ . '/../../storage/uploads/' . $name;
            if (move_uploaded_file($_FILES['header_logo']['tmp_name'], $target)) {
                foreach (['ru', 'en'] as $language) {
                    $updateSetting->execute([$language, 'header_logo_path', '/storage/uploads/' . $name]);
                }
            }
        }

        redirect('/admin/header');
    }

    render_partial('admin/header', [
        'settings' => $settings,
        'nav_ru' => $navRu,
        'nav_en' => $navEn,
    ]);
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
