<section class="section section-404">
    <div class="container">
        <h1><?= htmlspecialchars(t('error.not_found', $language), ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars(t('error.not_found_text', $language), ENT_QUOTES) ?></p>
        <a class="btn btn-secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/">
            <?= htmlspecialchars(t('cta.home', $language), ENT_QUOTES) ?>
        </a>
    </div>
</section>
