<?php
$sectionsData = $sections ?? [];
$pageSlug = $page['slug'] ?? '';
$isHome = $pageSlug === 'home';
$contentPageSlugs = [
    'custom-production',
    'quality',
    'about',
    'privacy-policy',
    'personal-data',
];
$useContentLayout = !$isHome && in_array($pageSlug, $contentPageSlugs, true);
$mainSections = [];
$asideSection = null;

foreach ($sectionsData as $section) {
    if (($section['template'] ?? '') === 'custom_production') {
        $asideSection = $section;
        continue;
    }
    $mainSections[] = $section;
}
?>
<?php if ($useContentLayout) : ?>
<main class="page">
    <section class="section section--hero">
        <div class="container">
            <nav class="breadcrumbs">
                <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
                <span>→</span>
                <span><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></span>
            </nav>
            <h1><?= htmlspecialchars($page['h1'] ?? '', ENT_QUOTES) ?></h1>
            <?php if (!empty($page['meta_description'])) : ?>
                <p class="lead"><?= htmlspecialchars($page['meta_description'], ENT_QUOTES) ?></p>
            <?php endif; ?>
        </div>
    </section>
    <section class="section section--content">
        <div class="container layout-two-columns">
            <article class="content prose">
                <?php foreach ($mainSections as $section) : ?>
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
            </article>
            <aside class="aside aside--sticky">
                <?php
                $data = $asideSection ? (json_decode($asideSection['data_json'] ?? '', true) ?: []) : [];
                include __DIR__ . '/blocks/contact-form.php';
                ?>
            </aside>
        </div>
    </section>
</main>
<?php else : ?>
    <?php if (!$isHome) : ?>
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
<?php endif; ?>
