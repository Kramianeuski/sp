<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function resolve_lang(string $lang): string
{
    return $lang === 'en' ? 'en' : 'ru';
}

function get_settings(): array
{
    $rows = db_fetch_all('SELECT setting_key, setting_value FROM settings');
    $settings = [];
    foreach ($rows as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

function get_navigation(string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT label_{$lang} AS label, url_{$lang} AS url FROM navigation_links ORDER BY position ASC"
    );
}

function get_page(string $slug, string $lang): ?array
{
    $lang = resolve_lang($lang);
    return db_fetch_one(
        "SELECT id, slug, title_{$lang} AS title, text_{$lang} AS text,
                seo_title_{$lang} AS seo_title, seo_description_{$lang} AS seo_description,
                seo_h1_{$lang} AS seo_h1, canonical, noindex, og_title_{$lang} AS og_title,
                og_description_{$lang} AS og_description, twitter_title_{$lang} AS twitter_title,
                twitter_description_{$lang} AS twitter_description,
                address_{$lang} AS address, email, phone
         FROM pages WHERE slug = ?",
        [$slug]
    );
}

function get_page_blocks(int $pageId, string $lang): array
{
    $lang = resolve_lang($lang);
    $rows = db_fetch_all(
        "SELECT block_type, content_{$lang} AS content
         FROM page_blocks WHERE page_id = ? ORDER BY position ASC",
        [$pageId]
    );

    foreach ($rows as &$row) {
        $row['content'] = $row['content'] ? json_decode($row['content'], true) : [];
    }
    unset($row);

    return $rows;
}

function get_categories(string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT id, slug, name_{$lang} AS name, description_{$lang} AS description,
                seo_title_{$lang} AS seo_title, seo_description_{$lang} AS seo_description,
                seo_h1_{$lang} AS seo_h1, canonical, noindex
         FROM categories ORDER BY id ASC"
    );
}

function get_category(string $slug, string $lang): ?array
{
    $lang = resolve_lang($lang);
    return db_fetch_one(
        "SELECT id, slug, name_{$lang} AS name, description_{$lang} AS description,
                seo_title_{$lang} AS seo_title, seo_description_{$lang} AS seo_description,
                seo_h1_{$lang} AS seo_h1, canonical, noindex,
                og_title_{$lang} AS og_title, og_description_{$lang} AS og_description,
                twitter_title_{$lang} AS twitter_title, twitter_description_{$lang} AS twitter_description
         FROM categories WHERE slug = ?",
        [$slug]
    );
}

function get_category_by_id(int $id, string $lang): ?array
{
    $lang = resolve_lang($lang);
    return db_fetch_one(
        "SELECT id, slug, name_{$lang} AS name, description_{$lang} AS description,
                seo_title_{$lang} AS seo_title, seo_description_{$lang} AS seo_description,
                seo_h1_{$lang} AS seo_h1, canonical, noindex,
                og_title_{$lang} AS og_title, og_description_{$lang} AS og_description,
                twitter_title_{$lang} AS twitter_title, twitter_description_{$lang} AS twitter_description
         FROM categories WHERE id = ?",
        [$id]
    );
}

function get_category_advantages(int $categoryId, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT text_{$lang} AS text FROM category_advantages WHERE category_id = ? ORDER BY position ASC",
        [$categoryId]
    );
}

function get_faq(string $scope, int $scopeId, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT question_{$lang} AS question, answer_{$lang} AS answer
         FROM faq_items WHERE scope = ? AND scope_id = ? ORDER BY position ASC",
        [$scope, $scopeId]
    );
}

function get_products_by_category(int $categoryId, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT id, slug, sku, name_{$lang} AS name, short_desc_{$lang} AS short_description,
                (SELECT file_path FROM product_images WHERE product_id = products.id ORDER BY position ASC LIMIT 1) AS image
         FROM products WHERE category_id = ? ORDER BY id ASC",
        [$categoryId]
    );
}

function get_product(string $slug, string $lang): ?array
{
    $lang = resolve_lang($lang);
    return db_fetch_one(
        "SELECT id, slug, sku, category_id,
                name_{$lang} AS name, short_desc_{$lang} AS short_description,
                description_{$lang} AS description,
                seo_title_{$lang} AS seo_title, seo_description_{$lang} AS seo_description,
                seo_h1_{$lang} AS seo_h1, canonical, noindex,
                og_title_{$lang} AS og_title, og_description_{$lang} AS og_description,
                twitter_title_{$lang} AS twitter_title, twitter_description_{$lang} AS twitter_description
         FROM products WHERE slug = ?",
        [$slug]
    );
}

function get_product_images(int $productId): array
{
    return db_fetch_all(
        "SELECT file_path FROM product_images WHERE product_id = ? ORDER BY position ASC",
        [$productId]
    );
}

function get_product_documents(int $productId, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT label_{$lang} AS label, file_path
         FROM product_documents WHERE product_id = ? ORDER BY position ASC",
        [$productId]
    );
}

function get_product_specs(int $productId, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT label_{$lang} AS label, value_{$lang} AS value
         FROM product_specs WHERE product_id = ? ORDER BY position ASC",
        [$productId]
    );
}

function get_product_features(int $productId, string $type, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT text_{$lang} AS text
         FROM product_features WHERE product_id = ? AND feature_type = ? ORDER BY position ASC",
        [$productId, $type]
    );
}

function get_product_certificates(int $productId, string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT title_{$lang} AS title, description_{$lang} AS description
         FROM product_certificates WHERE product_id = ? ORDER BY position ASC",
        [$productId]
    );
}

function get_regions(string $lang): array
{
    $lang = resolve_lang($lang);
    return db_fetch_all(
        "SELECT name_{$lang} AS name FROM regions ORDER BY position ASC"
    );
}

function get_files(): array
{
    return db_fetch_all(
        "SELECT id, title, file_path, file_type, file_size, created_at FROM files ORDER BY created_at DESC"
    );
}
