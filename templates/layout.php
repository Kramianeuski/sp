<?php
require_once __DIR__ . '/helpers.php';

$bodyClass = $bodyClass ?? '';
$seoTitle = $seo['title'] ?? '';
$seoDescription = $seo['description'] ?? '';
$seoRobots = $seo['robots'] ?? '';
$seoCanonical = $seo['canonical'] ?? '';
$hreflang = $seo['hreflang'] ?? [];
$siteName = $settings['site_name'] ?? '';
$logoText = $settings['logo_text'] ?? '';
$footerText = $settings['footer_text'] ?? '';
$contactText = $settings['contact_text'] ?? '';
?>
<!doctype html>
<html lang="<?= e($lang) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($seoTitle ?: $siteName) ?></title>
    <?php if ($seoDescription) : ?>
        <meta name="description" content="<?= e($seoDescription) ?>">
    <?php endif; ?>
    <?php if ($seoRobots) : ?>
        <meta name="robots" content="<?= e($seoRobots) ?>">
    <?php endif; ?>
    <?php if ($seoCanonical) : ?>
        <link rel="canonical" href="<?= e($seoCanonical) ?>">
    <?php endif; ?>
    <?php foreach ($hreflang as $code => $href) : ?>
        <link rel="alternate" hreflang="<?= e($code) ?>" href="<?= e($href) ?>">
    <?php endforeach; ?>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body class="<?= e($bodyClass) ?>">
    <header class="site-header">
        <div class="container header-inner">
            <div class="logo">
                <a href="/<?= e($lang) ?>/"><?= e($logoText ?: $siteName) ?></a>
            </div>
            <nav class="nav">
                <?php foreach ($nav as $item) : ?>
                    <a href="/<?= e($lang) ?>/<?= e($item['slug']) ?>/"><?= e($item['title']) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>
    <main>
        <?= $content ?? '' ?>
    </main>
    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <div class="footer-title"><?= e($siteName) ?></div>
                <?php if ($footerText) : ?>
                    <p><?= nl2br(e($footerText)) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <?php if ($contactText) : ?>
                    <p><?= nl2br(e($contactText)) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </footer>
</body>
</html>
