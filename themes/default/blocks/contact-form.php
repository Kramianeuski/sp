<?php
$titleKey = $data['title_key'] ?? '';
$introKey = $data['intro_key'] ?? '';
$success = !empty($_SESSION['lead_success']);
$errors = $_SESSION['lead_errors'] ?? [];
$old = $_SESSION['lead_old'] ?? [];
$selectedChannels = $old['channels'] ?? [];
if (!is_array($selectedChannels)) {
    $selectedChannels = [];
}
unset($_SESSION['lead_success'], $_SESSION['lead_errors'], $_SESSION['lead_old']);
?>
<form class="form-card contact-form" method="post" action="" novalidate>
    <input type="text" name="website" value="" class="sr-only" tabindex="-1" autocomplete="off">
    <?php if ($titleKey) : ?>
        <h3><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h3>
    <?php endif; ?>
    <?php if ($introKey) : ?>
        <p><?= htmlspecialchars(t($introKey, $language), ENT_QUOTES) ?></p>
    <?php endif; ?>
    <?php if ($success) : ?>
        <div class="form-success"><?= htmlspecialchars(t('form.success', $language), ENT_QUOTES) ?></div>
    <?php endif; ?>
    <?php if (!empty($errors['form'])) : ?>
        <div class="form-error"><?= htmlspecialchars($errors['form'], ENT_QUOTES) ?></div>
    <?php endif; ?>
    <div class="form-field required<?= !empty($errors['email']) ? ' is-invalid' : '' ?>">
        <label><?= htmlspecialchars(t('form.email', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <input type="email" name="email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>" data-error-message="<?= htmlspecialchars(t('form.error.email', $language), ENT_QUOTES) ?>">
        <span class="field-error" data-error-for="email"><?= htmlspecialchars($errors['email'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <div class="form-field required<?= !empty($errors['full_name']) ? ' is-invalid' : '' ?>">
        <label><?= htmlspecialchars(t('form.full_name', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <input type="text" name="full_name" required value="<?= htmlspecialchars($old['full_name'] ?? '', ENT_QUOTES) ?>" data-error-message="<?= htmlspecialchars(t('form.error.full_name', $language), ENT_QUOTES) ?>">
        <span class="field-error" data-error-for="full_name"><?= htmlspecialchars($errors['full_name'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <fieldset class="form-channels">
        <legend><?= htmlspecialchars(t('form.preferred_contact', $language), ENT_QUOTES) ?></legend>
        <?php foreach (['phone', 'telegram', 'whatsapp', 'email'] as $option) : ?>
            <?php $isChecked = in_array($option, $selectedChannels, true); ?>
            <label>
                <input type="checkbox" name="channel_<?= htmlspecialchars($option, ENT_QUOTES) ?>" value="1" <?= $isChecked ? 'checked' : '' ?> data-error-message="<?= htmlspecialchars(t('form.error.contact', $language), ENT_QUOTES) ?>">
                <?= htmlspecialchars(t('form.preferred_' . $option, $language), ENT_QUOTES) ?>
            </label>
        <?php endforeach; ?>
        <span class="field-error" data-error-for="channels"><?= htmlspecialchars($errors['channels'] ?? '', ENT_QUOTES) ?></span>
    </fieldset>
    <?php $phoneActive = in_array('phone', $selectedChannels, true); ?>
    <div class="form-field conditional<?= !empty($errors['phone']) ? ' is-invalid' : '' ?>" data-channel="phone" <?= $phoneActive ? '' : 'hidden' ?>>
        <label><?= htmlspecialchars(t('form.phone', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <input type="tel" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '', ENT_QUOTES) ?>" <?= $phoneActive ? 'required' : '' ?> data-error-message="<?= htmlspecialchars(t('form.error.contact', $language), ENT_QUOTES) ?>">
        <span class="field-error" data-error-for="phone"><?= htmlspecialchars($errors['phone'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <?php $telegramActive = in_array('telegram', $selectedChannels, true); ?>
    <div class="form-field conditional<?= !empty($errors['telegram']) ? ' is-invalid' : '' ?>" data-channel="telegram" <?= $telegramActive ? '' : 'hidden' ?>>
        <label><?= htmlspecialchars(t('form.telegram', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <input type="text" name="telegram" value="<?= htmlspecialchars($old['telegram'] ?? '', ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('form.telegram_placeholder', $language), ENT_QUOTES) ?>" <?= $telegramActive ? 'required' : '' ?> data-error-message="<?= htmlspecialchars(t('form.error.telegram', $language), ENT_QUOTES) ?>">
        <span class="field-hint"><?= htmlspecialchars(t('form.telegram_hint', $language), ENT_QUOTES) ?></span>
        <span class="field-error" data-error-for="telegram"><?= htmlspecialchars($errors['telegram'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <?php $whatsappActive = in_array('whatsapp', $selectedChannels, true); ?>
    <div class="form-field conditional<?= !empty($errors['whatsapp']) ? ' is-invalid' : '' ?>" data-channel="whatsapp" <?= $whatsappActive ? '' : 'hidden' ?>>
        <label><?= htmlspecialchars(t('form.whatsapp', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <input type="tel" name="whatsapp" value="<?= htmlspecialchars($old['whatsapp'] ?? '', ENT_QUOTES) ?>" <?= $whatsappActive ? 'required' : '' ?> data-error-message="<?= htmlspecialchars(t('form.error.contact', $language), ENT_QUOTES) ?>">
        <span class="field-error" data-error-for="whatsapp"><?= htmlspecialchars($errors['whatsapp'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <div class="form-field required<?= !empty($errors['message']) ? ' is-invalid' : '' ?>">
        <label><?= htmlspecialchars(t('form.message', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <textarea name="message" rows="4" required data-error-message="<?= htmlspecialchars(t('form.error.message', $language), ENT_QUOTES) ?>"><?= htmlspecialchars($old['message'] ?? '', ENT_QUOTES) ?></textarea>
        <span class="field-error" data-error-for="message"><?= htmlspecialchars($errors['message'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <div class="form-field required<?= !empty($errors['captcha']) ? ' is-invalid' : '' ?>">
        <label><?= htmlspecialchars(t('form.captcha', $language), ENT_QUOTES) ?><span class="required-indicator">*</span></label>
        <div class="captcha-row">
            <span><?= htmlspecialchars($captchaPrompt ?? '', ENT_QUOTES) ?> =</span>
            <input type="text" name="captcha_answer" required value="" data-error-message="<?= htmlspecialchars(t('form.error.captcha', $language), ENT_QUOTES) ?>">
        </div>
        <span class="field-error" data-error-for="captcha"><?= htmlspecialchars($errors['captcha'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <div class="form-field<?= !empty($errors['consent']) ? ' is-invalid' : '' ?>">
        <label class="checkbox-field">
            <input type="checkbox" name="consent" value="1" required data-error-message="<?= htmlspecialchars(t('form.error.consent', $language), ENT_QUOTES) ?>" <?= !empty($old['consent']) ? 'checked' : '' ?>>
            <?= htmlspecialchars(t('form.consent', $language), ENT_QUOTES) ?>
        </label>
        <span class="field-error" data-error-for="consent"><?= htmlspecialchars($errors['consent'] ?? '', ENT_QUOTES) ?></span>
    </div>
    <button type="submit" class="btn btn-primary">
        <?= htmlspecialchars(t('form.submit', $language), ENT_QUOTES) ?>
    </button>
    <p class="privacy-link">
        <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/privacy-policy/"><?= htmlspecialchars(t('form.privacy_link', $language), ENT_QUOTES) ?></a>
    </p>
</form>
<script>
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        const channelInputs = Array.from(contactForm.querySelectorAll('input[type="checkbox"][name^="channel_"]'));
        const conditionalFields = Array.from(contactForm.querySelectorAll('.conditional'));
        const channelError = contactForm.querySelector('[data-error-for="channels"]');
        const setError = (field, message) => {
            if (!field) {
                return;
            }
            field.textContent = message;
        };
        const toggleField = (channel, isChecked) => {
            const field = conditionalFields.find((item) => item.dataset.channel === channel);
            if (!field) {
                return;
            }
            const input = field.querySelector('input');
            field.hidden = !isChecked;
            if (input) {
                input.required = isChecked;
                if (!isChecked) {
                    input.value = '';
                    input.setCustomValidity('');
                    field.classList.remove('is-invalid');
                    setError(field.querySelector('[data-error-for]'), '');
                }
            }
        };
        const updateChannels = () => {
            channelInputs.forEach((checkbox) => {
                const channel = checkbox.name.replace('channel_', '');
                toggleField(channel, checkbox.checked);
            });
        };
        const validateChannels = () => {
            const anyChecked = channelInputs.some((checkbox) => checkbox.checked);
            if (!anyChecked) {
                channelInputs[0]?.setCustomValidity(channelInputs[0]?.dataset.errorMessage || ' ');
                setError(channelError, channelInputs[0]?.dataset.errorMessage || contactForm.dataset.channelsError || '');
                return false;
            }
            channelInputs.forEach((checkbox) => checkbox.setCustomValidity(''));
            setError(channelError, '');
            return true;
        };
        contactForm.addEventListener('change', (event) => {
            if (event.target instanceof HTMLInputElement && event.target.name.startsWith('channel_')) {
                updateChannels();
                validateChannels();
            }
        });
        contactForm.addEventListener('invalid', (event) => {
            const target = event.target;
            if (!(target instanceof HTMLElement)) {
                return;
            }
            if (target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement || target instanceof HTMLSelectElement) {
                const wrapper = target.closest('.form-field');
                wrapper?.classList.add('is-invalid');
                const errorNode = wrapper?.querySelector('[data-error-for]');
                const message = target.dataset.errorMessage || target.validationMessage;
                if (errorNode) {
                    errorNode.textContent = message;
                }
            }
        }, true);
        contactForm.addEventListener('input', (event) => {
            const target = event.target;
            if (!(target instanceof HTMLElement)) {
                return;
            }
            const wrapper = target.closest('.form-field');
            if (!wrapper) {
                return;
            }
            if (target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement || target instanceof HTMLSelectElement) {
                if (target.checkValidity()) {
                    wrapper.classList.remove('is-invalid');
                    const errorNode = wrapper.querySelector('[data-error-for]');
                    if (errorNode) {
                        errorNode.textContent = '';
                    }
                }
            }
        });
        contactForm.addEventListener('submit', (event) => {
            updateChannels();
            const channelsValid = validateChannels();
            if (!contactForm.checkValidity() || !channelsValid) {
                event.preventDefault();
                contactForm.reportValidity();
            }
        });
        updateChannels();
        validateChannels();
    }
</script>
