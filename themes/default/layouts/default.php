<?php
$baseUrl = config('base_url');
$brandName = t('brand.name', $language);
$brandDescription = t('brand.description', $language);
$logoPath = t('brand.logo_path', $language);
$logoAlt = t('brand.logo_alt', $language);
$headerCta = t('nav.cta', $language);

$categoriesStmt = db()->prepare(
    'SELECT c.id, ci.name, sm.slug
     FROM categories c
     JOIN category_i18n ci ON ci.category_id = c.id AND ci.locale = ?
     JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ?
     WHERE c.is_active = 1
     ORDER BY c.id'
);
$categoriesStmt->execute([$language, $language]);
$categoryLinks = $categoriesStmt->fetchAll();

$pageData = $page ?? [];
$metaTitle = $pageData['meta_title'] ?? $pageData['title'] ?? $brandName;
$metaDescription = $pageData['meta_description'] ?? $brandDescription;
$canonical = $pageData['canonical'] ?? '';
$ogTitle = $pageData['og_title'] ?? $metaTitle;
$ogDescription = $pageData['og_description'] ?? $metaDescription;
$ogImageId = $pageData['og_image_id'] ?? null;
$ogImage = $ogImageId ? media_path((int) $ogImageId) : null;
$isHome = ($pageData['slug'] ?? '') === 'home';

$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$ruLink = preg_replace('#^/en/#', '/ru/', $currentPath);
$enLink = preg_replace('#^/ru/#', '/en/', $currentPath);
if (!str_starts_with($currentPath, '/ru/') && !str_starts_with($currentPath, '/en/')) {
    $ruLink = '/ru/';
    $enLink = '/en/';
}

$breadcrumbs = [
    [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => t('breadcrumb.home', $language),
        'item' => $baseUrl . '/' . $language . '/',
    ],
];
$segments = array_values(array_filter(explode('/', trim($currentPath, '/'))));
if (isset($segments[1])) {
    $pathSlug = $segments[1];
    if ($pathSlug === 'products' && isset($segments[2])) {
        $stmt = db()->prepare('SELECT ci.name FROM categories c JOIN category_i18n ci ON ci.category_id = c.id AND ci.locale = ? JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ? WHERE sm.slug = ?');
        $stmt->execute([$language, $language, $segments[2]]);
        $name = $stmt->fetchColumn();
        if ($name) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => t('nav.products', $language),
                'item' => $baseUrl . '/' . $language . '/products/',
            ];
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $name,
                'item' => $baseUrl . '/' . $language . '/products/' . $segments[2] . '/',
            ];
        }
        if (isset($segments[3])) {
            $stmt = db()->prepare('SELECT pi.name FROM products p JOIN product_i18n pi ON pi.product_id = p.id AND pi.locale = ? JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ? WHERE sm.slug = ?');
            $stmt->execute([$language, $language, $segments[3]]);
            $productName = $stmt->fetchColumn();
            if ($productName) {
                $breadcrumbs[] = [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $productName,
                    'item' => $baseUrl . '/' . $language . '/products/' . $segments[2] . '/' . $segments[3] . '/',
                ];
            }
        }
    } else {
        $stmt = db()->prepare('SELECT sm.title FROM pages p JOIN seo_meta sm ON sm.entity_type = "page" AND sm.entity_id = p.id AND sm.locale = ? WHERE p.slug = ?');
        $stmt->execute([$language, $pathSlug ?: 'home']);
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
    <meta name="robots" content="index,follow">
    <?php if (!empty($canonical)) : ?>
        <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <?php endif; ?>
    <link rel="alternate" href="<?= htmlspecialchars($baseUrl . $ruLink, ENT_QUOTES) ?>" hreflang="ru">
    <link rel="alternate" href="<?= htmlspecialchars($baseUrl . $enLink, ENT_QUOTES) ?>" hreflang="en">
    <meta property="og:title" content="<?= htmlspecialchars($ogTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($ogDescription, ENT_QUOTES) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($baseUrl . $currentPath, ENT_QUOTES) ?>">
    <?php if ($ogImage) : ?>
        <meta property="og:image" content="<?= htmlspecialchars($baseUrl . $ogImage, ENT_QUOTES) ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="/themes/default/styles.css">
</head>
<body class="<?= $isHome ? 'is-home' : '' ?>">
<header class="site-header<?= $isHome ? ' is-hero' : '' ?>">
    <div class="container">
        <div class="header-left">
            <a class="logo" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/">
                <?php if (!empty($logoPath)) : ?>
                    <img src="<?= htmlspecialchars($logoPath, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($logoAlt, ENT_QUOTES) ?>">
                <?php else : ?>
                    <?= htmlspecialchars($brandName, ENT_QUOTES) ?>
                <?php endif; ?>
            </a>
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
            <div class="nav-item has-dropdown">
                <span><?= htmlspecialchars(t('nav.products', $language), ENT_QUOTES) ?></span>
                <div class="dropdown">
                    <?php foreach ($categoryLinks as $category) : ?>
                        <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>/">
                            <?= htmlspecialchars($category['name'], ENT_QUOTES) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/custom-production/">
                <?= htmlspecialchars(t('nav.custom', $language), ENT_QUOTES) ?>
            </a>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/quality/">
                <?= htmlspecialchars(t('nav.quality', $language), ENT_QUOTES) ?>
            </a>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/where-to-buy/">
                <?= htmlspecialchars(t('nav.where', $language), ENT_QUOTES) ?>
            </a>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/contacts/">
                <?= htmlspecialchars(t('nav.contacts', $language), ENT_QUOTES) ?>
            </a>
            <div class="nav-footer">
                <div class="nav-language">
                    <a href="<?= htmlspecialchars($ruLink, ENT_QUOTES) ?>" <?= $language === 'ru' ? 'class="active"' : '' ?>><?= htmlspecialchars(t('lang.ru', $language), ENT_QUOTES) ?></a>
                    <a href="<?= htmlspecialchars($enLink, ENT_QUOTES) ?>" <?= $language === 'en' ? 'class="active"' : '' ?>><?= htmlspecialchars(t('lang.en', $language), ENT_QUOTES) ?></a>
                </div>
            </div>
        </nav>
        <div class="header-actions">
            <?php if ($headerCta !== '[[nav.cta]]' && $headerCta !== '') : ?>
                <a class="btn btn-ghost" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/custom-production/">
                    <?= htmlspecialchars($headerCta, ENT_QUOTES) ?>
                </a>
            <?php endif; ?>
            <div class="language-switch">
                <a href="<?= htmlspecialchars($ruLink, ENT_QUOTES) ?>" <?= $language === 'ru' ? 'class="active"' : '' ?>><?= htmlspecialchars(t('lang.ru', $language), ENT_QUOTES) ?></a>
                <a href="<?= htmlspecialchars($enLink, ENT_QUOTES) ?>" <?= $language === 'en' ? 'class="active"' : '' ?>><?= htmlspecialchars(t('lang.en', $language), ENT_QUOTES) ?></a>
            </div>
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
                <div class="footer-title"><?= htmlspecialchars(t('footer.title', $language), ENT_QUOTES) ?></div>
                <div class="footer-text"><?= htmlspecialchars(t('footer.text', $language), ENT_QUOTES) ?></div>
            </div>
            <div>
                <div class="footer-title"><?= htmlspecialchars(t('footer.links', $language), ENT_QUOTES) ?></div>
                <div class="footer-text">
                    <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/">
                        <?= htmlspecialchars(t('nav.products', $language), ENT_QUOTES) ?>
                    </a>
                    <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/custom-production/">
                        <?= htmlspecialchars(t('nav.custom', $language), ENT_QUOTES) ?>
                    </a>
                    <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/quality/">
                        <?= htmlspecialchars(t('nav.quality', $language), ENT_QUOTES) ?>
                    </a>
                    <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/where-to-buy/">
                        <?= htmlspecialchars(t('nav.where', $language), ENT_QUOTES) ?>
                    </a>
                    <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/contacts/">
                        <?= htmlspecialchars(t('nav.contacts', $language), ENT_QUOTES) ?>
                    </a>
                </div>
            </div>
            <div>
                <div class="footer-title"><?= htmlspecialchars(t('footer.contacts', $language), ENT_QUOTES) ?></div>
                <div class="footer-text"><?= nl2br(htmlspecialchars(t('footer.contacts_text', $language), ENT_QUOTES)) ?></div>
                <div class="footer-social">
                    <a href="<?= htmlspecialchars(t('footer.telegram_link', $language), ENT_QUOTES) ?>" target="_blank" rel="noopener noreferrer">
                        <?= htmlspecialchars(t('footer.telegram_label', $language), ENT_QUOTES) ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-meta"><?= htmlspecialchars(t('footer.copyright', $language), ENT_QUOTES) ?></div>
    </div>
</footer>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $brandName,
    'url' => $baseUrl,
    'description' => $brandDescription,
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

    const heroVideo = document.querySelector('[data-hero-video]');
    const playButton = document.querySelector('[data-hero-play]');
    const shouldDefer = navigator.connection && (navigator.connection.saveData || /2g/.test(navigator.connection.effectiveType || ''));
    const loadVideo = () => {
        if (!heroVideo || heroVideo.dataset.loaded === '1') {
            return;
        }
        const src = heroVideo.getAttribute('data-src');
        if (src) {
            heroVideo.src = src;
            heroVideo.load();
            heroVideo.dataset.loaded = '1';
            heroVideo.play().catch(() => null);
        }
    };
    if (!shouldDefer) {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadVideo, { timeout: 2000 });
        } else {
            setTimeout(loadVideo, 1200);
        }
    } else if (playButton) {
        playButton.classList.add('is-visible');
    }
    playButton?.addEventListener('click', () => {
        loadVideo();
        playButton.classList.remove('is-visible');
    });
</script>
</body>
</html>
