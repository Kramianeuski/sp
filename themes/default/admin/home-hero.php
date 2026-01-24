<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.home_hero_title', 'ru'), ENT_QUOTES) ?></h1>
</div>
<form method="post" class="card form-card" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="field">
        <label for="hero-video"><?= htmlspecialchars(t('admin.hero_video', 'ru'), ENT_QUOTES) ?></label>
        <input id="hero-video" type="file" name="hero_video" accept="video/mp4,video/webm">
    </div>
    <div class="field">
        <label for="hero-poster"><?= htmlspecialchars(t('admin.hero_poster', 'ru'), ENT_QUOTES) ?></label>
        <input id="hero-poster" type="file" name="hero_poster" accept="image/*">
    </div>
    <label class="checkbox-field">
        <input type="checkbox" name="hero_autoplay" value="1" <?= !empty($settings['hero_video_autoplay']) ? 'checked' : '' ?>>
        <?= htmlspecialchars(t('admin.hero_autoplay', 'ru'), ENT_QUOTES) ?>
    </label>
    <div class="tabs" data-tabs="hero-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $settings[$lang] ?? []; ?>
        <div class="tab-panel" data-tab-group="hero-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label for="hero-title-<?= $lang ?>"><?= htmlspecialchars(t('admin.hero_title_label', 'ru'), ENT_QUOTES) ?></label>
                <input id="hero-title-<?= $lang ?>" type="text" name="hero_title_<?= $lang ?>" value="<?= htmlspecialchars($data['hero_title'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="hero-subtitle-<?= $lang ?>"><?= htmlspecialchars(t('admin.hero_subtitle_label', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="hero-subtitle-<?= $lang ?>" name="hero_subtitle_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['hero_subtitle'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.hero_primary_cta', 'ru'), ENT_QUOTES) ?></label>
                <div class="inline-fields">
                    <input type="text" name="hero_cta_primary_label_<?= $lang ?>" placeholder="<?= htmlspecialchars(t('admin.hero_cta_label', 'ru'), ENT_QUOTES) ?>" value="<?= htmlspecialchars($data['hero_cta_primary_label'] ?? '', ENT_QUOTES) ?>">
                    <input type="text" name="hero_cta_primary_url_<?= $lang ?>" placeholder="URL" value="<?= htmlspecialchars($data['hero_cta_primary_url'] ?? '', ENT_QUOTES) ?>">
                </div>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.hero_secondary_cta', 'ru'), ENT_QUOTES) ?></label>
                <div class="inline-fields">
                    <input type="text" name="hero_cta_secondary_label_<?= $lang ?>" placeholder="<?= htmlspecialchars(t('admin.hero_cta_label', 'ru'), ENT_QUOTES) ?>" value="<?= htmlspecialchars($data['hero_cta_secondary_label'] ?? '', ENT_QUOTES) ?>">
                    <input type="text" name="hero_cta_secondary_url_<?= $lang ?>" placeholder="URL" value="<?= htmlspecialchars($data['hero_cta_secondary_url'] ?? '', ENT_QUOTES) ?>">
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
