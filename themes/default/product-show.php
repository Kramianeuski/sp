<?php
$faqItems = $faqs;
$specItems = $specs;
$documentItems = $documents;
?>
<section class="page-header">
    <div class="container">
        <h1><?= htmlspecialchars($product['h1'], ENT_QUOTES) ?></h1>
        <p><?= nl2br(htmlspecialchars($product['short_description'], ENT_QUOTES)) ?></p>
    </div>
</section>
<section class="product-gallery">
    <div class="container">
        <div class="gallery-grid">
            <?php foreach ($images as $image) : ?>
                <figure>
                    <img src="<?= htmlspecialchars($image['file_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($image['alt_text'], ENT_QUOTES) ?>" loading="lazy">
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="product-description">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.description_title', $language), ENT_QUOTES) ?></h2>
        <div class="text-block"><?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES)) ?></div>
    </div>
</section>
<section class="official-seller">
    <div class="container">
        <div class="seller-card">
            <div class="seller-content">
                <h2><?= htmlspecialchars(t('official.seller_title', $language), ENT_QUOTES) ?></h2>
                <p><?= htmlspecialchars(t('official.seller_text', $language), ENT_QUOTES) ?></p>
            </div>
            <a class="button" href="<?= htmlspecialchars(t('official.seller_link', $language), ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                <?= htmlspecialchars(t('official.seller_button', $language), ENT_QUOTES) ?>
            </a>
        </div>
    </div>
</section>
<section class="specs">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.specs_title', $language), ENT_QUOTES) ?></h2>
        <table>
            <tbody>
            <?php foreach ($specItems as $spec) : ?>
                <tr>
                    <th><?= htmlspecialchars($spec['label'], ENT_QUOTES) ?></th>
                    <td><?= htmlspecialchars(trim($spec['value'] . ' ' . $spec['unit']), ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php if ($documentItems) : ?>
<section class="documents">
    <div class="container">
        <h2><?= htmlspecialchars(t('product.documents_title', $language), ENT_QUOTES) ?></h2>
        <ul>
            <?php foreach ($documentItems as $doc) : ?>
                <li><a href="<?= htmlspecialchars($doc['file_path'], ENT_QUOTES) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($doc['title'], ENT_QUOTES) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php endif; ?>
<?php if ($faqItems) : ?>
<section class="faq">
    <div class="container">
        <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
        <?php foreach ($faqItems as $faq) : ?>
            <div class="faq-item">
                <h3><?= htmlspecialchars($faq['question'], ENT_QUOTES) ?></h3>
                <p><?= nl2br(htmlspecialchars($faq['answer'], ENT_QUOTES)) ?></p>
            </div>
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
<section class="related-products">
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
