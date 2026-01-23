<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.product_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <a class="button-link" href="/admin/products"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
</div>
<form method="post" class="form-grid">
    <?= csrf_field() ?>
    <?php if (!empty($errors)) : ?>
        <div class="error">
            <?= htmlspecialchars(implode(' ', $errors), ENT_QUOTES) ?>
        </div>
    <?php endif; ?>
    <label>
        <?= htmlspecialchars(t('admin.product_slug', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="slug" value="<?= htmlspecialchars($slug ?? '', ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="sku" value="<?= htmlspecialchars($sku ?? '', ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?>
        <select name="category_id">
            <option value=""><?= htmlspecialchars(t('admin.select_category', 'ru'), ENT_QUOTES) ?></option>
            <?php foreach ($categories as $category) : ?>
                <?php $label = $category['name'] !== '' ? $category['name'] : $category['slug']; ?>
                <option value="<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>" <?= (string) $category['id'] === (string) ($category_id ?? '') ? 'selected' : '' ?>>
                    <?= htmlspecialchars($label, ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.create', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
