<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.page_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/pages"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
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
            <option value="archived" <?= ($page['status'] ?? '') === 'archived' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_archived', 'ru'), ENT_QUOTES) ?></option>
        </select>
    </div>
    <div class="tabs" data-tabs="page-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $translations[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="page-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label for="page-title-<?= $lang ?>"><?= htmlspecialchars(t('admin.page_title', 'ru'), ENT_QUOTES) ?></label>
                <input id="page-title-<?= $lang ?>" type="text" name="title_<?= $lang ?>" value="<?= htmlspecialchars($data['title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="page-h1-<?= $lang ?>"><?= htmlspecialchars(t('admin.page_h1', 'ru'), ENT_QUOTES) ?></label>
                <input id="page-h1-<?= $lang ?>" type="text" name="h1_<?= $lang ?>" value="<?= htmlspecialchars($data['h1'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="page-meta-title-<?= $lang ?>"><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
                <input id="page-meta-title-<?= $lang ?>" type="text" name="meta_title_<?= $lang ?>" value="<?= htmlspecialchars($data['meta_title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="page-meta-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="page-meta-description-<?= $lang ?>" name="meta_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['meta_description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="page-canonical-<?= $lang ?>"><?= htmlspecialchars(t('admin.canonical', 'ru'), ENT_QUOTES) ?></label>
                <input id="page-canonical-<?= $lang ?>" type="text" name="canonical_<?= $lang ?>" value="<?= htmlspecialchars($data['canonical'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="page-robots-<?= $lang ?>"><?= htmlspecialchars(t('admin.robots', 'ru'), ENT_QUOTES) ?></label>
                <input id="page-robots-<?= $lang ?>" type="text" name="robots_<?= $lang ?>" value="<?= htmlspecialchars($data['robots'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="page-og-title-<?= $lang ?>"><?= htmlspecialchars(t('admin.og_title', 'ru'), ENT_QUOTES) ?></label>
                <input id="page-og-title-<?= $lang ?>" type="text" name="og_title_<?= $lang ?>" value="<?= htmlspecialchars($data['og_title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="page-og-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.og_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="page-og-description-<?= $lang ?>" name="og_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['og_description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="page-custom-html-<?= $lang ?>"><?= htmlspecialchars(t('admin.custom_html', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="page-custom-html-<?= $lang ?>" name="custom_html_<?= $lang ?>" rows="6"><?= htmlspecialchars($data['custom_html'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="page-custom-css-<?= $lang ?>"><?= htmlspecialchars(t('admin.custom_css', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="page-custom-css-<?= $lang ?>" name="custom_css_<?= $lang ?>" rows="4"><?= htmlspecialchars($data['custom_css'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field checkbox-group">
                <label class="checkbox-field">
                    <input type="checkbox" name="use_layout_<?= $lang ?>" value="1" <?= !empty($data['use_layout']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars(t('admin.use_layout', 'ru'), ENT_QUOTES) ?>
                </label>
                <label class="checkbox-field">
                    <input type="checkbox" name="replace_styles_<?= $lang ?>" value="1" <?= !empty($data['replace_styles']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars(t('admin.replace_styles', 'ru'), ENT_QUOTES) ?>
                </label>
                <label class="checkbox-field">
                    <input type="checkbox" name="indexable_<?= $lang ?>" value="1" <?= !empty($data['indexable']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
