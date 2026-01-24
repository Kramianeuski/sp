<?php
$items = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $blockData['body']))));
?>
<section class="content-block manufacturing">
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
        <?php endif; ?>
    </div>
</section>
