<?php
$titleKey = $data['title_key'] ?? '';
$items = $data['items'] ?? [];
$faqItems = [];
foreach ($items as $item) {
    $question = t($item['question_key'] ?? '', $language);
    $answer = t($item['answer_key'] ?? '', $language);
    if ($question !== '' && !str_starts_with($question, '[[') && $answer !== '' && !str_starts_with($answer, '[[')) {
        $faqItems[] = [
            'question' => $question,
            'answer' => $answer,
        ];
    }
}
?>
<section class="section section-faq">
    <div class="container">
        <div class="faq-block">
            <?php if ($titleKey) : ?>
                <h2><?= htmlspecialchars(t($titleKey, $language), ENT_QUOTES) ?></h2>
            <?php endif; ?>
            <?php foreach ($faqItems as $item) : ?>
                <h3><?= htmlspecialchars($item['question'], ENT_QUOTES) ?></h3>
                <p><?= htmlspecialchars($item['answer'], ENT_QUOTES) ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php if ($faqItems) : ?>
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
