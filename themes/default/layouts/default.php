<?php
$navStmt = db()->prepare('SELECT label, url FROM navigation_items WHERE language = ? ORDER BY sort_order');
$navStmt->execute([$language]);
$navItems = $navStmt->fetchAll();
$siteSettings = db()->prepare('SELECT `key`, `value` FROM site_settings WHERE language = ?');
$siteSettings->execute([$language]);
$settings = [];
foreach ($siteSettings->fetchAll() as $row) {
    $settings[$row['key']] = $row['value'];
}
$metaTitle = $page['meta_title'] ?? $page['title'] ?? $settings['site_title'] ?? '';
$metaDescription = $page['meta_description'] ?? $settings['site_description'] ?? '';
$canonical = $page['canonical'] ?? '';
$robots = $page['robots'] ?? 'index,follow';
$ogTitle = $page['og_title'] ?? $metaTitle;
$ogDescription = $page['og_description'] ?? $metaDescription;
$baseUrl = config('base_url');
$breadcrumbs = [
    [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => t('breadcrumb.home', $language),
        'item' => $baseUrl . '/' . $language . '/',
    ],
];
$segments = array_values(array_filter(explode('/', trim($_SERVER['REQUEST_URI'], '/'))));
if (isset($segments[1])) {
    $pathSlug = $segments[1];
    if ($pathSlug === 'products' && isset($segments[2])) {
        $stmt = db()->prepare('SELECT ct.name FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE c.slug = ? AND ct.language = ?');
        $stmt->execute([$segments[2], $language]);
        $name = $stmt->fetchColumn();
        if ($name) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => t('products.h1', $language),
                'item' => $baseUrl . '/' . $language . '/products/',
            ];
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $name,
                'item' => $baseUrl . '/' . $language . '/products/' . $segments[2] . '/',
            ];
        }
    } elseif ($pathSlug === 'product' && isset($segments[2])) {
        $stmt = db()->prepare('SELECT pt.name FROM products p JOIN product_translations pt ON pt.product_id = p.id WHERE p.slug = ? AND pt.language = ?');
        $stmt->execute([$segments[2], $language]);
        $name = $stmt->fetchColumn();
        if ($name) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => t('products.h1', $language),
                'item' => $baseUrl . '/' . $language . '/products/',
            ];
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $name,
                'item' => $baseUrl . '/' . $language . '/product/' . $segments[2] . '/',
            ];
        }
    } else {
        $stmt = db()->prepare('SELECT pt.title FROM pages p JOIN page_translations pt ON pt.page_id = p.id WHERE p.slug = ? AND pt.language = ?');
        $stmt->execute([$pathSlug ?: 'home', $language]);
        $title = $stmt->fetchColumn();
        if ($title) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $title,
                'item' => $baseUrl . '/' . $language . '/' . ($pathSlug === 'home' ? '' : $pathSlug . '/'),
            ];
        }
    }
}
?>
<!doctype html>
<html lang="<?= htmlspecialchars($language, ENT_QUOTES) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($metaTitle, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES) ?>">
    <meta name="robots" content="<?= htmlspecialchars($robots, ENT_QUOTES) ?>">
    <?php if (!empty($canonical)) : ?>
        <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <?php endif; ?>
    <link rel="alternate" href="<?= htmlspecialchars($baseUrl . '/ru' . ($_SERVER['REQUEST_URI'] === '/ru/' ? '/' : substr($_SERVER['REQUEST_URI'], 3)), ENT_QUOTES) ?>" hreflang="ru">
    <link rel="alternate" href="<?= htmlspecialchars($baseUrl . '/en' . ($_SERVER['REQUEST_URI'] === '/en/' ? '/' : substr($_SERVER['REQUEST_URI'], 3)), ENT_QUOTES) ?>" hreflang="en">
    <meta property="og:title" content="<?= htmlspecialchars($ogTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($ogDescription, ENT_QUOTES) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($baseUrl . $_SERVER['REQUEST_URI'], ENT_QUOTES) ?>">
    <link rel="stylesheet" href="/themes/default/styles.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <a class="logo" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars($settings['brand_name'] ?? '', ENT_QUOTES) ?></a>
        <nav class="nav">
            <?php foreach ($navItems as $item) : ?>
                <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES) ?>"><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="language-switch">
            <a href="/ru/" <?= $language === 'ru' ? 'class="active"' : '' ?>>RU</a>
            <a href="/en/" <?= $language === 'en' ? 'class="active"' : '' ?>>EN</a>
        </div>
    </div>
</header>
<main class="site-main">
    <?php include $templatePath; ?>
</main>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-title"><?= htmlspecialchars($settings['footer_title'] ?? '', ENT_QUOTES) ?></div>
                <div class="footer-text"><?= nl2br(htmlspecialchars($settings['footer_text'] ?? '', ENT_QUOTES)) ?></div>
            </div>
            <div>
                <div class="footer-title"><?= htmlspecialchars($settings['footer_contacts_title'] ?? '', ENT_QUOTES) ?></div>
                <div class="footer-text"><?= nl2br(htmlspecialchars($settings['footer_contacts'] ?? '', ENT_QUOTES)) ?></div>
            </div>
        </div>
    </div>
</footer>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $settings['brand_name'] ?? '',
    'url' => $baseUrl,
    'description' => $settings['brand_description'] ?? '',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $breadcrumbs,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
</body>
</html>
