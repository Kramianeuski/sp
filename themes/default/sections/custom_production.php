<?php
$titleKey = $data['title_key'] ?? '';
$introKey = $data['intro_key'] ?? '';
$processTitleKey = $data['process_title_key'] ?? '';
$steps = $data['steps'] ?? [];
?>
<section class="section section-custom-production">
    <div class="container">
        <div class="custom-production layout-two-columns">
            <article class="content">
                <?php if ($titleKey) : ?>
                    <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
                <?php endif; ?>
                <?php if ($introKey) : ?>
                    <p><?= htmlspecialchars(t($introKey, $language), ENT_QUOTES) ?></p>
                <?php endif; ?>
                <?php if ($processTitleKey && $steps) : ?>
                    <div class="custom-process">
                        <h3><?= htmlspecialchars(t($processTitleKey, $language), ENT_QUOTES) ?></h3>
                        <ol>
                            <?php foreach ($steps as $stepKey) : ?>
                                <li><?= htmlspecialchars(t($stepKey, $language), ENT_QUOTES) ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                <?php endif; ?>
            </article>
            <aside class="aside aside--sticky">
                <?php include __DIR__ . '/../blocks/contact-form.php'; ?>
            </aside>
        </div>
    </div>
</section>
