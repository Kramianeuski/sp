<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.document_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/documents"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= htmlspecialchars($document['id'], ENT_QUOTES) ?>">
    <div class="field">
        <label for="document-scope"><?= htmlspecialchars(t('admin.document_scope', 'ru'), ENT_QUOTES) ?></label>
        <select id="document-scope" name="scope">
            <option value="brand" <?= $document['scope'] === 'brand' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.document_scope_brand', 'ru'), ENT_QUOTES) ?></option>
            <option value="product" <?= $document['scope'] === 'product' ? 'selected' : '' ?>><?= htmlspecialchars(t('admin.document_scope_product', 'ru'), ENT_QUOTES) ?></option>
        </select>
    </div>
    <div class="field">
        <label for="document-language"><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></label>
        <select id="document-language" name="language">
            <option value="ru" <?= $document['language'] === 'ru' ? 'selected' : '' ?>>RU</option>
            <option value="en" <?= $document['language'] === 'en' ? 'selected' : '' ?>>EN</option>
        </select>
    </div>
    <div class="field">
        <label for="document-title"><?= htmlspecialchars(t('admin.document_title', 'ru'), ENT_QUOTES) ?></label>
        <input id="document-title" type="text" name="title" value="<?= htmlspecialchars($document['title'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="document-type"><?= htmlspecialchars(t('admin.document_type', 'ru'), ENT_QUOTES) ?></label>
        <input id="document-type" type="text" name="doc_type" value="<?= htmlspecialchars($document['doc_type'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="document-file"><?= htmlspecialchars(t('admin.document_file', 'ru'), ENT_QUOTES) ?></label>
        <input id="document-file" type="file" name="file" accept="application/pdf,image/*">
    </div>
    <div class="field">
        <label for="document-path"><?= htmlspecialchars(t('admin.file_path', 'ru'), ENT_QUOTES) ?></label>
        <input id="document-path" type="text" name="file_path" value="<?= htmlspecialchars($document['file_path'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="document-sort"><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></label>
        <input id="document-sort" type="number" name="sort_order" value="<?= htmlspecialchars($document['sort_order'], ENT_QUOTES) ?>">
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_active" value="1" <?= !empty($document['is_active']) ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.document_active', 'ru'), ENT_QUOTES) ?>
    </label>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
