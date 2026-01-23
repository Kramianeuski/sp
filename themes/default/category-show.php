<section class="page-header">
    <div class="container">
        <h1><?= htmlspecialchars($category['h1'], ENT_QUOTES) ?></h1>
        <p><?= nl2br(htmlspecialchars($category['description'], ENT_QUOTES)) ?></p>
    </div>
</section>
<section class="products-list">
    <div class="container">
        <div class="product-grid">
            <?php foreach ($products as $product) : ?>
                <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>/">
                    <div class="product-card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></div>
                    <div class="product-card-text"><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="official-seller">
    <div class="container">
        <div class="seller-card">
            <div class="seller-content">
                <h2><?= htmlspecialchars(t('official.seller_title', $language), ENT_QUOTES) ?></h2>
                <p><?= nl2br(htmlspecialchars($category['official_seller'], ENT_QUOTES)) ?></p>
            </div>
            <a class="button" href="<?= htmlspecialchars(t('official.seller_link', $language), ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                <?= htmlspecialchars(t('official.seller_button', $language), ENT_QUOTES) ?>
            </a>
        </div>
    </div>
</section>
<?php
$faqItems = json_decode($category['faq'], true);
if (!is_array($faqItems)) {
    $faqItems = [];
}
?>
<?php if ($faqItems) : ?>
<section class="faq">
    <div class="container">
        <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
        <div class="faq-list">
            <?php foreach ($faqItems as $item) : ?>
                <div class="faq-item">
                    <h3><?= htmlspecialchars($item['question'] ?? '', ENT_QUOTES) ?></h3>
                    <p><?= nl2br(htmlspecialchars($item['answer'] ?? '', ENT_QUOTES)) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
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
    <div class="container">
        <h2><?= htmlspecialchars(t('seo.title', $language), ENT_QUOTES) ?></h2>
        <p><?= nl2br(htmlspecialchars($category['seo_text'], ENT_QUOTES)) ?></p>
    </div>
</section>
<?php endif; ?>
