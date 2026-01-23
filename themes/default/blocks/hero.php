<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h1>
            <p><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></p>
            <div class="hero-actions">
                <a class="button" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('hero.products', $language), ENT_QUOTES) ?></a>
                <a class="button secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/where-to-buy/"><?= htmlspecialchars(t('hero.where', $language), ENT_QUOTES) ?></a>
            </div>
        </div>
    </div>
</section>
