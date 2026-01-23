<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/"><?= htmlspecialchars(t('products.h1', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($category['h1'], ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($category['h1'], ENT_QUOTES) ?></h1>
        <p><?= nl2br(htmlspecialchars($category['description'], ENT_QUOTES)) ?></p>
        <div class="hero-actions">
            <a class="button" href="#products-list"><?= $language === 'en' ? 'View products' : 'Смотреть товары' ?></a>
        </div>
    </div>
</section>
<section class="products-list content-block" id="products-list">
    <div class="container">
        <form class="filters" method="get">
            <label>
                <?= $language === 'en' ? 'Search by name or SKU' : 'Поиск по названию или артикулу' ?>
                <input type="search" name="q" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES) ?>" placeholder="<?= $language === 'en' ? 'Enter name or SKU' : 'Введите название или артикул' ?>">
            </label>
            <label>
                <?= $language === 'en' ? 'Sort' : 'Сортировка' ?>
                <select name="sort">
                    <option value="name" <?= ($sort ?? '') === 'name' ? 'selected' : '' ?>><?= $language === 'en' ? 'By name' : 'По названию' ?></option>
                    <option value="new" <?= ($sort ?? '') === 'new' ? 'selected' : '' ?>><?= $language === 'en' ? 'Newest' : 'Новизне' ?></option>
                </select>
            </label>
            <button class="button secondary" type="submit"><?= $language === 'en' ? 'Apply' : 'Показать' ?></button>
        </form>
        <div class="product-grid">
            <?php foreach ($products as $product) : ?>
                <a class="product-card" href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/product/<?= htmlspecialchars($product['slug'], ENT_QUOTES) ?>/">
                    <div class="product-card-title"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></div>
                    <div class="product-card-text"><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></div>
                    <?php if (!empty($product['sku'])) : ?>
                        <div class="product-card-text"><?= htmlspecialchars($language === 'en' ? 'SKU' : 'Артикул', ENT_QUOTES) ?>: <?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></div>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php if (empty($products)) : ?>
            <p><?= $language === 'en' ? 'No products found for the selected filters.' : 'По выбранным фильтрам товары не найдены.' ?></p>
        <?php endif; ?>
    </div>
</section>
<section class="content-block">
    <div class="container">
        <div class="section-header">
            <h2><?= $language === 'en' ? 'Where to buy' : 'Где купить' ?></h2>
            <p><?= $language === 'en' ? 'Choose a distributor to request availability and pricing.' : 'Выберите дистрибьютора, чтобы уточнить наличие и цены.' ?></p>
        </div>
        <div class="partner-list">
            <?php foreach (partners_list($language) as $partner) : ?>
                <div class="partner-card">
                    <div class="partner-info">
                        <strong><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></strong>
                        <span><?= htmlspecialchars($partner['note'], ENT_QUOTES) ?></span>
                    </div>
                    <a class="button secondary" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" rel="nofollow sponsored" target="_blank">
                        <?= $language === 'en' ? 'Visit' : 'Перейти' ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$faqItems = json_decode($category['faq'], true);
if (!is_array($faqItems)) {
    $faqItems = [];
}
?>
<?php if ($faqItems) : ?>
<section class="faq">
    <div class="container">
        <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
        <div class="faq-list">
            <?php foreach ($faqItems as $item) : ?>
                <details class="faq-item">
                    <summary><?= htmlspecialchars($item['question'] ?? '', ENT_QUOTES) ?></summary>
                    <p><?= nl2br(htmlspecialchars($item['answer'] ?? '', ENT_QUOTES)) ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
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
<?php if (!empty($category['seo_text'])) : ?>
<section class="seo-text">
    <div class="container">
        <h2><?= htmlspecialchars(t('seo.title', $language), ENT_QUOTES) ?></h2>
        <p><?= nl2br(htmlspecialchars($category['seo_text'], ENT_QUOTES)) ?></p>
    </div>
</section>
<?php endif; ?>
