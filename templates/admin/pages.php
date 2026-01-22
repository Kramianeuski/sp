<?php
ob_start();
?>
<h1>Pages</h1>
<ul class="admin-list">
    <?php foreach ($pages as $page) : ?>
        <li>
            <a href="/admin/pages/<?= e((string) $page['id']) ?>"><?= e($page['slug']) ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
