<?php
$videoId = $data['video_id'] ?? null;
$posterId = $data['poster_id'] ?? null;
$videoPath = $videoId ? media_path((int) $videoId) : null;
$posterPath = $posterId ? media_path((int) $posterId) : null;
$videoPath = $videoPath ?: '/storage/uploads/pages/home/Banner.optimized.mp4';
$posterPath = $posterPath ?: '/storage/uploads/pages/home/Banner.jpg';
$titleKey = $data['title_key'] ?? '';
$subtitleKey = $data['subtitle_key'] ?? '';
$ctaPrimary = $data['cta_primary'] ?? [];
$ctaSecondary = $data['cta_secondary'] ?? [];
$overlayOpacity = $data['overlay_opacity'] ?? 0.45;
$gradient = !empty($data['gradient']);
?>
<section class="hero">
    <div class="hero-media">
        <?php if ($videoPath) : ?>
            <video
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                poster="<?= htmlspecialchars($posterPath, ENT_QUOTES) ?>"
                class="hero-video"
                data-hero-video
                data-src="<?= htmlspecialchars($videoPath, ENT_QUOTES) ?>"
            >
                <source src="<?= htmlspecialchars($videoPath, ENT_QUOTES) ?>" type="video/mp4">
            </video>
        <?php endif; ?>
        <div class="hero-overlay" style="opacity: <?= htmlspecialchars((string) $overlayOpacity, ENT_QUOTES) ?>"></div>
        <?php if ($gradient) : ?>
            <div class="hero-glow"></div>
        <?php endif; ?>
        <button class="hero-play" type="button" data-hero-play><?= htmlspecialchars(t('hero.play', $language), ENT_QUOTES) ?></button>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h1>
            <p><?= htmlspecialchars(t($subtitleKey, $language), ENT_QUOTES) ?></p>
            <div class="hero-actions">
                <?php if (!empty($ctaPrimary['text_key'])) : ?>
                    <a class="btn btn-primary" href="<?= htmlspecialchars(localized_url($ctaPrimary['url'] ?? '#', $language), ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t($ctaPrimary['text_key'], $language), ENT_QUOTES) ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($ctaSecondary['text_key'])) : ?>
                    <a class="btn btn-secondary" href="<?= htmlspecialchars(localized_url($ctaSecondary['url'] ?? '#', $language), ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t($ctaSecondary['text_key'], $language), ENT_QUOTES) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
