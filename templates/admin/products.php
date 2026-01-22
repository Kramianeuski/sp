<?php
ob_start();
?>
<h1>Products</h1>
<ul class="admin-list">
    <?php foreach ($products as $product) : ?>
        <li>
            <a href="/admin/products/<?= e((string) $product['id']) ?>">
                <?= e($product['slug']) ?> · <?= e($product['sku']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
