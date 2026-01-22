<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

$categoryRow = db_fetch_one('SELECT COUNT(*) AS count FROM categories') ?? ['count' => 0];
$productRow = db_fetch_one('SELECT COUNT(*) AS count FROM products') ?? ['count' => 0];
$pageRow = db_fetch_one('SELECT COUNT(*) AS count FROM pages') ?? ['count' => 0];
$fileRow = db_fetch_one('SELECT COUNT(*) AS count FROM files') ?? ['count' => 0];
$categoryCount = (int) $categoryRow['count'];
$productCount = (int) $productRow['count'];
$pageCount = (int) $pageRow['count'];
$fileCount = (int) $fileRow['count'];

admin_header('Админка System Power');
?>
<section class="card">
    <h2>Статус проекта</h2>
    <p>Бренд-портал System Power настроен для демонстрации продукции и передачи доверия официальному продавцу SISSOL.</p>
    <div class="form-grid">
        <div>
            <p class="notice">Категорий: <?= $categoryCount ?></p>
        </div>
        <div>
            <p class="notice">Товаров: <?= $productCount ?></p>
        </div>
        <div>
            <p class="notice">Страниц: <?= $pageCount ?></p>
        </div>
        <div>
            <p class="notice">Файлов: <?= $fileCount ?></p>
        </div>
    </div>
</section>
<section class="card">
    <h2>Быстрые действия</h2>
    <div class="form-grid">
        <div>
            <label>Добавить продукт</label>
            <input type="text" placeholder="Название модели">
        </div>
        <div>
            <label>Создать страницу</label>
            <input type="text" placeholder="Название страницы">
        </div>
        <div>
            <label>Загрузка файлов</label>
            <input type="file">
        </div>
    </div>
</section>
<?php
admin_footer();
