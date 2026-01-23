<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.translation_edit_title', 'ru'), ENT_QUOTES) ?></h1>
<form method="post" class="form-grid">
    <?= csrf_field() ?>
    <label>
        <?= htmlspecialchars(t('admin.translation_key', 'ru'), ENT_QUOTES) ?>
        <input type="text" value="<?= htmlspecialchars($translation['key'], ENT_QUOTES) ?>" disabled>
    </label>
    <label>
        <?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?>
        <textarea name="value" rows="4"><?= htmlspecialchars($translation['value'], ENT_QUOTES) ?></textarea>
    </label>
    <button type="submit"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
