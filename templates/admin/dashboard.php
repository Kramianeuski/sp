<?php
ob_start();
?>
<h1>Dashboard</h1>
<div class="admin-grid">
    <div class="admin-card">
        <h2>Pages</h2>
        <p><?= e((string) $stats['pages']) ?></p>
    </div>
    <div class="admin-card">
        <h2>Categories</h2>
        <p><?= e((string) $stats['categories']) ?></p>
    </div>
    <div class="admin-card">
        <h2>Products</h2>
        <p><?= e((string) $stats['products']) ?></p>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
