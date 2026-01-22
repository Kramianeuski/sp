<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

$langOptions = ['ru', 'en'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        db_execute(
            'UPDATE products SET slug = ?, sku = ?, category_id = ?, name_ru = ?, name_en = ?, short_desc_ru = ?, short_desc_en = ?, description_ru = ?, description_en = ?, seo_title_ru = ?, seo_title_en = ?, seo_description_ru = ?, seo_description_en = ?, seo_h1_ru = ?, seo_h1_en = ?, canonical = ?, noindex = ?, og_title_ru = ?, og_title_en = ?, og_description_ru = ?, og_description_en = ?, twitter_title_ru = ?, twitter_title_en = ?, twitter_description_ru = ?, twitter_description_en = ? WHERE id = ?',
            [
                $_POST['slug'],
                $_POST['sku'],
                (int) $_POST['category_id'],
                $_POST['name_ru'],
                $_POST['name_en'],
                $_POST['short_desc_ru'],
                $_POST['short_desc_en'],
                $_POST['description_ru'],
                $_POST['description_en'],
                $_POST['seo_title_ru'],
                $_POST['seo_title_en'],
                $_POST['seo_description_ru'],
                $_POST['seo_description_en'],
                $_POST['seo_h1_ru'],
                $_POST['seo_h1_en'],
                $_POST['canonical'],
                isset($_POST['noindex']) ? 1 : 0,
                $_POST['og_title_ru'],
                $_POST['og_title_en'],
                $_POST['og_description_ru'],
                $_POST['og_description_en'],
                $_POST['twitter_title_ru'],
                $_POST['twitter_title_en'],
                $_POST['twitter_description_ru'],
                $_POST['twitter_description_en'],
                (int) $_POST['id'],
            ]
        );
    }

    if ($_POST['action'] === 'create') {
        db_execute(
            'INSERT INTO products (slug, sku, category_id, name_ru, name_en, short_desc_ru, short_desc_en, description_ru, description_en) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $_POST['new_slug'],
                $_POST['new_sku'],
                (int) $_POST['new_category_id'],
                $_POST['new_name_ru'],
                $_POST['new_name_en'],
                $_POST['new_short_desc_ru'],
                $_POST['new_short_desc_en'],
                $_POST['new_description_ru'],
                $_POST['new_description_en'],
            ]
        );
    }

    if ($_POST['action'] === 'specs') {
        foreach ($_POST['specs'] as $id => $spec) {
            db_execute(
                'UPDATE product_specs SET label_ru = ?, value_ru = ?, label_en = ?, value_en = ? WHERE id = ?',
                [$spec['label_ru'], $spec['value_ru'], $spec['label_en'], $spec['value_en'], (int) $id]
            );
        }
    }

    if ($_POST['action'] === 'features') {
        foreach ($_POST['features'] as $id => $feature) {
            db_execute(
                'UPDATE product_features SET text_ru = ?, text_en = ? WHERE id = ?',
                [$feature['text_ru'], $feature['text_en'], (int) $id]
            );
        }
    }

    if ($_POST['action'] === 'documents') {
        foreach ($_POST['documents'] as $id => $doc) {
            db_execute(
                'UPDATE product_documents SET label_ru = ?, label_en = ?, file_path = ? WHERE id = ?',
                [$doc['label_ru'], $doc['label_en'], $doc['file_path'], (int) $id]
            );
        }
    }

    if ($_POST['action'] === 'certificates') {
        foreach ($_POST['certificates'] as $id => $certificate) {
            db_execute(
                'UPDATE product_certificates SET title_ru = ?, title_en = ?, description_ru = ?, description_en = ? WHERE id = ?',
                [$certificate['title_ru'], $certificate['title_en'], $certificate['description_ru'], $certificate['description_en'], (int) $id]
            );
        }
    }

    if ($_POST['action'] === 'faq') {
        foreach ($_POST['faq'] as $id => $item) {
            db_execute(
                'UPDATE faq_items SET question_ru = ?, answer_ru = ?, question_en = ?, answer_en = ? WHERE id = ?',
                [$item['question_ru'], $item['answer_ru'], $item['question_en'], $item['answer_en'], (int) $id]
            );
        }
    }

    header('Location: /admin/products.php');
    exit;
}

$products = db_fetch_all('SELECT id, slug, sku, category_id, name_ru, name_en, short_desc_ru, short_desc_en, description_ru, description_en, seo_title_ru, seo_title_en, seo_description_ru, seo_description_en, seo_h1_ru, seo_h1_en, canonical, noindex, og_title_ru, og_title_en, og_description_ru, og_description_en, twitter_title_ru, twitter_title_en, twitter_description_ru, twitter_description_en FROM products ORDER BY id ASC');
$categories = db_fetch_all('SELECT id, name_ru FROM categories ORDER BY id ASC');
$categoryMap = [];
foreach ($categories as $category) {
    $categoryMap[$category['id']] = $category['name_ru'];
}
$activeProduct = $products[0] ?? null;
$productSpecs = $activeProduct ? db_fetch_all('SELECT id, label_ru, value_ru, label_en, value_en FROM product_specs WHERE product_id = ? ORDER BY position ASC', [(int) $activeProduct['id']]) : [];
$productFeatures = $activeProduct ? db_fetch_all('SELECT id, feature_type, text_ru, text_en FROM product_features WHERE product_id = ? ORDER BY position ASC', [(int) $activeProduct['id']]) : [];
$productDocuments = $activeProduct ? db_fetch_all('SELECT id, label_ru, label_en, file_path FROM product_documents WHERE product_id = ? ORDER BY position ASC', [(int) $activeProduct['id']]) : [];
$productCertificates = $activeProduct ? db_fetch_all('SELECT id, title_ru, title_en, description_ru, description_en FROM product_certificates WHERE product_id = ? ORDER BY position ASC', [(int) $activeProduct['id']]) : [];
$productFaq = $activeProduct ? db_fetch_all('SELECT id, question_ru, answer_ru, question_en, answer_en FROM faq_items WHERE scope = \"product\" AND scope_id = ? ORDER BY position ASC', [(int) $activeProduct['id']]) : [];

admin_header('Товары');
?>
<section class="card">
    <h2>Список товаров</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>SKU</th>
            <th>Название (RU)</th>
            <th>Категория</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= (int) $product['id'] ?></td>
                <td><?= htmlspecialchars($product['sku']) ?></td>
                <td><?= htmlspecialchars($product['name_ru']) ?></td>
                <td><?= htmlspecialchars($categoryMap[$product['category_id']] ?? '') ?></td>
                <td><span class="badge">Опубликован</span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php if ($activeProduct) : ?>
<section class="card">
    <h2>Редактирование товара</h2>
    <form method="post">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= (int) $activeProduct['id'] ?>">
        <div class="form-grid">
            <div>
                <label>Slug</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($activeProduct['slug']) ?>">
            </div>
            <div>
                <label>SKU</label>
                <input type="text" name="sku" value="<?= htmlspecialchars($activeProduct['sku']) ?>">
            </div>
            <div>
                <label>Категория</label>
                <select name="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= (int) $category['id'] ?>" <?= (int) $category['id'] === (int) $activeProduct['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name_ru']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Название (RU)</label>
                <input type="text" name="name_ru" value="<?= htmlspecialchars($activeProduct['name_ru']) ?>">
            </div>
            <div>
                <label>Название (EN)</label>
                <input type="text" name="name_en" value="<?= htmlspecialchars($activeProduct['name_en']) ?>">
            </div>
            <div>
                <label>Краткое описание (RU)</label>
                <textarea name="short_desc_ru"><?= htmlspecialchars($activeProduct['short_desc_ru']) ?></textarea>
            </div>
            <div>
                <label>Краткое описание (EN)</label>
                <textarea name="short_desc_en"><?= htmlspecialchars($activeProduct['short_desc_en']) ?></textarea>
            </div>
            <div>
                <label>Описание (RU)</label>
                <textarea name="description_ru"><?= htmlspecialchars($activeProduct['description_ru']) ?></textarea>
            </div>
            <div>
                <label>Описание (EN)</label>
                <textarea name="description_en"><?= htmlspecialchars($activeProduct['description_en']) ?></textarea>
            </div>
            <div>
                <label>SEO Title (RU)</label>
                <input type="text" name="seo_title_ru" value="<?= htmlspecialchars($activeProduct['seo_title_ru']) ?>">
            </div>
            <div>
                <label>SEO Title (EN)</label>
                <input type="text" name="seo_title_en" value="<?= htmlspecialchars($activeProduct['seo_title_en']) ?>">
            </div>
            <div>
                <label>SEO Description (RU)</label>
                <textarea name="seo_description_ru"><?= htmlspecialchars($activeProduct['seo_description_ru']) ?></textarea>
            </div>
            <div>
                <label>SEO Description (EN)</label>
                <textarea name="seo_description_en"><?= htmlspecialchars($activeProduct['seo_description_en']) ?></textarea>
            </div>
            <div>
                <label>H1 (RU)</label>
                <input type="text" name="seo_h1_ru" value="<?= htmlspecialchars($activeProduct['seo_h1_ru']) ?>">
            </div>
            <div>
                <label>H1 (EN)</label>
                <input type="text" name="seo_h1_en" value="<?= htmlspecialchars($activeProduct['seo_h1_en']) ?>">
            </div>
            <div>
                <label>Canonical</label>
                <input type="text" name="canonical" value="<?= htmlspecialchars($activeProduct['canonical']) ?>">
            </div>
            <div>
                <label>OG Title (RU)</label>
                <input type="text" name="og_title_ru" value="<?= htmlspecialchars($activeProduct['og_title_ru']) ?>">
            </div>
            <div>
                <label>OG Title (EN)</label>
                <input type="text" name="og_title_en" value="<?= htmlspecialchars($activeProduct['og_title_en']) ?>">
            </div>
            <div>
                <label>OG Description (RU)</label>
                <textarea name="og_description_ru"><?= htmlspecialchars($activeProduct['og_description_ru']) ?></textarea>
            </div>
            <div>
                <label>OG Description (EN)</label>
                <textarea name="og_description_en"><?= htmlspecialchars($activeProduct['og_description_en']) ?></textarea>
            </div>
            <div>
                <label>Twitter Title (RU)</label>
                <input type="text" name="twitter_title_ru" value="<?= htmlspecialchars($activeProduct['twitter_title_ru']) ?>">
            </div>
            <div>
                <label>Twitter Title (EN)</label>
                <input type="text" name="twitter_title_en" value="<?= htmlspecialchars($activeProduct['twitter_title_en']) ?>">
            </div>
            <div>
                <label>Twitter Description (RU)</label>
                <textarea name="twitter_description_ru"><?= htmlspecialchars($activeProduct['twitter_description_ru']) ?></textarea>
            </div>
            <div>
                <label>Twitter Description (EN)</label>
                <textarea name="twitter_description_en"><?= htmlspecialchars($activeProduct['twitter_description_en']) ?></textarea>
            </div>
            <div>
                <label>Индексирование</label>
                <label class="notice"><input type="checkbox" name="noindex" <?= $activeProduct['noindex'] ? 'checked' : '' ?>> noindex</label>
            </div>
        </div>
        <button class="button" type="submit">Сохранить</button>
    </form>
</section>
<section class="card">
    <h2>Характеристики</h2>
    <form method="post">
        <input type="hidden" name="action" value="specs">
        <table class="table">
            <thead>
            <tr>
                <th>Label RU</th>
                <th>Value RU</th>
                <th>Label EN</th>
                <th>Value EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productSpecs as $spec) : ?>
                <tr>
                    <td><input type="text" name="specs[<?= (int) $spec['id'] ?>][label_ru]" value="<?= htmlspecialchars($spec['label_ru']) ?>"></td>
                    <td><input type="text" name="specs[<?= (int) $spec['id'] ?>][value_ru]" value="<?= htmlspecialchars($spec['value_ru']) ?>"></td>
                    <td><input type="text" name="specs[<?= (int) $spec['id'] ?>][label_en]" value="<?= htmlspecialchars($spec['label_en']) ?>"></td>
                    <td><input type="text" name="specs[<?= (int) $spec['id'] ?>][value_en]" value="<?= htmlspecialchars($spec['value_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить характеристики</button>
    </form>
</section>
<section class="card">
    <h2>Особенности и преимущества</h2>
    <form method="post">
        <input type="hidden" name="action" value="features">
        <table class="table">
            <thead>
            <tr>
                <th>Тип</th>
                <th>Текст RU</th>
                <th>Текст EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productFeatures as $feature) : ?>
                <tr>
                    <td><?= htmlspecialchars($feature['feature_type']) ?></td>
                    <td><input type="text" name="features[<?= (int) $feature['id'] ?>][text_ru]" value="<?= htmlspecialchars($feature['text_ru']) ?>"></td>
                    <td><input type="text" name="features[<?= (int) $feature['id'] ?>][text_en]" value="<?= htmlspecialchars($feature['text_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить особенности</button>
    </form>
</section>
<section class="card">
    <h2>Документация</h2>
    <form method="post">
        <input type="hidden" name="action" value="documents">
        <table class="table">
            <thead>
            <tr>
                <th>Label RU</th>
                <th>Label EN</th>
                <th>Файл</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productDocuments as $doc) : ?>
                <tr>
                    <td><input type="text" name="documents[<?= (int) $doc['id'] ?>][label_ru]" value="<?= htmlspecialchars($doc['label_ru']) ?>"></td>
                    <td><input type="text" name="documents[<?= (int) $doc['id'] ?>][label_en]" value="<?= htmlspecialchars($doc['label_en']) ?>"></td>
                    <td><input type="text" name="documents[<?= (int) $doc['id'] ?>][file_path]" value="<?= htmlspecialchars($doc['file_path']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить документацию</button>
    </form>
</section>
<section class="card">
    <h2>Сертификаты и гарантия</h2>
    <form method="post">
        <input type="hidden" name="action" value="certificates">
        <table class="table">
            <thead>
            <tr>
                <th>Title RU</th>
                <th>Title EN</th>
                <th>Description RU</th>
                <th>Description EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productCertificates as $certificate) : ?>
                <tr>
                    <td><input type="text" name="certificates[<?= (int) $certificate['id'] ?>][title_ru]" value="<?= htmlspecialchars($certificate['title_ru']) ?>"></td>
                    <td><input type="text" name="certificates[<?= (int) $certificate['id'] ?>][title_en]" value="<?= htmlspecialchars($certificate['title_en']) ?>"></td>
                    <td><input type="text" name="certificates[<?= (int) $certificate['id'] ?>][description_ru]" value="<?= htmlspecialchars($certificate['description_ru']) ?>"></td>
                    <td><input type="text" name="certificates[<?= (int) $certificate['id'] ?>][description_en]" value="<?= htmlspecialchars($certificate['description_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить сертификаты</button>
    </form>
</section>
<section class="card">
    <h2>FAQ товара</h2>
    <form method="post">
        <input type="hidden" name="action" value="faq">
        <table class="table">
            <thead>
            <tr>
                <th>Вопрос RU</th>
                <th>Ответ RU</th>
                <th>Question EN</th>
                <th>Answer EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productFaq as $item) : ?>
                <tr>
                    <td><input type="text" name="faq[<?= (int) $item['id'] ?>][question_ru]" value="<?= htmlspecialchars($item['question_ru']) ?>"></td>
                    <td><input type="text" name="faq[<?= (int) $item['id'] ?>][answer_ru]" value="<?= htmlspecialchars($item['answer_ru']) ?>"></td>
                    <td><input type="text" name="faq[<?= (int) $item['id'] ?>][question_en]" value="<?= htmlspecialchars($item['question_en']) ?>"></td>
                    <td><input type="text" name="faq[<?= (int) $item['id'] ?>][answer_en]" value="<?= htmlspecialchars($item['answer_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить FAQ</button>
    </form>
</section>
<?php endif; ?>
<section class="card">
    <h2>Добавить новый товар</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        <div class="form-grid">
            <div>
                <label>Slug</label>
                <input type="text" name="new_slug" placeholder="sp01-0301">
            </div>
            <div>
                <label>SKU</label>
                <input type="text" name="new_sku" placeholder="SP01-0301">
            </div>
            <div>
                <label>Категория</label>
                <select name="new_category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= (int) $category['id'] ?>"><?= htmlspecialchars($category['name_ru']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Название (RU)</label>
                <input type="text" name="new_name_ru">
            </div>
            <div>
                <label>Название (EN)</label>
                <input type="text" name="new_name_en">
            </div>
            <div>
                <label>Краткое описание (RU)</label>
                <textarea name="new_short_desc_ru"></textarea>
            </div>
            <div>
                <label>Краткое описание (EN)</label>
                <textarea name="new_short_desc_en"></textarea>
            </div>
            <div>
                <label>Описание (RU)</label>
                <textarea name="new_description_ru"></textarea>
            </div>
            <div>
                <label>Описание (EN)</label>
                <textarea name="new_description_en"></textarea>
            </div>
        </div>
        <button class="button" type="submit">Создать</button>
    </form>
</section>
<?php
admin_footer();
