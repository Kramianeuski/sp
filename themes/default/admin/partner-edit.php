<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.partner_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/partners"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_type', 'ru'), ENT_QUOTES) ?></label>
        <select name="type">
            <option value="distributor" <?= $partner['type'] === 'distributor' ? 'selected' : '' ?>>distributor</option>
            <option value="marketplace" <?= $partner['type'] === 'marketplace' ? 'selected' : '' ?>>marketplace</option>
        </select>
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_name', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="name" value="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_city', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="city" value="<?= htmlspecialchars($partner['city'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_url', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="url" value="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></label>
        <input type="number" name="sort_order" value="<?= htmlspecialchars((string) $partner['sort_order'], ENT_QUOTES) ?>">
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_active" value="1" <?= !empty($partner['is_active']) ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.is_active', 'ru'), ENT_QUOTES) ?>
    </label>
    <div class="tabs" data-tabs="partner-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <div class="tab-panel" data-tab-group="partner-edit" data-tab-panel="ru">
        <div class="field">
            <label><?= htmlspecialchars(t('admin.partner_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea name="description_ru" rows="6"><?= htmlspecialchars($translations['ru'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
    </div>
    <div class="tab-panel" data-tab-group="partner-edit" data-tab-panel="en">
        <div class="field">
            <label><?= htmlspecialchars(t('admin.partner_description', 'ru'), ENT_QUOTES) ?></label>
            <textarea name="description_en" rows="6"><?= htmlspecialchars($translations['en'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
