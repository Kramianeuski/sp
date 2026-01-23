<?php include __DIR__ . '/partials/header.php'; ?>
<h1><?= htmlspecialchars(t('admin.translations_title', 'ru'), ENT_QUOTES) ?></h1>
<table>
    <thead>
    <tr>
        <th><?= htmlspecialchars(t('admin.language', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.translation_key', 'ru'), ENT_QUOTES) ?></th>
        <th><?= htmlspecialchars(t('admin.translation_value', 'ru'), ENT_QUOTES) ?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($translations as $translation) : ?>
        <tr>
            <td><?= htmlspecialchars($translation['language'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($translation['key'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($translation['value'], ENT_QUOTES) ?></td>
            <td>
                <a href="/admin/translations/edit?id=<?= htmlspecialchars($translation['id'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php include __DIR__ . '/partials/footer.php'; ?>
