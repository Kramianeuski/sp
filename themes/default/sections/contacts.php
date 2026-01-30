<?php
?>
<section class="section section-contacts">
    <div class="container">
        <div class="contacts-grid">
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
                    <span class="sr-only"><?= htmlspecialchars(t('contacts.telegram_label', $language), ENT_QUOTES) ?></span>
                    <a class="telegram-icon" href="https://t.me/<?= htmlspecialchars(ltrim(t('contacts.telegram', $language), '@'), ENT_QUOTES) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= htmlspecialchars(t('contacts.telegram_label', $language), ENT_QUOTES) ?>">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21.6 3.6c.4-.16.82.2.72.62l-3.4 16.12c-.08.38-.5.6-.84.4l-4.64-2.62-2.32 2.24c-.26.26-.72.14-.8-.22l.36-3.98 9.5-8.7c.24-.22.02-.62-.3-.46l-11.68 5.98-4.94-1.56c-.38-.12-.4-.64-.04-.8L21.6 3.6Z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="contacts-map" aria-label="<?= htmlspecialchars(t('contacts.address', $language), ENT_QUOTES) ?>">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?text=ул.%20Тенишевой%2015%2C%20Смоленск%2C%20Россия&z=16"
                    allowfullscreen="true"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="<?= htmlspecialchars(t('contacts.address', $language), ENT_QUOTES) ?>"
                ></iframe>
            </div>
        </div>
    </div>
</section>
