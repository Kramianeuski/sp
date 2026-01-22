<?php
ob_start();
$settingKeys = array_unique(array_merge(array_keys($settingsRu), array_keys($settingsEn)));
?>
<h1>Settings</h1>
<form method="post" class="admin-form">
    <div class="admin-grid two">
        <div>
            <h2>RU</h2>
            <?php foreach ($settingKeys as $key) : ?>
                <label>
                    <?= e($key) ?>
                    <input type="text" name="settings[ru][<?= e($key) ?>]" value="<?= e($settingsRu[$key] ?? '') ?>">
                </label>
            <?php endforeach; ?>
        </div>
        <div>
            <h2>EN</h2>
            <?php foreach ($settingKeys as $key) : ?>
                <label>
                    <?= e($key) ?>
                    <input type="text" name="settings[en][<?= e($key) ?>]" value="<?= e($settingsEn[$key] ?? '') ?>">
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <button type="submit">Save</button>
</form>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
