<?php
$items = $data['items'] ?? [];
?>
<section class="section section-features">
    <div class="container">
        <div class="features-grid">
            <?php foreach ($items as $item) : ?>
                <div class="feature-card">
                    <div class="feature-icon">
                        <span><?= htmlspecialchars($item['icon'] ?? '', ENT_QUOTES) ?></span>
                    </div>
                    <h3><?= htmlspecialchars(t($item['title_key'] ?? '', $language), ENT_QUOTES) ?></h3>
                    <p><?= htmlspecialchars(t($item['text_key'] ?? '', $language), ENT_QUOTES) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
