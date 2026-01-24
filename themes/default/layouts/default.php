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
$footerLinksStmt = db()->prepare('SELECT label, url FROM footer_links WHERE language = ? ORDER BY sort_order');
$footerLinksStmt->execute([$language]);
$footerLinks = $footerLinksStmt->fetchAll();
$pageData = $page ?? [];
$metaTitle = $pageData['meta_title'] ?? $pageData['title'] ?? $settings['site_title'] ?? '';
$metaDescription = $pageData['meta_description'] ?? $settings['site_description'] ?? '';
$canonical = $pageData['canonical'] ?? '';
$robots = $pageData['robots'] ?? 'index,follow';
$ogTitle = $pageData['og_title'] ?? $metaTitle;
$ogDescription = $pageData['og_description'] ?? $metaDescription;
$useLayout = isset($pageData['use_layout']) ? (int) $pageData['use_layout'] : 1;
$replaceStyles = isset($pageData['replace_styles']) ? (int) $pageData['replace_styles'] : 0;
$customCss = $pageData['custom_css'] ?? '';
$isHome = ($pageData['slug'] ?? '') === 'home';
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
    <?php if (!$replaceStyles) : ?>
        <link rel="stylesheet" href="/themes/default/styles.css">
    <?php else : ?>
        <style>
            body { margin: 0; font-family: "Inter", "Segoe UI", sans-serif; }
        </style>
    <?php endif; ?>
    <?php if (!empty($customCss)) : ?>
        <style><?= $customCss ?></style>
    <?php endif; ?>
</head>
<body class="<?= $isHome ? 'is-home' : '' ?><?= $useLayout ? '' : ' no-layout' ?>">
<?php if ($useLayout) : ?>
<header class="site-header<?= $isHome ? ' is-hero' : '' ?>">
    <div class="container">
        <div class="header-left">
            <?php if (!empty($settings['header_show_logo']) && !empty($settings['header_logo_path'])) : ?>
                <a class="logo logo-image" href="<?= htmlspecialchars($settings['header_logo_link'] ?? '/', ENT_QUOTES) ?>">
                    <img src="<?= htmlspecialchars($settings['header_logo_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($settings['header_logo_alt'] ?? '', ENT_QUOTES) ?>">
                </a>
            <?php else : ?>
                <a class="logo" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars($settings['brand_name'] ?? '', ENT_QUOTES) ?></a>
            <?php endif; ?>
        </div>
        <button class="nav-toggle" type="button" aria-label="<?= htmlspecialchars(t('nav.toggle', $language), ENT_QUOTES) ?>" aria-expanded="false" aria-controls="site-nav">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="nav" id="site-nav">
            <div class="nav-top">
                <button class="nav-close" type="button" aria-label="<?= htmlspecialchars(t('nav.close', $language), ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('nav.close', $language), ENT_QUOTES) ?>
                </button>
            </div>
            <?php foreach ($navItems as $item) : ?>
                <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES) ?>"><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></a>
            <?php endforeach; ?>
            <div class="nav-footer">
                <div class="nav-contacts"><?= nl2br(htmlspecialchars($settings['footer_contacts'] ?? '', ENT_QUOTES)) ?></div>
                <div class="nav-language">
                    <a href="/ru/" <?= $language === 'ru' ? 'class="active"' : '' ?>>RU</a>
                    <a href="/en/" <?= $language === 'en' ? 'class="active"' : '' ?>>EN</a>
                </div>
            </div>
        </nav>
        <div class="header-actions">
            <div class="language-switch">
                <a href="/ru/" <?= $language === 'ru' ? 'class="active"' : '' ?>>RU</a>
                <a href="/en/" <?= $language === 'en' ? 'class="active"' : '' ?>>EN</a>
            </div>
        </div>
    </div>
</header>
<?php endif; ?>
<main class="site-main<?= $useLayout ? '' : ' is-custom' ?>">
    <?php include $templatePath; ?>
</main>
<?php if ($useLayout) : ?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-title"><?= htmlspecialchars($settings['footer_title'] ?? '', ENT_QUOTES) ?></div>
                <div class="footer-text"><?= nl2br(htmlspecialchars($settings['footer_text'] ?? '', ENT_QUOTES)) ?></div>
            </div>
            <div>
                <div class="footer-title"><?= htmlspecialchars(t('footer.links', $language), ENT_QUOTES) ?></div>
                <div class="footer-text">
                    <?php foreach ($footerLinks as $item) : ?>
                        <div><a href="<?= htmlspecialchars($item['url'], ENT_QUOTES) ?>"><?= htmlspecialchars($item['label'], ENT_QUOTES) ?></a></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div>
                <div class="footer-title"><?= htmlspecialchars($settings['footer_contacts_title'] ?? '', ENT_QUOTES) ?></div>
                <div class="footer-text"><?= nl2br(htmlspecialchars($settings['footer_contacts'] ?? '', ENT_QUOTES)) ?></div>
            </div>
        </div>
        <div class="footer-meta"><?= htmlspecialchars($settings['footer_copyright'] ?? '© System Power', ENT_QUOTES) ?></div>
    </div>
</footer>
<?php endif; ?>
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
<script>
    const header = document.querySelector('.site-header');
    const navToggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.nav');
    const navClose = document.querySelector('.nav-close');
    if (navToggle) {
        navToggle.addEventListener('click', () => {
            const isOpen = document.body.classList.toggle('nav-open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }
    if (navClose) {
        navClose.addEventListener('click', () => {
            document.body.classList.remove('nav-open');
            navToggle?.setAttribute('aria-expanded', 'false');
        });
    }
    const closeNav = () => {
        document.body.classList.remove('nav-open');
        navToggle?.setAttribute('aria-expanded', 'false');
    };
    if (nav) {
        nav.addEventListener('click', (event) => {
            if (event.target instanceof HTMLElement && event.target.tagName === 'A') {
                closeNav();
            }
        });
    }
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeNav();
        }
    });
    let touchStartX = 0;
    nav?.addEventListener('touchstart', (event) => {
        if (event.touches.length) {
            touchStartX = event.touches[0].clientX;
        }
    });
    nav?.addEventListener('touchend', (event) => {
        if (event.changedTouches.length) {
            const deltaX = touchStartX - event.changedTouches[0].clientX;
            if (deltaX > 80) {
                closeNav();
            }
        }
    });
    const onScroll = () => {
        if (window.scrollY > 12) {
            header?.classList.add('is-compact');
            header?.classList.add('is-scrolled');
        } else {
            header?.classList.remove('is-compact');
            header?.classList.remove('is-scrolled');
        }
    };
    window.addEventListener('scroll', onScroll);
    onScroll();
</script>
</body>
</html>
