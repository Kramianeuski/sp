<?php
$partners = partners_list($language);
$filters = [
    'all' => t('partners.filter_all', $language),
    'official_distributor' => t('partners.filter_official', $language),
    'marketplace' => t('partners.filter_marketplace', $language),
];
?>
<section class="content-block partners-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></p>
        </div>
        <div class="partners-filters" data-partner-filters>
            <?php foreach ($filters as $key => $label) : ?>
                <button class="button secondary" type="button" data-filter="<?= htmlspecialchars($key, ENT_QUOTES) ?>" <?= $key === 'all' ? 'data-active="true"' : '' ?>>
                    <?= htmlspecialchars($label, ENT_QUOTES) ?>
                </button>
            <?php endforeach; ?>
        </div>
        <div class="partners-grid" data-partner-grid>
            <?php foreach ($partners as $partner) : ?>
                <article class="partner-card" data-partner-type="<?= htmlspecialchars($partner['type'], ENT_QUOTES) ?>">
                    <div class="partner-header">
                        <?php if (!empty($partner['logo_large_path'])) : ?>
                            <img src="<?= htmlspecialchars($partner['logo_large_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>">
                        <?php endif; ?>
                        <div>
                            <h3><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></h3>
                            <span class="partner-meta">
                                <?= htmlspecialchars(t('partner.type.' . $partner['type'], $language), ENT_QUOTES) ?>
                                <?php if (!empty($partner['city'])) : ?>
                                    · <?= htmlspecialchars($partner['city'], ENT_QUOTES) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <p><?= nl2br(htmlspecialchars($partner['description'], ENT_QUOTES)) ?></p>
                    <a class="button secondary" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" target="_blank" rel="nofollow sponsored">
                        <?= htmlspecialchars(t('cta.visit', $language), ENT_QUOTES) ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
    const partnerFilters = document.querySelectorAll('[data-partner-filters] button');
    const partnerCards = document.querySelectorAll('[data-partner-grid] [data-partner-type]');
    partnerFilters.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            partnerFilters.forEach((btn) => btn.removeAttribute('data-active'));
            button.setAttribute('data-active', 'true');
            partnerCards.forEach((card) => {
                if (filter === 'all' || card.dataset.partnerType === filter) {
                    card.removeAttribute('hidden');
                } else {
                    card.setAttribute('hidden', 'hidden');
                }
            });
        });
    });
</script>
