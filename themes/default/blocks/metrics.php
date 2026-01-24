<?php
$rows = preg_split('/\r?\n/', $blockData['body']);
$metrics = [];
foreach ($rows as $row) {
    $parts = array_map('trim', explode('|', $row));
    if (count($parts) === 2) {
        $metrics[] = [
            'value' => $parts[0],
            'label' => $parts[1],
        ];
    }
}
?>
<?php if ($metrics) : ?>
<section class="content-block metrics-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        </div>
        <div class="metrics-grid">
            <?php foreach ($metrics as $metric) : ?>
                <div class="metric-card">
                    <div class="metric-value"><?= htmlspecialchars($metric['value'], ENT_QUOTES) ?></div>
                    <div class="metric-label"><?= htmlspecialchars($metric['label'], ENT_QUOTES) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
