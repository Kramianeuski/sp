<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.sections_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/pages"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
        <a class="btn btn-primary" href="/admin/blocks/create?page_id=<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card table-card">
    <table class="table">
        <thead>
        <tr>
            <th><?= htmlspecialchars(t('admin.section_key', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.template', 'ru'), ENT_QUOTES) ?></th>
            <th><?= htmlspecialchars(t('admin.sort_order', 'ru'), ENT_QUOTES) ?></th>
            <th class="table-actions"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sections as $section) : ?>
            <tr>
                <td><?= htmlspecialchars($section['section_key'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars($section['template'], ENT_QUOTES) ?></td>
                <td><?= htmlspecialchars((string) $section['sort_order'], ENT_QUOTES) ?></td>
                <td class="table-actions">
                    <a href="/admin/blocks/edit?id=<?= htmlspecialchars($section['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                    ·
                    <form class="inline-form" method="post" action="/admin/blocks/delete" onsubmit="return confirm('Удалить секцию?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($section['id'], ENT_QUOTES) ?>">
                        <input type="hidden" name="page_id" value="<?= htmlspecialchars($page['id'], ENT_QUOTES) ?>">
                        <button class="btn-link" type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
