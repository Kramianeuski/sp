<?php
$isHome = ($page['slug'] ?? '') === 'home';
?>
<?php if (!$isHome) : ?>
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
