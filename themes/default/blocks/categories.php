<?php
$catStmt = db()->prepare('SELECT c.slug, ct.name, ct.description FROM categories c JOIN category_translations ct ON ct.category_id = c.id WHERE ct.language = ?');
$catStmt->execute([$language]);
$categories = $catStmt->fetchAll();
?>
<section class="categories-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></p>
        </div>
        <div class="category-grid">
            <?php foreach ($categories as $category) : ?>
                <a class="category-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>/">
                    <div class="category-card-title"><?= htmlspecialchars($category['name'], ENT_QUOTES) ?></div>
                    <div class="category-card-text"><?= htmlspecialchars($category['description'], ENT_QUOTES) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
