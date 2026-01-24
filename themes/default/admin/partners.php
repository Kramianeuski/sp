<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.partners_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/partners/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.partner_name', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.partner_type', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.partner_city', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($partners as $partner) : ?>
            <tr>
                <td><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars(t('partner.type.' . $partner['type'], 'ru'), ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($partner['city'], ENT_QUOTES) ?></td>
                <td><?= !empty($partner['is_active']) ? htmlspecialchars(t('admin.status_published', 'ru'), ENT_QUOTES) : htmlspecialchars(t('admin.status_archived', 'ru'), ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($partner['sort_order'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a class="btn btn-secondary" href="/admin/partners/edit?id=<?= htmlspecialchars($partner['id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                    </a>
                    <form method="post" action="/admin/partners/delete" onsubmit="return confirm('Удалить партнёра?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($partner['id'], ENT_QUOTES) ?>">
                        <button class="btn btn-danger" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
