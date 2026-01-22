<?php
ob_start();
?>
<section class="hero hero-small">
    <div class="container">
        <h1><?= e($category['h1'] ?? '') ?></h1>
        <?php if (!empty($category['description'])) : ?>
            <p class="lead"><?= nl2br(e($category['description'])) ?></p>
        <?php endif; ?>
    </div>
</section>
<div class="container">
    <div class="grid">
        <?php foreach ($products as $product) : ?>
            <a class="card" href="/<?= e($lang) ?>/product/<?= e($product['slug']) ?>/">
                <h2><?= e($product['title']) ?></h2>
                <p><?= nl2br(e($product['short_description'])) ?></p>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($highlights)) : ?>
        <section class="section">
            <div class="grid">
                <?php foreach ($highlights as $highlight) : ?>
                    <div class="card">
                        <h3><?= e($highlight['title']) ?></h3>
                        <p><?= nl2br(e($highlight['body'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($partner) : ?>
        <section class="section partner">
            <div class="partner-card">
                <div>
                    <h2><?= e($partner['name']) ?></h2>
                    <p><?= nl2br(e($partner['description'] ?? '')) ?></p>
                </div>
                <a class="button" href="<?= e($partner['url']) ?>" rel="<?= e($partner['rel_attr']) ?>"><?= e($settings['partner_cta'] ?? '') ?></a>
            </div>
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
$breadcrumbs = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => $category['title'] ?? '',
            'item' => "/{$lang}/products/{$category['slug']}/",
        ],
    ],
];
if (!empty($faqData)) {
    $content .= jsonLd([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqData,
    ]);
}
$content .= jsonLd($breadcrumbs);
include __DIR__ . '/layout.php';
