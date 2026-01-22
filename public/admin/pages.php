<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        db_execute(
            'UPDATE pages SET slug = ?, title_ru = ?, title_en = ?, text_ru = ?, text_en = ?, seo_title_ru = ?, seo_title_en = ?, seo_description_ru = ?, seo_description_en = ?, seo_h1_ru = ?, seo_h1_en = ?, canonical = ?, noindex = ?, og_title_ru = ?, og_title_en = ?, og_description_ru = ?, og_description_en = ?, twitter_title_ru = ?, twitter_title_en = ?, twitter_description_ru = ?, twitter_description_en = ?, address_ru = ?, address_en = ?, email = ?, phone = ? WHERE id = ?',
            [
                $_POST['slug'],
                $_POST['title_ru'],
                $_POST['title_en'],
                $_POST['text_ru'],
                $_POST['text_en'],
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
                $_POST['address_ru'],
                $_POST['address_en'],
                $_POST['email'],
                $_POST['phone'],
                (int) $_POST['id'],
            ]
        );
    }

    if ($_POST['action'] === 'create') {
        db_execute(
            'INSERT INTO pages (slug, title_ru, title_en, text_ru, text_en) VALUES (?, ?, ?, ?, ?)',
            [
                $_POST['new_slug'],
                $_POST['new_title_ru'],
                $_POST['new_title_en'],
                $_POST['new_text_ru'],
                $_POST['new_text_en'],
            ]
        );
    }

    header('Location: /admin/pages.php');
    exit;
}

$pages = db_fetch_all('SELECT id, slug, title_ru, title_en, text_ru, text_en, seo_title_ru, seo_title_en, seo_description_ru, seo_description_en, seo_h1_ru, seo_h1_en, canonical, noindex, og_title_ru, og_title_en, og_description_ru, og_description_en, twitter_title_ru, twitter_title_en, twitter_description_ru, twitter_description_en, address_ru, address_en, email, phone FROM pages ORDER BY id ASC');
$activePage = $pages[0] ?? null;

admin_header('Страницы');
?>
<section class="card">
    <h2>Контентные страницы</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Slug</th>
            <th>Заголовок (RU)</th>
            <th>Индексирование</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pages as $page) : ?>
            <tr>
                <td><?= (int) $page['id'] ?></td>
                <td><?= htmlspecialchars($page['slug']) ?></td>
                <td><?= htmlspecialchars($page['title_ru']) ?></td>
                <td><span class="badge"><?= $page['noindex'] ? 'noindex' : 'index' ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php if ($activePage) : ?>
<section class="card">
    <h2>Редактирование страницы</h2>
    <form method="post">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= (int) $activePage['id'] ?>">
        <div class="form-grid">
            <div>
                <label>Slug</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($activePage['slug']) ?>">
            </div>
            <div>
                <label>Заголовок (RU)</label>
                <input type="text" name="title_ru" value="<?= htmlspecialchars($activePage['title_ru']) ?>">
            </div>
            <div>
                <label>Заголовок (EN)</label>
                <input type="text" name="title_en" value="<?= htmlspecialchars($activePage['title_en']) ?>">
            </div>
            <div>
                <label>Текст (RU)</label>
                <textarea name="text_ru"><?= htmlspecialchars($activePage['text_ru']) ?></textarea>
            </div>
            <div>
                <label>Текст (EN)</label>
                <textarea name="text_en"><?= htmlspecialchars($activePage['text_en']) ?></textarea>
            </div>
            <div>
                <label>SEO Title (RU)</label>
                <input type="text" name="seo_title_ru" value="<?= htmlspecialchars($activePage['seo_title_ru']) ?>">
            </div>
            <div>
                <label>SEO Title (EN)</label>
                <input type="text" name="seo_title_en" value="<?= htmlspecialchars($activePage['seo_title_en']) ?>">
            </div>
            <div>
                <label>SEO Description (RU)</label>
                <textarea name="seo_description_ru"><?= htmlspecialchars($activePage['seo_description_ru']) ?></textarea>
            </div>
            <div>
                <label>SEO Description (EN)</label>
                <textarea name="seo_description_en"><?= htmlspecialchars($activePage['seo_description_en']) ?></textarea>
            </div>
            <div>
                <label>H1 (RU)</label>
                <input type="text" name="seo_h1_ru" value="<?= htmlspecialchars($activePage['seo_h1_ru']) ?>">
            </div>
            <div>
                <label>H1 (EN)</label>
                <input type="text" name="seo_h1_en" value="<?= htmlspecialchars($activePage['seo_h1_en']) ?>">
            </div>
            <div>
                <label>Canonical</label>
                <input type="text" name="canonical" value="<?= htmlspecialchars($activePage['canonical']) ?>">
            </div>
            <div>
                <label>OG Title (RU)</label>
                <input type="text" name="og_title_ru" value="<?= htmlspecialchars($activePage['og_title_ru']) ?>">
            </div>
            <div>
                <label>OG Title (EN)</label>
                <input type="text" name="og_title_en" value="<?= htmlspecialchars($activePage['og_title_en']) ?>">
            </div>
            <div>
                <label>OG Description (RU)</label>
                <textarea name="og_description_ru"><?= htmlspecialchars($activePage['og_description_ru']) ?></textarea>
            </div>
            <div>
                <label>OG Description (EN)</label>
                <textarea name="og_description_en"><?= htmlspecialchars($activePage['og_description_en']) ?></textarea>
            </div>
            <div>
                <label>Twitter Title (RU)</label>
                <input type="text" name="twitter_title_ru" value="<?= htmlspecialchars($activePage['twitter_title_ru']) ?>">
            </div>
            <div>
                <label>Twitter Title (EN)</label>
                <input type="text" name="twitter_title_en" value="<?= htmlspecialchars($activePage['twitter_title_en']) ?>">
            </div>
            <div>
                <label>Twitter Description (RU)</label>
                <textarea name="twitter_description_ru"><?= htmlspecialchars($activePage['twitter_description_ru']) ?></textarea>
            </div>
            <div>
                <label>Twitter Description (EN)</label>
                <textarea name="twitter_description_en"><?= htmlspecialchars($activePage['twitter_description_en']) ?></textarea>
            </div>
            <div>
                <label>Контактный адрес (RU)</label>
                <input type="text" name="address_ru" value="<?= htmlspecialchars($activePage['address_ru']) ?>">
            </div>
            <div>
                <label>Контактный адрес (EN)</label>
                <input type="text" name="address_en" value="<?= htmlspecialchars($activePage['address_en']) ?>">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($activePage['email']) ?>">
            </div>
            <div>
                <label>Телефон</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($activePage['phone']) ?>">
            </div>
            <div>
                <label>Индексирование</label>
                <label class="notice"><input type="checkbox" name="noindex" <?= $activePage['noindex'] ? 'checked' : '' ?>> noindex</label>
            </div>
        </div>
        <button class="button" type="submit">Сохранить</button>
    </form>
</section>
<?php endif; ?>
<section class="card">
    <h2>Добавить страницу</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        <div class="form-grid">
            <div>
                <label>Slug</label>
                <input type="text" name="new_slug">
            </div>
            <div>
                <label>Заголовок (RU)</label>
                <input type="text" name="new_title_ru">
            </div>
            <div>
                <label>Заголовок (EN)</label>
                <input type="text" name="new_title_en">
            </div>
            <div>
                <label>Текст (RU)</label>
                <textarea name="new_text_ru"></textarea>
            </div>
            <div>
                <label>Текст (EN)</label>
                <textarea name="new_text_en"></textarea>
            </div>
        </div>
        <button class="button" type="submit">Создать</button>
    </form>
</section>
<?php
admin_footer();
