<?php
$titleKey = $data['title_key'] ?? '';
$textKey = $data['text_key'] ?? '';
$imageId = $data['image_id'] ?? null;
$imagePath = $imageId ? media_path((int) $imageId) : null;
?>
<section class="section section-about">
    <div class="container">
        <div class="about-grid">
            <div>
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
                <div class="text-block"><?= t_html($textKey, $language) ?></div>
            </div>
            <div class="about-image">
                <?php if ($imagePath) : ?>
                    <img src="<?= htmlspecialchars($imagePath, ENT_QUOTES) ?>" alt="">
                <?php else : ?>
                    <div class="about-placeholder"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
