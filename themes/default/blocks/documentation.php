<?php
$documents = documents_list('brand', $language);
?>
<section class="content-block documentation-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
            <p><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></p>
        </div>
        <div class="documents-grid">
            <?php foreach ($documents as $doc) : ?>
                <a class="document-card" href="<?= htmlspecialchars($doc['file_path'], ENT_QUOTES) ?>" target="_blank" rel="noopener">
                    <span class="document-type"><?= htmlspecialchars($doc['doc_type'] ?: t('documents.type.default', $language), ENT_QUOTES) ?></span>
                    <span class="document-title"><?= htmlspecialchars($doc['title'], ENT_QUOTES) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
