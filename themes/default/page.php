<?php
$sectionsData = $sections ?? [];
?>
<?php if (($page['slug'] ?? '') !== 'home') : ?>
<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <span><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></h1>
        <?php if (!empty($page['meta_description'])) : ?>
            <p><?= htmlspecialchars($page['meta_description'], ENT_QUOTES) ?></p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php foreach ($sectionsData as $section) : ?>
    <?php
    $template = $section['template'] ?? '';
    $data = json_decode($section['data_json'] ?? '', true) ?: [];
    $sectionKey = $section['section_key'] ?? '';
    $templatePath = __DIR__ . '/sections/' . $template . '.php';
    if (file_exists($templatePath)) {
        include $templatePath;
    }
    ?>
<?php endforeach; ?>
