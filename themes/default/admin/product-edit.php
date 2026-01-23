<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.product_edit_title', 'ru'), ENT_QUOTES) ?></h1>
<form method="post" class="form-grid">
    <label>
        <?= htmlspecialchars(t('admin.product_slug', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="slug" value="<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="sku" value="<?= htmlspecialchars($product['sku'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.product_name', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.product_h1', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="h1" value="<?= htmlspecialchars($product['h1'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.product_short', 'ru'), ENT_QUOTES) ?>
        <textarea name="short_description" rows="3"><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.product_description', 'ru'), ENT_QUOTES) ?>
        <textarea name="description" rows="6"><?= htmlspecialchars($product['description'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="meta_title" value="<?= htmlspecialchars($product['meta_title'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?>
        <textarea name="meta_description" rows="3"><?= htmlspecialchars($product['meta_description'], ENT_QUOTES) ?></textarea>
    </label>
    <label class="checkbox">
        <input type="checkbox" name="indexable" value="1" <?= $product['indexable'] ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
