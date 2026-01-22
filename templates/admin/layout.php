<?php
require_once __DIR__ . '/../helpers.php';
$bodyClass = $bodyClass ?? '';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="stylesheet" href="/assets/admin.css">
</head>
<body class="<?= e($bodyClass) ?>">
    <header class="admin-header">
        <div class="admin-container">
            <div class="admin-logo">System Power Admin</div>
            <nav class="admin-nav">
                <a href="/admin">Dashboard</a>
                <a href="/admin/settings">Settings</a>
                <a href="/admin/pages">Pages</a>
                <a href="/admin/categories">Categories</a>
                <a href="/admin/products">Products</a>
                <a href="/admin/logout">Logout</a>
            </nav>
        </div>
    </header>
    <main class="admin-main">
        <div class="admin-container">
            <?= $content ?? '' ?>
        </div>
    </main>
</body>
</html>
