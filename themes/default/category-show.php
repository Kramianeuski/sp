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
        <div class="category-description">
            <?php if (!empty($category['description'])) : ?>
                <?php if (!empty($category['is_html'])) : ?>
                    <div class="text-block"><?= $category['description'] ?></div>
                <?php else : ?>
                    <p><?= nl2br(htmlspecialchars($category['description'], ENT_QUOTES)) ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php $faqItems = category_faq($category['code'] ?? '', $language); ?>
        <?php if ($faqItems) : ?>
            <div class="faq-block">
                <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
                <div class="faq">
                    <?php foreach ($faqItems as $item) : ?>
                        <details class="faq-item">
                            <summary><?= htmlspecialchars($item['question'], ENT_QUOTES) ?></summary>
                            <div class="faq-content"><?= htmlspecialchars($item['answer'], ENT_QUOTES) ?></div>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="catalog-layout">
            <aside class="catalog-filters filters--sticky">
                <button class="filters-close" type="button" data-filters-close><?= htmlspecialchars(t('filters.close', $language), ENT_QUOTES) ?></button>
                <form id="catalog-filters" class="filters" method="get">
                    <div class="field">
                        <label><?= htmlspecialchars(t('filters.search_label', $language), ENT_QUOTES) ?></label>
                        <input type="text" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('filters.search_placeholder', $language), ENT_QUOTES) ?>">
                    </div>
                    <?php foreach ($availableFilters as $specKey => $filter) : ?>
                        <div class="field">
                            <span class="filters-title"><?= htmlspecialchars($filter['name'], ENT_QUOTES) ?></span>
                            <div class="filter-options">
                                <?php foreach ($filter['values'] as $value) : ?>
                                    <?php
                                    $checked = in_array($value, $activeFilters[$specKey] ?? [], true);
                                    ?>
                                    <label>
                                        <input type="checkbox" name="filters[<?= htmlspecialchars($specKey, ENT_QUOTES) ?>][]" value="<?= htmlspecialchars($value, ENT_QUOTES) ?>" <?= $checked ? 'checked' : '' ?>>
                                        <?= htmlspecialchars($value, ENT_QUOTES) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <button class="btn btn-ghost" type="submit"><?= htmlspecialchars(t('filters.apply', $language), ENT_QUOTES) ?></button>
                </form>
            </aside>
            <section class="catalog-results">
                <div class="catalog-toolbar">
                    <button class="filters-toggle" type="button" data-filters-toggle><?= htmlspecialchars(t('filters.toggle', $language), ENT_QUOTES) ?></button>
                    <div class="field">
                        <label><?= htmlspecialchars(t('filters.sort_label', $language), ENT_QUOTES) ?></label>
                        <select name="sort" form="catalog-filters">
                            <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>><?= htmlspecialchars(t('filters.sort_name', $language), ENT_QUOTES) ?></option>
                            <option value="new" <?= $sort === 'new' ? 'selected' : '' ?>><?= htmlspecialchars(t('filters.sort_new', $language), ENT_QUOTES) ?></option>
                        </select>
                    </div>
                </div>
                <div class="product-grid">
                    <?php if (!$products) : ?>
                        <p><?= htmlspecialchars(t('products.empty', $language), ENT_QUOTES) ?></p>
                    <?php endif; ?>
                    <?php foreach ($products as $index => $product) : ?>
                        <?php $displayName = format_product_name($product['name'], $product['sku'] ?? null); ?>
                        <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>/">
                            <div class="product-card-media">
                                <?php if (!empty($productImages[$product['id']]['path'])) : ?>
                                    <img src="<?= htmlspecialchars($productImages[$product['id']]['path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($displayName, ENT_QUOTES) ?>" loading="lazy">
                                <?php else : ?>
                                    <img src="/themes/default/placeholder-product.svg" alt="<?= htmlspecialchars($displayName, ENT_QUOTES) ?>" loading="lazy">
                                <?php endif; ?>
                            </div>
                            <div class="product-card-content">
                                <h3><?= htmlspecialchars($displayName, ENT_QUOTES) ?></h3>
                                <p><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></p>
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
            </section>
        </div>
        <div class="filters-overlay" data-filters-overlay></div>
    </div>
</section>
<?php if (!empty($faqItems)) : ?>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn(array $item) => [
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $item['answer'],
        ],
    ], $faqItems),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php endif; ?>
