<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.import_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<?php if (!empty($importResult)) : ?>
    <div class="card">
        <h2><?= htmlspecialchars(t('admin.import_result', 'ru'), ENT_QUOTES) ?></h2>
        <p><?= htmlspecialchars(t('admin.import_created', 'ru'), ENT_QUOTES) ?>: <?= htmlspecialchars($importResult['created'], ENT_QUOTES) ?></p>
        <p><?= htmlspecialchars(t('admin.import_updated', 'ru'), ENT_QUOTES) ?>: <?= htmlspecialchars($importResult['updated'], ENT_QUOTES) ?></p>
        <p><?= htmlspecialchars(t('admin.import_skipped', 'ru'), ENT_QUOTES) ?>: <?= htmlspecialchars($importResult['skipped'], ENT_QUOTES) ?></p>
        <?php if (!empty($importResult['errors'])) : ?>
            <div class="alert alert-warning">
                <strong><?= htmlspecialchars(t('admin.import_errors', 'ru'), ENT_QUOTES) ?></strong>
                <ul>
                    <?php foreach ($importResult['errors'] as $error) : ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<form method="post" class="card form-card" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if (empty($previewRows)) : ?>
        <div class="field">
            <label for="import-file"><?= htmlspecialchars(t('admin.import_upload', 'ru'), ENT_QUOTES) ?></label>
            <input id="import-file" type="file" name="file" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
        </div>
        <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.import_preview', 'ru'), ENT_QUOTES) ?></button>
    <?php else : ?>
        <input type="hidden" name="file_token" value="<?= htmlspecialchars($fileToken, ENT_QUOTES) ?>">
        <div class="field">
            <label for="import-mode"><?= htmlspecialchars(t('admin.import_mode', 'ru'), ENT_QUOTES) ?></label>
            <select id="import-mode" name="mode">
                <option value="create_new"><?= htmlspecialchars(t('admin.import_mode_create', 'ru'), ENT_QUOTES) ?></option>
                <option value="update_by_sku"><?= htmlspecialchars(t('admin.import_mode_update', 'ru'), ENT_QUOTES) ?></option>
                <option value="skip_existing"><?= htmlspecialchars(t('admin.import_mode_skip', 'ru'), ENT_QUOTES) ?></option>
            </select>
        </div>
        <h2><?= htmlspecialchars(t('admin.import_map_title', 'ru'), ENT_QUOTES) ?></h2>
        <div class="repeatable-table">
            <?php foreach ($fieldMap as $fieldKey => $label) : ?>
                <div class="repeatable-row repeatable-row--two">
                    <span><?= htmlspecialchars($label, ENT_QUOTES) ?></span>
                    <select name="mapping[<?= htmlspecialchars($fieldKey, ENT_QUOTES) ?>]">
                        <option value="">—</option>
                        <?php foreach ($columns as $index => $column) : ?>
                            <option value="<?= htmlspecialchars($index, ENT_QUOTES) ?>">
                                <?= htmlspecialchars($column, ENT_QUOTES) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>
        <h2><?= htmlspecialchars(t('admin.import_preview_title', 'ru'), ENT_QUOTES) ?></h2>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <?php foreach ($columns as $column) : ?>
                        <th><?= htmlspecialchars($column, ENT_QUOTES) ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($previewRows as $row) : ?>
                    <tr>
                        <?php foreach ($columns as $index => $column) : ?>
                            <td><?= htmlspecialchars($row[$index] ?? '', ENT_QUOTES) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary" name="run_import" value="1"><?= htmlspecialchars(t('admin.import_start', 'ru'), ENT_QUOTES) ?></button>
    <?php endif; ?>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
