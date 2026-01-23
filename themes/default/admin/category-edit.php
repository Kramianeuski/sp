<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.category_edit_title', 'ru'), ENT_QUOTES) ?></h1>
<form method="post" class="form-grid">
    <label>
        <?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="name" value="<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.category_h1', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="h1" value="<?= htmlspecialchars($category['h1'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.category_description', 'ru'), ENT_QUOTES) ?>
        <textarea name="description" rows="4"><?= htmlspecialchars($category['description'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="meta_title" value="<?= htmlspecialchars($category['meta_title'], ENT_QUOTES) ?>">
    </label>
    <label>
        <?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?>
        <textarea name="meta_description" rows="3"><?= htmlspecialchars($category['meta_description'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.seo_text', 'ru'), ENT_QUOTES) ?>
        <textarea name="seo_text" rows="4"><?= htmlspecialchars($category['seo_text'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.official_seller', 'ru'), ENT_QUOTES) ?>
        <textarea name="official_seller" rows="3"><?= htmlspecialchars($category['official_seller'], ENT_QUOTES) ?></textarea>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.faq', 'ru'), ENT_QUOTES) ?>
        <textarea name="faq" rows="6"><?= htmlspecialchars($category['faq'], ENT_QUOTES) ?></textarea>
    </label>
    <label class="checkbox">
        <input type="checkbox" name="indexable" value="1" <?= $category['indexable'] ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
