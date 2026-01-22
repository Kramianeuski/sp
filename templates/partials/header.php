<?php
/** @var string $lang */
/** @var string $title */
/** @var array $nav */
/** @var string $description */
/** @var string $canonical */
/** @var array $hreflang */
/** @var bool $noindex */
/** @var string $ogTitle */
/** @var string $ogDescription */
/** @var string $twitterTitle */
/** @var string $twitterDescription */
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
    <?php foreach ($hreflang as $hrefLang => $href) : ?>
        <link rel="alternate" hreflang="<?= htmlspecialchars($hrefLang) ?>" href="<?= htmlspecialchars($href) ?>">
    <?php endforeach; ?>
    <?php if ($noindex) : ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>
    <meta property="og:title" content="<?= htmlspecialchars($ogTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($ogDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= htmlspecialchars($lang) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($twitterTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($twitterDescription) ?>">
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="/<?= htmlspecialchars($lang) ?>/">
            <img src="/assets/logo.svg" alt="System Power logo">
        </a>
        <nav class="main-nav">
            <?php foreach ($nav as $item) : ?>
                <a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['label']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="lang-switch">
            <a href="<?= htmlspecialchars($hreflang['ru-RU']) ?>" class="<?= $lang === 'ru' ? 'active' : '' ?>">RU</a>
            <span>/</span>
            <a href="<?= htmlspecialchars($hreflang['en-US']) ?>" class="<?= $lang === 'en' ? 'active' : '' ?>">EN</a>
        </div>
    </div>
</header>
<main>
