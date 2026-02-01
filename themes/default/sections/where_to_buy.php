<?php
$titleKey = $data['title_key'] ?? '';
$introKey = $data['intro_key'] ?? '';
$distributors = partners_list($language, 'distributor', true);
$marketplaces = partners_list($language, 'marketplace', true);
?>
<section class="section section-where">
    <div class="container">
        <div class="text-block">
            <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
            <p><?= htmlspecialchars(t($introKey, $language), ENT_QUOTES) ?></p>
        </div>
        <div class="partner-group">
            <h3><?= htmlspecialchars(t('wherebuy.distributors', $language), ENT_QUOTES) ?></h3>
            <div class="partner-grid">
                <?php foreach ($distributors as $partner) : ?>
                    <div class="partner-card partner-card--large">
                        <div class="partner-logo-lg">
                            <?php if (!empty($partner['logo_large_path'])) : ?>
                                <img src="<?= htmlspecialchars($partner['logo_large_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>" loading="lazy">
                            <?php else : ?>
                                <span><?= htmlspecialchars(mb_substr($partner['name'], 0, 1), ENT_QUOTES) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="partner-title">
                            <?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>
                            <?php if (!empty($partner['city'])) : ?>
                                <span><?= htmlspecialchars($partner['city'], ENT_QUOTES) ?></span>
                            <?php endif; ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($partner['description'], ENT_QUOTES)) ?></p>
                        <a href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" target="_blank" rel="nofollow sponsored noopener">
                            <?= htmlspecialchars(t('cta.visit', $language), ENT_QUOTES) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="partner-group">
            <h3><?= htmlspecialchars(t('wherebuy.marketplaces', $language), ENT_QUOTES) ?></h3>
            <div class="partner-grid">
                <?php foreach ($marketplaces as $partner) : ?>
                    <div class="partner-card partner-card--large">
                        <div class="partner-logo-lg">
                            <?php if (!empty($partner['logo_large_path'])) : ?>
                                <img src="<?= htmlspecialchars($partner['logo_large_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>" loading="lazy">
                            <?php else : ?>
                                <span><?= htmlspecialchars(mb_substr($partner['name'], 0, 1), ENT_QUOTES) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="partner-title">
                            <?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>
                            <?php if (!empty($partner['city'])) : ?>
                                <span><?= htmlspecialchars($partner['city'], ENT_QUOTES) ?></span>
                            <?php endif; ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($partner['description'], ENT_QUOTES)) ?></p>
                        <a href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" target="_blank" rel="nofollow sponsored noopener">
                            <?= htmlspecialchars(t('cta.visit', $language), ENT_QUOTES) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
