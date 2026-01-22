<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'nav') {
        foreach ($_POST['nav'] as $id => $row) {
            db_execute(
                'UPDATE navigation_links SET label_ru = ?, label_en = ?, url_ru = ?, url_en = ? WHERE id = ?',
                [$row['label_ru'], $row['label_en'], $row['url_ru'], $row['url_en'], (int) $id]
            );
        }
    }

    if ($_POST['action'] === 'regions') {
        foreach ($_POST['regions'] as $id => $row) {
            db_execute(
                'UPDATE regions SET name_ru = ?, name_en = ? WHERE id = ?',
                [$row['name_ru'], $row['name_en'], (int) $id]
            );
        }
    }

    header('Location: /admin/translations.php');
    exit;
}

$navigation = db_fetch_all('SELECT id, label_ru, label_en, url_ru, url_en FROM navigation_links ORDER BY position ASC');
$regions = db_fetch_all('SELECT id, name_ru, name_en FROM regions ORDER BY position ASC');

admin_header('Переводы');
?>
<section class="card">
    <h2>Навигация</h2>
    <form method="post">
        <input type="hidden" name="action" value="nav">
        <table class="table">
            <thead>
            <tr>
                <th>URL RU</th>
                <th>URL EN</th>
                <th>Label RU</th>
                <th>Label EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($navigation as $item) : ?>
                <tr>
                    <td><input type="text" name="nav[<?= (int) $item['id'] ?>][url_ru]" value="<?= htmlspecialchars($item['url_ru']) ?>"></td>
                    <td><input type="text" name="nav[<?= (int) $item['id'] ?>][url_en]" value="<?= htmlspecialchars($item['url_en']) ?>"></td>
                    <td><input type="text" name="nav[<?= (int) $item['id'] ?>][label_ru]" value="<?= htmlspecialchars($item['label_ru']) ?>"></td>
                    <td><input type="text" name="nav[<?= (int) $item['id'] ?>][label_en]" value="<?= htmlspecialchars($item['label_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить навигацию</button>
    </form>
</section>
<section class="card">
    <h2>Регионы (где купить)</h2>
    <form method="post">
        <input type="hidden" name="action" value="regions">
        <table class="table">
            <thead>
            <tr>
                <th>Регион RU</th>
                <th>Регион EN</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($regions as $region) : ?>
                <tr>
                    <td><input type="text" name="regions[<?= (int) $region['id'] ?>][name_ru]" value="<?= htmlspecialchars($region['name_ru']) ?>"></td>
                    <td><input type="text" name="regions[<?= (int) $region['id'] ?>][name_en]" value="<?= htmlspecialchars($region['name_en']) ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить регионы</button>
    </form>
</section>
<?php
admin_footer();
