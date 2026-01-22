<?php
ob_start();
?>
<h1>Not found</h1>
<p>Admin section not found.</p>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
