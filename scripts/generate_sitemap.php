<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

$languages = ['ru', 'en'];
$urls = [];

foreach ($languages as $language) {
    $stmt = db()->prepare(
        'SELECT p.slug AS page_slug, sm.slug AS seo_slug
         FROM pages p
         JOIN seo_meta sm ON sm.entity_type = "page" AND sm.entity_id = p.id AND sm.locale = ?
         WHERE p.status = "published"'
    );
    $stmt->execute([$language]);

    foreach ($stmt->fetchAll() as $page) {
        $slug = $page['seo_slug'] ?: $page['page_slug'];
        $urls[] = '/' . $language . '/' . ($slug === 'home' ? '' : $slug . '/');
    }

    $stmt = db()->prepare(
        'SELECT c.id, sm.slug
         FROM categories c
         JOIN seo_meta sm ON sm.entity_type = "category" AND sm.entity_id = c.id AND sm.locale = ?
         WHERE c.is_active = 1'
    );
    $stmt->execute([$language]);

    foreach ($stmt->fetchAll() as $category) {
        $urls[] = '/' . $language . '/products/' . $category['slug'] . '/';
    }

    $stmt = db()->prepare(
        'SELECT p.id, sm.slug AS product_slug
         FROM products p
         JOIN seo_meta sm ON sm.entity_type = "product" AND sm.entity_id = p.id AND sm.locale = ?
         WHERE p.is_active = 1'
    );
    $stmt->execute([$language]);

    foreach ($stmt->fetchAll() as $product) {
        $urls[] = '/' . $language . '/product/' . $product['product_slug'] . '/';
    }
}

$urls = array_unique($urls);

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($urls as $url) {
    $xml .= '<url><loc>' . htmlspecialchars(config('base_url') . $url, ENT_QUOTES) . '</loc></url>';
}

$xml .= '</urlset>';

file_put_contents(__DIR__ . '/../public/sitemap.xml', $xml);
