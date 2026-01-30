<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.leads_title', 'ru'), ENT_QUOTES) ?></h1>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th><?= htmlspecialchars(t('admin.lead_name', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.lead_contact', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.created_at', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($leads as $lead) : ?>
            <tr>
                <td><?= htmlspecialchars((string) $lead['id'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($lead['full_name'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($lead['preferred_contact'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($lead['status'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($lead['created_at'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/leads/edit?id=<?= htmlspecialchars((string) $lead['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
