<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.partner_create_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/partners"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="field">
        <label for="partner-type"><?= htmlspecialchars(t('admin.partner_type', 'ru'), ENT_QUOTES) ?></label>
        <select id="partner-type" name="type">
            <option value="official_distributor"><?= htmlspecialchars(t('partner.type.official_distributor', 'ru'), ENT_QUOTES) ?></option>
            <option value="marketplace"><?= htmlspecialchars(t('partner.type.marketplace', 'ru'), ENT_QUOTES) ?></option>
        </select>
    </div>
    <div class="field">
        <label for="partner-url"><?= htmlspecialchars(t('admin.partner_url', 'ru'), ENT_QUOTES) ?></label>
        <input id="partner-url" type="text" name="url" value="<?= htmlspecialchars($partner['url'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="partner-city"><?= htmlspecialchars(t('admin.partner_city', 'ru'), ENT_QUOTES) ?></label>
        <input id="partner-city" type="text" name="city" value="<?= htmlspecialchars($partner['city'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label><?= htmlspecialchars(t('admin.partner_coordinates', 'ru'), ENT_QUOTES) ?></label>
        <div class="inline-fields">
            <input type="text" name="lat" placeholder="lat" value="<?= htmlspecialchars($partner['lat'] ?? '', ENT_QUOTES) ?>">
            <input type="text" name="lng" placeholder="lng" value="<?= htmlspecialchars($partner['lng'] ?? '', ENT_QUOTES) ?>">
        </div>
    </div>
    <div class="field">
        <label for="partner-sort"><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></label>
        <input id="partner-sort" type="number" name="sort_order" value="<?= htmlspecialchars($partner['sort_order'] ?? 0, ENT_QUOTES) ?>">
    </div>
    <div class="field">
        <label for="partner-logo"><?= htmlspecialchars(t('admin.partner_logo', 'ru'), ENT_QUOTES) ?></label>
        <input id="partner-logo" type="file" name="logo" accept="image/*">
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="is_active" value="1" checked>
        <?= htmlspecialchars(t('admin.partner_active', 'ru'), ENT_QUOTES) ?>
    </label>
    <div class="tabs" data-tabs="partner-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $translations[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="partner-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label for="partner-name-<?= $lang ?>"><?= htmlspecialchars(t('admin.partner_name', 'ru'), ENT_QUOTES) ?></label>
                <input id="partner-name-<?= $lang ?>" type="text" name="name_<?= $lang ?>" value="<?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="partner-description-<?= $lang ?>"><?= htmlspecialchars(t('admin.partner_description', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="partner-description-<?= $lang ?>" name="description_<?= $lang ?>" rows="5"><?= htmlspecialchars($data['description'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
