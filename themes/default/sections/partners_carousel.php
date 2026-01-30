<?php
$titleKey = $data['title_key'] ?? '';
$partners = partners_list($language, null, true);
$loopPartners = $partners ? array_merge($partners, $partners) : [];
?>
<?php if (!empty($partners)) : ?>
<section class="section section-partners-carousel">
    <div class="container">
        <?php if ($titleKey) : ?>
            <div class="text-block">
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
            </div>
        <?php endif; ?>
        <div class="partners-carousel" aria-label="<?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?>">
            <div class="partners-carousel-track">
                <?php foreach ($loopPartners as $partner) : ?>
                    <a class="partners-carousel-item" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" target="_blank" rel="nofollow sponsored">
                        <?php if (!empty($partner['logo_path'])) : ?>
                            <img src="<?= htmlspecialchars($partner['logo_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>" loading="lazy">
                        <?php else : ?>
                            <span><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
