<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.blocks_title', 'ru'), ENT_QUOTES) ?></h1>
<table>
    <thead>
    <tr>
        <th><?= htmlspecialchars(t('admin.block_key', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.block_title', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($blocks as $block) : ?>
        <tr>
            <td><?= htmlspecialchars($block['block_key'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($block['title'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars((string) $block['sort_order'], ENT_QUOTES) ?></td>
            <td>
                <a href="/admin/blocks/edit?id=<?= htmlspecialchars($block['id'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/partials/footer.php'; ?>
