<?php
$titleKey = $data['title_key'] ?? '';
$textKey = $data['text_key'] ?? '';
$cta = $data['cta'] ?? [];
?>
<section class="section section-custom">
    <div class="container">
        <div class="custom-cta">
            <div>
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
                <p><?= htmlspecialchars(t($textKey, $language), ENT_QUOTES) ?></p>
            </div>
            <?php if (!empty($cta['text_key'])) : ?>
                <a class="btn btn-secondary" href="<?= htmlspecialchars(localized_url($cta['url'] ?? '#', $language), ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t($cta['text_key'], $language), ENT_QUOTES) ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
