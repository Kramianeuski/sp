<?php
$facts = preg_split('/\r?\n|•/', $blockData['body']);
$facts = array_values(array_filter(array_map('trim', $facts)));
?>
<section class="hero">
    <div class="hero-media"></div>
    <div class="container">
        <div class="hero-content">
            <h1><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h1>
            <?php if ($facts) : ?>
                <div class="hero-facts">
                    <?php foreach ($facts as $fact) : ?>
                        <span><?= htmlspecialchars($fact, ENT_QUOTES) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="hero-actions">
                <a class="button" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('cta.catalog', $language), ENT_QUOTES) ?></a>
                <a class="button secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/manufacturing/"><?= htmlspecialchars(t('cta.production', $language), ENT_QUOTES) ?></a>
                <?php if ($language === 'ru') : ?>
                    <a class="button secondary" href="/ru/about/"><?= htmlspecialchars(t('cta.about', $language), ENT_QUOTES) ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
