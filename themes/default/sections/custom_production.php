<?php
$titleKey = $data['title_key'] ?? '';
$introKey = $data['intro_key'] ?? '';
$processTitleKey = $data['process_title_key'] ?? '';
$steps = $data['steps'] ?? [];
$success = !empty($_SESSION['lead_success']);
$errors = $_SESSION['lead_errors'] ?? [];
$old = $_SESSION['lead_old'] ?? [];
unset($_SESSION['lead_success'], $_SESSION['lead_errors'], $_SESSION['lead_old']);
?>
<section class="section section-custom-production">
    <div class="container">
        <div class="custom-production">
            <div>
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
            </div>
            <form class="form-card" method="post" action="">
                <input type="text" name="website" value="" class="sr-only" tabindex="-1" autocomplete="off">
                <?php if ($success) : ?>
                    <div class="form-success"><?= htmlspecialchars(t('form.success', $language), ENT_QUOTES) ?></div>
                <?php endif; ?>
                <?php if (!empty($errors['form'])) : ?>
                    <div class="form-error"><?= htmlspecialchars($errors['form'], ENT_QUOTES) ?></div>
                <?php endif; ?>
                <div class="field">
                    <label><?= htmlspecialchars(t('form.full_name', $language), ENT_QUOTES) ?></label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($old['full_name'] ?? '', ENT_QUOTES) ?>">
                    <?php if (!empty($errors['full_name'])) : ?>
                        <span class="field-error"><?= htmlspecialchars($errors['full_name'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label><?= htmlspecialchars(t('form.preferred_contact', $language), ENT_QUOTES) ?></label>
                    <div class="radio-group">
                        <?php foreach (['phone', 'telegram', 'whatsapp', 'email'] as $option) : ?>
                            <label>
                                <input type="radio" name="preferred_contact" value="<?= htmlspecialchars($option, ENT_QUOTES) ?>" <?= ($old['preferred_contact'] ?? '') === $option ? 'checked' : '' ?>>
                                <?= htmlspecialchars(t('form.preferred_' . $option, $language), ENT_QUOTES) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if (!empty($errors['preferred_contact'])) : ?>
                        <span class="field-error"><?= htmlspecialchars($errors['preferred_contact'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                </div>
                <div class="field contact-field" data-contact="phone" hidden>
                    <label><?= htmlspecialchars(t('form.phone', $language), ENT_QUOTES) ?></label>
                    <input type="tel" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '', ENT_QUOTES) ?>">
                </div>
                <div class="field contact-field" data-contact="telegram" hidden>
                    <label><?= htmlspecialchars(t('form.telegram', $language), ENT_QUOTES) ?></label>
                    <input type="text" name="telegram" value="<?= htmlspecialchars($old['telegram'] ?? '', ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('form.telegram_placeholder', $language), ENT_QUOTES) ?>">
                    <span class="field-hint"><?= htmlspecialchars(t('form.telegram_hint', $language), ENT_QUOTES) ?></span>
                </div>
                <div class="field contact-field" data-contact="whatsapp" hidden>
                    <label><?= htmlspecialchars(t('form.whatsapp', $language), ENT_QUOTES) ?></label>
                    <input type="tel" name="whatsapp" value="<?= htmlspecialchars($old['whatsapp'] ?? '', ENT_QUOTES) ?>">
                </div>
                <div class="field contact-field" data-contact="email" hidden>
                    <label><?= htmlspecialchars(t('form.email', $language), ENT_QUOTES) ?></label>
                    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>">
                </div>
                <?php if (!empty($errors['contact'])) : ?>
                    <span class="field-error"><?= htmlspecialchars($errors['contact'], ENT_QUOTES) ?></span>
                <?php endif; ?>
                <div class="field">
                    <label><?= htmlspecialchars(t('form.message', $language), ENT_QUOTES) ?></label>
                    <textarea name="message" rows="4"><?= htmlspecialchars($old['message'] ?? '', ENT_QUOTES) ?></textarea>
                    <?php if (!empty($errors['message'])) : ?>
                        <span class="field-error"><?= htmlspecialchars($errors['message'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label><?= htmlspecialchars(t('form.captcha', $language), ENT_QUOTES) ?></label>
                    <div class="captcha-row">
                        <span><?= htmlspecialchars($captchaPrompt ?? '', ENT_QUOTES) ?> =</span>
                        <input type="text" name="captcha_answer" value="">
                    </div>
                    <?php if (!empty($errors['captcha'])) : ?>
                        <span class="field-error"><?= htmlspecialchars($errors['captcha'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                </div>
                <label class="checkbox-field">
                    <input type="checkbox" name="consent" value="1" <?= !empty($old['consent']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars(t('form.consent', $language), ENT_QUOTES) ?>
                    <?php if (!empty($errors['consent'])) : ?>
                        <span class="field-error"><?= htmlspecialchars($errors['consent'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                </label>
                <button type="submit" class="btn btn-primary">
                    <?= htmlspecialchars(t('form.submit', $language), ENT_QUOTES) ?>
                </button>
            </form>
        </div>
    </div>
</section>
<script>
    const contactRadios = document.querySelectorAll('input[name="preferred_contact"]');
    const contactFields = document.querySelectorAll('.contact-field');
    const updateContactFields = () => {
        const selected = document.querySelector('input[name="preferred_contact"]:checked')?.value;
        contactFields.forEach((field) => {
            const isActive = field.dataset.contact === selected;
            field.hidden = !isActive;
        });
    };
    contactRadios.forEach((radio) => radio.addEventListener('change', updateContactFields));
    updateContactFields();
</script>
