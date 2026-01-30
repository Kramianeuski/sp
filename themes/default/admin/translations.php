<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.translations_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/translations/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form class="card form-card" method="get">
    <div class="field">
        <label><?= htmlspecialchars(t('admin.translation_search', 'ru'), ENT_QUOTES) ?></label>
        <input type="text" name="q" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('admin.translation_search_placeholder', 'ru'), ENT_QUOTES) ?>">
    </div>
    <button class="btn btn-secondary" type="submit"><?= htmlspecialchars(t('admin.search', 'ru'), ENT_QUOTES) ?></button>
</form>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.translation_key', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($translations as $translation) : ?>
            <tr>
                <td><?= htmlspecialchars($translation['key'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($translation['locale'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars(mb_strimwidth($translation['value'], 0, 120, '...'), ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/translations/edit?id=<?= htmlspecialchars($translation['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                    ·
                    <form class="inline-form" method="post" action="/admin/translations/delete" onsubmit="return confirm('Удалить перевод?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($translation['id'], ENT_QUOTES) ?>">
                        <button class="btn-link" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
