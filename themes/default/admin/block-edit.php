<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.section_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/blocks?page_id=<?= htmlspecialchars($pageId, ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.section_key', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="section_key" value="<?= htmlspecialchars($section['section_key'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.template', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="template" value="<?= htmlspecialchars($section['template'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></label>
        <input type="number" name="sort_order" value="<?= htmlspecialchars((string) ($section['sort_order'] ?? 0), ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.section_data', 'ru'), ENT_QUOTES) ?></label>
        <textarea name="data_json" rows="10"><?= htmlspecialchars($section['data_json'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
