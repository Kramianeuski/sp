<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.categories_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/categories/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.category_slug', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?= htmlspecialchars($category['slug'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($category['language'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($category['name'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/categories/edit?id=<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($category['language'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
