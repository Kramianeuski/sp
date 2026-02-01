<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.partner_links_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-primary" href="/admin/product-partner-links/create"><?= htmlspecialchars(t('admin.add', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<div class="card">
    <table>
        <thead>
            <tr>
                <th><?= htmlspecialchars(t('admin.product_sku', 'ru'), ENT_QUOTES) ?></th>
                <th><?= htmlspecialchars(t('admin.product_name', 'ru'), ENT_QUOTES) ?></th>
                <th><?= htmlspecialchars(t('admin.partner_name', 'ru'), ENT_QUOTES) ?></th>
                <th><?= htmlspecialchars(t('admin.partner_url', 'ru'), ENT_QUOTES) ?></th>
                <th><?= htmlspecialchars(t('admin.is_active', 'ru'), ENT_QUOTES) ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($links as $link) : ?>
                <tr>
                    <td><?= htmlspecialchars($link['sku'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($link['product_name'] ?? '', ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($link['partner_name'] ?? '', ENT_QUOTES) ?></td>
                    <td>
                        <a href="<?= htmlspecialchars($link['product_url'] ?? '', ENT_QUOTES) ?>" target="_blank" rel="nofollow sponsored noopener">
                            <?= htmlspecialchars($link['product_url'] ?? '', ENT_QUOTES) ?>
                        </a>
                    </td>
                    <td><?= !empty($link['is_active']) ? '✓' : '—' ?></td>
                    <td>
                        <a href="/admin/product-partner-links/edit?id=<?= htmlspecialchars((string) $link['id'], ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.edit', 'ru'), ENT_QUOTES) ?></a>
                        <form class="inline-form" method="post" action="/admin/product-partner-links/delete" onsubmit="return confirm('Удалить ссылку?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars((string) $link['id'], ENT_QUOTES) ?>">
                            <button type="submit"><?= htmlspecialchars(t('admin.delete', 'ru'), ENT_QUOTES) ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
