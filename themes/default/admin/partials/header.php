<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(t('admin.panel_title', 'ru'), ENT_QUOTES) ?></title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="/themes/default/admin.css">
</head>
<body class="admin-app">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-brand"><?= htmlspecialchars(t('admin.panel_title', 'ru'), ENT_QUOTES) ?></div>
        <nav class="admin-nav">
            <a href="/admin/pages"><?= htmlspecialchars(t('admin.nav_pages', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/categories"><?= htmlspecialchars(t('admin.nav_categories', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/products"><?= htmlspecialchars(t('admin.nav_products', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/products/import"><?= htmlspecialchars(t('admin.nav_import', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/partners"><?= htmlspecialchars(t('admin.nav_partners', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/product-partner-links"><?= htmlspecialchars(t('admin.nav_partner_links', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/leads"><?= htmlspecialchars(t('admin.nav_leads', 'ru'), ENT_QUOTES) ?></a>
            <a href="/admin/translations"><?= htmlspecialchars(t('admin.nav_translations', 'ru'), ENT_QUOTES) ?></a>
        </nav>
        <form method="post" action="/admin/logout" class="logout-form">
            <?= csrf_field() ?>
            <button type="submit"><?= htmlspecialchars(t('admin.logout', 'ru'), ENT_QUOTES) ?></button>
        </form>
    </aside>
    <div class="admin-main">
        <main class="admin-content">
