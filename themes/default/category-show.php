<section class="page-hero">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('products.h1', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($category['h1'], ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($category['h1'], ENT_QUOTES) ?></h1>
        <p><?= nl2br(htmlspecialchars($category['description'], ENT_QUOTES)) ?></p>
    </div>
</section>
<section class="content-block" id="products-list">
    <div class="container">
        <form class="filters" method="get">
            <label>
                <?= htmlspecialchars(t('filters.search_label', $language), ENT_QUOTES) ?>
                <input type="search" name="q" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES) ?>" placeholder="<?= htmlspecialchars(t('filters.search_placeholder', $language), ENT_QUOTES) ?>">
            </label>
            <label>
                <?= htmlspecialchars(t('filters.sort_label', $language), ENT_QUOTES) ?>
                <select name="sort">
                    <option value="name" <?= ($sort ?? '') === 'name' ? 'selected' : '' ?>><?= htmlspecialchars(t('filters.sort_name', $language), ENT_QUOTES) ?></option>
                    <option value="new" <?= ($sort ?? '') === 'new' ? 'selected' : '' ?>><?= htmlspecialchars(t('filters.sort_new', $language), ENT_QUOTES) ?></option>
                </select>
            </label>
            <button class="button secondary" type="submit"><?= htmlspecialchars(t('filters.apply', $language), ENT_QUOTES) ?></button>
        </form>
        <div class="product-grid">
            <?php foreach ($products as $product) : ?>
                <article class="product-card">
                    <div>
                        <div class="product-card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></div>
                        <?php if (!empty($product['sku'])) : ?>
                            <div class="product-card-meta"><?= htmlspecialchars(t('product.sku', $language), ENT_QUOTES) ?>: <?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($productFacts[$product['id']])) : ?>
                            <ul class="product-facts">
                                <?php foreach ($productFacts[$product['id']] as $fact) : ?>
                                    <li><?= htmlspecialchars($fact, ENT_QUOTES) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <a class="button secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>/">
                        <?= htmlspecialchars(t('cta.open', $language), ENT_QUOTES) ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if (empty($products)) : ?>
            <p><?= htmlspecialchars(t('products.empty', $language), ENT_QUOTES) ?></p>
        <?php endif; ?>

        <?php
        $faqItems = json_decode($category['faq'], true);
        if (!is_array($faqItems)) {
            $faqItems = [];
        }
        ?>
        <?php if ($faqItems) : ?>
        <section class="faq">
            <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
            <div class="faq-list">
                <?php foreach ($faqItems as $item) : ?>
                    <details class="faq-item">
                        <summary><?= htmlspecialchars($item['question'] ?? '', ENT_QUOTES) ?></summary>
                        <p><?= nl2br(htmlspecialchars($item['answer'] ?? '', ENT_QUOTES)) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </section>
        <script type="application/ld+json">
        <?= json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static function ($item) {
                return [
                    '@type' => 'Question',
                    'name' => $item['question'] ?? '',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['answer'] ?? '',
                    ],
                ];
            }, $faqItems),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
        </script>
        <?php endif; ?>
        <?php if (!empty($category['seo_text'])) : ?>
        <section class="seo-text">
            <h2><?= htmlspecialchars(t('seo.title', $language), ENT_QUOTES) ?></h2>
            <p><?= nl2br(htmlspecialchars($category['seo_text'], ENT_QUOTES)) ?></p>
        </section>
        <?php endif; ?>
    </div>
</section>
