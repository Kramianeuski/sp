<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>/">
                <?= htmlspecialchars($category['name'], ENT_QUOTES) ?>
            </a>
            <span>→</span>
            <span><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($product['h1'] ?? $product['name'], ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="product-layout">
            <div class="product-gallery">
                <?php if (!empty($images)) : ?>
                    <?php foreach ($images as $image) : ?>
                        <img src="<?= htmlspecialchars($image['path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($image['alt_key'] ? t($image['alt_key'], $language) : $product['name'], ENT_QUOTES) ?>">
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="product-placeholder"></div>
                <?php endif; ?>
            </div>
            <div class="product-details">
                <div class="product-description">
                    <h2><?= htmlspecialchars(t('product.description_title', $language), ENT_QUOTES) ?></h2>
                    <?php if (!empty($product['is_html'])) : ?>
                        <div class="text-block"><?= $product['description'] ?></div>
                    <?php else : ?>
                        <p><?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES)) ?></p>
                    <?php endif; ?>
                </div>
                <?php if (!empty($specs)) : ?>
                    <div class="product-specs">
                        <h2><?= htmlspecialchars(t('product.specs_title', $language), ENT_QUOTES) ?></h2>
                        <table>
                            <?php foreach ($specs as $spec) : ?>
                                <tr>
                                    <th><?= htmlspecialchars($spec['name'], ENT_QUOTES) ?></th>
                                    <td><?= htmlspecialchars($spec['value'], ENT_QUOTES) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product['name'],
    'description' => strip_tags($product['description'] ?? ''),
    'image' => array_map(static fn(array $img) => config('base_url') . $img['path'], $images),
    'sku' => $product['sku'] ?? '',
    'brand' => [
        '@type' => 'Brand',
        'name' => 'System Power',
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php if ($hasMultipleImages) : ?>
<script>
    const gallery = document.querySelector('[data-product-gallery]');
    if (gallery) {
        const track = gallery.querySelector('[data-gallery-track]');
        const slides = Array.from(gallery.querySelectorAll('[data-gallery-slide]'));
        const prevButton = gallery.querySelector('[data-gallery-prev]');
        const nextButton = gallery.querySelector('[data-gallery-next]');
        let index = 0;
        const update = () => {
            track.style.transform = `translateX(-${index * 100}%)`;
        };
        const goNext = () => {
            index = (index + 1) % slides.length;
            update();
        };
        const goPrev = () => {
            index = (index - 1 + slides.length) % slides.length;
            update();
        };
        prevButton?.addEventListener('click', goPrev);
        nextButton?.addEventListener('click', goNext);

        let startX = 0;
        let isDragging = false;
        gallery.addEventListener('touchstart', (event) => {
            startX = event.touches[0].clientX;
            isDragging = true;
        });
        gallery.addEventListener('touchend', (event) => {
            if (!isDragging) {
                return;
            }
            const endX = event.changedTouches[0].clientX;
            const delta = endX - startX;
            if (Math.abs(delta) > 40) {
                if (delta < 0) {
                    goNext();
                } else {
                    goPrev();
                }
            }
            isDragging = false;
        });
    }
</script>
<?php endif; ?>
