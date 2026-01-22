<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

$homePage = db_fetch_one('SELECT id FROM pages WHERE slug = "home"');
$homePageId = (int) ($homePage['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $homePageId) {
    $blocks = [
        'hero' => [
            'title' => $_POST['hero_title_ru'] ?? '',
            'subtitle' => $_POST['hero_subtitle_ru'] ?? '',
            'text' => $_POST['hero_text_ru'] ?? '',
        ],
        'brand' => [
            'title' => $_POST['brand_title_ru'] ?? '',
            'text' => $_POST['brand_text_ru'] ?? '',
        ],
        'manufacturing' => [
            'title' => $_POST['manufacturing_title_ru'] ?? '',
            'text' => $_POST['manufacturing_text_ru'] ?? '',
            'list' => array_filter(array_map('trim', explode("\n", $_POST['manufacturing_list_ru'] ?? ''))),
        ],
        'where' => [
            'title' => $_POST['where_title_ru'] ?? '',
            'text' => $_POST['where_text_ru'] ?? '',
        ],
        'seo' => [
            'text' => $_POST['seo_text_ru'] ?? '',
        ],
    ];
    $blocksEn = [
        'hero' => [
            'title' => $_POST['hero_title_en'] ?? '',
            'subtitle' => $_POST['hero_subtitle_en'] ?? '',
            'text' => $_POST['hero_text_en'] ?? '',
        ],
        'brand' => [
            'title' => $_POST['brand_title_en'] ?? '',
            'text' => $_POST['brand_text_en'] ?? '',
        ],
        'manufacturing' => [
            'title' => $_POST['manufacturing_title_en'] ?? '',
            'text' => $_POST['manufacturing_text_en'] ?? '',
            'list' => array_filter(array_map('trim', explode("\n", $_POST['manufacturing_list_en'] ?? ''))),
        ],
        'where' => [
            'title' => $_POST['where_title_en'] ?? '',
            'text' => $_POST['where_text_en'] ?? '',
        ],
        'seo' => [
            'text' => $_POST['seo_text_en'] ?? '',
        ],
    ];

    foreach ($blocks as $type => $contentRu) {
        $contentEn = $blocksEn[$type] ?? [];
        db_execute(
            'UPDATE page_blocks SET content_ru = ?, content_en = ? WHERE page_id = ? AND block_type = ?',
            [
                json_encode($contentRu, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                json_encode($contentEn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                $homePageId,
                $type,
            ]
        );
    }

    header('Location: /admin/blocks.php');
    exit;
}

$blocks = [];
if ($homePageId) {
    $rows = db_fetch_all('SELECT block_type, content_ru, content_en FROM page_blocks WHERE page_id = ? ORDER BY position ASC', [$homePageId]);
    foreach ($rows as $row) {
        $blocks[$row['block_type']] = [
            'ru' => $row['content_ru'] ? json_decode($row['content_ru'], true) : [],
            'en' => $row['content_en'] ? json_decode($row['content_en'], true) : [],
        ];
    }
}

admin_header('Блоки');
?>
<section class="card">
    <h2>Главная страница — блоки</h2>
    <p class="notice">Редактируйте блоки для RU и EN. Для списков используйте новую строку.</p>
    <form method="post">
        <div class="form-grid">
            <div>
                <label>Hero заголовок (RU)</label>
                <input type="text" name="hero_title_ru" value="<?= htmlspecialchars($blocks['hero']['ru']['title'] ?? '') ?>">
            </div>
            <div>
                <label>Hero заголовок (EN)</label>
                <input type="text" name="hero_title_en" value="<?= htmlspecialchars($blocks['hero']['en']['title'] ?? '') ?>">
            </div>
            <div>
                <label>Hero подзаголовок (RU)</label>
                <input type="text" name="hero_subtitle_ru" value="<?= htmlspecialchars($blocks['hero']['ru']['subtitle'] ?? '') ?>">
            </div>
            <div>
                <label>Hero подзаголовок (EN)</label>
                <input type="text" name="hero_subtitle_en" value="<?= htmlspecialchars($blocks['hero']['en']['subtitle'] ?? '') ?>">
            </div>
            <div>
                <label>Hero текст (RU)</label>
                <textarea name="hero_text_ru"><?= htmlspecialchars($blocks['hero']['ru']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>Hero текст (EN)</label>
                <textarea name="hero_text_en"><?= htmlspecialchars($blocks['hero']['en']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>О бренде заголовок (RU)</label>
                <input type="text" name="brand_title_ru" value="<?= htmlspecialchars($blocks['brand']['ru']['title'] ?? '') ?>">
            </div>
            <div>
                <label>О бренде заголовок (EN)</label>
                <input type="text" name="brand_title_en" value="<?= htmlspecialchars($blocks['brand']['en']['title'] ?? '') ?>">
            </div>
            <div>
                <label>О бренде текст (RU)</label>
                <textarea name="brand_text_ru"><?= htmlspecialchars($blocks['brand']['ru']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>О бренде текст (EN)</label>
                <textarea name="brand_text_en"><?= htmlspecialchars($blocks['brand']['en']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>Производство заголовок (RU)</label>
                <input type="text" name="manufacturing_title_ru" value="<?= htmlspecialchars($blocks['manufacturing']['ru']['title'] ?? '') ?>">
            </div>
            <div>
                <label>Производство заголовок (EN)</label>
                <input type="text" name="manufacturing_title_en" value="<?= htmlspecialchars($blocks['manufacturing']['en']['title'] ?? '') ?>">
            </div>
            <div>
                <label>Производство текст (RU)</label>
                <textarea name="manufacturing_text_ru"><?= htmlspecialchars($blocks['manufacturing']['ru']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>Производство текст (EN)</label>
                <textarea name="manufacturing_text_en"><?= htmlspecialchars($blocks['manufacturing']['en']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>Производство список (RU)</label>
                <textarea name="manufacturing_list_ru"><?= htmlspecialchars(implode("\n", $blocks['manufacturing']['ru']['list'] ?? [])) ?></textarea>
            </div>
            <div>
                <label>Производство список (EN)</label>
                <textarea name="manufacturing_list_en"><?= htmlspecialchars(implode("\n", $blocks['manufacturing']['en']['list'] ?? [])) ?></textarea>
            </div>
            <div>
                <label>Где купить заголовок (RU)</label>
                <input type="text" name="where_title_ru" value="<?= htmlspecialchars($blocks['where']['ru']['title'] ?? '') ?>">
            </div>
            <div>
                <label>Где купить заголовок (EN)</label>
                <input type="text" name="where_title_en" value="<?= htmlspecialchars($blocks['where']['en']['title'] ?? '') ?>">
            </div>
            <div>
                <label>Где купить текст (RU)</label>
                <textarea name="where_text_ru"><?= htmlspecialchars($blocks['where']['ru']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>Где купить текст (EN)</label>
                <textarea name="where_text_en"><?= htmlspecialchars($blocks['where']['en']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>SEO текст (RU)</label>
                <textarea name="seo_text_ru"><?= htmlspecialchars($blocks['seo']['ru']['text'] ?? '') ?></textarea>
            </div>
            <div>
                <label>SEO текст (EN)</label>
                <textarea name="seo_text_en"><?= htmlspecialchars($blocks['seo']['en']['text'] ?? '') ?></textarea>
            </div>
        </div>
        <button class="button" type="submit">Сохранить блоки</button>
    </form>
</section>
<?php
admin_footer();
