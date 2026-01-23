<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.files_title', 'ru'), ENT_QUOTES) ?></h1>
<form method="post" enctype="multipart/form-data" class="form-grid">
    <label>
        <?= htmlspecialchars(t('admin.file_upload', 'ru'), ENT_QUOTES) ?>
        <input type="file" name="file">
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.upload', 'ru'), ENT_QUOTES) ?></button>
</form>
<table>
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
<?php include __DIR__ . '/partials/footer.php'; ?>
