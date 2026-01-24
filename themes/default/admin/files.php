<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.files_title', 'ru'), ENT_QUOTES) ?></h1>
</div>
<form method="post" enctype="multipart/form-data" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="file-upload"><?= htmlspecialchars(t('admin.file_upload', 'ru'), ENT_QUOTES) ?></label>
        <input id="file-upload" type="file" name="file">
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.upload', 'ru'), ENT_QUOTES) ?></button>
</form>
<div class="card table-card" style="margin-top: 20px;">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.file_name', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.file_path', 'ru'), ENT_QUOTES) ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file) : ?>
            <tr>
                <td><?= htmlspecialchars($file['file_name'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($file['file_path'], ENT_QUOTES) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
