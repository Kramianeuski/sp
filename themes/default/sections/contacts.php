<?php
?>
<section class="section section-contacts">
    <div class="container">
        <div class="contacts-card">
            <h2><?= htmlspecialchars(t('contacts.title', $language), ENT_QUOTES) ?></h2>
            <div class="contact-item">
                <span><?= htmlspecialchars(t('contacts.company_label', $language), ENT_QUOTES) ?></span>
                <strong><?= htmlspecialchars(t('contacts.company', $language), ENT_QUOTES) ?></strong>
            </div>
            <div class="contact-item">
                <span><?= htmlspecialchars(t('contacts.email_label', $language), ENT_QUOTES) ?></span>
                <a href="mailto:<?= htmlspecialchars(t('contacts.email', $language), ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('contacts.email', $language), ENT_QUOTES) ?>
                </a>
            </div>
            <div class="contact-item">
                <span><?= htmlspecialchars(t('contacts.phone_label', $language), ENT_QUOTES) ?></span>
                <a href="tel:<?= htmlspecialchars(t('contacts.phone', $language), ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('contacts.phone', $language), ENT_QUOTES) ?>
                </a>
            </div>
            <div class="contact-item">
                <span><?= htmlspecialchars(t('contacts.address_label', $language), ENT_QUOTES) ?></span>
                <p><?= htmlspecialchars(t('contacts.address', $language), ENT_QUOTES) ?></p>
            </div>
            <div class="contact-item">
                <span><?= htmlspecialchars(t('contacts.telegram_label', $language), ENT_QUOTES) ?></span>
                <a href="https://t.me/<?= htmlspecialchars(ltrim(t('contacts.telegram', $language), '@'), ENT_QUOTES) ?>" target="_blank" rel="noopener noreferrer">
                    <?= htmlspecialchars(t('contacts.telegram', $language), ENT_QUOTES) ?>
                </a>
            </div>
        </div>
    </div>
</section>
