<section class="content-block contact-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></p>
        </div>
        <div class="contact-grid">
            <div class="contact-card">
                <div class="contact-item">
                    <span><?= htmlspecialchars(t('contacts.email_label', $language), ENT_QUOTES) ?></span>
                    <a href="mailto:<?= htmlspecialchars(t('contacts.email_value', $language), ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('contacts.email_value', $language), ENT_QUOTES) ?>
                    </a>
                </div>
                <div class="contact-item">
                    <span><?= htmlspecialchars(t('contacts.phone_label', $language), ENT_QUOTES) ?></span>
                    <a href="tel:<?= htmlspecialchars(t('contacts.phone_value', $language), ENT_QUOTES) ?>">
                        <?= htmlspecialchars(t('contacts.phone_value', $language), ENT_QUOTES) ?>
                    </a>
                </div>
                <div class="contact-item">
                    <span><?= htmlspecialchars(t('contacts.address_label', $language), ENT_QUOTES) ?></span>
                    <div><?= htmlspecialchars(t('contacts.address_value', $language), ENT_QUOTES) ?></div>
                </div>
            </div>
            <div class="contact-card">
                <div class="contact-item">
                    <span><?= htmlspecialchars(t('contacts.legal_label', $language), ENT_QUOTES) ?></span>
                    <div><?= nl2br(htmlspecialchars(t('contacts.legal_text', $language), ENT_QUOTES)) ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
