<?php
require_once __DIR__ . '/../src/Database.php';

$db = Database::instance()->pdo();
$baseUrl = getenv('SITE_URL') ?: 'https://system-power.local';

$urls = [];

$languages = ['ru', 'en'];

foreach ($languages as $lang) {
    $urls[] = ["{$baseUrl}/{$lang}/", 'daily'];

    $pageStmt = $db->prepare('SELECT p.slug FROM pages p JOIN page_translations pt ON pt.page_id = p.id AND pt.lang = :lang');
    $pageStmt->execute(['lang' => $lang]);
    foreach ($pageStmt->fetchAll(PDO::FETCH_COLUMN) as $slug) {
        $urls[] = ["{$baseUrl}/{$lang}/{$slug}/", 'weekly'];
    }

    $categoryStmt = $db->prepare('SELECT c.slug FROM categories c JOIN category_translations ct ON ct.category_id = c.id AND ct.lang = :lang');
    $categoryStmt->execute(['lang' => $lang]);
    foreach ($categoryStmt->fetchAll(PDO::FETCH_COLUMN) as $slug) {
        $urls[] = ["{$baseUrl}/{$lang}/products/{$slug}/", 'weekly'];
    }

    $productStmt = $db->prepare('SELECT p.slug FROM products p JOIN product_translations pt ON pt.product_id = p.id AND pt.lang = :lang');
    $productStmt->execute(['lang' => $lang]);
    foreach ($productStmt->fetchAll(PDO::FETCH_COLUMN) as $slug) {
        $urls[] = ["{$baseUrl}/{$lang}/product/{$slug}/", 'weekly'];
    }
}

header('Content-Type: application/xml; charset=utf-8');

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($urls as [$loc, $freq]) {
    echo "  <url>\n";
    echo "    <loc>{$loc}</loc>\n";
    echo "    <changefreq>{$freq}</changefreq>\n";
    echo "  </url>\n";
}
echo "</urlset>\n";
