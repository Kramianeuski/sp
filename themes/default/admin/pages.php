<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.pages_title', 'ru'), ENT_QUOTES) ?></h1>
    <a class="button-link" href="/admin/pages/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
</div>
<table>
    <thead>
    <tr>
        <th><?= htmlspecialchars(t('admin.page_slug', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.page_title', 'ru'), ENT_QUOTES) ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pages as $page) : ?>
        <tr>
            <td><?= htmlspecialchars($page['slug'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($page['language'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($page['h1'], ENT_QUOTES) ?></td>
            <td>
                <a href="/admin/pages/edit?id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($page['language'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                </a>
                <a href="/admin/blocks?page_id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($page['language'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.blocks', 'ru'), ENT_QUOTES) ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/partials/footer.php'; ?>
