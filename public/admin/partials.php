<?php

function admin_header(string $title): void
{
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= htmlspecialchars($title) ?></title>
        <link rel="stylesheet" href="/assets/admin.css">
    </head>
    <body>
    <header class="admin-header">
        <h1><?= htmlspecialchars($title) ?></h1>
        <nav class="admin-nav">
            <a href="/admin/">Обзор</a>
            <a href="/admin/products.php">Товары</a>
            <a href="/admin/categories.php">Категории</a>
            <a href="/admin/pages.php">Страницы</a>
            <a href="/admin/blocks.php">Блоки</a>
            <a href="/admin/translations.php">Переводы</a>
            <a href="/admin/files.php">Файлы</a>
            <a href="/admin/partner.php">Партнёр</a>
            <a href="/admin/settings.php">Настройки SEO</a>
            <a href="/admin/redirects.php">Редиректы</a>
            <a href="/admin/sitemap.php">Sitemap</a>
        </nav>
    </header>
    <main class="admin-container">
    <?php
}

function admin_footer(): void
{
    ?>
    </main>
    </body>
    </html>
    <?php
}
