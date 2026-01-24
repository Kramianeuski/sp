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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updateProduct = db()->prepare('UPDATE products SET sku = ?, slug = ?, category_id = ?, status = ? WHERE id = ?');
        $updateProduct->execute([
            $_POST['sku'] ?? '',
            $_POST['slug'] ?? '',
            (int) ($_POST['category_id'] ?? 0),
            $_POST['status'] ?? 'draft',
            $product['id'],
        ]);

        $updateTranslation = db()->prepare('UPDATE product_translations SET name = ?, h1 = ?, short_description = ?, description = ?, meta_title = ?, meta_description = ?, indexable = ? WHERE id = ?');
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
        redirect('/admin/products');
    }

    render_partial('admin/product-edit', [
        'product' => $product,
        'translations' => $translations,
        'categories' => $categories,
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $updateSetting = $pdo->prepare('INSERT INTO site_settings (language, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)');
        foreach (['ru', 'en'] as $language) {
            $updateSetting->execute([$language, 'header_show_logo', isset($_POST['header_show_logo_' . $language]) ? '1' : '0']);
            $updateSetting->execute([$language, 'header_logo_link', $_POST['header_logo_link_' . $language] ?? '']);
            $updateSetting->execute([$language, 'header_logo_alt', $_POST['header_logo_alt_' . $language] ?? '']);
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

    render_partial('admin/header', ['settings' => $settings]);
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
