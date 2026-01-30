<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('nav.products', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($category['name'], ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($category['h1'] ?? $category['name'], ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($category['meta_description'] ?? $category['description'], ENT_QUOTES) ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <form class="filters" method="get">
            <div class="field">
                <label><?= htmlspecialchars(t('filters.search_label', $language), ENT_QUOTES) ?></label>
                <input type="text" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('filters.search_placeholder', $language), ENT_QUOTES) ?>">
            </div>
            <div class="field">
                <label><?= htmlspecialchars(t('filters.sort_label', $language), ENT_QUOTES) ?></label>
                <select name="sort">
                    <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>><?= htmlspecialchars(t('filters.sort_name', $language), ENT_QUOTES) ?></option>
                    <option value="new" <?= $sort === 'new' ? 'selected' : '' ?>><?= htmlspecialchars(t('filters.sort_new', $language), ENT_QUOTES) ?></option>
                </select>
            </div>
            <button class="btn btn-ghost" type="submit"><?= htmlspecialchars(t('filters.apply', $language), ENT_QUOTES) ?></button>
        </form>
        <div class="product-grid">
<?php
$sanitizeSnippet = static function (?string $text): string {
    if ($text === null) {
        return '';
    }
    $patterns = [
        '~sale@a-energ\\.ru~i',
        '~\\+7\\s*495\\s*\\d{3}[- ]?\\d{2}[- ]?\\d{2}~',
        '~Индивидуальные решения.*$~isu',
        '~Контакты для заказа.*$~isu',
    ];
    return trim(preg_replace($patterns, '', $text) ?? '');
};
?>
<?php if (!$products) : ?>
                <p><?= htmlspecialchars(t('products.empty', $language), ENT_QUOTES) ?></p>
            <?php endif; ?>
            <?php foreach ($products as $index => $product) : ?>
                <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>/">
                    <div class="product-card-content">
                        <h3><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></h3>
                        <p><?= htmlspecialchars($sanitizeSnippet($product['short_description'] ?? ''), ENT_QUOTES) ?></p>
                        <?php if (!empty($productFacts[$product['id']])) : ?>
                            <ul>
                                <?php foreach ($productFacts[$product['id']] as $fact) : ?>
                                    <li><?= htmlspecialchars($fact, ENT_QUOTES) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <span><?= htmlspecialchars(t('cta.view', $language), ENT_QUOTES) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
