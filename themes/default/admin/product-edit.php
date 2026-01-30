<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.product_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
        <a class="btn btn-secondary" href="/admin/products/specs?product_id=<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.specs', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.product_category', 'ru'), ENT_QUOTES) ?></label>
        <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= htmlspecialchars((string) $category['id'], ENT_QUOTES) ?>" <?= (string) $product['category_id'] === (string) $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['code'], ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="sku" value="<?= htmlspecialchars($product['sku'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></label>
        <input type="number" name="sort_order" value="<?= htmlspecialchars((string) $product['sort_order'], ENT_QUOTES) ?>">
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_active" value="1" <?= !empty($product['is_active']) ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.is_active', 'ru'), ENT_QUOTES) ?>
    </label>
    <div class="tabs" data-tabs="product-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $translations[$lang] ?? []; ?>
        <?php $seoData = $seo[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="product-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label><?= htmlspecialchars(t('admin.product_name', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="name_<?= $lang ?>" value="<?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.product_short', 'ru'), ENT_QUOTES) ?></label>
                <textarea name="short_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['short_description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.product_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea name="description_<?= $lang ?>" rows="6"><?= htmlspecialchars($data['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <label class="checkbox-field">
                <input type="checkbox" name="is_html_<?= $lang ?>" value="1" <?= !empty($data['is_html']) ? 'checked' : '' ?>>
                <?= htmlspecialchars(t('admin.is_html', 'ru'), ENT_QUOTES) ?>
            </label>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="meta_title_<?= $lang ?>" value="<?= htmlspecialchars($seoData['title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea name="meta_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($seoData['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.product_h1', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="h1_<?= $lang ?>" value="<?= htmlspecialchars($seoData['h1'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.slug', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="slug_<?= $lang ?>" value="<?= htmlspecialchars($seoData['slug'] ?? '', ENT_QUOTES) ?>">
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
