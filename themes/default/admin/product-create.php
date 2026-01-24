<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.product_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="product-sku"><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></label>
        <input id="product-sku" type="text" name="sku" value="<?= htmlspecialchars($sku ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($errors['sku'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['sku'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="field">
        <label for="product-slug"><?= htmlspecialchars(t('admin.product_slug', 'ru'), ENT_QUOTES) ?></label>
        <input id="product-slug" type="text" name="slug" value="<?= htmlspecialchars($slug ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($errors['slug'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['slug'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="field">
        <label for="product-category"><?= htmlspecialchars(t('admin.product_category', 'ru'), ENT_QUOTES) ?></label>
        <select id="product-category" name="category_id">
            <option value="0"><?= htmlspecialchars(t('admin.select_category', 'ru'), ENT_QUOTES) ?></option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>" <?= (int) ($category_id ?? 0) === (int) $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name'] ?: $category['slug'], ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['category_id'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['category_id'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="field">
        <label for="product-status"><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></label>
        <select id="product-status" name="status">
            <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_draft', 'ru'), ENT_QUOTES) ?></option>
            <option value="published" <?= ($status ?? '') === 'published' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_published', 'ru'), ENT_QUOTES) ?></option>
            <option value="archived" <?= ($status ?? '') === 'archived' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.status_archived', 'ru'), ENT_QUOTES) ?></option>
        </select>
    </div>
    <div class="tabs" data-tabs="product-create">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $translations[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="product-create" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label for="product-name-<?= $lang ?>"><?= htmlspecialchars(t('admin.product_name', 'ru'), ENT_QUOTES) ?></label>
                <input id="product-name-<?= $lang ?>" type="text" name="name_<?= $lang ?>" value="<?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="product-h1-<?= $lang ?>"><?= htmlspecialchars(t('admin.product_h1', 'ru'), ENT_QUOTES) ?></label>
                <input id="product-h1-<?= $lang ?>" type="text" name="h1_<?= $lang ?>" value="<?= htmlspecialchars($data['h1'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="product-short-<?= $lang ?>"><?= htmlspecialchars(t('admin.product_short', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="product-short-<?= $lang ?>" name="short_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['short_description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="product-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.product_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="product-description-<?= $lang ?>" name="description_<?= $lang ?>" rows="6"><?= htmlspecialchars($data['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="product-meta-title-<?= $lang ?>"><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
                <input id="product-meta-title-<?= $lang ?>" type="text" name="meta_title_<?= $lang ?>" value="<?= htmlspecialchars($data['meta_title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="product-meta-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="product-meta-description-<?= $lang ?>" name="meta_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['meta_description'] ?? '', ENT_QUOTES) ?></textarea>
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
