<?php
$titleKey = $data['title_key'] ?? '';
$partners = partners_list($language, null, true);
$loopPartners = $partners ? array_merge($partners, $partners) : [];
?>
<?php if (!empty($partners)) : ?>
<section class="section section-partners-carousel">
    <div class="container">
        <?php if ($titleKey) : ?>
            <div class="text-block">
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
            </div>
        <?php endif; ?>
        <div class="partners-carousel" aria-label="<?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?>" data-partners-carousel>
            <button class="partners-carousel-nav partners-carousel-prev" type="button" aria-label="<?= htmlspecialchars(t('carousel.prev', $language), ENT_QUOTES) ?>">←</button>
            <div class="partners-carousel-track">
                <?php foreach ($loopPartners as $partner) : ?>
                    <a class="partners-carousel-item" href="<?= htmlspecialchars($partner['url'], ENT_QUOTES) ?>" target="_blank" rel="nofollow sponsored">
                        <?php if (!empty($partner['logo_small_path'])) : ?>
                            <img src="<?= htmlspecialchars($partner['logo_small_path'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($partner['name'], ENT_QUOTES) ?>" loading="lazy">
                        <?php else : ?>
                            <span><?= htmlspecialchars($partner['name'], ENT_QUOTES) ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <button class="partners-carousel-nav partners-carousel-next" type="button" aria-label="<?= htmlspecialchars(t('carousel.next', $language), ENT_QUOTES) ?>">→</button>
        </div>
    </div>
</section>
<script>
    const carousel = document.querySelector('[data-partners-carousel]');
    if (carousel) {
        const track = carousel.querySelector('.partners-carousel-track');
        const prev = carousel.querySelector('.partners-carousel-prev');
        const next = carousel.querySelector('.partners-carousel-next');
        const scrollAmount = () => Math.min(track.clientWidth, 320);
        prev?.addEventListener('click', () => {
            track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });
        next?.addEventListener('click', () => {
            track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });
    }
</script>
<?php endif; ?>
