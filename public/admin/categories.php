<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        db_execute(
            'UPDATE categories SET slug = ?, name_ru = ?, name_en = ?, description_ru = ?, description_en = ?, seo_title_ru = ?, seo_title_en = ?, seo_description_ru = ?, seo_description_en = ?, seo_h1_ru = ?, seo_h1_en = ?, canonical = ?, noindex = ?, og_title_ru = ?, og_title_en = ?, og_description_ru = ?, og_description_en = ?, twitter_title_ru = ?, twitter_title_en = ?, twitter_description_ru = ?, twitter_description_en = ? WHERE id = ?',
            [
                $_POST['slug'],
                $_POST['name_ru'],
                $_POST['name_en'],
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
            'INSERT INTO categories (slug, name_ru, name_en, description_ru, description_en) VALUES (?, ?, ?, ?, ?)',
            [
                $_POST['new_slug'],
                $_POST['new_name_ru'],
                $_POST['new_name_en'],
                $_POST['new_description_ru'],
                $_POST['new_description_en'],
            ]
        );
    }

    if ($_POST['action'] === 'advantages') {
        foreach ($_POST['advantages'] as $id => $advantage) {
            db_execute(
                'UPDATE category_advantages SET text_ru = ?, text_en = ? WHERE id = ?',
                [$advantage['text_ru'], $advantage['text_en'], (int) $id]
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

    header('Location: /admin/categories.php');
    exit;
}

$categories = db_fetch_all('SELECT id, slug, name_ru, name_en, description_ru, description_en, seo_title_ru, seo_title_en, seo_description_ru, seo_description_en, seo_h1_ru, seo_h1_en, canonical, noindex, og_title_ru, og_title_en, og_description_ru, og_description_en, twitter_title_ru, twitter_title_en, twitter_description_ru, twitter_description_en FROM categories ORDER BY id ASC');
$activeCategory = $categories[0] ?? null;
$categoryAdvantages = $activeCategory ? db_fetch_all('SELECT id, text_ru, text_en FROM category_advantages WHERE category_id = ? ORDER BY position ASC', [(int) $activeCategory['id']]) : [];
$categoryFaq = $activeCategory ? db_fetch_all('SELECT id, question_ru, answer_ru, question_en, answer_en FROM faq_items WHERE scope = \"category\" AND scope_id = ? ORDER BY position ASC', [(int) $activeCategory['id']]) : [];

admin_header('Категории');
?>
<section class="card">
    <h2>Категории продукции</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Slug</th>
            <th>Название</th>
            <th>Описание</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?= (int) $category['id'] ?></td>
                <td><?= htmlspecialchars($category['slug']) ?></td>
                <td><?= htmlspecialchars($category['name_ru']) ?></td>
                <td><?= htmlspecialchars(mb_substr($category['description_ru'], 0, 120)) ?>...</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php if ($activeCategory) : ?>
<section class="card">
    <h2>Редактирование категории</h2>
    <form method="post">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= (int) $activeCategory['id'] ?>">
        <div class="form-grid">
            <div>
                <label>Slug</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($activeCategory['slug']) ?>">
            </div>
            <div>
                <label>Название (RU)</label>
                <input type="text" name="name_ru" value="<?= htmlspecialchars($activeCategory['name_ru']) ?>">
            </div>
            <div>
                <label>Название (EN)</label>
                <input type="text" name="name_en" value="<?= htmlspecialchars($activeCategory['name_en']) ?>">
            </div>
            <div>
                <label>Описание (RU)</label>
                <textarea name="description_ru"><?= htmlspecialchars($activeCategory['description_ru']) ?></textarea>
            </div>
            <div>
                <label>Описание (EN)</label>
                <textarea name="description_en"><?= htmlspecialchars($activeCategory['description_en']) ?></textarea>
            </div>
            <div>
                <label>SEO Title (RU)</label>
                <input type="text" name="seo_title_ru" value="<?= htmlspecialchars($activeCategory['seo_title_ru']) ?>">
            </div>
            <div>
                <label>SEO Title (EN)</label>
                <input type="text" name="seo_title_en" value="<?= htmlspecialchars($activeCategory['seo_title_en']) ?>">
            </div>
            <div>
                <label>SEO Description (RU)</label>
                <textarea name="seo_description_ru"><?= htmlspecialchars($activeCategory['seo_description_ru']) ?></textarea>
            </div>
            <div>
                <label>SEO Description (EN)</label>
                <textarea name="seo_description_en"><?= htmlspecialchars($activeCategory['seo_description_en']) ?></textarea>
            </div>
            <div>
                <label>H1 (RU)</label>
                <input type="text" name="seo_h1_ru" value="<?= htmlspecialchars($activeCategory['seo_h1_ru']) ?>">
            </div>
            <div>
                <label>H1 (EN)</label>
                <input type="text" name="seo_h1_en" value="<?= htmlspecialchars($activeCategory['seo_h1_en']) ?>">
            </div>
            <div>
                <label>Canonical</label>
                <input type="text" name="canonical" value="<?= htmlspecialchars($activeCategory['canonical']) ?>">
            </div>
            <div>
                <label>OG Title (RU)</label>
                <input type="text" name="og_title_ru" value="<?= htmlspecialchars($activeCategory['og_title_ru']) ?>">
            </div>
            <div>
                <label>OG Title (EN)</label>
                <input type="text" name="og_title_en" value="<?= htmlspecialchars($activeCategory['og_title_en']) ?>">
            </div>
            <div>
                <label>OG Description (RU)</label>
                <textarea name="og_description_ru"><?= htmlspecialchars($activeCategory['og_description_ru']) ?></textarea>
            </div>
            <div>
                <label>OG Description (EN)</label>
                <textarea name="og_description_en"><?= htmlspecialchars($activeCategory['og_description_en']) ?></textarea>
            </div>
            <div>
                <label>Twitter Title (RU)</label>
                <input type="text" name="twitter_title_ru" value="<?= htmlspecialchars($activeCategory['twitter_title_ru']) ?>">
            </div>
            <div>
                <label>Twitter Title (EN)</label>
                <input type="text" name="twitter_title_en" value="<?= htmlspecialchars($activeCategory['twitter_title_en']) ?>">
            </div>
            <div>
                <label>Twitter Description (RU)</label>
                <textarea name="twitter_description_ru"><?= htmlspecialchars($activeCategory['twitter_description_ru']) ?></textarea>
            </div>
            <div>
                <label>Twitter Description (EN)</label>
                <textarea name="twitter_description_en"><?= htmlspecialchars($activeCategory['twitter_description_en']) ?></textarea>
            </div>
            <div>
                <label>Индексирование</label>
                <label class="notice"><input type="checkbox" name="noindex" <?= $activeCategory['noindex'] ? 'checked' : '' ?>> noindex</label>
            </div>
        </div>
        <button class="button" type="submit">Сохранить</button>
    </form>
</section>
<section class="card">
    <h2>Преимущества категории</h2>
    <form method="post">
        <input type="hidden" name="action" value="advantages">
        <table class="table">
            <thead>
            <tr>
                <th>Текст RU</th>
                <th>Текст EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categoryAdvantages as $advantage) : ?>
                <tr>
                    <td><input type="text" name="advantages[<?= (int) $advantage['id'] ?>][text_ru]" value="<?= htmlspecialchars($advantage['text_ru']) ?>"></td>
                    <td><input type="text" name="advantages[<?= (int) $advantage['id'] ?>][text_en]" value="<?= htmlspecialchars($advantage['text_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить преимущества</button>
    </form>
</section>
<section class="card">
    <h2>FAQ категории</h2>
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
            <?php foreach ($categoryFaq as $item) : ?>
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
    <h2>Добавить новую категорию</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        <div class="form-grid">
            <div>
                <label>Slug</label>
                <input type="text" name="new_slug">
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
