<section class="content-block">
    <div class="container">
        <?php if (!empty($blockData['title'])) : ?>
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        <?php endif; ?>
        <?php if (!empty($blockData['body'])) : ?>
            <div class="text-block"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
        <?php endif; ?>
        <?php if (!empty($page['slug']) && $page['slug'] === 'where-to-buy') : ?>
            <div class="partner-list partner-list--spaced">
                <?php foreach (partners_list($language) as $partner) : ?>
                    <div class="partner-card">
                        <div class="partner-info">
                            <strong><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></strong>
                            <span><?= htmlspecialchars($partner['note'], ENT_QUOTES) ?></span>
                            <?php if (!empty($partner['description'])) : ?>
                                <span><?= htmlspecialchars($partner['description'], ENT_QUOTES) ?></span>
                            <?php endif; ?>
                        </div>
                        <a class="button secondary" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                            <?= $language === 'en' ? 'Visit' : 'Перейти' ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
