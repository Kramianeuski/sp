<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.block_edit_title', 'ru'), ENT_QUOTES) ?></h1>
<form method="post" class="form-grid">
    <?= csrf_field() ?>
    <label>
        <?= htmlspecialchars(t('admin.block_title', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="title" value="<?= htmlspecialchars($block['title'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.block_body', 'ru'), ENT_QUOTES) ?>
        <textarea name="body" rows="8"><?= htmlspecialchars($block['body'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?>
        <input type="number" name="sort_order" value="<?= htmlspecialchars((string) $block['sort_order'], ENT_QUOTES) ?>">
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
