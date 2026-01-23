<section class="content-block">
    <div class="container">
        <?php if (!empty($blockData['title'])) : ?>
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        <?php endif; ?>
        <?php if (!empty($blockData['body'])) : ?>
            <?php
            $body = $blockData['body'];
            if (!empty($page['slug']) && $page['slug'] === 'where-to-buy') {
                $body = $language === 'en'
                    ? 'System Power products are supplied through official partners and distributors. Choose a partner to request availability and delivery terms.'
                    : 'Продукция System Power поставляется через официальных партнёров и дистрибьюторов. Выберите партнёра, чтобы уточнить наличие и условия поставки.';
            }
            ?>
            <div class="text-block"><?= nl2br(htmlspecialchars($body, ENT_QUOTES)) ?></div>
        <?php endif; ?>
        <?php if (!empty($page['slug']) && $page['slug'] === 'where-to-buy') : ?>
            <div class="partner-list partner-list--spaced">
                <?php foreach (partners_list($language) as $partner) : ?>
                    <div class="partner-card">
                        <div class="partner-info">
                            <strong><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></strong>
                            <span><?= htmlspecialchars($partner['note'], ENT_QUOTES) ?></span>
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
