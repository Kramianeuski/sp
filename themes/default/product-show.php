<?php $displayName = format_product_name($product['name'], $product['sku'] ?? null); ?>
<section class="page-header">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/"><?= htmlspecialchars(t('breadcrumb.home', $language), ENT_QUOTES) ?></a>
            <span>→</span>
            <a href="/<?= htmlspecialchars($language, ENT_QUOTES) ?>/products/<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>/">
                <?= htmlspecialchars($category['name'], ENT_QUOTES) ?>
            </a>
            <span>→</span>
            <span><?= htmlspecialchars($displayName, ENT_QUOTES) ?></span>
        </nav>
        <h1><?= htmlspecialchars($product['h1'] ?? $displayName, ENT_QUOTES) ?></h1>
        <p><?= htmlspecialchars($product['short_description'], ENT_QUOTES) ?></p>
    </div>
</section>
<?php $hasMultipleImages = count($images) > 1; ?>
<section class="section">
    <div class="container">
        <div class="product-layout">
            <div class="product-hero">
                <div class="product-gallery" data-product-gallery>
                    <?php if (!empty($images)) : ?>
                        <div class="product-gallery-track" data-gallery-track>
                            <?php foreach ($images as $index => $image) : ?>
                                <div class="product-gallery-slide" data-gallery-slide>
                                    <img
                                        src="<?= htmlspecialchars($image['path'], ENT_QUOTES) ?>"
                                        alt="<?= htmlspecialchars($image['alt_key'] ? t($image['alt_key'], $language) : $product['name'], ENT_QUOTES) ?>"
                                        loading="<?= $index === 0 ? 'eager' : 'lazy' ?>"
                                        <?= $index === 0 ? 'fetchpriority="high"' : '' ?>
                                    >
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($hasMultipleImages) : ?>
                            <button class="gallery-nav gallery-prev" type="button" data-gallery-prev aria-label="<?= htmlspecialchars(t('gallery.prev', $language), ENT_QUOTES) ?>">←</button>
                            <button class="gallery-nav gallery-next" type="button" data-gallery-next aria-label="<?= htmlspecialchars(t('gallery.next', $language), ENT_QUOTES) ?>">→</button>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="product-placeholder"></div>
                    <?php endif; ?>
                    <?php if ($hasMultipleImages) : ?>
                        <div class="product-gallery-thumbs" data-gallery-thumbs>
                            <?php foreach ($images as $index => $image) : ?>
                                <button class="product-thumb" type="button" data-gallery-thumb="<?= $index ?>" aria-label="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>">
                                    <img src="<?= htmlspecialchars($image['path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($image['alt_key'] ? t($image['alt_key'], $language) : $product['name'], ENT_QUOTES) ?>" loading="lazy">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-details">
                    <div class="product-meta">
                        <?php if (!empty($product['sku'])) : ?>
                            <span class="sku"><?= htmlspecialchars(t('product.sku', $language), ENT_QUOTES) ?> <?= htmlspecialchars($product['sku'], ENT_QUOTES) ?></span>
                        <?php endif; ?>
                        <span class="country-origin"><?= htmlspecialchars(t('product.country', $language), ENT_QUOTES) ?></span>
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
                    <?php if (!empty($partnerLinks)) : ?>
                        <div class="product-buy" data-product-buy>
                            <button class="product-buy-toggle" type="button" aria-expanded="false">
                                <span><?= htmlspecialchars(t('product.where_buy', $language), ENT_QUOTES) ?></span>
                                <span class="product-buy-icon" aria-hidden="true">+</span>
                            </button>
                            <div class="product-buy-panel" hidden>
                                <div class="partner-logos">
                                    <?php foreach ($partnerLinks as $partner) : ?>
                                        <a
                                            class="partner-logo"
                                            href="<?= htmlspecialchars($partner['product_url'], ENT_QUOTES) ?>"
                                            target="_blank"
                                            rel="nofollow sponsored noopener"
                                            title="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>"
                                            aria-label="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>"
                                        >
                                            <?php if (!empty($partner['logo_small_path'])) : ?>
                                                <img src="<?= htmlspecialchars($partner['logo_small_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>" loading="lazy">
                                            <?php else : ?>
                                                <span><?= htmlspecialchars(mb_substr($partner['name'], 0, 1), ENT_QUOTES) ?></span>
                                            <?php endif; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-description">
                <h2><?= htmlspecialchars(t('product.description_title', $language), ENT_QUOTES) ?></h2>
                <div class="text-block"><?= format_product_description($product['description'] ?? '') ?></div>
                <?php $faqItems = category_faq($category['code'] ?? '', $language); ?>
                <?php if ($faqItems) : ?>
                    <div class="faq-block">
                        <h2><?= htmlspecialchars(t('faq.title', $language), ENT_QUOTES) ?></h2>
                        <?php foreach ($faqItems as $item) : ?>
                            <h3><?= htmlspecialchars($item['question'], ENT_QUOTES) ?></h3>
                            <p><?= htmlspecialchars($item['answer'], ENT_QUOTES) ?></p>
                        <?php endforeach; ?>
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
    'name' => $displayName,
    'description' => strip_tags($product['description'] ?? ''),
    'image' => array_map(static fn(array $img) => config('base_url') . $img['path'], $images),
    'sku' => $product['sku'] ?? '',
    'brand' => [
        '@type' => 'Brand',
        'name' => 'System Power',
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php if (!empty($faqItems)) : ?>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn(array $item) => [
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $item['answer'],
        ],
    ], $faqItems),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php endif; ?>
<?php if ($hasMultipleImages) : ?>
<script>
    const gallery = document.querySelector('[data-product-gallery]');
    if (gallery) {
        const track = gallery.querySelector('[data-gallery-track]');
        const slides = Array.from(gallery.querySelectorAll('[data-gallery-slide]'));
        const prevButton = gallery.querySelector('[data-gallery-prev]');
        const nextButton = gallery.querySelector('[data-gallery-next]');
        const thumbs = Array.from(gallery.querySelectorAll('[data-gallery-thumb]'));
        let index = 0;
        const update = () => {
            track.style.transform = `translateX(-${index * 100}%)`;
            thumbs.forEach((thumb, idx) => {
                if (idx === index) {
                    thumb.classList.add('is-active');
                    thumb.setAttribute('aria-current', 'true');
                } else {
                    thumb.classList.remove('is-active');
                    thumb.removeAttribute('aria-current');
                }
            });
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
        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const nextIndex = Number(thumb.dataset.galleryThumb || 0);
                if (!Number.isNaN(nextIndex)) {
                    index = nextIndex;
                    update();
                }
            });
        });

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
        update();
    }
</script>
<?php endif; ?>
<?php if (!empty($partnerLinks)) : ?>
<script>
    const buySection = document.querySelector('[data-product-buy]');
    if (buySection) {
        const toggle = buySection.querySelector('.product-buy-toggle');
        const panel = buySection.querySelector('.product-buy-panel');
        toggle?.addEventListener('click', () => {
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            if (panel) {
                panel.hidden = isExpanded;
            }
        });
    }
</script>
<?php endif; ?>
