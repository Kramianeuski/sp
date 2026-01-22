<?php
ob_start();
?>
<section class="hero hero-small">
    <div class="container">
        <h1><?= e($page['h1'] ?? '') ?></h1>
        <?php if (!empty($page['body'])) : ?>
            <p class="lead"><?= nl2br(e($page['body'])) ?></p>
        <?php endif; ?>
    </div>
</section>
<div class="container">
    <?= renderBlocks($blocks) ?>
</div>
<?php
$content = ob_get_clean();
$breadcrumbs = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => $page['title'] ?? '',
            'item' => "/{$lang}/{$page['slug']}/",
        ],
    ],
];
$content .= jsonLd($breadcrumbs);
include __DIR__ . '/layout.php';
