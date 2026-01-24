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
        <?php
        $catalogLabel = t('cta.view_models', $language);
        if (!empty($category['slug'])) {
            if ($category['slug'] === 'electrical-enclosures') {
                $catalogLabel = $language === 'ru' ? 'Каталог РУСП' : 'RUSP catalog';
            } elseif ($category['slug'] === 'floor-boxes') {
                $catalogLabel = $language === 'ru' ? 'Каталог лючков' : 'Floor box catalog';
            }
        }
        ?>
        <div class="hero-actions">
            <a class="button" href="#products-list"><?= htmlspecialchars($catalogLabel, ENT_QUOTES) ?></a>
            <a class="button secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/documentation/"><?= htmlspecialchars(t('cta.documents', $language), ENT_QUOTES) ?></a>
            <a class="button secondary" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/where-to-buy/"><?= htmlspecialchars(t('where_to_buy.button', $language), ENT_QUOTES) ?></a>
        </div>
    </div>
</section>
<section class="content-with-sidebar" id="products-list">
    <div class="container content-grid">
        <div class="content-main">
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
                    <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>/">
                        <div class="product-card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></div>
                        <div class="product-card-text"><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></div>
                        <?php if (!empty($product['sku'])) : ?>
                            <div class="product-card-text"><?= htmlspecialchars(t('product.sku', $language), ENT_QUOTES) ?>: <?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></div>
                        <?php endif; ?>
                    </a>
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
        <aside class="content-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.documents_title', $language), ENT_QUOTES) ?></div>
                <p><?= htmlspecialchars(t('sidebar.documents_text', $language), ENT_QUOTES) ?></p>
                <a class="cta-link" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/documentation/">
                    <?= htmlspecialchars(t('sidebar.documents_link', $language), ENT_QUOTES) ?> →
                </a>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.parameters_title', $language), ENT_QUOTES) ?></div>
                <p><?= htmlspecialchars(t('sidebar.parameters_text', $language), ENT_QUOTES) ?></p>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.where_title', $language), ENT_QUOTES) ?></div>
                <p><?= htmlspecialchars(t('sidebar.where_text', $language), ENT_QUOTES) ?></p>
                <a class="cta-link" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/where-to-buy/">
                    <?= htmlspecialchars(t('sidebar.where_link', $language), ENT_QUOTES) ?> →
                </a>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.support_title', $language), ENT_QUOTES) ?></div>
                <p><?= htmlspecialchars(t('sidebar.support_text', $language), ENT_QUOTES) ?></p>
                <a class="cta-link" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/support/">
                    <?= htmlspecialchars(t('sidebar.support_link', $language), ENT_QUOTES) ?> →
                </a>
            </div>
        </aside>
    </div>
</section>
