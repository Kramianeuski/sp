<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.products_title', 'ru'), ENT_QUOTES) ?></h1>
<table>
    <thead>
    <tr>
        <th><?= htmlspecialchars(t('admin.product_slug', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.product_name', 'ru'), ENT_QUOTES) ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= htmlspecialchars($product['slug'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($product['language'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></td>
            <td>
                <a href="/admin/products/edit?id=<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($product['language'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                </a>
                <a href="/admin/products/specs?id=<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($product['language'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.specs', 'ru'), ENT_QUOTES) ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/partials/footer.php'; ?>
