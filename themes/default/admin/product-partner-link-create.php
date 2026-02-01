<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.partner_links_create', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/product-partner-links"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.product', 'ru'), ENT_QUOTES) ?></label>
        <select name="product_id">
            <?php foreach ($products as $product) : ?>
                <option value="<?= htmlspecialchars((string) $product['id'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(($product['sku'] ?? '') . ' — ' . ($product['name'] ?? ''), ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_name', 'ru'), ENT_QUOTES) ?></label>
        <select name="partner_id">
            <?php foreach ($partners as $partner) : ?>
                <option value="<?= htmlspecialchars((string) $partner['id'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars($partner['name'], ENT_QUOTES) ?> (<?= htmlspecialchars($partner['type'], ENT_QUOTES) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_product_url', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="product_url" value="">
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_active" value="1" checked>
        <?= htmlspecialchars(t('admin.is_active', 'ru'), ENT_QUOTES) ?>
    </label>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
