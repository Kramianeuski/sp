<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.page_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/pages"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card">
    <div class="tabs">
        <a class="tab <?= $page['language'] === 'ru' ? 'is-active' : '' ?>" href="/admin/pages/edit?id=<?= htmlspecialchars($page['page_id'], ENT_QUOTES) ?>&lang=ru">RU</a>
        <a class="tab <?= $page['language'] === 'en' ? 'is-active' : '' ?>" href="/admin/pages/edit?id=<?= htmlspecialchars($page['page_id'], ENT_QUOTES) ?>&lang=en">EN</a>
    </div>
    <form method="post" class="form-card">
        <?= csrf_field() ?>
        <div class="field">
            <label for="page-title"><?= htmlspecialchars(t('admin.page_title', 'ru'), ENT_QUOTES) ?></label>
            <input id="page-title" type="text" name="title" value="<?= htmlspecialchars($page['title'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="page-h1"><?= htmlspecialchars(t('admin.page_h1', 'ru'), ENT_QUOTES) ?></label>
            <input id="page-h1" type="text" name="h1" value="<?= htmlspecialchars($page['h1'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="page-meta-title"><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
            <input id="page-meta-title" type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="page-meta-description"><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="page-meta-description" name="meta_description" rows="3"><?= htmlspecialchars($page['meta_description'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="page-canonical"><?= htmlspecialchars(t('admin.canonical', 'ru'), ENT_QUOTES) ?></label>
            <input id="page-canonical" type="text" name="canonical" value="<?= htmlspecialchars($page['canonical'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="page-robots"><?= htmlspecialchars(t('admin.robots', 'ru'), ENT_QUOTES) ?></label>
            <input id="page-robots" type="text" name="robots" value="<?= htmlspecialchars($page['robots'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="page-og-title"><?= htmlspecialchars(t('admin.og_title', 'ru'), ENT_QUOTES) ?></label>
            <input id="page-og-title" type="text" name="og_title" value="<?= htmlspecialchars($page['og_title'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="page-og-description"><?= htmlspecialchars(t('admin.og_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="page-og-description" name="og_description" rows="3"><?= htmlspecialchars($page['og_description'], ENT_QUOTES) ?></textarea>
        </div>
        <label class="checkbox-field">
            <input type="checkbox" name="indexable" value="1" <?= $page['indexable'] ? 'checked' : '' ?>>
            <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
        </label>
        <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
    </form>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
