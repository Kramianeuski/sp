<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(t('admin.login_title', 'ru'), ENT_QUOTES) ?></title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="/themes/default/admin.css">
</head>
<body class="admin-login">
<div class="admin-login-wrap">
    <div class="admin-login-card">
        <div class="admin-login-logo">System Power</div>
        <h1>Вход в админ-панель</h1>
        <p class="admin-login-subtitle">Доступ только для администраторов</p>
        <?php if (!empty($error)) : ?>
            <div class="alert error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
        <?php endif; ?>
        <form method="post" class="admin-login-form" novalidate>
            <?= csrf_field() ?>
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                required
                autocomplete="username"
                placeholder="admin@system-power.ru"
                value="<?= htmlspecialchars($email ?? '', ENT_QUOTES) ?>"
                <?= !empty($errors['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>
            >
            <?php if (!empty($errors['email'])) : ?>
                <div class="field-error" id="email-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES) ?></div>
            <?php endif; ?>

            <label for="password">Password</label>
            <div class="password-field">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    <?= !empty($errors['password']) ? 'aria-invalid="true" aria-describedby="password-error"' : '' ?>
                >
                <button type="button" class="toggle-password" aria-label="Показать пароль">👁</button>
            </div>
            <?php if (!empty($errors['password'])) : ?>
                <div class="field-error" id="password-error"><?= htmlspecialchars($errors['password'], ENT_QUOTES) ?></div>
            <?php endif; ?>

            <button type="submit" class="primary-button" data-loading-text="Входим...">Войти</button>
        </form>
        <a class="back-link" href="/ru/">На сайт</a>
    </div>
</div>
<script>
    const toggleButton = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');
    if (toggleButton && passwordInput) {
        toggleButton.addEventListener('click', () => {
            const isHidden = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
            toggleButton.setAttribute('aria-label', isHidden ? 'Скрыть пароль' : 'Показать пароль');
        });
    }
    const loginForm = document.querySelector('.admin-login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', () => {
            const submitButton = loginForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.setAttribute('disabled', 'disabled');
                submitButton.classList.add('is-loading');
                submitButton.textContent = submitButton.dataset.loadingText || '...';
            }
        });
    }
</script>
</body>
</html>
