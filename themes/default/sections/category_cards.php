<?php
$items = $data['items'] ?? [];
?>
<section class="section section-categories">
    <div class="container">
        <div class="category-grid">
            <?php foreach ($items as $item) : ?>
                <a class="category-card" href="<?= htmlspecialchars(localized_url($item['url'] ?? '#', $language), ENT_QUOTES) ?>">
                    <div class="category-card-bg"></div>
                    <div class="category-card-content">
                        <h3><?= htmlspecialchars(t($item['title_key'] ?? '', $language), ENT_QUOTES) ?></h3>
                        <p><?= htmlspecialchars(t($item['text_key'] ?? '', $language), ENT_QUOTES) ?></p>
                        <span class="category-card-cta"><?= htmlspecialchars(t('cta.view', $language), ENT_QUOTES) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
