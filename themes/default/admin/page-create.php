<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.page_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/pages"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label for="page-slug"><?= htmlspecialchars(t('admin.page_slug', 'ru'), ENT_QUOTES) ?></label>
        <input id="page-slug" type="text" name="slug" value="<?= htmlspecialchars($slug ?? '', ENT_QUOTES) ?>">
        <?php if (!empty($errors['slug'])) : ?>
            <div class="field-error"><?= htmlspecialchars($errors['slug'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.create', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
