<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.categories_title', 'ru'), ENT_QUOTES) ?></h1>
<table>
    <thead>
    <tr>
        <th><?= htmlspecialchars(t('admin.category_slug', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?= htmlspecialchars($category['slug'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($category['language'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($category['name'], ENT_QUOTES) ?></td>
            <td>
                <a href="/admin/categories/edit?id=<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($category['language'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/partials/footer.php'; ?>
