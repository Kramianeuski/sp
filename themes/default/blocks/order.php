<section class="content-block order-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars(t('order.title', $language), ENT_QUOTES) ?></h2>
            <p><?= htmlspecialchars(t('order.description', $language), ENT_QUOTES) ?></p>
        </div>
        <div class="order-grid">
            <div class="order-card">
                <h3><?= htmlspecialchars(t('order.series_title', $language), ENT_QUOTES) ?></h3>
                <p><?= htmlspecialchars(t('order.series_text', $language), ENT_QUOTES) ?></p>
            </div>
            <div class="order-card">
                <h3><?= htmlspecialchars(t('order.custom_title', $language), ENT_QUOTES) ?></h3>
                <p><?= htmlspecialchars(t('order.custom_text', $language), ENT_QUOTES) ?></p>
            </div>
        </div>
        <div class="order-actions">
            <a class="button secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('order.cta_catalog', $language), ENT_QUOTES) ?></a>
            <a class="button" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/where-to-buy/"><?= htmlspecialchars(t('order.cta_where', $language), ENT_QUOTES) ?></a>
        </div>
    </div>
</section>
