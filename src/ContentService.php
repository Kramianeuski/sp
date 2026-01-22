<?php

class ContentService
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getSettings(string $lang): array
    {
        $stmt = $this->db->prepare('SELECT setting_key, setting_value FROM settings WHERE lang = :lang');
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
    }

    public function getPagesForNav(string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.slug, pt.title
             FROM pages p
             JOIN page_translations pt ON pt.page_id = p.id AND pt.lang = :lang
             WHERE p.show_in_nav = 1
             ORDER BY p.nav_order ASC'
        );
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getPageBySlug(string $slug, string $lang): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.id, p.slug, pt.title, pt.h1, pt.body, pt.seo_title, pt.seo_description,
                    pt.seo_canonical, pt.seo_robots
             FROM pages p
             JOIN page_translations pt ON pt.page_id = p.id AND pt.lang = :lang
             WHERE p.slug = :slug'
        );
        $stmt->execute(['slug' => $slug, 'lang' => $lang]);
        $page = $stmt->fetch();
        return $page ?: null;
    }

    public function getPageBlocks(int $pageId, string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT pb.id, pb.block_type, pbt.title, pbt.body, pbt.cta_label, pbt.cta_url
             FROM page_blocks pb
             JOIN page_block_translations pbt ON pbt.block_id = pb.id AND pbt.lang = :lang
             WHERE pb.page_id = :page_id
             ORDER BY pb.sort_order ASC'
        );
        $stmt->execute(['page_id' => $pageId, 'lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getCategories(string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, c.slug, ct.title, ct.h1, ct.description, ct.seo_title, ct.seo_description, ct.seo_robots
             FROM categories c
             JOIN category_translations ct ON ct.category_id = c.id AND ct.lang = :lang
             ORDER BY c.sort_order ASC'
        );
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getCategoryBySlug(string $slug, string $lang): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, c.slug, ct.title, ct.h1, ct.description, ct.seo_title, ct.seo_description, ct.seo_robots
             FROM categories c
             JOIN category_translations ct ON ct.category_id = c.id AND ct.lang = :lang
             WHERE c.slug = :slug'
        );
        $stmt->execute(['slug' => $slug, 'lang' => $lang]);
        $category = $stmt->fetch();
        return $category ?: null;
    }

    public function getCategoryById(int $id, string $lang): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, c.slug, ct.title, ct.h1, ct.description, ct.seo_title, ct.seo_description, ct.seo_robots
             FROM categories c
             JOIN category_translations ct ON ct.category_id = c.id AND ct.lang = :lang
             WHERE c.id = :id'
        );
        $stmt->execute(['id' => $id, 'lang' => $lang]);
        $category = $stmt->fetch();
        return $category ?: null;
    }

    public function getCategoryHighlights(int $categoryId, string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT title, body FROM category_highlights WHERE category_id = :category_id AND lang = :lang ORDER BY sort_order ASC'
        );
        $stmt->execute(['category_id' => $categoryId, 'lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getProductsByCategory(int $categoryId, string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.id, p.slug, p.sku, pt.title, pt.short_description
             FROM products p
             JOIN product_translations pt ON pt.product_id = p.id AND pt.lang = :lang
             WHERE p.category_id = :category_id
             ORDER BY p.sort_order ASC'
        );
        $stmt->execute(['category_id' => $categoryId, 'lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getProductBySlug(string $slug, string $lang): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.id, p.slug, p.sku, p.category_id,
                    pt.title, pt.h1, pt.short_description, pt.description,
                    pt.seo_title, pt.seo_description, pt.seo_robots
             FROM products p
             JOIN product_translations pt ON pt.product_id = p.id AND pt.lang = :lang
             WHERE p.slug = :slug'
        );
        $stmt->execute(['slug' => $slug, 'lang' => $lang]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function getProductImages(int $productId): array
    {
        $stmt = $this->db->prepare('SELECT url FROM product_images WHERE product_id = :product_id ORDER BY sort_order ASC');
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getProductSpecs(int $productId, string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT label, value, value_type, unit
             FROM product_specs
             WHERE product_id = :product_id AND lang = :lang
             ORDER BY sort_order ASC'
        );
        $stmt->execute(['product_id' => $productId, 'lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getProductDocs(int $productId, string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT title, url FROM product_documents WHERE product_id = :product_id AND lang = :lang ORDER BY sort_order ASC'
        );
        $stmt->execute(['product_id' => $productId, 'lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getFaqs(string $entityType, int $entityId, string $lang): array
    {
        $stmt = $this->db->prepare(
            'SELECT question, answer FROM faqs WHERE entity_type = :entity_type AND entity_id = :entity_id AND lang = :lang ORDER BY sort_order ASC'
        );
        $stmt->execute(['entity_type' => $entityType, 'entity_id' => $entityId, 'lang' => $lang]);
        return $stmt->fetchAll();
    }

    public function getPartner(): ?array
    {
        $stmt = $this->db->prepare('SELECT name, url, rel_attr, logo_url, description FROM partners WHERE is_primary = 1 LIMIT 1');
        $stmt->execute();
        $partner = $stmt->fetch();
        return $partner ?: null;
    }
}
