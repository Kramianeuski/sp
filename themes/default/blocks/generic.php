<section class="content-block">
    <div class="container">
        <?php if (!empty($blockData['title'])) : ?>
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        <?php endif; ?>
        <?php
        $isWhereToBuy = !empty($page['slug']) && $page['slug'] === 'where-to-buy';
        $isPartnersBlock = $isWhereToBuy && (($blockData['block_key'] ?? '') === 'partners');
        ?>
        <?php if (!empty($blockData['body']) && !$isPartnersBlock) : ?>
            <div class="text-block"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
        <?php endif; ?>
        <?php if ($isWhereToBuy) : ?>
            <?php
            $partnerGroups = [];
            foreach (partners_list($language) as $partner) {
                $group = $partner['group'] ?: ($language === 'en' ? 'Partners' : 'Партнёры');
                $partnerGroups[$group][] = $partner;
            }
            $groupOrder = array_keys($partnerGroups);
            ?>
            <?php foreach ($groupOrder as $groupKey) : ?>
                <?php if (!empty($partnerGroups[$groupKey])) : ?>
                    <h3><?= htmlspecialchars($groupKey, ENT_QUOTES) ?></h3>
                    <div class="partner-list partner-list--spaced">
                        <?php foreach ($partnerGroups[$groupKey] as $partner) : ?>
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
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
