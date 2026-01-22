<?php
ob_start();
?>
<section class="hero hero-small">
    <div class="container">
        <h1><?= e($product['h1'] ?? '') ?></h1>
        <?php if (!empty($product['short_description'])) : ?>
            <p class="lead"><?= nl2br(e($product['short_description'])) ?></p>
        <?php endif; ?>
    </div>
</section>
<div class="container">
    <section class="section">
        <div class="gallery">
            <?php foreach ($images as $image) : ?>
                <div class="gallery-item" style="background-image: url('<?= e($image) ?>');"></div>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($product['description'])) : ?>
            <div class="product-description">
                <p><?= nl2br(e($product['description'])) ?></p>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($partner) : ?>
        <section class="section partner">
            <div class="partner-card">
                <div>
                    <h2><?= e($settings['partner_title'] ?? '') ?></h2>
                    <p><?= nl2br(e($partner['description'] ?? '')) ?></p>
                </div>
                <a class="button" href="<?= e($partner['url']) ?>" rel="<?= e($partner['rel_attr']) ?>"><?= e($settings['partner_cta'] ?? '') ?></a>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($specs)) : ?>
        <section class="section">
            <h2><?= e($settings['specs_title'] ?? '') ?></h2>
            <table class="specs">
                <?php foreach ($specs as $spec) : ?>
                    <tr>
                        <th><?= e($spec['label']) ?></th>
                        <td><?= e(trim($spec['value'] . ' ' . ($spec['unit'] ?? ''))) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    <?php endif; ?>

    <?php if (!empty($docs)) : ?>
        <section class="section">
            <h2><?= e($settings['docs_title'] ?? '') ?></h2>
            <ul class="docs">
                <?php foreach ($docs as $doc) : ?>
                    <li><a href="<?= e($doc['url']) ?>"><?= e($doc['title']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($faqs)) : ?>
        <section class="section">
            <h2><?= e($settings['faq_title'] ?? '') ?></h2>
            <div class="faq">
                <?php foreach ($faqs as $faq) : ?>
                    <details>
                        <summary><?= e($faq['question']) ?></summary>
                        <p><?= nl2br(e($faq['answer'])) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$faqData = [];
foreach ($faqs as $faq) {
    $faqData[] = [
        '@type' => 'Question',
        'name' => $faq['question'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq['answer'],
        ],
    ];
}
$productData = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product['title'],
    'description' => $product['short_description'] ?? '',
    'sku' => $product['sku'] ?? '',
    'brand' => $settings['brand_name'] ?? '',
    'manufacturer' => $settings['brand_name'] ?? '',
];
$breadcrumbsItems = [];
if (!empty($category)) {
    $breadcrumbsItems[] = [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => $category['title'] ?? '',
        'item' => "/{$lang}/products/{$category['slug']}/",
    ];
}
$breadcrumbsItems[] = [
    '@type' => 'ListItem',
    'position' => count($breadcrumbsItems) + 1,
    'name' => $product['title'] ?? '',
    'item' => "/{$lang}/product/{$product['slug']}/",
];
$breadcrumbs = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $breadcrumbsItems,
];
$content .= jsonLd($productData);
if (!empty($faqData)) {
    $content .= jsonLd([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqData,
    ]);
}
$content .= jsonLd($breadcrumbs);
include __DIR__ . '/layout.php';
