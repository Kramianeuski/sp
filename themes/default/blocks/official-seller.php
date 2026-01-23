<?php
$partners = partners_list($language);
?>
<section class="content-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= $language === 'en' ? 'The System Power range is available through verified distributors.' : 'Продукция System Power доступна через проверенных дистрибьюторов.' ?></p>
        </div>
        <div class="partner-list">
            <?php foreach ($partners as $partner) : ?>
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
    </div>
</section>
