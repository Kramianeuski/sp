<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.category_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/categories"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card">
    <div class="tabs">
        <a class="tab <?= $category['language'] === 'ru' ? 'is-active' : '' ?>" href="/admin/categories/edit?id=<?= htmlspecialchars($category['category_id'], ENT_QUOTES) ?>&lang=ru">RU</a>
        <a class="tab <?= $category['language'] === 'en' ? 'is-active' : '' ?>" href="/admin/categories/edit?id=<?= htmlspecialchars($category['category_id'], ENT_QUOTES) ?>&lang=en">EN</a>
    </div>
    <form method="post" class="form-card">
        <?= csrf_field() ?>
        <div class="field">
            <label for="category-name"><?= htmlspecialchars(t('admin.category_name', 'ru'), ENT_QUOTES) ?></label>
            <input id="category-name" type="text" name="name" value="<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="category-h1"><?= htmlspecialchars(t('admin.category_h1', 'ru'), ENT_QUOTES) ?></label>
            <input id="category-h1" type="text" name="h1" value="<?= htmlspecialchars($category['h1'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="category-description"><?= htmlspecialchars(t('admin.category_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="category-description" name="description" rows="4"><?= htmlspecialchars($category['description'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="category-meta-title"><?= htmlspecialchars(t('admin.meta_title', 'ru'), ENT_QUOTES) ?></label>
            <input id="category-meta-title" type="text" name="meta_title" value="<?= htmlspecialchars($category['meta_title'], ENT_QUOTES) ?>">
        </div>
        <div class="field">
            <label for="category-meta-description"><?= htmlspecialchars(t('admin.meta_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="category-meta-description" name="meta_description" rows="3"><?= htmlspecialchars($category['meta_description'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="category-seo-text"><?= htmlspecialchars(t('admin.seo_text', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="category-seo-text" name="seo_text" rows="4"><?= htmlspecialchars($category['seo_text'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="category-official"><?= htmlspecialchars(t('admin.official_seller', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="category-official" name="official_seller" rows="3"><?= htmlspecialchars($category['official_seller'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="field">
            <label for="category-faq"><?= htmlspecialchars(t('admin.faq', 'ru'), ENT_QUOTES) ?></label>
            <textarea id="category-faq" name="faq" rows="6"><?= htmlspecialchars($category['faq'], ENT_QUOTES) ?></textarea>
        </div>
        <label class="checkbox-field">
            <input type="checkbox" name="indexable" value="1" <?= $category['indexable'] ? 'checked' : '' ?>>
            <?= htmlspecialchars(t('admin.indexable', 'ru'), ENT_QUOTES) ?>
        </label>
        <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
    </form>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
