<?php
ob_start();
?>
<section class="hero hero-small">
    <div class="container">
        <h1><?= e($settings['not_found_title'] ?? '') ?></h1>
        <p class="lead"><?= nl2br(e($settings['not_found_text'] ?? '')) ?></p>
    </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
