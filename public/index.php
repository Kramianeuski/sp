<?php

declare(strict_types=1);

require __DIR__ . '/../templates/helpers.php';
require __DIR__ . '/../database/repository.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
if ($path === '/') {
    header('Location: /ru/', true, 302);
    exit;
}

$redirect = db_fetch_one('SELECT target, status_code FROM redirects WHERE source = ?', [$path]);
if ($redirect) {
    header('Location: ' . $redirect['target'], true, (int) $redirect['status_code']);
    exit;
}

$segments = array_values(array_filter(explode('/', $path)));
$lang = $segments[0] ?? 'ru';
$lang = resolve_lang($lang);

$subPath = '/' . implode('/', array_slice($segments, 1));
$subPath = $subPath === '/' ? '/' : rtrim($subPath, '/') . '/';

$settings = get_settings();
$nav = get_navigation($lang);

$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$brandName = $settings['brand_name'] ?? 'System Power';
$brandUrl = $settings['brand_url'] ?? ($baseUrl . '/' . $lang . '/');
$sellerName = $settings['official_seller_name'] ?? 'SISSOL';
$sellerUrl = $settings['official_seller_url'] ?? 'https://sissol.ru';

function page_header(string $lang, array $meta, array $nav, bool $noindex = false): void
{
    $hreflang = build_hreflang($meta['path']);
    $canonical = $meta['canonical'] ?: $hreflang[$lang === 'ru' ? 'ru-RU' : 'en-US'];
    render_template(__DIR__ . '/../templates/partials/header.php', [
        'lang' => $lang,
        'title' => $meta['title'],
        'description' => $meta['description'],
        'ogTitle' => $meta['og_title'],
        'ogDescription' => $meta['og_description'],
        'twitterTitle' => $meta['twitter_title'],
        'twitterDescription' => $meta['twitter_description'],
        'canonical' => $canonical,
        'nav' => $nav,
        'hreflang' => $hreflang,
        'noindex' => $noindex,
    ]);
}

function page_footer(string $lang, array $settings, array $contacts): void
{
    render_template(__DIR__ . '/../templates/partials/footer.php', [
        'lang' => $lang,
        'footer' => [
            'text' => $contacts['text'] ?? '',
            'address' => $contacts['address'] ?? '',
            'email' => $contacts['email'] ?? '',
            'phone' => $contacts['phone'] ?? '',
        ],
        'settings' => $settings,
    ]);
}

function render_official_seller(string $sellerName, string $sellerUrl, string $lang): void
{
    $title = $lang === 'ru' ? 'Официальный продавец' : 'Official seller';
    $text = $lang === 'ru'
        ? 'Эксклюзивный официальный дистрибьютор продукции System Power.'
        : 'Exclusive official distributor of System Power products.';
    $button = $lang === 'ru' ? 'Перейти на сайт sissol.ru' : 'Go to sissol.ru';
    ?>
    <section class="seller-block">
        <div>
            <p class="section-label"><?= htmlspecialchars($title) ?></p>
            <h3><?= htmlspecialchars($sellerName) ?></h3>
            <p><?= htmlspecialchars($text) ?></p>
        </div>
        <a class="button" href="<?= htmlspecialchars($sellerUrl) ?>" rel="nofollow sponsored">
            <?= htmlspecialchars($button) ?>
        </a>
    </section>
    <?php
}

function build_meta(array $page, string $lang, string $path): array
{
    $title = $page['seo_title'] ?: $page['title'];
    $description = $page['seo_description'] ?: ($page['text'] ?? $page['title']);
    $ogTitle = $page['og_title'] ?: $title;
    $ogDescription = $page['og_description'] ?: $description;
    $twitterTitle = $page['twitter_title'] ?: $title;
    $twitterDescription = $page['twitter_description'] ?: $description;

    return [
        'title' => $title,
        'description' => $description,
        'path' => $path,
        'canonical' => $page['canonical'] ?? '',
        'og_title' => $ogTitle,
        'og_description' => $ogDescription,
        'twitter_title' => $twitterTitle,
        'twitter_description' => $twitterDescription,
    ];
}

$contactsPage = get_page('contacts', $lang);

switch ($subPath) {
    case '/':
        $page = get_page('home', $lang);
        if (!$page) {
            http_response_code(404);
            echo 'Page not found';
            exit;
        }
        $blocks = get_page_blocks((int) $page['id'], $lang);
        $blockMap = [];
        foreach ($blocks as $block) {
            $blockMap[$block['block_type']] = $block['content'];
        }
        $meta = build_meta($page, $lang, '/');
        $noindex = (bool) $page['noindex'];
        page_header($lang, $meta, $nav, $noindex);
        ?>
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <p class="section-label"><?= htmlspecialchars($brandName) ?></p>
                    <h1><?= htmlspecialchars($blockMap['hero']['title'] ?? $page['title']) ?></h1>
                    <p class="hero-subtitle"><?= htmlspecialchars($blockMap['hero']['subtitle'] ?? '') ?></p>
                    <p><?= htmlspecialchars($blockMap['hero']['text'] ?? '') ?></p>
                    <div class="hero-actions">
                        <a class="button" href="/<?= htmlspecialchars($lang) ?>/products/">
                            <?= $lang === 'ru' ? 'Продукция' : 'Products' ?>
                        </a>
                        <a class="button button-outline" href="/<?= htmlspecialchars($lang) ?>/where-to-buy/">
                            <?= $lang === 'ru' ? 'Где приобрести' : 'Where to buy' ?>
                        </a>
                    </div>
                </div>
                <div class="hero-card">
                    <p><?= htmlspecialchars($blockMap['brand']['text'] ?? '') ?></p>
                    <div class="metrics">
                        <div>
                            <span class="metric">2</span>
                            <span><?= $lang === 'ru' ? 'категории продукции' : 'product categories' ?></span>
                        </div>
                        <div>
                            <span class="metric">1</span>
                            <span><?= $lang === 'ru' ? 'официальный продавец' : 'official seller' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <h2><?= $lang === 'ru' ? 'Категории продукции' : 'Product categories' ?></h2>
                    <p><?= $lang === 'ru' ? 'Две ключевые линейки System Power для инженерных систем.' : 'Two core System Power lines for engineering systems.' ?></p>
                </div>
                <div class="tiles">
                    <?php foreach (get_categories($lang) as $category) : ?>
                        <a class="tile" href="/<?= htmlspecialchars($lang) ?>/products/<?= htmlspecialchars($category['slug']) ?>/">
                            <h3><?= htmlspecialchars($category['name']) ?></h3>
                            <p><?= htmlspecialchars($category['description']) ?></p>
                            <span class="link-arrow">→</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container two-column">
                <div>
                    <p class="section-label"><?= $lang === 'ru' ? 'О бренде' : 'About the brand' ?></p>
                    <h2><?= htmlspecialchars($blockMap['brand']['title'] ?? '') ?></h2>
                    <p><?= htmlspecialchars($blockMap['brand']['text'] ?? '') ?></p>
                </div>
                <div>
                    <p class="section-label"><?= $lang === 'ru' ? 'Производство' : 'Manufacturing' ?></p>
                    <h2><?= htmlspecialchars($blockMap['manufacturing']['title'] ?? '') ?></h2>
                    <p><?= htmlspecialchars($blockMap['manufacturing']['text'] ?? '') ?></p>
                    <ul class="checklist">
                        <?php foreach (($blockMap['manufacturing']['list'] ?? []) as $item) : ?>
                            <li><?= htmlspecialchars($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <h2><?= htmlspecialchars($blockMap['where']['title'] ?? '') ?></h2>
                    <p><?= htmlspecialchars($blockMap['where']['text'] ?? '') ?></p>
                </div>
                <?php render_official_seller($sellerName, $sellerUrl, $lang); ?>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <h2><?= $lang === 'ru' ? 'Сертификаты и доверие' : 'Certificates & trust' ?></h2>
                    <p><?= $lang === 'ru' ? 'Документация подтверждает соответствие продукции требованиям и стандартам.' : 'Documentation confirms product compliance with requirements and standards.' ?></p>
                </div>
                <div class="trust-grid">
                    <div class="trust-card">
                        <h3><?= $lang === 'ru' ? 'Паспорта изделий' : 'Product passports' ?></h3>
                        <p><?= $lang === 'ru' ? 'Паспорт и технические параметры для каждой модели.' : 'Passports and technical parameters for each model.' ?></p>
                    </div>
                    <div class="trust-card">
                        <h3><?= $lang === 'ru' ? 'Схемы и инструкции' : 'Schemes and manuals' ?></h3>
                        <p><?= $lang === 'ru' ? 'Подробные схемы и инструкции по монтажу.' : 'Detailed wiring schemes and installation manuals.' ?></p>
                    </div>
                    <div class="trust-card">
                        <h3><?= $lang === 'ru' ? 'Контроль качества' : 'Quality control' ?></h3>
                        <p><?= $lang === 'ru' ? 'Локальная сборка и контроль комплектности.' : 'Local assembly and completeness checks.' ?></p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section seo-text">
            <div class="container">
                <h2><?= $lang === 'ru' ? 'System Power — официальный бренд' : 'System Power — official brand' ?></h2>
                <p><?= htmlspecialchars($blockMap['seo']['text'] ?? '') ?></p>
            </div>
        </section>
        <?php
        render_json_ld(build_organization($brandName, $brandUrl));
        page_footer($lang, $settings, $contactsPage ?? []);
        break;
    case '/products/':
        $pageTitle = $lang === 'ru' ? 'Каталог продукции' : 'Product catalog';
        $meta = [
            'title' => $pageTitle,
            'description' => $pageTitle,
            'path' => '/products/',
            'canonical' => '',
            'og_title' => $pageTitle,
            'og_description' => $pageTitle,
            'twitter_title' => $pageTitle,
            'twitter_description' => $pageTitle,
        ];
        page_header($lang, $meta, $nav, false);
        ?>
        <section class="section">
            <div class="container">
                <h1><?= htmlspecialchars($pageTitle) ?></h1>
                <p><?= $lang === 'ru' ? 'Каталог включает электрощитовое оборудование и напольные лючки System Power.' : 'The catalog includes System Power electrical enclosures and floor boxes.' ?></p>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="tiles">
                    <?php foreach (get_categories($lang) as $category) : ?>
                        <a class="tile" href="/<?= htmlspecialchars($lang) ?>/products/<?= htmlspecialchars($category['slug']) ?>/">
                            <h3><?= htmlspecialchars($category['name']) ?></h3>
                            <p><?= htmlspecialchars($category['description']) ?></p>
                            <span class="link-arrow">→</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
        page_footer($lang, $settings, $contactsPage ?? []);
        break;
    case '/products/electrical-enclosures/':
    case '/products/floor-boxes/':
        $categorySlug = trim(str_replace('products/', '', trim($subPath, '/')));
        $category = get_category($categorySlug, $lang);
        if (!$category) {
            http_response_code(404);
            echo 'Page not found';
            exit;
        }
        $meta = build_meta($category, $lang, '/products/' . $categorySlug . '/');
        $noindex = (bool) $category['noindex'];
        page_header($lang, $meta, $nav, $noindex);
        $advantages = get_category_advantages((int) $category['id'], $lang);
        $products = get_products_by_category((int) $category['id'], $lang);
        ?>
        <section class="section">
            <div class="container">
                <h1><?= htmlspecialchars($category['seo_h1'] ?: $category['name']) ?></h1>
                <p><?= htmlspecialchars($category['description']) ?></p>
                <div class="markers">
                    <?php foreach ($advantages as $advantage) : ?>
                        <span><?= htmlspecialchars($advantage['text']) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="filter-bar">
                    <span class="filter-label"><?= $lang === 'ru' ? 'Фильтры' : 'Filters' ?></span>
                    <button class="filter-chip" type="button"><?= $lang === 'ru' ? 'Тип установки' : 'Installation type' ?></button>
                    <button class="filter-chip" type="button"><?= $lang === 'ru' ? 'Степень защиты' : 'Protection' ?></button>
                    <button class="filter-chip" type="button"><?= $lang === 'ru' ? 'Материал' : 'Material' ?></button>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <h2><?= $lang === 'ru' ? 'Товары категории' : 'Category products' ?></h2>
                <div class="product-grid">
                    <?php foreach ($products as $product) : ?>
                        <article class="product-card">
                            <div class="product-card__media">
                                <img src="<?= htmlspecialchars($product['image'] ?: '/assets/images/floor-box-1.svg') ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>
                            <div class="product-card__body">
                                <h3><?= htmlspecialchars($product['name']) ?></h3>
                                <p><?= htmlspecialchars($product['short_description']) ?></p>
                                <a class="button" href="/<?= htmlspecialchars($lang) ?>/product/<?= htmlspecialchars($product['slug']) ?>/">
                                    <?= $lang === 'ru' ? 'Открыть карточку' : 'View product' ?>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <?php render_official_seller($sellerName, $sellerUrl, $lang); ?>
            </div>
        </section>
        <?php
        $faq = get_faq('category', (int) $category['id'], $lang);
        if ($faq) {
            ?>
            <section class="section faq">
                <div class="container">
                    <h2>FAQ</h2>
                    <div class="faq-grid">
                        <?php foreach ($faq as $item) : ?>
                            <div class="faq-item">
                                <h3><?= htmlspecialchars($item['question']) ?></h3>
                                <p><?= htmlspecialchars($item['answer']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php
        }
        render_json_ld(build_breadcrumbs($lang, [
            ['label' => $lang === 'ru' ? 'Продукция' : 'Products', 'url' => $baseUrl . '/' . $lang . '/products/'],
            ['label' => $category['name'], 'url' => $baseUrl . '/' . $lang . '/products/' . $categorySlug . '/'],
        ]));
        if ($faq) {
            render_json_ld(build_faq($faq));
        }
        page_footer($lang, $settings, $contactsPage ?? []);
        break;
    default:
        if (!preg_match('~^/product/([^/]+)/$~', $subPath, $matches)) {
            http_response_code(404);
            echo 'Page not found';
            exit;
        }
        $productSlug = $matches[1];
        $product = get_product($productSlug, $lang);
        if (!$product) {
            http_response_code(404);
            echo 'Page not found';
            exit;
        }
        $meta = build_meta($product, $lang, '/product/' . $productSlug . '/');
        $noindex = (bool) $product['noindex'];
        page_header($lang, $meta, $nav, $noindex);
        $category = get_category_by_id((int) $product['category_id'], $lang);
        $images = get_product_images((int) $product['id']);
        $specs = get_product_specs((int) $product['id'], $lang);
        $documents = get_product_documents((int) $product['id'], $lang);
        $features = get_product_features((int) $product['id'], 'feature', $lang);
        $advantages = get_product_features((int) $product['id'], 'advantage', $lang);
        $certificates = get_product_certificates((int) $product['id'], $lang);
        $faq = get_faq('product', (int) $product['id'], $lang);
        ?>
        <section class="section product-hero">
            <div class="container product-hero-grid">
                <div>
                    <p class="section-label"><?= $lang === 'ru' ? 'Карточка товара' : 'Product card' ?></p>
                    <h1><?= htmlspecialchars($product['seo_h1'] ?: $product['name']) ?></h1>
                    <p><?= htmlspecialchars($product['short_description']) ?></p>
                    <div class="tag-list">
                        <?php foreach ($features as $feature) : ?>
                            <span><?= htmlspecialchars($feature['text']) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="gallery">
                    <?php foreach ($images as $image) : ?>
                        <img src="<?= htmlspecialchars($image['file_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container two-column">
                <div>
                    <h2><?= $lang === 'ru' ? 'Описание' : 'Description' ?></h2>
                    <?php foreach (array_filter(explode("\n", $product['description'])) as $paragraph) : ?>
                        <p><?= htmlspecialchars($paragraph) ?></p>
                    <?php endforeach; ?>
                </div>
                <div>
                    <h2><?= $lang === 'ru' ? 'Преимущества' : 'Advantages' ?></h2>
                    <ul class="checklist">
                        <?php foreach ($advantages as $advantage) : ?>
                            <li><?= htmlspecialchars($advantage['text']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <?php render_official_seller($sellerName, $sellerUrl, $lang); ?>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <h2><?= $lang === 'ru' ? 'Характеристики' : 'Specifications' ?></h2>
                <table class="spec-table">
                    <tbody>
                    <?php foreach ($specs as $spec) : ?>
                        <tr>
                            <th><?= htmlspecialchars($spec['label']) ?></th>
                            <td><?= htmlspecialchars($spec['value']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <h2><?= $lang === 'ru' ? 'Документация' : 'Documentation' ?></h2>
                <div class="doc-grid">
                    <?php foreach ($documents as $doc) : ?>
                        <a class="doc-card" href="<?= htmlspecialchars($doc['file_path']) ?>">
                            <span><?= htmlspecialchars($doc['label']) ?></span>
                            <span class="link-arrow">PDF →</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php if ($certificates) : ?>
            <section class="section">
                <div class="container">
                    <h2><?= $lang === 'ru' ? 'Сертификаты и гарантия' : 'Certificates & warranty' ?></h2>
                    <div class="trust-grid">
                        <?php foreach ($certificates as $certificate) : ?>
                            <div class="trust-card">
                                <h3><?= htmlspecialchars($certificate['title']) ?></h3>
                                <p><?= htmlspecialchars($certificate['description']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if ($faq) : ?>
            <section class="section faq">
                <div class="container">
                    <h2>FAQ</h2>
                    <div class="faq-grid">
                        <?php foreach ($faq as $item) : ?>
                            <div class="faq-item">
                                <h3><?= htmlspecialchars($item['question']) ?></h3>
                                <p><?= htmlspecialchars($item['answer']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <section class="section">
            <div class="container">
                <h2><?= $lang === 'ru' ? 'Похожие товары' : 'Related products' ?></h2>
                <div class="product-grid">
                    <article class="product-card">
                        <div class="product-card__media">
                            <img src="<?= htmlspecialchars($images[0]['file_path'] ?? '/assets/images/floor-box-1.svg') ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="product-card__body">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p><?= htmlspecialchars($product['short_description']) ?></p>
                            <a class="button" href="/<?= htmlspecialchars($lang) ?>/product/<?= htmlspecialchars($product['slug']) ?>/">
                                <?= $lang === 'ru' ? 'Открыть карточку' : 'View product' ?>
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <?php
        render_json_ld([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'],
            'description' => $product['short_description'],
            'sku' => $product['sku'],
            'brand' => [
                '@type' => 'Brand',
                'name' => $brandName,
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => $brandName,
            ],
        ]);
        render_json_ld(build_breadcrumbs($lang, [
            ['label' => $lang === 'ru' ? 'Продукция' : 'Products', 'url' => $baseUrl . '/' . $lang . '/products/'],
            ['label' => $category['name'] ?? '', 'url' => $baseUrl . '/' . $lang . '/products/' . ($category['slug'] ?? '') . '/'],
            ['label' => $product['name'], 'url' => $baseUrl . '/' . $lang . '/product/' . $product['slug'] . '/'],
        ]));
        if ($faq) {
            render_json_ld(build_faq($faq));
        }
        page_footer($lang, $settings, $contactsPage ?? []);
        break;
    case '/where-to-buy/':
        $page = get_page('where-to-buy', $lang);
        if (!$page) {
            http_response_code(404);
            echo 'Page not found';
            exit;
        }
        $meta = build_meta($page, $lang, '/where-to-buy/');
        page_header($lang, $meta, $nav, (bool) $page['noindex']);
        $regions = get_regions($lang);
        ?>
        <section class="section">
            <div class="container">
                <h1><?= htmlspecialchars($page['seo_h1'] ?: $page['title']) ?></h1>
                <p><?= htmlspecialchars($page['text']) ?></p>
                <label class="form-label" for="region"><?= $lang === 'ru' ? 'Выберите регион' : 'Select region' ?></label>
                <select id="region" class="select">
                    <?php foreach ($regions as $region) : ?>
                        <option><?= htmlspecialchars($region['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php render_official_seller($sellerName, $sellerUrl, $lang); ?>
            </div>
        </section>
        <?php
        page_footer($lang, $settings, $contactsPage ?? []);
        break;
    case '/about/':
    case '/manufacturing/':
    case '/documentation/':
    case '/support/':
    case '/contacts/':
        $key = trim($subPath, '/');
        $page = get_page($key, $lang);
        if (!$page) {
            http_response_code(404);
            echo 'Page not found';
            exit;
        }
        $meta = build_meta($page, $lang, '/' . $key . '/');
        page_header($lang, $meta, $nav, (bool) $page['noindex']);
        ?>
        <section class="section">
            <div class="container">
                <h1><?= htmlspecialchars($page['seo_h1'] ?: $page['title']) ?></h1>
                <p><?= htmlspecialchars($page['text']) ?></p>
                <?php if (!empty($page['address'])) : ?>
                    <div class="contact-grid">
                        <div>
                            <p class="section-label"><?= $lang === 'ru' ? 'Адрес' : 'Address' ?></p>
                            <p><?= htmlspecialchars($page['address']) ?></p>
                        </div>
                        <div>
                            <p class="section-label"><?= $lang === 'ru' ? 'Почта' : 'Email' ?></p>
                            <p><a href="mailto:<?= htmlspecialchars($page['email']) ?>"><?= htmlspecialchars($page['email']) ?></a></p>
                        </div>
                        <div>
                            <p class="section-label"><?= $lang === 'ru' ? 'Телефон' : 'Phone' ?></p>
                            <p><a href="tel:<?= htmlspecialchars($page['phone']) ?>"><?= htmlspecialchars($page['phone']) ?></a></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        page_footer($lang, $settings, $contactsPage ?? []);
        break;
}
