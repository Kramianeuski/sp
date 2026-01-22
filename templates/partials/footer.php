<?php
/** @var array $footer */
/** @var array $settings */
/** @var string $lang */
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <p class="footer-title">System Power</p>
            <p><?= htmlspecialchars($footer['text']) ?></p>
        </div>
        <div>
            <p class="footer-title"><?= $lang === 'ru' ? 'Контакты' : 'Contacts' ?></p>
            <p><?= htmlspecialchars($footer['address']) ?></p>
            <p><a href="mailto:<?= htmlspecialchars($footer['email']) ?>"><?= htmlspecialchars($footer['email']) ?></a></p>
            <p><a href="tel:<?= htmlspecialchars($footer['phone']) ?>"><?= htmlspecialchars($footer['phone']) ?></a></p>
        </div>
        <div>
            <p class="footer-title"><?= $lang === 'ru' ? 'Официальный продавец' : 'Official seller' ?></p>
            <p><?= htmlspecialchars($settings['official_seller_name'] ?? 'SISSOL') ?></p>
            <a class="button button-outline" href="<?= htmlspecialchars($settings['official_seller_url'] ?? 'https://sissol.ru') ?>" rel="nofollow sponsored">
                <?= htmlspecialchars(parse_url($settings['official_seller_url'] ?? 'https://sissol.ru', PHP_URL_HOST) ?: 'sissol.ru') ?>
            </a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© <?= date('Y') ?> System Power</span>
        <span><?= $lang === 'ru' ? 'Все права защищены.' : 'All rights reserved.' ?></span>
    </div>
</footer>
</body>
</html>
