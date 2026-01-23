<?php
$faqItems = $faqs;
$specItems = $specs;
$documentItems = $documents;
$specGroups = [];
foreach ($specItems as $spec) {
    $group = $spec['type'] ?: ($language === 'en' ? 'Specifications' : 'Характеристики');
    $specGroups[$group][] = $spec;
}
$highlightSpecs = array_slice($specItems, 0, 4);
$partners = partners_list($language);
?>
<section class="product-hero">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('products.h1', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($product['h1'], ENT_QUOTES) ?></span>
        </nav>
        <div class="product-hero-grid">
            <div class="gallery-grid">
                <?php foreach ($images as $image) : ?>
                    <figure>
                        <img src="<?= htmlspecialchars($image['file_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($image['alt_text'], ENT_QUOTES) ?>" loading="lazy">
                    </figure>
                <?php endforeach; ?>
            </div>
            <div class="product-summary">
                <h1><?= htmlspecialchars($product['h1'], ENT_QUOTES) ?></h1>
                <div class="product-meta">
                    <?php if (!empty($product['sku'])) : ?>
                        <span><?= htmlspecialchars($language === 'en' ? 'SKU' : 'Артикул', ENT_QUOTES) ?>: <?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></span>
                    <?php endif; ?>
                </div>
                <p><?= nl2br(htmlspecialchars($product['short_description'], ENT_QUOTES)) ?></p>
                <?php if ($highlightSpecs) : ?>
                    <div class="spec-highlight">
                        <?php foreach ($highlightSpecs as $spec) : ?>
                            <div class="spec-highlight-item">
                                <span><?= htmlspecialchars($spec['label'], ENT_QUOTES) ?></span>
                                <strong><?= htmlspecialchars(trim($spec['value'] . ' ' . $spec['unit']), ENT_QUOTES) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="cta-panel">
                    <a class="button" href="#partners"><?= $language === 'en' ? 'Buy from partners' : 'Купить у партнёров' ?></a>
                    <a class="button secondary" href="#specs"><?= $language === 'en' ? 'View specifications' : 'Характеристики' ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content-block">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.description_title', $language), ENT_QUOTES) ?></h2>
        <div class="text-block"><?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES)) ?></div>
    </div>
</section>
<section class="content-block" id="partners">
    <div class="container">
        <div class="section-header">
            <h2><?= $language === 'en' ? 'Where to buy' : 'Где купить' ?></h2>
            <p><?= $language === 'en' ? 'Choose a distributor to request availability and pricing.' : 'Выберите дистрибьютора, чтобы уточнить наличие и цены.' ?></p>
        </div>
        <div class="partner-list">
            <?php foreach ($partners as $partner) : ?>
                <div class="partner-card">
                    <div class="partner-info">
                        <strong><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></strong>
                        <span><?= htmlspecialchars($partner['note'], ENT_QUOTES) ?></span>
                    </div>
                    <a class="button secondary" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                        <?= $language === 'en' ? 'Visit' : 'Перейти' ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="specs content-block" id="specs">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.specs_title', $language), ENT_QUOTES) ?></h2>
        <?php foreach ($specGroups as $groupName => $groupSpecs) : ?>
            <div class="spec-group">
                <h3><?= htmlspecialchars($groupName, ENT_QUOTES) ?></h3>
                <table class="specs-table">
                    <tbody>
                    <?php foreach ($groupSpecs as $spec) : ?>
                        <tr>
                            <th><?= htmlspecialchars($spec['label'], ENT_QUOTES) ?></th>
                            <td><?= htmlspecialchars(trim($spec['value'] . ' ' . $spec['unit']), ENT_QUOTES) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php if ($documentItems) : ?>
<section class="documents content-block">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.documents_title', $language), ENT_QUOTES) ?></h2>
        <div class="documents-list">
            <?php foreach ($documentItems as $doc) : ?>
                <a href="<?= htmlspecialchars($doc['file_path'], ENT_QUOTES) ?>" target="_blank" rel="noopener">
                    <?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php if ($faqItems) : ?>
<section class="faq content-block">
    <div class="container">
        <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
        <?php foreach ($faqItems as $faq) : ?>
            <details class="faq-item">
                <summary><?= htmlspecialchars($faq['question'], ENT_QUOTES) ?></summary>
                <p><?= nl2br(htmlspecialchars($faq['answer'], ENT_QUOTES)) ?></p>
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
<?php if ($related) : ?>
<section class="related-products content-block">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.related_title', $language), ENT_QUOTES) ?></h2>
        <div class="product-grid">
            <?php foreach ($related as $item) : ?>
                <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($item['slug'], ENT_QUOTES) ?>/">
                    <div class="product-card-title"><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<div class="cta-sticky">
    <a class="button" href="#partners"><?= $language === 'en' ? 'Buy from partners' : 'Купить у партнёров' ?></a>
</div>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product['name'],
    'brand' => [
        '@type' => 'Brand',
        'name' => 'System Power',
    ],
    'manufacturer' => [
        '@type' => 'Organization',
        'name' => 'System Power',
    ],
    'description' => $product['short_description'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
