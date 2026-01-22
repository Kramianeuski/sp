<?php
ob_start();
?>
<section class="hero">
    <div class="container">
        <h1><?= e($page['h1'] ?? '') ?></h1>
        <?php if (!empty($page['body'])) : ?>
            <p class="lead"><?= nl2br(e($page['body'])) ?></p>
        <?php endif; ?>
        <?php if (!empty($blocks)) : ?>
            <div class="hero-actions">
                <?php foreach ($blocks as $block) : ?>
                    <?php if ($block['block_type'] === 'hero_action') : ?>
                        <a class="button" href="<?= e($block['cta_url']) ?>"><?= e($block['cta_label']) ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<div class="container">
    <?= renderBlocks(array_filter($blocks, fn($block) => $block['block_type'] !== 'hero_action')) ?>
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
</div>
<?php
$content = ob_get_clean();
$organization = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $settings['site_name'] ?? '',
    'url' => $settings['site_url'] ?? '',
    'brand' => $settings['brand_name'] ?? '',
];
$breadcrumbs = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => $page['title'] ?? '',
            'item' => "/{$lang}/",
        ],
    ],
];
$content .= jsonLd($organization);
$content .= jsonLd($breadcrumbs);
include __DIR__ . '/layout.php';
