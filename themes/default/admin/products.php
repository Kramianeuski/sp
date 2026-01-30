<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.products_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/products/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.product_category', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_ru', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_en', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= htmlspecialchars($product['sku'] ?? '', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($product['code'] ?? '', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($product['name_ru'] ?? '', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($product['name_en'] ?? '', ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/products/edit?id=<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                    ·
                    <a href="/admin/products/specs?product_id=<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.specs', 'ru'), ENT_QUOTES) ?></a>
                    ·
                    <form class="inline-form" method="post" action="/admin/products/delete" onsubmit="return confirm('Удалить продукт?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>">
                        <button class="btn-link" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
