<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.import_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card">
    <p><?= htmlspecialchars(t('admin.import_note', 'ru'), ENT_QUOTES) ?></p>
    <?php if (!empty($importResult)) : ?>
        <div class="alert <?= $importResult['status'] === 0 ? 'alert-success' : 'alert-warning' ?>">
            <strong><?= htmlspecialchars(t('admin.import_result', 'ru'), ENT_QUOTES) ?></strong>
            <pre><?= htmlspecialchars(implode("\n", $importResult['output'] ?? []), ENT_QUOTES) ?></pre>
        </div>
    <?php endif; ?>
    <form method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.import_start', 'ru'), ENT_QUOTES) ?></button>
    </form>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
