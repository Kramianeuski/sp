<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.footer_title', 'ru'), ENT_QUOTES) ?></h1>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="tabs" data-tabs="footer-edit">
        <button type="button" class="tab" data-tab-target="ru">RU</button>
        <button type="button" class="tab" data-tab-target="en">EN</button>
    </div>
    <?php foreach (['ru' => 'RU', 'en' => 'EN'] as $lang => $label) : ?>
        <?php $data = $settings[$lang] ?? []; ?>
        <?php $links = $lang === 'ru' ? $links_ru : $links_en; ?>
        <div class="tab-panel" data-tab-group="footer-edit" data-tab-panel="<?= $lang ?>">
            <div class="field">
                <label for="footer-text-<?= $lang ?>"><?= htmlspecialchars(t('admin.footer_text', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="footer-text-<?= $lang ?>" name="footer_text_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['footer_text'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label for="footer-copyright-<?= $lang ?>"><?= htmlspecialchars(t('admin.footer_copyright', 'ru'), ENT_QUOTES) ?></label>
                <input id="footer-copyright-<?= $lang ?>" type="text" name="footer_copyright_<?= $lang ?>" value="<?= htmlspecialchars($data['footer_copyright'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label for="footer-contacts-<?= $lang ?>"><?= htmlspecialchars(t('admin.footer_contacts', 'ru'), ENT_QUOTES) ?></label>
                <textarea id="footer-contacts-<?= $lang ?>" name="footer_contacts_<?= $lang ?>" rows="3"><?= htmlspecialchars($data['footer_contacts'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('admin.footer_links', 'ru'), ENT_QUOTES) ?></label>
                <div class="repeatable-table">
                    <div class="repeatable-row repeatable-row--head">
                        <span><?= htmlspecialchars(t('admin.footer_link_label', 'ru'), ENT_QUOTES) ?></span>
                        <span><?= htmlspecialchars(t('admin.footer_link_url', 'ru'), ENT_QUOTES) ?></span>
                        <span><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></span>
                    </div>
                    <?php foreach ($links as $link) : ?>
                        <div class="repeatable-row">
                            <input type="text" name="footer_links_label_<?= $lang ?>[]" value="<?= htmlspecialchars($link['label'], ENT_QUOTES) ?>">
                            <input type="text" name="footer_links_url_<?= $lang ?>[]" value="<?= htmlspecialchars($link['url'], ENT_QUOTES) ?>">
                            <input type="number" name="footer_links_sort_<?= $lang ?>[]" value="<?= htmlspecialchars($link['sort_order'], ENT_QUOTES) ?>">
                        </div>
                    <?php endforeach; ?>
                    <?php for ($i = 0; $i < 3; $i++) : ?>
                        <div class="repeatable-row">
                            <input type="text" name="footer_links_label_<?= $lang ?>[]" value="">
                            <input type="text" name="footer_links_url_<?= $lang ?>[]" value="">
                            <input type="number" name="footer_links_sort_<?= $lang ?>[]" value="">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
