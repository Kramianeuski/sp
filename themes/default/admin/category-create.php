<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.category_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <a class="button-link" href="/admin/categories"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
</div>
<form method="post" class="form-grid">
    <?= csrf_field() ?>
    <?php if (!empty($errors['slug'])) : ?>
        <div class="error"><?= htmlspecialchars($errors['slug'], ENT_QUOTES) ?></div>
    <?php endif; ?>
    <label>
        <?= htmlspecialchars(t('admin.category_slug', 'ru'), ENT_QUOTES) ?>
        <input type="text" name="slug" value="<?= htmlspecialchars($slug ?? '', ENT_QUOTES) ?>">
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.create', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
