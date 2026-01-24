<?php
$items = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $blockData['body']))));
?>
<section class="content-block advantages">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        </div>
        <?php if ($items) : ?>
            <ul class="list-grid">
                <?php foreach ($items as $item) : ?>
                    <li><?= htmlspecialchars($item, ENT_QUOTES) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <div class="text-block"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
        <?php endif; ?>
    </div>
</section>
