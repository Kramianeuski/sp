<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.header_title', 'ru'), ENT_QUOTES) ?></h1>
</div>
<form method="post" class="card form-card" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="field">
        <label for="header-logo-file"><?= htmlspecialchars(t('admin.header_logo_file', 'ru'), ENT_QUOTES) ?></label>
        <input id="header-logo-file" type="file" name="header_logo" accept="image/svg+xml,image/png">
    </div>
    <div class="tabs" data-tabs="header-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $settings[$lang] ?? []; ?>
        <?php $navLinks = $lang === 'ru' ? ($nav_ru ?? []) : ($nav_en ?? []); ?>
        <div class="tab-panel" data-tab-group="header-edit" data-tab-panel="<?= $lang ?>">
            <label class="checkbox-field">
                <input type="checkbox" name="header_show_logo_<?= $lang ?>" value="1" <?= !empty($data['header_show_logo']) ? 'checked' : '' ?>>
                <?= htmlspecialchars(t('admin.header_show_logo', 'ru'), ENT_QUOTES) ?>
            </label>
            <div class="field">
                <label for="header-logo-link-<?= $lang ?>"><?= htmlspecialchars(t('admin.header_logo_link', 'ru'), ENT_QUOTES) ?></label>
                <input id="header-logo-link-<?= $lang ?>" type="text" name="header_logo_link_<?= $lang ?>" value="<?= htmlspecialchars($data['header_logo_link'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="header-logo-alt-<?= $lang ?>"><?= htmlspecialchars(t('admin.header_logo_alt', 'ru'), ENT_QUOTES) ?></label>
                <input id="header-logo-alt-<?= $lang ?>" type="text" name="header_logo_alt_<?= $lang ?>" value="<?= htmlspecialchars($data['header_logo_alt'] ?? '', ENT_QUOTES) ?>">
            </div>
            <?php if (!empty($data['header_logo_path'])) : ?>
                <div class="field">
                    <label><?= htmlspecialchars(t('admin.header_logo_current', 'ru'), ENT_QUOTES) ?></label>
                    <div class="media-preview">
                        <img src="<?= htmlspecialchars($data['header_logo_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($data['header_logo_alt'] ?? '', ENT_QUOTES) ?>">
                    </div>
                </div>
            <?php endif; ?>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.header_links', 'ru'), ENT_QUOTES) ?></label>
                <div class="repeatable-table">
                    <div class="repeatable-row repeatable-row--head">
                        <span><?= htmlspecialchars(t('admin.header_link_label', 'ru'), ENT_QUOTES) ?></span>
                        <span><?= htmlspecialchars(t('admin.header_link_url', 'ru'), ENT_QUOTES) ?></span>
                        <span><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></span>
                    </div>
                    <?php foreach ($navLinks as $link) : ?>
                        <div class="repeatable-row">
                            <input type="text" name="header_links_label_<?= $lang ?>[]" value="<?= htmlspecialchars($link['label'], ENT_QUOTES) ?>">
                            <input type="text" name="header_links_url_<?= $lang ?>[]" value="<?= htmlspecialchars($link['url'], ENT_QUOTES) ?>">
                            <input type="number" name="header_links_sort_<?= $lang ?>[]" value="<?= htmlspecialchars($link['sort_order'], ENT_QUOTES) ?>">
                        </div>
                    <?php endforeach; ?>
                    <?php for ($i = 0; $i < 3; $i++) : ?>
                        <div class="repeatable-row">
                            <input type="text" name="header_links_label_<?= $lang ?>[]" value="">
                            <input type="text" name="header_links_url_<?= $lang ?>[]" value="">
                            <input type="number" name="header_links_sort_<?= $lang ?>[]" value="">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
