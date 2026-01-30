<?php
$items = $data['items'] ?? [];
$icons = [
    'shield' => '<path d="M12 2.2 4.5 5.1v5.3c0 4.5 3.1 8.6 7.5 9.7 4.4-1.1 7.5-5.2 7.5-9.7V5.1L12 2.2zm0 15.7c-3.1-1-5.3-3.9-5.3-7.1V6.5L12 4.4l5.3 2.1v4.3c0 3.2-2.2 6.1-5.3 7.1z"/>',
    'settings' => '<path d="M19.4 13.5c.1-.5.2-1 .2-1.5s-.1-1-.2-1.5l2.1-1.6-2-3.4-2.5 1a7.8 7.8 0 0 0-2.6-1.5L14 2h-4l-.4 2.9c-.9.3-1.8.8-2.6 1.5l-2.5-1-2 3.4 2.1 1.6c-.1.5-.2 1-.2 1.5s.1 1 .2 1.5l-2.1 1.6 2 3.4 2.5-1c.8.7 1.7 1.2 2.6 1.5L10 22h4l.4-2.9c.9-.3 1.8-.8 2.6-1.5l2.5 1 2-3.4-2.1-1.6zM12 15.2a3.2 3.2 0 1 1 0-6.4 3.2 3.2 0 0 1 0 6.4z"/>',
    'layers' => '<path d="M12 3 3 8l9 5 9-5-9-5zm0 8.6L5.1 8 12 4.4 18.9 8 12 11.6z"/><path d="m3 12 9 5 9-5v3l-9 5-9-5v-3z"/>',
    'briefcase' => '<path d="M7 6V4.5A2.5 2.5 0 0 1 9.5 2h5A2.5 2.5 0 0 1 17 4.5V6h3a2 2 0 0 1 2 2v3.5a2 2 0 0 1-2 2V18a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4.5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3zm2 0h6V4.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0-.5.5V6zm-5 5h16V8H4v3z"/>',
];
?>
<section class="section section-features">
    <div class="container">
        <div class="features-grid">
            <?php foreach ($items as $item) : ?>
                <div class="feature-card">
                    <div class="feature-icon">
                        <?php if (!empty($item['icon']) && !empty($icons[$item['icon']])) : ?>
                            <svg viewBox="0 0 24 24" aria-hidden="true" width="24" height="24">
                                <?= $icons[$item['icon']] ?>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <h3><?= htmlspecialchars(t($item['title_key'] ?? '', $language), ENT_QUOTES) ?></h3>
                    <p><?= htmlspecialchars(t($item['text_key'] ?? '', $language), ENT_QUOTES) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
