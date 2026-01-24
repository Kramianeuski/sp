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
        <input id="translation-key" type="text" value="<?= htmlspecialchars($translation['key'], ENT_QUOTES) ?>" disabled>
    </div>
    <div class="field">
        <label for="translation-value"><?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?></label>
        <textarea id="translation-value" name="value" rows="4"><?= htmlspecialchars($translation['value'], ENT_QUOTES) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
