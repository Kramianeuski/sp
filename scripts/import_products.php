<?php

declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

$sourcePath = __DIR__ . '/../reference/product.txt';
if (!file_exists($sourcePath)) {
    fwrite(STDERR, "File not found: {$sourcePath}\n");
    exit(1);
}

function slugify(string $value): string
{
    $value = trim(mb_strtolower($value));
    $value = preg_replace('/[^a-z0-9\-]+/u', '-', $value);
    $value = preg_replace('/-+/', '-', $value);
    $value = trim($value, '-');

    return $value !== '' ? $value : 'item';
}

function download_file(string $url, string $targetPath): bool
{
    if (file_exists($targetPath)) {
        return true;
    }

    $context = stream_context_create([
        'http' => [
            'timeout' => 20,
            'header' => "User-Agent: SystemPowerImporter/1.0\r\n",
        ],
    ]);

    $data = @file_get_contents($url, false, $context);
    if ($data === false) {
        return false;
    }
    $dir = dirname($targetPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    file_put_contents($targetPath, $data);

    return true;
}

$handle = fopen($sourcePath, 'rb');
$header = fgetcsv($handle, 0, ',');
if (!$header) {
    fwrite(STDERR, "Empty CSV\n");
    exit(1);
}
$map = array_flip($header);

$pdo = db();
$created = 0;
$updated = 0;
$skipped = 0;
$errors = [];

while (($row = fgetcsv($handle, 0, ',')) !== false) {
    $sku = trim($row[$map['sku']] ?? '');
    $nameRu = trim($row[$map['name_ru']] ?? '');
    if ($sku === '' || $nameRu === '') {
        $skipped++;
        continue;
    }

    $categoryCode = str_starts_with($sku, 'SP01') ? 'hatches' : 'electrical_cabinets';
    $categoryStmt = $pdo->prepare('SELECT id FROM categories WHERE code = ? LIMIT 1');
    $categoryStmt->execute([$categoryCode]);
    $categoryId = (int) $categoryStmt->fetchColumn();
    if (!$categoryId) {
        $errors[] = "Category not found for SKU {$sku}";
        continue;
    }

    $descriptionRu = trim($row[$map['description_ru']] ?? '');
    $shortRu = trim($row[$map['entry_1']] ?? $nameRu);
    $metaTitleRu = trim($row[$map['meta_title_ru']] ?? $nameRu);
    $metaDescriptionRu = trim($row[$map['meta_description_ru']] ?? '');
    $metaH1Ru = trim($row[$map['meta_h1_ru']] ?? $nameRu);
    $slugRu = trim($row[$map['seo_keyword_ru']] ?? '');
    if ($slugRu === '') {
        $slugRu = slugify($nameRu);
    }

    $productIdStmt = $pdo->prepare('SELECT id FROM products WHERE sku = ? LIMIT 1');
    $productIdStmt->execute([$sku]);
    $productId = (int) $productIdStmt->fetchColumn();

    $pdo->beginTransaction();
    if ($productId) {
        $update = $pdo->prepare('UPDATE products SET category_id = ?, is_active = 1, updated_at = NOW() WHERE id = ?');
        $update->execute([$categoryId, $productId]);
        $updated++;
    } else {
        $insert = $pdo->prepare('INSERT INTO products (category_id, sku, is_active, sort_order, created_at, updated_at) VALUES (?, ?, 1, 0, NOW(), NOW())');
        $insert->execute([$categoryId, $sku]);
        $productId = (int) $pdo->lastInsertId();
        $created++;
    }

    $updateI18n = $pdo->prepare('INSERT INTO product_i18n (product_id, locale, name, short_description, description, is_html, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, 1, NOW(), NOW())
        ON DUPLICATE KEY UPDATE name = VALUES(name), short_description = VALUES(short_description), description = VALUES(description), is_html = 1, updated_at = NOW()');
    foreach (['ru', 'en'] as $locale) {
        $updateI18n->execute([$productId, $locale, $nameRu, $shortRu, $descriptionRu]);
    }

    $updateSeo = $pdo->prepare('INSERT INTO seo_meta (entity_type, entity_id, locale, title, description, h1, slug, created_at, updated_at)
        VALUES ("product", ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description), h1 = VALUES(h1), slug = VALUES(slug), updated_at = NOW()');
    foreach (['ru', 'en'] as $locale) {
        $updateSeo->execute([$productId, $locale, $metaTitleRu, $metaDescriptionRu, $metaH1Ru, $slugRu]);
    }

    $pdo->prepare('DELETE FROM product_specs_i18n WHERE product_spec_id IN (SELECT id FROM product_specs WHERE product_id = ?)')->execute([$productId]);
    $pdo->prepare('DELETE FROM product_specs WHERE product_id = ?')->execute([$productId]);
    $attributeRaw = trim($row[$map['product_attribute']] ?? '');
    if ($attributeRaw !== '') {
        $specParts = explode('|', $attributeRaw);
        $specInsert = $pdo->prepare('INSERT INTO product_specs (product_id, spec_key, sort_order) VALUES (?, ?, ?)');
        $specI18nInsert = $pdo->prepare('INSERT INTO product_specs_i18n (product_spec_id, locale, name, value) VALUES (?, ?, ?, ?)');
        $order = 0;
        foreach ($specParts as $part) {
            $chunks = array_values(array_filter(explode(':', $part)));
            if (count($chunks) < 3) {
                continue;
            }
            $label = trim($chunks[1]);
            $value = trim($chunks[2]);
            $specKey = slugify($label);
            $specInsert->execute([$productId, $specKey, $order]);
            $specId = (int) $pdo->lastInsertId();
            foreach (['ru', 'en'] as $locale) {
                $specI18nInsert->execute([$specId, $locale, $label, $value]);
            }
            $order++;
        }
    }

    $pdo->prepare('DELETE FROM product_media WHERE product_id = ?')->execute([$productId]);

    $imageUrls = [];
    $mainImage = trim($row[$map['image']] ?? '');
    if ($mainImage !== '') {
        $imageUrls[] = $mainImage;
    }
    $additional = trim($row[$map['additional_images']] ?? '');
    if ($additional !== '') {
        foreach (explode('|', $additional) as $url) {
            $url = trim($url);
            if ($url !== '') {
                $imageUrls[] = $url;
            }
        }
    }

    $imageUrls = array_values(array_unique($imageUrls));
    foreach ($imageUrls as $index => $url) {
        $filename = basename(parse_url($url, PHP_URL_PATH) ?? '');
        if ($filename === '') {
            $filename = 'image-' . $index . '.jpg';
        }
        $targetPath = __DIR__ . '/../storage/uploads/products/' . $sku . '/' . $filename;
        if (!download_file($url, $targetPath)) {
            $errors[] = "Failed to download {$url}";
            continue;
        }
        $publicPath = '/storage/uploads/products/' . $sku . '/' . $filename;
        $mime = mime_content_type($targetPath) ?: 'image/jpeg';
        $size = filesize($targetPath) ?: 0;
        $width = null;
        $height = null;
        if (str_starts_with($mime, 'image/')) {
            $dimensions = @getimagesize($targetPath);
            if ($dimensions) {
                $width = $dimensions[0];
                $height = $dimensions[1];
            }
        }
        $mediaStmt = $pdo->prepare('SELECT id FROM media WHERE path = ? LIMIT 1');
        $mediaStmt->execute([$publicPath]);
        $mediaId = (int) $mediaStmt->fetchColumn();
        if (!$mediaId) {
            $insertMedia = $pdo->prepare('INSERT INTO media (path, type, mime, size_bytes, width, height, created_at, updated_at) VALUES (?, "image", ?, ?, ?, ?, NOW(), NOW())');
            $insertMedia->execute([$publicPath, $mime, $size, $width, $height]);
            $mediaId = (int) $pdo->lastInsertId();
        }
        $insertLink = $pdo->prepare('INSERT INTO product_media (product_id, media_id, sort_order, is_primary) VALUES (?, ?, ?, ?)');
        $insertLink->execute([$productId, $mediaId, $index, $index === 0 ? 1 : 0]);
    }

    $pdo->commit();
}

fclose($handle);

echo "Created: {$created}\n";
echo "Updated: {$updated}\n";
echo "Skipped: {$skipped}\n";
if ($errors) {
    echo "Errors:\n" . implode("\n", $errors) . "\n";
}
