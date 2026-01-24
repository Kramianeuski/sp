<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.category_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/categories"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="category-slug"><?= htmlspecialchars(t('admin.category_slug', 'ru'), ENT_QUOTES) ?></label>
        <input id="category-slug" type="text" name="slug" value="<?= htmlspecialchars($slug ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($errors['slug'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['slug'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="field">
        <label for="category-status"><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></label>
        <select id="category-status" name="status">
            <option value="published" <?= ($status ?? '') === 'published' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_published', 'ru'), ENT_QUOTES) ?></option>
            <option value="archived" <?= ($status ?? '') === 'archived' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_archived', 'ru'), ENT_QUOTES) ?></option>
        </select>
    </div>
    <div class="tabs" data-tabs="category-create">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $translations[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="category-create" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label for="category-name-<?= $lang ?>"><?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?></label>
                <input id="category-name-<?= $lang ?>" type="text" name="name_<?= $lang ?>" value="<?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="category-h1-<?= $lang ?>"><?= htmlspecialchars(t('admin.category_h1', 'ru'), ENT_QUOTES) ?></label>
                <input id="category-h1-<?= $lang ?>" type="text" name="h1_<?= $lang ?>" value="<?= htmlspecialchars($data['h1'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="category-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.category_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="category-description-<?= $lang ?>" name="description_<?= $lang ?>" rows="4"><?= htmlspecialchars($data['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="category-seo-text-<?= $lang ?>"><?= htmlspecialchars(t('admin.seo_text', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="category-seo-text-<?= $lang ?>" name="seo_text_<?= $lang ?>" rows="4"><?= htmlspecialchars($data['seo_text'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="category-faq-<?= $lang ?>"><?= htmlspecialchars(t('admin.faq', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="category-faq-<?= $lang ?>" name="faq_<?= $lang ?>" rows="4"><?= htmlspecialchars($data['faq'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="category-meta-title-<?= $lang ?>"><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
                <input id="category-meta-title-<?= $lang ?>" type="text" name="meta_title_<?= $lang ?>" value="<?= htmlspecialchars($data['meta_title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="category-meta-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="category-meta-description-<?= $lang ?>" name="meta_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['meta_description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <label class="checkbox-field">
                <input type="checkbox" name="indexable_<?= $lang ?>" value="1" <?= !empty($data['indexable']) ? 'checked' : '' ?>>
                <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
            </label>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.create', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
