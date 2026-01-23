<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.specs_title', 'ru'), ENT_QUOTES) ?></h1>
<table>
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
<?php include __DIR__ . '/partials/footer.php'; ?>
