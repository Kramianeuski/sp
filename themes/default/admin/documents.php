<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.documents_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/documents/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.document_title', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.document_scope', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.document_type', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($documents as $document) : ?>
            <tr>
                <td><?= htmlspecialchars($document['title'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars(t('admin.document_scope_' . $document['scope'], 'ru'), ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars(strtoupper($document['language']), ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($document['doc_type'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($document['sort_order'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a class="btn btn-secondary" href="/admin/documents/edit?id=<?= htmlspecialchars($document['id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                    </a>
                    <form method="post" action="/admin/documents/delete" onsubmit="return confirm('Удалить документ?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($document['id'], ENT_QUOTES) ?>">
                        <button class="btn btn-danger" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
