<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(t('admin.login_title', 'ru'), ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="/themes/default/admin.css">
</head>
<body>
<div class="admin-container">
    <h1><?= htmlspecialchars(t('admin.login_title', 'ru'), ENT_QUOTES) ?></h1>
    <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif; ?>
    <form method="post">
        <label>
            <?= htmlspecialchars(t('admin.username', 'ru'), ENT_QUOTES) ?>
            <input type="text" name="username" required>
        </label>
        <label>
            <?= htmlspecialchars(t('admin.password', 'ru'), ENT_QUOTES) ?>
            <input type="password" name="password" required>
        </label>
        <button type="submit"><?= htmlspecialchars(t('admin.login', 'ru'), ENT_QUOTES) ?></button>
    </form>
</div>
</body>
</html>
