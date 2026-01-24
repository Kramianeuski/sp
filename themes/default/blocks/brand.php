<section class="content-block intro-block">
    <div class="container">
        <div class="section-header">
            <h2><?= htmlspecialchars($blockData['title'], ENT_QUOTES) ?></h2>
        </div>
        <div class="intro-text"><?= nl2br(htmlspecialchars($blockData['body'], ENT_QUOTES)) ?></div>
    </div>
</section>
