<?php
ob_start();
?>
<h1>Categories</h1>
<ul class="admin-list">
    <?php foreach ($categories as $category) : ?>
        <li>
            <a href="/admin/categories/<?= e((string) $category['id']) ?>"><?= e($category['slug']) ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
