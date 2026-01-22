<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "official_seller_name"', [$_POST['seller_name']]);
    db_execute('UPDATE settings SET setting_value = ? WHERE setting_key = "official_seller_url"', [$_POST['seller_url']]);
    header('Location: /admin/partner.php');
    exit;
}

$settings = get_settings();

admin_header('Партнёр');
?>
<section class="card">
    <h2>Официальный продавец</h2>
    <form method="post">
        <div class="form-grid">
            <div>
                <label>Название партнёра</label>
                <input type="text" name="seller_name" value="<?= htmlspecialchars($settings['official_seller_name'] ?? '') ?>">
            </div>
            <div>
                <label>URL</label>
                <input type="text" name="seller_url" value="<?= htmlspecialchars($settings['official_seller_url'] ?? '') ?>">
            </div>
        </div>
        <button class="button" type="submit">Сохранить</button>
    </form>
</section>
<?php
admin_footer();
