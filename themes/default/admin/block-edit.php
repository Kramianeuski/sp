<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.block_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/blocks?page_id=<?= htmlspecialchars($block['page_id'], ENT_QUOTES) ?>&lang=<?= htmlspecialchars($block['language'], ENT_QUOTES) ?>">
            <?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?>
        </a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="block-title"><?= htmlspecialchars(t('admin.block_title', 'ru'), ENT_QUOTES) ?></label>
        <input id="block-title" type="text" name="title" value="<?= htmlspecialchars($block['title'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="block-body"><?= htmlspecialchars(t('admin.block_body', 'ru'), ENT_QUOTES) ?></label>
        <textarea id="block-body" name="body" rows="8"><?= htmlspecialchars($block['body'], ENT_QUOTES) ?></textarea>
    </div>
    <div class="field">
        <label for="block-order"><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></label>
        <input id="block-order" type="number" name="sort_order" value="<?= htmlspecialchars((string) $block['sort_order'], ENT_QUOTES) ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
