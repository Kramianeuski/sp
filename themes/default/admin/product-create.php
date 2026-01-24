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
        <label for="product-slug"><?= htmlspecialchars(t('admin.product_slug', 'ru'), ENT_QUOTES) ?></label>
        <input id="product-slug" type="text" name="slug" value="<?= htmlspecialchars($slug ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($errors['slug'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['slug'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="field">
        <label for="product-sku"><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></label>
        <input id="product-sku" type="text" name="sku" value="<?= htmlspecialchars($sku ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($errors['sku'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['sku'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <div class="field">
        <label for="product-category"><?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?></label>
        <select id="product-category" name="category_id">
            <option value=""><?= htmlspecialchars(t('admin.select_category', 'ru'), ENT_QUOTES) ?></option>
            <?php foreach ($categories as $category) : ?>
                <?php $label = $category['name'] !== '' ? $category['name'] : $category['slug']; ?>
                <option value="<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>" <?= (string) $category['id'] === (string) ($category_id ?? '') ? 'selected' : '' ?>>
                    <?= htmlspecialchars($label, ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['category_id'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['category_id'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.create', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
