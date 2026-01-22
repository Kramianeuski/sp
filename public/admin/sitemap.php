<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

admin_header('Sitemap');
?>
<section class="card">
    <h2>Файлы Sitemap</h2>
    <p class="notice">Файлы sitemap доступны в публичной зоне и включают страницы, категории и товары.</p>
    <ul>
        <li><a href="/sitemap.xml">/sitemap.xml</a></li>
        <li><a href="/sitemap-pages.xml">/sitemap-pages.xml</a></li>
        <li><a href="/sitemap-categories.xml">/sitemap-categories.xml</a></li>
        <li><a href="/sitemap-products.xml">/sitemap-products.xml</a></li>
    </ul>
</section>
<?php
admin_footer();
