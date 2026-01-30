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

if ($path === '/admin/partners/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $partnerId = (int) ($_POST['id'] ?? 0);
    if ($partnerId > 0) {
        $stmt = db()->prepare('DELETE FROM partners WHERE id = ?');
        $stmt->execute([$partnerId]);
    }
    redirect('/admin/partners');
}

if ($path === '/admin/blocks/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $sectionId = (int) ($_POST['id'] ?? 0);
    $pageId = (int) ($_POST['page_id'] ?? 0);
    if ($sectionId > 0) {
        $stmt = db()->prepare('DELETE FROM page_sections WHERE id = ?');
        $stmt->execute([$sectionId]);
    }
    redirect('/admin/blocks?page_id=' . $pageId);
}

if ($path === '/admin/translations/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $translationId = (int) ($_POST['id'] ?? 0);
    if ($translationId > 0) {
        $stmt = db()->prepare('DELETE FROM i18n_strings WHERE id = ?');
        $stmt->execute([$translationId]);
    }
    redirect('/admin/translations');
}

if ($path === '/admin/pages') {
    $stmt = db()->query("SELECT p.id, p.slug, p.status,
        MAX(CASE WHEN sm.locale = 'ru' THEN sm.h1 END) AS h1_ru,
        MAX(CASE WHEN sm.locale = 'en' THEN sm.h1 END) AS h1_en
        FROM pages p
        LEFT JOIN seo_meta sm ON sm.entity_type = 'page' AND sm.entity_id = p.id
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
    $seo = [
        'ru' => [
            'title' => trim($_POST['title_ru'] ?? ''),
            'h1' => trim($_POST['h1_ru'] ?? ''),
            'description' => trim($_POST['description_ru'] ?? ''),
            'slug' => trim($_POST['slug_ru'] ?? ''),
            'canonical' => trim($_POST['canonical_ru'] ?? ''),
        ],
        'en' => [
            'title' => trim($_POST['title_en'] ?? ''),
            'h1' => trim($_POST['h1_en'] ?? ''),
            'description' => trim($_POST['description_en'] ?? ''),
            'slug' => trim($_POST['slug_en'] ?? ''),
            'canonical' => trim($_POST['canonical_en'] ?? ''),
        ],
    ];

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
            $stmt = $pdo->prepare('INSERT INTO pages (slug, status, created_at, updated_at) VALUES (?, ?, NOW(), NOW())');
            $stmt->execute([$slug, $status]);
            $pageId = (int) $pdo->lastInsertId();
            $insertMeta = $pdo->prepare('INSERT INTO seo_meta (entity_type, entity_id, locale, title, description, h1, slug, canonical, created_at, updated_at) VALUES ("page", ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
            foreach (['ru', 'en'] as $locale) {
                $data = $seo[$locale];
                $insertMeta->execute([
                    $pageId,
                    $locale,
                    $data['title'],
                    $data['description'],
                    $data['h1'],
                    $data['slug'],
                    $data['canonical'] ?: null,
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
        'seo' => $seo,
    ]);
    exit;
}

if ($path === '/admin/pages/edit' && isset($_GET['id'])) {
    $pageId = (int) $_GET['id'];
    $stmt = db()->prepare('SELECT id, slug, status FROM pages WHERE id = ?');
    $stmt->execute([$pageId]);
    $page = $stmt->fetch();

    if (!$page) {
        redirect('/admin/pages');
    }

    $seoStmt = db()->prepare('SELECT * FROM seo_meta WHERE entity_type = "page" AND entity_id = ?');
    $seoStmt->execute([$pageId]);
    $seoRows = $seoStmt->fetchAll();
    $seo = ['ru' => [], 'en' => []];
    foreach ($seoRows as $row) {
        $seo[$row['locale']] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $slug = trim($_POST['slug'] ?? '');
        $status = $_POST['status'] ?? 'published';
        $update = db()->prepare('UPDATE pages SET slug = ?, status = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([$slug, $status, $pageId]);

        $updateMeta = db()->prepare('UPDATE seo_meta SET title = ?, description = ?, h1 = ?, slug = ?, canonical = ?, updated_at = NOW() WHERE entity_type = "page" AND entity_id = ? AND locale = ?');
        foreach (['ru', 'en'] as $locale) {
            $updateMeta->execute([
                trim($_POST['title_' . $locale] ?? ''),
                trim($_POST['description_' . $locale] ?? ''),
                trim($_POST['h1_' . $locale] ?? ''),
                trim($_POST['slug_' . $locale] ?? ''),
                trim($_POST['canonical_' . $locale] ?? '') ?: null,
                $pageId,
                $locale,
            ]);
        }
        redirect('/admin/pages/edit?id=' . $pageId);
    }

    render_partial('admin/page-edit', [
        'page' => $page,
        'seo' => $seo,
    ]);
    exit;
}

if ($path === '/admin/blocks' && isset($_GET['page_id'])) {
    $pageId = (int) $_GET['page_id'];
    $stmt = db()->prepare('SELECT id, slug FROM pages WHERE id = ?');
    $stmt->execute([$pageId]);
    $page = $stmt->fetch();
    if (!$page) {
        redirect('/admin/pages');
    }
    $sectionsStmt = db()->prepare('SELECT * FROM page_sections WHERE page_id = ? ORDER BY sort_order');
    $sectionsStmt->execute([$pageId]);
    render_partial('admin/blocks', [
        'page' => $page,
        'sections' => $sectionsStmt->fetchAll(),
    ]);
    exit;
}

if ($path === '/admin/blocks/create' && isset($_GET['page_id'])) {
    $pageId = (int) $_GET['page_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = db()->prepare('INSERT INTO page_sections (page_id, section_key, template, sort_order, data_json, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([
            $pageId,
            trim($_POST['section_key'] ?? ''),
            trim($_POST['template'] ?? ''),
            (int) ($_POST['sort_order'] ?? 0),
            $_POST['data_json'] ?? '',
        ]);
        redirect('/admin/blocks?page_id=' . $pageId);
    }
    render_partial('admin/block-edit', [
        'section' => [
            'section_key' => '',
            'template' => '',
            'sort_order' => 0,
            'data_json' => '{}',
        ],
        'pageId' => $pageId,
    ]);
    exit;
}

if ($path === '/admin/blocks/edit' && isset($_GET['id'])) {
    $sectionId = (int) $_GET['id'];
    $stmt = db()->prepare('SELECT * FROM page_sections WHERE id = ?');
    $stmt->execute([$sectionId]);
    $section = $stmt->fetch();
    if (!$section) {
        redirect('/admin/pages');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE page_sections SET section_key = ?, template = ?, sort_order = ?, data_json = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([
            trim($_POST['section_key'] ?? ''),
            trim($_POST['template'] ?? ''),
            (int) ($_POST['sort_order'] ?? 0),
            $_POST['data_json'] ?? '',
            $sectionId,
        ]);
        redirect('/admin/blocks?page_id=' . $section['page_id']);
    }
    render_partial('admin/block-edit', [
        'section' => $section,
        'pageId' => $section['page_id'],
    ]);
    exit;
}

if ($path === '/admin/categories') {
    $stmt = db()->query("SELECT c.id, c.code, c.is_active,
        MAX(CASE WHEN ci.locale = 'ru' THEN ci.name END) AS name_ru,
        MAX(CASE WHEN ci.locale = 'en' THEN ci.name END) AS name_en
        FROM categories c
        LEFT JOIN category_i18n ci ON ci.category_id = c.id
        GROUP BY c.id
        ORDER BY c.id");
    $categories = $stmt->fetchAll();
    render_partial('admin/categories', ['categories' => $categories]);
    exit;
}

if ($path === '/admin/categories/create') {
    $errors = [];
    $code = trim($_POST['code'] ?? '');
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $translations = [
        'ru' => [
            'name' => trim($_POST['name_ru'] ?? ''),
            'description' => trim($_POST['description_ru'] ?? ''),
        ],
        'en' => [
            'name' => trim($_POST['name_en'] ?? ''),
            'description' => trim($_POST['description_en'] ?? ''),
        ],
    ];
    $seo = [
        'ru' => [
            'title' => trim($_POST['meta_title_ru'] ?? ''),
            'description' => trim($_POST['meta_description_ru'] ?? ''),
            'h1' => trim($_POST['h1_ru'] ?? ''),
            'slug' => trim($_POST['slug_ru'] ?? ''),
        ],
        'en' => [
            'title' => trim($_POST['meta_title_en'] ?? ''),
            'description' => trim($_POST['meta_description_en'] ?? ''),
            'h1' => trim($_POST['h1_en'] ?? ''),
            'slug' => trim($_POST['slug_en'] ?? ''),
        ],
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($code === '') {
            $errors['code'] = 'Укажите код категории.';
        }
        $existing = db()->prepare('SELECT id FROM categories WHERE code = ? LIMIT 1');
        $existing->execute([$code]);
        if ($existing->fetch()) {
            $errors['code'] = 'Код уже используется.';
        }

        if (empty($errors)) {
            foreach (['ru', 'en'] as $locale) {
                $baseSlug = slugify($translations[$locale]['name']);
                $seo[$locale]['slug'] = unique_product_slug($baseSlug, $locale);
            }
            $pdo = db();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO categories (code, is_active, created_at, updated_at) VALUES (?, ?, NOW(), NOW())');
            $stmt->execute([$code, $isActive]);
            $categoryId = (int) $pdo->lastInsertId();
            $insertTranslation = $pdo->prepare('INSERT INTO category_i18n (category_id, locale, name, description, is_html, created_at, updated_at) VALUES (?, ?, ?, ?, 0, NOW(), NOW())');
            $insertSeo = $pdo->prepare('INSERT INTO seo_meta (entity_type, entity_id, locale, title, description, h1, slug, created_at, updated_at) VALUES ("category", ?, ?, ?, ?, ?, ?, NOW(), NOW())');
            foreach (['ru', 'en'] as $locale) {
                $insertTranslation->execute([$categoryId, $locale, $translations[$locale]['name'], $translations[$locale]['description']]);
                $insertSeo->execute([$categoryId, $locale, $seo[$locale]['title'], $seo[$locale]['description'], $seo[$locale]['h1'], $seo[$locale]['slug']]);
            }
            $pdo->commit();
            redirect('/admin/categories/edit?id=' . $categoryId);
        }
    }

    render_partial('admin/category-create', [
        'errors' => $errors,
        'code' => $code,
        'isActive' => $isActive,
        'translations' => $translations,
        'seo' => $seo,
    ]);
    exit;
}

if ($path === '/admin/categories/edit' && isset($_GET['id'])) {
    $categoryId = (int) $_GET['id'];
    $stmt = db()->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$categoryId]);
    $category = $stmt->fetch();
    if (!$category) {
        redirect('/admin/categories');
    }
    $translationsStmt = db()->prepare('SELECT * FROM category_i18n WHERE category_id = ?');
    $translationsStmt->execute([$categoryId]);
    $translations = ['ru' => [], 'en' => []];
    foreach ($translationsStmt->fetchAll() as $row) {
        $translations[$row['locale']] = $row;
    }
    $seoStmt = db()->prepare('SELECT * FROM seo_meta WHERE entity_type = "category" AND entity_id = ?');
    $seoStmt->execute([$categoryId]);
    $seo = ['ru' => [], 'en' => []];
    foreach ($seoStmt->fetchAll() as $row) {
        $seo[$row['locale']] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE categories SET code = ?, is_active = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([
            trim($_POST['code'] ?? ''),
            isset($_POST['is_active']) ? 1 : 0,
            $categoryId,
        ]);
        $updateTranslation = db()->prepare('UPDATE category_i18n SET name = ?, description = ?, updated_at = NOW() WHERE category_id = ? AND locale = ?');
        $updateSeo = db()->prepare('UPDATE seo_meta SET title = ?, description = ?, h1 = ?, slug = ?, updated_at = NOW() WHERE entity_type = "category" AND entity_id = ? AND locale = ?');
        foreach (['ru', 'en'] as $locale) {
            $updateTranslation->execute([
                trim($_POST['name_' . $locale] ?? ''),
                trim($_POST['description_' . $locale] ?? ''),
                $categoryId,
                $locale,
            ]);
            $updateSeo->execute([
                trim($_POST['meta_title_' . $locale] ?? ''),
                trim($_POST['meta_description_' . $locale] ?? ''),
                trim($_POST['h1_' . $locale] ?? ''),
                trim($_POST['slug_' . $locale] ?? ''),
                $categoryId,
                $locale,
            ]);
        }
        redirect('/admin/categories/edit?id=' . $categoryId);
    }

    render_partial('admin/category-edit', [
        'category' => $category,
        'translations' => $translations,
        'seo' => $seo,
    ]);
    exit;
}

if ($path === '/admin/products') {
    $stmt = db()->query("SELECT p.id, p.sku, p.is_active, c.code,
        MAX(CASE WHEN pi.locale = 'ru' THEN pi.name END) AS name_ru,
        MAX(CASE WHEN pi.locale = 'en' THEN pi.name END) AS name_en
        FROM products p
        LEFT JOIN product_i18n pi ON pi.product_id = p.id
        LEFT JOIN categories c ON c.id = p.category_id
        GROUP BY p.id
        ORDER BY p.id DESC");
    $products = $stmt->fetchAll();
    render_partial('admin/products', ['products' => $products]);
    exit;
}

if ($path === '/admin/products/create') {
    $errors = [];
    $categories = db()->query('SELECT id, code FROM categories ORDER BY id')->fetchAll();
    $product = [
        'category_id' => $_POST['category_id'] ?? ($categories[0]['id'] ?? null),
        'sku' => trim($_POST['sku'] ?? ''),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'sort_order' => (int) ($_POST['sort_order'] ?? 0),
    ];
    $translations = [
        'ru' => [
            'name' => trim($_POST['name_ru'] ?? ''),
            'short_description' => trim($_POST['short_description_ru'] ?? ''),
            'description' => $_POST['description_ru'] ?? '',
            'is_html' => isset($_POST['is_html_ru']) ? 1 : 0,
        ],
        'en' => [
            'name' => trim($_POST['name_en'] ?? ''),
            'short_description' => trim($_POST['short_description_en'] ?? ''),
            'description' => $_POST['description_en'] ?? '',
            'is_html' => isset($_POST['is_html_en']) ? 1 : 0,
        ],
    ];
    $seo = [
        'ru' => [
            'title' => trim($_POST['meta_title_ru'] ?? ''),
            'description' => trim($_POST['meta_description_ru'] ?? ''),
            'h1' => trim($_POST['h1_ru'] ?? ''),
            'slug' => trim($_POST['slug_ru'] ?? ''),
        ],
        'en' => [
            'title' => trim($_POST['meta_title_en'] ?? ''),
            'description' => trim($_POST['meta_description_en'] ?? ''),
            'h1' => trim($_POST['h1_en'] ?? ''),
            'slug' => trim($_POST['slug_en'] ?? ''),
        ],
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($product['category_id'])) {
            $errors['category_id'] = 'Выберите категорию.';
        }

        if (empty($errors)) {
            $pdo = db();
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO products (category_id, sku, is_active, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');
            $stmt->execute([$product['category_id'], $product['sku'], $product['is_active'], $product['sort_order']]);
            $productId = (int) $pdo->lastInsertId();
            $insertTranslation = $pdo->prepare('INSERT INTO product_i18n (product_id, locale, name, short_description, description, is_html, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())');
            $insertSeo = $pdo->prepare('INSERT INTO seo_meta (entity_type, entity_id, locale, title, description, h1, slug, created_at, updated_at) VALUES ("product", ?, ?, ?, ?, ?, ?, NOW(), NOW())');
            foreach (['ru', 'en'] as $locale) {
                $insertTranslation->execute([
                    $productId,
                    $locale,
                    $translations[$locale]['name'],
                    $translations[$locale]['short_description'],
                    $translations[$locale]['description'],
                    $translations[$locale]['is_html'],
                ]);
                $insertSeo->execute([
                    $productId,
                    $locale,
                    $seo[$locale]['title'],
                    $seo[$locale]['description'],
                    $seo[$locale]['h1'],
                    $seo[$locale]['slug'],
                ]);
            }
            $pdo->commit();
            redirect('/admin/products/edit?id=' . $productId);
        }
    }

    render_partial('admin/product-create', [
        'errors' => $errors,
        'categories' => $categories,
        'product' => $product,
        'translations' => $translations,
        'seo' => $seo,
    ]);
    exit;
}

if ($path === '/admin/products/edit' && isset($_GET['id'])) {
    $productId = (int) $_GET['id'];
    $productStmt = db()->prepare('SELECT * FROM products WHERE id = ?');
    $productStmt->execute([$productId]);
    $product = $productStmt->fetch();
    if (!$product) {
        redirect('/admin/products');
    }
    $categories = db()->query('SELECT id, code FROM categories ORDER BY id')->fetchAll();
    $translationsStmt = db()->prepare('SELECT * FROM product_i18n WHERE product_id = ?');
    $translationsStmt->execute([$productId]);
    $translations = ['ru' => [], 'en' => []];
    foreach ($translationsStmt->fetchAll() as $row) {
        $translations[$row['locale']] = $row;
    }
    $seoStmt = db()->prepare('SELECT * FROM seo_meta WHERE entity_type = "product" AND entity_id = ?');
    $seoStmt->execute([$productId]);
    $seo = ['ru' => [], 'en' => []];
    foreach ($seoStmt->fetchAll() as $row) {
        $seo[$row['locale']] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach (['ru', 'en'] as $locale) {
            $baseSlug = slugify(trim($_POST['name_' . $locale] ?? ''));
            $seo[$locale]['slug'] = unique_product_slug($baseSlug, $locale, $productId);
        }
        $update = db()->prepare('UPDATE products SET category_id = ?, sku = ?, is_active = ?, sort_order = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([
            (int) ($_POST['category_id'] ?? $product['category_id']),
            trim($_POST['sku'] ?? ''),
            isset($_POST['is_active']) ? 1 : 0,
            (int) ($_POST['sort_order'] ?? 0),
            $productId,
        ]);
        $updateTranslation = db()->prepare('UPDATE product_i18n SET name = ?, short_description = ?, description = ?, is_html = ?, updated_at = NOW() WHERE product_id = ? AND locale = ?');
        $updateSeo = db()->prepare('UPDATE seo_meta SET title = ?, description = ?, h1 = ?, slug = ?, updated_at = NOW() WHERE entity_type = "product" AND entity_id = ? AND locale = ?');
        foreach (['ru', 'en'] as $locale) {
            $updateTranslation->execute([
                trim($_POST['name_' . $locale] ?? ''),
                trim($_POST['short_description_' . $locale] ?? ''),
                $_POST['description_' . $locale] ?? '',
                isset($_POST['is_html_' . $locale]) ? 1 : 0,
                $productId,
                $locale,
            ]);
            $updateSeo->execute([
                trim($_POST['meta_title_' . $locale] ?? ''),
                trim($_POST['meta_description_' . $locale] ?? ''),
                trim($_POST['h1_' . $locale] ?? ''),
                $seo[$locale]['slug'],
                $productId,
                $locale,
            ]);
        }
        redirect('/admin/products/edit?id=' . $productId);
    }

    render_partial('admin/product-edit', [
        'product' => $product,
        'categories' => $categories,
        'translations' => $translations,
        'seo' => $seo,
    ]);
    exit;
}

if ($path === '/admin/products/specs' && isset($_GET['product_id'])) {
    $productId = (int) $_GET['product_id'];
    $specsStmt = db()->prepare(
        'SELECT ps.id, ps.spec_key, ps.sort_order,
            MAX(CASE WHEN psi.locale = "ru" THEN psi.name END) AS name_ru,
            MAX(CASE WHEN psi.locale = "ru" THEN psi.value END) AS value_ru,
            MAX(CASE WHEN psi.locale = "en" THEN psi.name END) AS name_en,
            MAX(CASE WHEN psi.locale = "en" THEN psi.value END) AS value_en
         FROM product_specs ps
         LEFT JOIN product_specs_i18n psi ON psi.product_spec_id = ps.id
         WHERE ps.product_id = ?
         GROUP BY ps.id
         ORDER BY ps.sort_order'
    );
    $specsStmt->execute([$productId]);
    $specs = $specsStmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = db();
        $pdo->beginTransaction();
        $pdo->prepare('DELETE FROM product_specs_i18n WHERE product_spec_id IN (SELECT id FROM product_specs WHERE product_id = ?)')->execute([$productId]);
        $pdo->prepare('DELETE FROM product_specs WHERE product_id = ?')->execute([$productId]);
        $specRows = $_POST['specs'] ?? [];
        $insertSpec = $pdo->prepare('INSERT INTO product_specs (product_id, spec_key, sort_order) VALUES (?, ?, ?)');
        $insertSpecI18n = $pdo->prepare('INSERT INTO product_specs_i18n (product_spec_id, locale, name, value) VALUES (?, ?, ?, ?)');
        foreach ($specRows as $index => $row) {
            $specKey = trim($row['spec_key'] ?? ('spec_' . $index));
            $insertSpec->execute([$productId, $specKey, $index]);
            $specId = (int) $pdo->lastInsertId();
            $insertSpecI18n->execute([$specId, 'ru', trim($row['name_ru'] ?? ''), trim($row['value_ru'] ?? '')]);
            $insertSpecI18n->execute([$specId, 'en', trim($row['name_en'] ?? ''), trim($row['value_en'] ?? '')]);
        }
        $pdo->commit();
        redirect('/admin/products/specs?product_id=' . $productId);
    }

    render_partial('admin/product-specs', [
        'specs' => $specs,
        'productId' => $productId,
    ]);
    exit;
}

if ($path === '/admin/products/import') {
    $importResult = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $command = escapeshellcmd(PHP_BINARY . ' ' . dirname(__DIR__, 2) . '/scripts/import_products.php');
        $output = [];
        $status = 0;
        exec($command, $output, $status);
        $importResult = [
            'status' => $status,
            'output' => $output,
        ];
    }
    render_partial('admin/product-import', [
        'importResult' => $importResult,
    ]);
    exit;
}

if ($path === '/admin/partners') {
    $stmt = db()->query('SELECT * FROM partners ORDER BY sort_order, id');
    $partners = $stmt->fetchAll();
    render_partial('admin/partners', ['partners' => $partners]);
    exit;
}

if ($path === '/admin/partners/create') {
    $partner = [
        'type' => $_POST['type'] ?? 'distributor',
        'name' => trim($_POST['name'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'url' => trim($_POST['url'] ?? ''),
        'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'logo_media_id' => null,
    ];
    $translations = [
        'ru' => trim($_POST['description_ru'] ?? ''),
        'en' => trim($_POST['description_en'] ?? ''),
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $logoMediaId = store_uploaded_media($_FILES['logo'] ?? [], 'partners');
        $pdo = db();
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO partners (type, name, city, url, sort_order, is_active, logo_media_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([
            $partner['type'],
            $partner['name'],
            $partner['city'] ?: null,
            $partner['url'],
            $partner['sort_order'],
            $partner['is_active'],
            $logoMediaId,
        ]);
        $partnerId = (int) $pdo->lastInsertId();
        $insertTranslation = $pdo->prepare('INSERT INTO partner_i18n (partner_id, locale, description, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())');
        foreach (['ru', 'en'] as $locale) {
            $insertTranslation->execute([$partnerId, $locale, $translations[$locale]]);
        }
        $pdo->commit();
        redirect('/admin/partners/edit?id=' . $partnerId);
    }

    render_partial('admin/partner-create', [
        'partner' => $partner,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/partners/edit' && isset($_GET['id'])) {
    $partnerId = (int) $_GET['id'];
    $stmt = db()->prepare('SELECT * FROM partners WHERE id = ?');
    $stmt->execute([$partnerId]);
    $partner = $stmt->fetch();
    if (!$partner) {
        redirect('/admin/partners');
    }
    $translationsStmt = db()->prepare('SELECT * FROM partner_i18n WHERE partner_id = ?');
    $translationsStmt->execute([$partnerId]);
    $translations = ['ru' => '', 'en' => ''];
    foreach ($translationsStmt->fetchAll() as $row) {
        $translations[$row['locale']] = $row['description'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $logoMediaId = store_uploaded_media($_FILES['logo'] ?? [], 'partners');
        $update = db()->prepare('UPDATE partners SET type = ?, name = ?, city = ?, url = ?, sort_order = ?, is_active = ?, logo_media_id = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([
            $_POST['type'] ?? $partner['type'],
            trim($_POST['name'] ?? ''),
            trim($_POST['city'] ?? ''),
            trim($_POST['url'] ?? ''),
            (int) ($_POST['sort_order'] ?? 0),
            isset($_POST['is_active']) ? 1 : 0,
            $logoMediaId ?: $partner['logo_media_id'],
            $partnerId,
        ]);
        $updateTranslation = db()->prepare('UPDATE partner_i18n SET description = ?, updated_at = NOW() WHERE partner_id = ? AND locale = ?');
        foreach (['ru', 'en'] as $locale) {
            $updateTranslation->execute([
                trim($_POST['description_' . $locale] ?? ''),
                $partnerId,
                $locale,
            ]);
        }
        redirect('/admin/partners/edit?id=' . $partnerId);
    }

    render_partial('admin/partner-edit', [
        'partner' => $partner,
        'translations' => $translations,
    ]);
    exit;
}

if ($path === '/admin/leads') {
    $stmt = db()->query('SELECT * FROM leads ORDER BY created_at DESC');
    $leads = $stmt->fetchAll();
    render_partial('admin/leads', ['leads' => $leads]);
    exit;
}

if ($path === '/admin/leads/edit' && isset($_GET['id'])) {
    $leadId = (int) $_GET['id'];
    $stmt = db()->prepare('SELECT * FROM leads WHERE id = ?');
    $stmt->execute([$leadId]);
    $lead = $stmt->fetch();
    if (!$lead) {
        redirect('/admin/leads');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE leads SET status = ?, admin_comment = ? WHERE id = ?');
        $update->execute([
            $_POST['status'] ?? $lead['status'],
            trim($_POST['admin_comment'] ?? ''),
            $leadId,
        ]);
        redirect('/admin/leads/edit?id=' . $leadId);
    }
    render_partial('admin/lead-edit', ['lead' => $lead]);
    exit;
}

if ($path === '/admin/translations') {
    $search = trim($_GET['q'] ?? '');
    $query = 'SELECT * FROM i18n_strings';
    $params = [];
    if ($search !== '') {
        $query .= ' WHERE `key` LIKE ?';
        $params[] = '%' . $search . '%';
    }
    $query .= ' ORDER BY `key`, locale';
    $stmt = db()->prepare($query);
    $stmt->execute($params);
    render_partial('admin/translations', [
        'translations' => $stmt->fetchAll(),
        'search' => $search,
    ]);
    exit;
}

if ($path === '/admin/translations/create') {
    $translation = [
        'key' => trim($_POST['key'] ?? ''),
        'locale' => $_POST['locale'] ?? 'ru',
        'value' => $_POST['value'] ?? '',
        'is_html' => isset($_POST['is_html']) ? 1 : 0,
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = db()->prepare('INSERT INTO i18n_strings (`key`, locale, value, is_html, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([$translation['key'], $translation['locale'], $translation['value'], $translation['is_html']]);
        redirect('/admin/translations');
    }
    render_partial('admin/translation-edit', ['translation' => $translation]);
    exit;
}

if ($path === '/admin/translations/edit' && isset($_GET['id'])) {
    $translationId = (int) $_GET['id'];
    $stmt = db()->prepare('SELECT * FROM i18n_strings WHERE id = ?');
    $stmt->execute([$translationId]);
    $translation = $stmt->fetch();
    if (!$translation) {
        redirect('/admin/translations');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update = db()->prepare('UPDATE i18n_strings SET `key` = ?, locale = ?, value = ?, is_html = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([
            trim($_POST['key'] ?? ''),
            $_POST['locale'] ?? 'ru',
            $_POST['value'] ?? '',
            isset($_POST['is_html']) ? 1 : 0,
            $translationId,
        ]);
        redirect('/admin/translations/edit?id=' . $translationId);
    }
    render_partial('admin/translation-edit', ['translation' => $translation]);
    exit;
}

http_response_code(404);
render_partial('admin/404', ['language' => 'ru']);
