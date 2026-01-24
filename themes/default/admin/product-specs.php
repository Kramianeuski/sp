<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.specs_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products/edit?id=<?= htmlspecialchars($product_id, ENT_QUOTES) ?>&lang=<?= htmlspecialchars($lang, ENT_QUOTES) ?>">
            <?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?>
        </a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.spec_label', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.spec_value', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.spec_unit', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($specs as $spec) : ?>
            <tr>
                <td><?= htmlspecialchars($spec['label'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($spec['value'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($spec['unit'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars((string) $spec['sort_order'], ENT_QUOTES) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
