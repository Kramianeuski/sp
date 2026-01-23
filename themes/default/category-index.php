<section class="page-header">
    <div class="container">
        <h1><?= htmlspecialchars($page['h1'], ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($page['title'], ENT_QUOTES) ?></p>
    </div>
</section>
<section class="category-grid">
    <div class="container">
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
