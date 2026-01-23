<section class="content-block">
    <div class="container">
        <?php if (!empty($blockData['title'])) : ?>
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        <?php endif; ?>
        <?php if (!empty($blockData['body'])) : ?>
            <div class="text-block"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
        <?php endif; ?>
    </div>
</section>
