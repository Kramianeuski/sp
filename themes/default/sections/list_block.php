<?php
$titleKey = $data['title_key'] ?? '';
$items = $data['items'] ?? [];
?>
<section class="section section-list">
    <div class="container">
        <div class="list-block">
            <?php if ($titleKey) : ?>
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
            <?php endif; ?>
            <ul>
                <?php foreach ($items as $item) : ?>
                    <li>
                        <?php if (!empty($item['title_key'])) : ?>
                            <strong><?= htmlspecialchars(t($item['title_key'], $language), ENT_QUOTES) ?></strong>
                        <?php endif; ?>
                        <?php if (!empty($item['text_key'])) : ?>
                            <span><?= htmlspecialchars(t($item['text_key'], $language), ENT_QUOTES) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($item['value_key'])) : ?>
                            <span><?= htmlspecialchars(t($item['value_key'], $language), ENT_QUOTES) ?></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
