<?php
?>
<section class="page-header">
    <div class="container">
        <h1><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></h1>
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
