<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.translations_title', 'ru'), ENT_QUOTES) ?></h1>
</div>
<form class="card filter-card" method="get">
    <div class="field">
        <label for="translation-search"><?= htmlspecialchars(t('admin.translation_search', 'ru'), ENT_QUOTES) ?></label>
        <input id="translation-search" type="search" name="q" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('admin.translation_search_placeholder', 'ru'), ENT_QUOTES) ?>">
    </div>
    <button type="submit" class="btn btn-secondary"><?= htmlspecialchars(t('admin.search', 'ru'), ENT_QUOTES) ?></button>
</form>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.translation_key', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_ru', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.language_en', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($translations as $translation) : ?>
            <tr>
                <td><?= htmlspecialchars($translation['key'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($translation['ru_value'] ?? '', ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($translation['en_value'] ?? '', ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/translations/edit?key=<?= urlencode($translation['key']) ?>">
                        <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
