<?php
$isoItems = [
    [
        'code' => t('iso.9001.code', $language),
        'title' => t('iso.9001.title', $language),
        'text' => t('iso.9001.text', $language),
    ],
    [
        'code' => t('iso.14001.code', $language),
        'title' => t('iso.14001.title', $language),
        'text' => t('iso.14001.text', $language),
    ],
    [
        'code' => t('iso.45001.code', $language),
        'title' => t('iso.45001.title', $language),
        'text' => t('iso.45001.text', $language),
    ],
];
?>
<section class="content-block production">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= htmlspecialchars($blockData['body'], ENT_QUOTES) ?></p>
        </div>
        <div class="iso-grid">
            <?php foreach ($isoItems as $item) : ?>
                <div class="iso-card">
                    <div class="iso-code"><?= htmlspecialchars($item['code'], ENT_QUOTES) ?></div>
                    <h3><?= htmlspecialchars($item['title'], ENT_QUOTES) ?></h3>
                    <p><?= htmlspecialchars($item['text'], ENT_QUOTES) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="cta-link" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/manufacturing/">
            <?= htmlspecialchars(t('cta.production', $language), ENT_QUOTES) ?> →
        </a>
    </div>
</section>
