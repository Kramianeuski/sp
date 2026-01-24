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
$sidebarSpecs = array_slice($specItems, 0, 6);
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
                        <span><?= htmlspecialchars(t('product.sku', $language), ENT_QUOTES) ?>: <?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></span>
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
                    <a class="button" href="#partners"><?= htmlspecialchars(t('cta.buy_partners', $language), ENT_QUOTES) ?></a>
                    <a class="button secondary" href="#specs"><?= htmlspecialchars(t('cta.view_specs', $language), ENT_QUOTES) ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content-with-sidebar">
    <div class="container content-grid">
        <div class="content-main">
            <section class="content-block">
                <h2><?= htmlspecialchars(t('product.description_title', $language), ENT_QUOTES) ?></h2>
                <div class="text-block"><?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES)) ?></div>
            </section>
            <section class="content-block" id="partners">
                <div class="section-header">
                    <h2><?= htmlspecialchars(t('sidebar.where_title', $language), ENT_QUOTES) ?></h2>
                    <p><?= htmlspecialchars(t('sidebar.where_text', $language), ENT_QUOTES) ?></p>
                </div>
                <div class="partner-list">
                    <?php foreach ($partners as $partner) : ?>
                        <div class="partner-card">
                            <div class="partner-info">
                                <strong><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></strong>
                                <span><?= htmlspecialchars($partner['note'], ENT_QUOTES) ?></span>
                            </div>
                            <a class="button secondary" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                                <?= htmlspecialchars(t('cta.visit', $language), ENT_QUOTES) ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="specs content-block" id="specs">
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
            </section>
            <?php if ($documentItems) : ?>
            <section class="documents content-block">
                <h2><?= htmlspecialchars(t('product.documents_title', $language), ENT_QUOTES) ?></h2>
                <div class="documents-list">
                    <?php foreach ($documentItems as $doc) : ?>
                        <a href="<?= htmlspecialchars($doc['file_path'], ENT_QUOTES) ?>" target="_blank" rel="noopener">
                            <?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
            <?php if ($faqItems) : ?>
            <section class="faq content-block">
                <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
                <?php foreach ($faqItems as $faq) : ?>
                    <details class="faq-item">
                        <summary><?= htmlspecialchars($faq['question'], ENT_QUOTES) ?></summary>
                        <p><?= nl2br(htmlspecialchars($faq['answer'], ENT_QUOTES)) ?></p>
                    </details>
                <?php endforeach; ?>
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
                <h2><?= htmlspecialchars(t('product.related_title', $language), ENT_QUOTES) ?></h2>
                <div class="product-grid">
                    <?php foreach ($related as $item) : ?>
                        <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($item['slug'], ENT_QUOTES) ?>/">
                            <div class="product-card-title"><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>
        <aside class="content-sidebar">
            <?php if ($documentItems) : ?>
                <div class="sidebar-card">
                    <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.documents_title', $language), ENT_QUOTES) ?></div>
                    <ul class="sidebar-list">
                        <?php foreach (array_slice($documentItems, 0, 3) as $doc) : ?>
                            <li>
                                <a href="<?= htmlspecialchars($doc['file_path'], ENT_QUOTES) ?>" target="_blank" rel="noopener">
                                    <?= htmlspecialchars($doc['title'], ENT_QUOTES) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="sidebar-card">
                <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.parameters_title', $language), ENT_QUOTES) ?></div>
                <?php if ($sidebarSpecs) : ?>
                    <ul class="sidebar-list">
                        <?php foreach ($sidebarSpecs as $spec) : ?>
                            <li>
                                <span><?= htmlspecialchars($spec['label'], ENT_QUOTES) ?></span>
                                <strong><?= htmlspecialchars(trim($spec['value'] . ' ' . $spec['unit']), ENT_QUOTES) ?></strong>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p><?= htmlspecialchars(t('sidebar.parameters_text', $language), ENT_QUOTES) ?></p>
                <?php endif; ?>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-title"><?= htmlspecialchars(t('sidebar.where_title', $language), ENT_QUOTES) ?></div>
                <p><?= htmlspecialchars(t('sidebar.where_text', $language), ENT_QUOTES) ?></p>
                <a class="cta-link" href="#partners"><?= htmlspecialchars(t('sidebar.where_link', $language), ENT_QUOTES) ?> →</a>
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
<div class="cta-sticky">
    <a class="button" href="#partners"><?= htmlspecialchars(t('cta.buy_partners', $language), ENT_QUOTES) ?></a>
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
