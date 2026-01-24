<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($page['h1'], ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($page['h1'], ENT_QUOTES) ?></h1>
        <p><?= nl2br(htmlspecialchars($page['meta_description'] ?? $page['title'], ENT_QUOTES)) ?></p>
        <div class="hero-actions">
            <a class="button" href="#categories"><?= htmlspecialchars(t('cta.browse_categories', $language), ENT_QUOTES) ?></a>
        </div>
    </div>
</section>
<section class="content-block" id="categories">
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
