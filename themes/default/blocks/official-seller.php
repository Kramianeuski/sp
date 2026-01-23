<?php
$sellerStmt = db()->prepare('SELECT `value` FROM site_settings WHERE language = ? AND `key` = ?');
$sellerStmt->execute([$language, 'official_seller_text']);
$sellerText = $sellerStmt->fetchColumn();
?>
<section class="official-seller">
    <div class="container">
        <div class="seller-card">
            <div class="seller-content">
                <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
                <p><?= nl2br(htmlspecialchars($sellerText ?: $blockData['body'], ENT_QUOTES)) ?></p>
            </div>
            <a class="button" href="<?= htmlspecialchars(t('official.seller_link', $language), ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                <?= htmlspecialchars(t('official.seller_button', $language), ENT_QUOTES) ?>
            </a>
        </div>
    </div>
</section>
