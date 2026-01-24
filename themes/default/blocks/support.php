<section class="content-block support">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        </div>
        <div class="text-block"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
        <a class="cta-link" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/contacts/">
            <?= htmlspecialchars(t('cta.contacts', $language), ENT_QUOTES) ?> →
        </a>
    </div>
</section>
