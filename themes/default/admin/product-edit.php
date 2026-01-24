<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.product_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
        <a class="btn btn-secondary" href="/admin/products/specs?id=<?= htmlspecialchars($product['product_id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($product['language'], ENT_QUOTES) ?>">
            <?= htmlspecialchars(t('admin.specs', 'ru'), ENT_QUOTES) ?>
        </a>
    </div>
</div>
<div class="card">
    <div class="tabs">
        <a class="tab <?= $product['language'] === 'ru' ? 'is-active' : '' ?>" href="/admin/products/edit?id=<?= htmlspecialchars($product['product_id'], ENT_QUOTES) ?>&lang=ru">RU</a>
        <a class="tab <?= $product['language'] === 'en' ? 'is-active' : '' ?>" href="/admin/products/edit?id=<?= htmlspecialchars($product['product_id'], ENT_QUOTES) ?>&lang=en">EN</a>
    </div>
    <form method="post" class="form-card">
        <?= csrf_field() ?>
        <div class="field">
            <label for="product-slug"><?= htmlspecialchars(t('admin.product_slug', 'ru'), ENT_QUOTES) ?></label>
            <input id="product-slug" type="text" name="slug" value="<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="product-sku"><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></label>
            <input id="product-sku" type="text" name="sku" value="<?= htmlspecialchars($product['sku'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="product-name"><?= htmlspecialchars(t('admin.product_name', 'ru'), ENT_QUOTES) ?></label>
            <input id="product-name" type="text" name="name" value="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="product-h1"><?= htmlspecialchars(t('admin.product_h1', 'ru'), ENT_QUOTES) ?></label>
            <input id="product-h1" type="text" name="h1" value="<?= htmlspecialchars($product['h1'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="product-short"><?= htmlspecialchars(t('admin.product_short', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="product-short" name="short_description" rows="3"><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="product-description"><?= htmlspecialchars(t('admin.product_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="product-description" name="description" rows="6"><?= htmlspecialchars($product['description'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="product-meta-title"><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
            <input id="product-meta-title" type="text" name="meta_title" value="<?= htmlspecialchars($product['meta_title'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="product-meta-description"><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="product-meta-description" name="meta_description" rows="3"><?= htmlspecialchars($product['meta_description'], ENT_QUOTES) ?></textarea>
        </div>
        <label class="checkbox-field">
            <input type="checkbox" name="indexable" value="1" <?= $product['indexable'] ? 'checked' : '' ?>>
            <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
        </label>
        <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
    </form>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
