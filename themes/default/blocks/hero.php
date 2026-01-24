<?php
$heroTitle = $settings['hero_title'] ?? $blockData['title'] ?? '';
$heroSubtitle = $settings['hero_subtitle'] ?? $blockData['body'] ?? '';
$primaryLabel = $settings['hero_cta_primary_label'] ?? t('cta.catalog', $language);
$primaryUrl = $settings['hero_cta_primary_url'] ?? '/' . $language . '/products/';
$secondaryLabel = $settings['hero_cta_secondary_label'] ?? t('where_to_buy.button', $language);
$secondaryUrl = $settings['hero_cta_secondary_url'] ?? '/' . $language . '/where-to-buy/';
$heroVideo = $settings['hero_video_path'] ?? '';
$heroPoster = $settings['hero_video_poster'] ?? '';
$heroAutoplay = !empty($settings['hero_video_autoplay']);
?>
<section class="hero">
    <div class="hero-media">
        <?php if (!empty($heroVideo)) : ?>
            <video class="hero-video" <?= $heroAutoplay ? 'autoplay muted loop playsinline' : 'controls' ?> <?= !empty($heroPoster) ? 'poster="' . htmlspecialchars($heroPoster, ENT_QUOTES) . '"' : '' ?>>
                <source src="<?= htmlspecialchars($heroVideo, ENT_QUOTES) ?>">
            </video>
        <?php endif; ?>
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1><?= htmlspecialchars($heroTitle, ENT_QUOTES) ?></h1>
            <?php if (!empty($heroSubtitle)) : ?>
                <p class="hero-subtitle"><?= nl2br(htmlspecialchars($heroSubtitle, ENT_QUOTES)) ?></p>
            <?php endif; ?>
            <div class="hero-actions">
                <a class="button" href="<?= htmlspecialchars($primaryUrl, ENT_QUOTES) ?>"><?= htmlspecialchars($primaryLabel, ENT_QUOTES) ?></a>
                <a class="button secondary" href="<?= htmlspecialchars($secondaryUrl, ENT_QUOTES) ?>"><?= htmlspecialchars($secondaryLabel, ENT_QUOTES) ?></a>
            </div>
        </div>
    </div>
</section>
