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
        <label><?= htmlspecialchars(t('admin.translation_key', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="key" value="<?= htmlspecialchars($translation['key'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></label>
        <select name="locale">
            <option value="ru" <?= ($translation['locale'] ?? '') === 'ru' ? 'selected' : '' ?>>RU</option>
            <option value="en" <?= ($translation['locale'] ?? '') === 'en' ? 'selected' : '' ?>>EN</option>
        </select>
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?></label>
        <textarea name="value" rows="6"><?= htmlspecialchars($translation['value'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_html" value="1" <?= !empty($translation['is_html']) ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.is_html', 'ru'), ENT_QUOTES) ?>
    </label>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
