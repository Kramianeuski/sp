<?php
ob_start();
?>
<h1>Page: <?= e($page['slug']) ?></h1>
<form method="post" class="admin-form">
    <div class="admin-grid two">
        <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $langCode => $label) : ?>
            <div>
                <h2><?= e($label) ?></h2>
                <label>Title
                    <input type="text" name="<?= e($langCode) ?>[title]" value="<?= e($translations[$langCode]['title'] ?? '') ?>">
                </label>
                <label>H1
                    <input type="text" name="<?= e($langCode) ?>[h1]" value="<?= e($translations[$langCode]['h1'] ?? '') ?>">
                </label>
                <label>Body
                    <textarea name="<?= e($langCode) ?>[body]" rows="6"><?= e($translations[$langCode]['body'] ?? '') ?></textarea>
                </label>
                <label>SEO Title
                    <input type="text" name="<?= e($langCode) ?>[seo_title]" value="<?= e($translations[$langCode]['seo_title'] ?? '') ?>">
                </label>
                <label>SEO Description
                    <textarea name="<?= e($langCode) ?>[seo_description]" rows="3"><?= e($translations[$langCode]['seo_description'] ?? '') ?></textarea>
                </label>
                <label>SEO Canonical
                    <input type="text" name="<?= e($langCode) ?>[seo_canonical]" value="<?= e($translations[$langCode]['seo_canonical'] ?? '') ?>">
                </label>
                <label>SEO Robots
                    <input type="text" name="<?= e($langCode) ?>[seo_robots]" value="<?= e($translations[$langCode]['seo_robots'] ?? '') ?>">
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="submit">Save</button>
</form>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
