<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($page['h1'], ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($page['h1'], ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($page['meta_description'] ?? $page['title'], ENT_QUOTES) ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="category-grid">
            <?php foreach ($categories as $category) : ?>
                <a class="category-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>/">
                    <div class="category-card-bg"></div>
                    <div class="category-card-content">
                        <h3><?= htmlspecialchars($category['name'], ENT_QUOTES) ?></h3>
                        <p><?= htmlspecialchars($category['description'], ENT_QUOTES) ?></p>
                        <span class="category-card-cta"><?= htmlspecialchars(t('cta.view', $language), ENT_QUOTES) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
