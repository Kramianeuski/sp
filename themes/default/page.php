<?php
$isHome = ($page['slug'] ?? '') === 'home';
$isWhereToBuy = ($page['slug'] ?? '') === 'where-to-buy';
$isContacts = ($page['slug'] ?? '') === 'contacts';
$isDocumentation = ($page['slug'] ?? '') === 'documentation';
$hasDocumentationBlock = false;
foreach ($blocks as $block) {
    if (($block['block_key'] ?? '') === 'documentation') {
        $hasDocumentationBlock = true;
        break;
    }
}
?>
<?php if (!$isHome) : ?>
    <?php if ($isWhereToBuy || $isContacts) : ?>
        <section class="map-banner">
            <iframe
                src="<?= $isWhereToBuy
                    ? 'https://yandex.ru/map-widget/v1/?ll=34.765130%2C55.202455&z=5&pt=32.055806%2C54.774769,pm2rdm~37.474453%2C55.630141,pm2blm'
                    : 'https://yandex.ru/map-widget/v1/?ll=32.055806%2C54.774769&z=16&pt=32.055806%2C54.774769,pm2rdm' ?>"
                width="100%" height="420" frameborder="0"
                style="border:0"
                allowfullscreen
                loading="lazy"
            ></iframe>
        </section>
    <?php endif; ?>
<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($page['meta_description'] ?? $page['title'] ?? '', ENT_QUOTES) ?></p>
    </div>
</section>
<?php endif; ?>
<?php if (!empty($page['custom_html'])) : ?>
    <section class="page-custom">
        <?= $page['custom_html'] ?>
    </section>
<?php endif; ?>
<?php foreach ($blocks as $block) : ?>
    <?php
    if ($isHome && $block['block_key'] === 'official-seller') {
        continue;
    }
    if (($isDocumentation || $hasDocumentationBlock) && $block['block_key'] === 'partners') {
        continue;
    }
    $blockTemplate = __DIR__ . '/blocks/' . $block['block_key'] . '.php';
    if (file_exists($blockTemplate)) {
        $blockData = $block;
        include $blockTemplate;
    } else {
        $blockData = $block;
        include __DIR__ . '/blocks/generic.php';
    }
    ?>
<?php endforeach; ?>
