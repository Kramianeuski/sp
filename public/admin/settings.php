<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "brand_name"', [$_POST['brand_name']]);
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "brand_url"', [$_POST['brand_url']]);
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "default_robots"', [$_POST['default_robots']]);
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "default_og_title"', [$_POST['default_og_title']]);
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "default_og_description"', [$_POST['default_og_description']]);
    header('Location: /admin/settings.php');
    exit;
}

$settings = get_settings();

admin_header('SEO и системные настройки');
?>
<section class="card">
    <h2>SEO по умолчанию</h2>
    <form method="post">
        <div class="form-grid">
            <div>
                <label>Бренд</label>
                <input type="text" name="brand_name" value="<?= htmlspecialchars($settings['brand_name'] ?? '') ?>">
            </div>
            <div>
                <label>Canonical URL</label>
                <input type="text" name="brand_url" value="<?= htmlspecialchars($settings['brand_url'] ?? '') ?>">
            </div>
            <div>
                <label>Robots</label>
                <input type="text" name="default_robots" value="<?= htmlspecialchars($settings['default_robots'] ?? 'index, follow') ?>">
            </div>
            <div>
                <label>OG Title</label>
                <input type="text" name="default_og_title" value="<?= htmlspecialchars($settings['default_og_title'] ?? '') ?>">
            </div>
            <div>
                <label>OG Description</label>
                <textarea name="default_og_description"><?= htmlspecialchars($settings['default_og_description'] ?? '') ?></textarea>
            </div>
        </div>
        <button class="button" type="submit">Сохранить</button>
    </form>
</section>
<section class="card">
    <h2>Файлы и документы</h2>
    <p class="notice">Файлы загружаются через раздел «Файлы» и привязываются к продуктам и категориям.</p>
</section>
<?php
admin_footer();
