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
    <div class="grid">
        <?php foreach ($categories as $category) : ?>
            <a class="card" href="/<?= e($lang) ?>/products/<?= e($category['slug']) ?>/">
                <h2><?= e($category['title']) ?></h2>
                <p><?= nl2br(e($category['description'])) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
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
            'item' => "/{$lang}/products/",
        ],
    ],
];
$content .= jsonLd($breadcrumbs);
include __DIR__ . '/layout.php';
