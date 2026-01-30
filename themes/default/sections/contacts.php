<?php
?>
<section class="section section-contacts">
    <div class="container">
        <div class="contacts-layout">
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
                        <svg class="telegram-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M21.75 3.5a1.2 1.2 0 0 0-1.27-.2L2.9 9.76a1.2 1.2 0 0 0 .06 2.27l4.7 1.52 1.79 5.71a1.2 1.2 0 0 0 2.16.3l2.63-3.63 4.95 3.61a1.2 1.2 0 0 0 1.9-.68l2.94-13.2a1.2 1.2 0 0 0-.38-1.16Zm-4.56 4.75-7.8 7.08a1.1 1.1 0 0 0-.32.56l-.63 2.71-1.05-3.34a1.2 1.2 0 0 0-.78-.8l-2.78-.9 13.15-4.3-7.79 7.09 8.87-8.1Z"/>
                        </svg>
                        <span class="sr-only"><?= htmlspecialchars(t('contacts.telegram_label', $language), ENT_QUOTES) ?></span>
                    </a>
                </div>
            </div>
            <div class="contacts-map">
                <iframe src="https://yandex.ru/map-widget/v1/?ll=32.044102%2C54.782635&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Ftext%3D%25D1%2583%25D0%25BB.%2520%25D0%25A2%25D0%25B5%25D0%25BD%25D0%25B8%25D1%2588%25D0%25B5%25D0%25B2%25D0%25BE%25D0%25B9%252015%252C%2520%25D0%25A1%25D0%25BC%25D0%25BE%25D0%25BB%25D0%25B5%25D0%25BD%25D1%2581%25D0%25BA%25D0%25B8%25D0%25B9%2520%25D0%25BE%25D0%25B1%25D0%25BB%25D0%25B0%25D1%2581%25D1%2582%25D1%258C&z=16" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="System Power map"></iframe>
            </div>
        </div>
    </div>
</section>
