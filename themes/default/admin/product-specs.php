<?php include __DIR__ . '/partials/header.php'; ?>
<div class="page-header">
    <h1><?= htmlspecialchars(t('admin.specs_title', 'ru'), ENT_QUOTES) ?></h1>
    <div class="page-header-actions">
        <a class="btn btn-secondary" href="/admin/products/edit?id=<?= htmlspecialchars($productId, ENT_QUOTES) ?>"><?= htmlspecialchars(t('admin.back', 'ru'), ENT_QUOTES) ?></a>
    </div>
</div>
<form method="post" class="card form-card">
    <?= csrf_field() ?>
    <div class="repeatable-table">
        <?php foreach ($specs as $index => $spec) : ?>
            <div class="repeatable-row">
                <input type="text" name="specs[<?= $index ?>][spec_key]" placeholder="key" value="<?= htmlspecialchars($spec['spec_key'], ENT_QUOTES) ?>">
                <input type="text" name="specs[<?= $index ?>][name_ru]" placeholder="RU name" value="<?= htmlspecialchars($spec['name_ru'] ?? '', ENT_QUOTES) ?>">
                <input type="text" name="specs[<?= $index ?>][value_ru]" placeholder="RU value" value="<?= htmlspecialchars($spec['value_ru'] ?? '', ENT_QUOTES) ?>">
                <input type="text" name="specs[<?= $index ?>][name_en]" placeholder="EN name" value="<?= htmlspecialchars($spec['name_en'] ?? '', ENT_QUOTES) ?>">
                <input type="text" name="specs[<?= $index ?>][value_en]" placeholder="EN value" value="<?= htmlspecialchars($spec['value_en'] ?? '', ENT_QUOTES) ?>">
            </div>
        <?php endforeach; ?>
        <?php for ($i = count($specs); $i < count($specs) + 3; $i++) : ?>
            <div class="repeatable-row">
                <input type="text" name="specs[<?= $i ?>][spec_key]" placeholder="key">
                <input type="text" name="specs[<?= $i ?>][name_ru]" placeholder="RU name">
                <input type="text" name="specs[<?= $i ?>][value_ru]" placeholder="RU value">
                <input type="text" name="specs[<?= $i ?>][name_en]" placeholder="EN name">
                <input type="text" name="specs[<?= $i ?>][value_en]" placeholder="EN value">
            </div>
        <?php endfor; ?>
    </div>
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('admin.save', 'ru'), ENT_QUOTES) ?></button>
</form>
<?php include __DIR__ . '/partials/footer.php'; ?>
