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
            <th><?= htmlspecialchars(t('admin.category_code', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_ru', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_en', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?= htmlspecialchars($category['code'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($category['is_active'] ? 'active' : 'inactive', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($category['name_ru'] ?? '', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($category['name_en'] ?? '', ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/categories/edit?id=<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                    ·
                    <form class="inline-form" method="post" action="/admin/categories/delete" onsubmit="return confirm('Удалить категорию?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id'], ENT_QUOTES) ?>">
                        <button class="btn-link" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
