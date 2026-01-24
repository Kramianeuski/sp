<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.pages_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/pages/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.page_slug', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_ru', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_en', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pages as $page) : ?>
            <tr>
                <td><?= htmlspecialchars($page['slug'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($page['status'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($page['h1_ru'] ?? '', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($page['h1_en'] ?? '', ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/pages/edit?id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                    </a>
                    ·
                    <a href="/admin/blocks?page_id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>&lang=ru">
                        <?= htmlspecialchars(t('admin.blocks_ru', 'ru'), ENT_QUOTES) ?>
                    </a>
                    ·
                    <a href="/admin/blocks?page_id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>&lang=en">
                        <?= htmlspecialchars(t('admin.blocks_en', 'ru'), ENT_QUOTES) ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
