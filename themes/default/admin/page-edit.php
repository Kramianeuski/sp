<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.page_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/pages"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
        <a class="btn btn-secondary" href="/admin/blocks?page_id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.sections', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="page-slug"><?= htmlspecialchars(t('admin.page_slug', 'ru'), ENT_QUOTES) ?></label>
        <input id="page-slug" type="text" name="slug" value="<?= htmlspecialchars($page['slug'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="page-status"><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></label>
        <select id="page-status" name="status">
            <option value="published" <?= ($page['status'] ?? '') === 'published' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_published', 'ru'), ENT_QUOTES) ?></option>
            <option value="draft" <?= ($page['status'] ?? '') === 'draft' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_draft', 'ru'), ENT_QUOTES) ?></option>
        </select>
    </div>
    <div class="tabs" data-tabs="page-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $seo[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="page-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="title_<?= $lang ?>" value="<?= htmlspecialchars($data['title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.page_h1', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="h1_<?= $lang ?>" value="<?= htmlspecialchars($data['h1'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea name="description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.slug', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="slug_<?= $lang ?>" value="<?= htmlspecialchars($data['slug'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.canonical', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="canonical_<?= $lang ?>" value="<?= htmlspecialchars($data['canonical'] ?? '', ENT_QUOTES) ?>">
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
