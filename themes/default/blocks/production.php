<section class="content-block production">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        </div>
        <div class="text-block"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
        <a class="cta-link" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/manufacturing/">
            <?= htmlspecialchars(t('cta.production', $language), ENT_QUOTES) ?> →
        </a>
    </div>
</section>
