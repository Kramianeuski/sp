<?php
$catStmt = db()->prepare('SELECT c.slug, ct.name FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE ct.language = ? AND c.status = "published"');
$catStmt->execute([$language]);
$categories = $catStmt->fetchAll();
$factsMap = [
    'electrical-enclosures' => [
        t('categories.rusp.fact1', $language),
        t('categories.rusp.fact2', $language),
        t('categories.rusp.fact3', $language),
        t('categories.rusp.fact4', $language),
    ],
    'floor-boxes' => [
        t('categories.floor.fact1', $language),
        t('categories.floor.fact2', $language),
        t('categories.floor.fact3', $language),
        t('categories.floor.fact4', $language),
    ],
];
?>
<section class="content-block categories-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></p>
        </div>
        <div class="category-grid">
            <?php foreach ($categories as $category) : ?>
                <a class="category-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>/">
                    <div class="category-card-title"><?= htmlspecialchars($category['name'], ENT_QUOTES) ?></div>
                    <?php if (!empty($factsMap[$category['slug']])) : ?>
                        <ul class="category-facts">
                            <?php foreach ($factsMap[$category['slug']] as $fact) : ?>
                                <li><?= htmlspecialchars($fact, ENT_QUOTES) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="cta-link"><?= htmlspecialchars(t('cta.open_category', $language), ENT_QUOTES) ?> →</div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
