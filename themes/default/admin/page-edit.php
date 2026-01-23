<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.page_edit_title', 'ru'), ENT_QUOTES) ?></h1>
<form method="post" class="form-grid">
    <label>
        <?= htmlspecialchars(t('admin.page_title', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="title" value="<?= htmlspecialchars($page['title'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.page_h1', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="h1" value="<?= htmlspecialchars($page['h1'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?>
        <textarea name="meta_description" rows="3"><?= htmlspecialchars($page['meta_description'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.canonical', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="canonical" value="<?= htmlspecialchars($page['canonical'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.robots', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="robots" value="<?= htmlspecialchars($page['robots'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.og_title', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="og_title" value="<?= htmlspecialchars($page['og_title'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.og_description', 'ru'), ENT_QUOTES) ?>
        <textarea name="og_description" rows="3"><?= htmlspecialchars($page['og_description'], ENT_QUOTES) ?></textarea>
    </label>
    <label class="checkbox">
        <input type="checkbox" name="indexable" value="1" <?= $page['indexable'] ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
