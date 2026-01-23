<?php
?>
<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($page['meta_description'] ?? $page['title'] ?? '', ENT_QUOTES) ?></p>
        <div class="hero-actions">
            <a class="button" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= $language === 'en' ? 'View products' : 'Смотреть продукцию' ?></a>
        </div>
    </div>
</section>
<?php foreach ($blocks as $block) : ?>
    <?php
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
