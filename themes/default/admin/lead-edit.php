<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.lead_edit_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/leads"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card form-card">
    <p><strong><?= htmlspecialchars(t('admin.lead_name', 'ru'), ENT_QUOTES) ?>:</strong> <?= htmlspecialchars($lead['full_name'], ENT_QUOTES) ?></p>
    <p><strong><?= htmlspecialchars(t('admin.lead_company', 'ru'), ENT_QUOTES) ?>:</strong> <?= htmlspecialchars($lead['company'] ?? '', ENT_QUOTES) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($lead['email'] ?? '', ENT_QUOTES) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($lead['phone'] ?? '', ENT_QUOTES) ?></p>
    <p><strong>Telegram:</strong> <?= htmlspecialchars($lead['telegram'] ?? '', ENT_QUOTES) ?></p>
    <p><strong>WhatsApp:</strong> <?= htmlspecialchars($lead['whatsapp'] ?? '', ENT_QUOTES) ?></p>
    <p><strong><?= htmlspecialchars(t('admin.lead_message', 'ru'), ENT_QUOTES) ?>:</strong><br><?= nl2br(htmlspecialchars($lead['message'] ?? '', ENT_QUOTES)) ?></p>
    <form method="post">
        <?= csrf_field() ?>
        <div class="field">
            <label><?= htmlspecialchars(t('admin.status', 'ru'), ENT_QUOTES) ?></label>
            <select name="status">
                <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>new</option>
                <option value="in_progress" <?= $lead['status'] === 'in_progress' ? 'selected' : '' ?>>in_progress</option>
                <option value="done" <?= $lead['status'] === 'done' ? 'selected' : '' ?>>done</option>
            </select>
        </div>
        <div class="field">
            <label><?= htmlspecialchars(t('admin.lead_comment', 'ru'), ENT_QUOTES) ?></label>
            <textarea name="admin_comment" rows="4"><?= htmlspecialchars($lead['admin_comment'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
    </form>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
