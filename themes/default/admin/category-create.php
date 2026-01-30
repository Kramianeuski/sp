<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.category_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/categories"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.category_code', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="code" value="<?= htmlspecialchars($code, ENT_QUOTES) ?>">
        <?php if (!empty($errors['code'])) : ?>
            <span class="field-error"><?= htmlspecialchars($errors['code'], ENT_QUOTES) ?></span>
        <?php endif; ?>
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_active" value="1" <?= !empty($isActive) ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.is_active', 'ru'), ENT_QUOTES) ?>
    </label>
    <div class="tabs" data-tabs="category-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $translations[$lang] ?? []; ?>
        <?php $seoData = $seo[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="category-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label><?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="name_<?= $lang ?>" value="<?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.category_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea name="description_<?= $lang ?>" rows="4"><?= htmlspecialchars($data['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="meta_title_<?= $lang ?>" value="<?= htmlspecialchars($seoData['title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea name="meta_description_<?= $lang ?>" rows="3"><?= htmlspecialchars($seoData['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.category_h1', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="h1_<?= $lang ?>" value="<?= htmlspecialchars($seoData['h1'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.slug', 'ru'), ENT_QUOTES) ?></label>
                <input type="text" name="slug_<?= $lang ?>" value="<?= htmlspecialchars($seoData['slug'] ?? '', ENT_QUOTES) ?>">
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
