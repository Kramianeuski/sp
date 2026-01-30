<?php
$items = $data['items'] ?? [];
$iconMap = [
    'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 4 5v6c0 5.3 3.4 9.9 8 11 4.6-1.1 8-5.7 8-11V5l-8-3Zm0 17.1c-3-1-5-4.1-5-7.7V6.3l5-1.9 5 1.9v5.1c0 3.6-2 6.7-5 7.7Z"/></svg>',
    'settings' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m19.1 12.9.9-.7-1-1.8-1.1.4a6.7 6.7 0 0 0-1.2-.7l-.2-1.2h-2l-.2 1.2c-.4.2-.8.4-1.2.7l-1.1-.4-1 1.8.9.7a6.8 6.8 0 0 0 0 1.4l-.9.7 1 1.8 1.1-.4c.4.3.8.5 1.2.7l.2 1.2h2l.2-1.2c.4-.2.8-.4 1.2-.7l1.1.4 1-1.8-.9-.7a6.8 6.8 0 0 0 0-1.4ZM12 15.5A3.5 3.5 0 1 1 12 8a3.5 3.5 0 0 1 0 7.5Z"/></svg>',
    'layers' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 9 5-9 5-9-5 9-5Zm0 7.5 6.5-3.6L12 4.3 5.5 6.9 12 10.5Zm0 3 7.5-4.1 1.5.9L12 16.8 3 10.3l1.5-.9L12 13.5Zm0 3 7.5-4.1 1.5.9L12 19.8 3 13.3l1.5-.9L12 16.5Z"/></svg>',
    'briefcase' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 4h6a1 1 0 0 1 1 1v2h4a2 2 0 0 1 2 2v3H2V9a2 2 0 0 1 2-2h4V5a1 1 0 0 1 1-1Zm1 3h4V5h-4v2Zm12 6v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5h8v2h4v-2h8Z"/></svg>',
];
?>
<section class="section section-features">
    <div class="container">
        <div class="features-grid">
            <?php foreach ($items as $item) : ?>
                <div class="feature-card">
                    <div class="feature-icon">
                        <?= $iconMap[$item['icon'] ?? ''] ?? '' ?>
                    </div>
                    <h3><?= htmlspecialchars(t($item['title_key'] ?? '', $language), ENT_QUOTES) ?></h3>
                    <p><?= htmlspecialchars(t($item['text_key'] ?? '', $language), ENT_QUOTES) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
