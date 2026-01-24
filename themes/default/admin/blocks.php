<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.blocks_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/pages/edit?id=<?= htmlspecialchars($page_id, ENT_QUOTES) ?>">
            <?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?>
        </a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.block_key', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.block_title', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($blocks as $block) : ?>
            <tr>
                <td><?= htmlspecialchars($block['block_key'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($block['title'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars((string) $block['sort_order'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/blocks/edit?id=<?= htmlspecialchars($block['id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
