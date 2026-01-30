<?php
$titleKey = $data['title_key'] ?? '';
$textKey = $data['text_key'] ?? '';
$align = $data['align'] ?? 'left';
?>
<section class="section section-text">
    <div class="container">
        <div class="text-block text-<?= htmlspecialchars($align, ENT_QUOTES) ?>">
            <?php if ($titleKey) : ?>
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
            <?php endif; ?>
            <?php if ($textKey) : ?>
                <div class="text-block-body"><?= t_html($textKey, $language) ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
