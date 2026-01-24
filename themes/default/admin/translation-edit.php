<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.translation_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/translations"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="translation-key"><?= htmlspecialchars(t('admin.translation_key', 'ru'), ENT_QUOTES) ?></label>
        <input id="translation-key" type="text" value="<?= htmlspecialchars($key, ENT_QUOTES) ?>" readonly>
    </div>
    <div class="tabs" data-tabs="translation-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <div class="tab-panel" data-tab-group="translation-edit" data-tab-panel="ru">
        <div class="field">
            <label for="translation-value-ru"><?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="translation-value-ru" name="value_ru" rows="4"><?= htmlspecialchars($values['ru'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
    </div>
    <div class="tab-panel" data-tab-group="translation-edit" data-tab-panel="en">
        <div class="field">
            <label for="translation-value-en"><?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="translation-value-en" name="value_en" rows="4"><?= htmlspecialchars($values['en'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
