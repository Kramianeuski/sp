<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.partners_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/partners/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.partner_name', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.partner_type', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.partner_url', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($partners as $partner) : ?>
            <tr>
                <td><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($partner['type'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($partner['url'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars((string) $partner['sort_order'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/partners/edit?id=<?= htmlspecialchars($partner['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                    ·
                    <form class="inline-form" method="post" action="/admin/partners/delete" onsubmit="return confirm('Удалить партнера?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($partner['id'], ENT_QUOTES) ?>">
                        <button class="btn-link" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
