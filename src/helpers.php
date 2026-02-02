<?php

declare(strict_types=1);

function db(): PDO
{
    global $pdo;

    return $pdo;
}

function config(string $key, mixed $default = null): mixed
{
    global $config;

    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function t(string $key, string $language): string
{
    $entry = i18n_entry($key, $language);

    return $entry['value'] ?? '[[' . $key . ']]';
}

function t_html(string $key, string $language): string
{
    $entry = i18n_entry($key, $language);

    return $entry['value'] ?? '';
}

function i18n_entry(string $key, string $language): ?array
{
    static $cache = [];
    static $missing = [];

    if (!isset($cache[$language])) {
        $stmt = db()->prepare('SELECT `key`, `value`, is_html FROM i18n_strings WHERE locale = ?');
        $stmt->execute([$language]);
        $cache[$language] = [];
        foreach ($stmt->fetchAll() as $row) {
            $cache[$language][$row['key']] = [
                'value' => $row['value'],
                'is_html' => (int) $row['is_html'],
            ];
        }
    }

    if (isset($cache[$language][$key])) {
        return $cache[$language][$key];
    }

    $missingKey = $language . ':' . $key;
    if (!isset($missing[$missingKey])) {
        $missing[$missingKey] = true;
        $logDir = __DIR__ . '/../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }
        $payload = [
            'time' => date('c'),
            'language' => $language,
            'key' => $key,
            'path' => $_SERVER['REQUEST_URI'] ?? '',
        ];
        file_put_contents($logDir . '/missing_translations.log', json_encode($payload, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
    }

    return null;
}

function render(string $template, array $data = []): void
{
    $theme = config('theme');
    $layout = __DIR__ . '/../themes/' . $theme . '/layouts/default.php';
    $templatePath = __DIR__ . '/../themes/' . $theme . '/' . $template . '.php';
    extract($data, EXTR_SKIP);
    include $layout;
}

function render_partial(string $template, array $data = []): void
{
    $theme = config('theme');
    $templatePath = __DIR__ . '/../themes/' . $theme . '/' . $template . '.php';
    extract($data, EXTR_SKIP);
    include $templatePath;
}

function redirect(string $path, int $code = 302): void
{
    header('Location: ' . $path, true, $code);
    exit;
}

function current_language(string $path): string
{
    if (str_starts_with($path, '/en/')) {
        return 'en';
    }

    return 'ru';
}

function slug_from_path(string $path): string
{
    $segments = array_values(array_filter(explode('/', trim($path, '/'))));

    return end($segments) ?: 'home';
}

function slugify(string $text): string
{
    $text = mb_strtolower(trim($text));
    $map = [
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'e',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'ts',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sch',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
    ];
    $text = strtr($text, $map);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');

    return $text !== '' ? $text : 'product';
}

function unique_product_slug(string $baseSlug, string $locale, ?int $productId = null): string
{
    $slug = $baseSlug;
    $suffix = 1;
    $params = [$locale, $slug];
    $sql = 'SELECT entity_id FROM seo_meta WHERE entity_type = "product" AND locale = ? AND slug = ?';
    if ($productId) {
        $sql .= ' AND entity_id != ?';
        $params[] = $productId;
    }
    $stmt = db()->prepare($sql);
    while (true) {
        $stmt->execute($params);
        if (!$stmt->fetchColumn()) {
            return $slug;
        }
        $suffix++;
        $slug = $baseSlug . '-' . $suffix;
        $params[1] = $slug;
    }
}

function clean_branding_text(string $text): string
{
    $replacements = [
        'Аргумент Энерго' => 'System Power',
        'Argument Energo' => 'System Power',
        'a-energ' => 'System Power',
        'A-ENERG' => 'System Power',
        'A-Energ' => 'System Power',
    ];

    $cleaned = str_replace(array_keys($replacements), array_values($replacements), $text);
    $cleaned = preg_replace('/System Power\s*System Power/i', 'System Power', $cleaned);

    return trim($cleaned);
}

function format_product_name(string $name, ?string $sku = null, string $brand = 'System Power'): string
{
    $base = preg_replace('/\b' . preg_quote($brand, '/') . '\b/iu', '', $name);
    if ($sku) {
        $base = preg_replace('/\b' . preg_quote($sku, '/') . '\b/iu', '', $base);
    }
    $base = preg_replace('/\s*\|\s*/u', ' ', $base);
    $base = preg_replace('/\s{2,}/u', ' ', $base);
    $base = trim($base);

    $parts = [];
    if ($base !== '') {
        $parts[] = $base;
    }
    if ($sku) {
        $parts[] = $sku;
    }
    $parts[] = $brand;

    return trim(preg_replace('/\s{2,}/u', ' ', implode(' ', $parts)));
}

function clean_product_text(string $text): string
{
    $patterns = [
        '/Индивидуальные решения и оптовые заказы/iu',
        '/Контакты для заказа/iu',
        '/sale@a-energ\.ru/iu',
        '/mailto:sale@a-energ\.ru/iu',
        '/\+7\s*\d{3}\s*\d{3}[-\s]?\d{2}[-\s]?\d{2}/u',
        '/Аргумент Энерго/iu',
        '/a-energ/iu',
    ];

    $cleaned = preg_replace($patterns, '', $text);
    $cleaned = preg_replace('/\s{2,}/u', ' ', $cleaned);
    $cleaned = preg_replace('/\s+([,.:;])/u', '$1', $cleaned);

    return trim($cleaned);
}

function format_product_description(string $text, string $language = 'ru'): string
{
    if (preg_match('/<\/(p|ul|ol|table|h2|h3|section)>/i', $text)) {
        return $text;
    }

    $text = str_replace(["\r\n", "\r"], "\n", $text);

    $headingMap = $language === 'en'
        ? [
            'Technical specifications' => 'Technical parameters',
            'Technical parameters' => 'Technical parameters',
            'Advantages' => 'Advantages',
            'Purpose' => 'Purpose',
            'Design and features' => 'Technical parameters',
            'Package contents' => 'Package contents',
            'Additional information' => 'Technical parameters',
        ]
        : [
            'Технические характеристики' => 'Технические параметры',
            'Технические параметры' => 'Технические параметры',
            'Преимущества' => 'Преимущества',
            'Назначение' => 'Назначение',
            'Конструкция и особенности' => 'Технические параметры',
            'Комплект поставки' => 'Комплект поставки',
            'Дополнительная информация' => 'Технические параметры',
        ];

    foreach (array_keys($headingMap) as $heading) {
        $pattern = '/\b' . preg_quote($heading, '/') . '\b/u';
        $text = preg_replace($pattern, "\n\n## " . $heading . "\n", $text);
    }

    $text = preg_replace('/:\s*—/u', ":\n- ", $text);
    $text = preg_replace('/\n—\s*/u', "\n- ", $text);
    $text = preg_replace('/\n-\s*/u', "\n- ", $text);
    $text = preg_replace('/\s{2,}/u', ' ', $text);

    $blocks = preg_split('/\n{2,}/', trim($text));
    $sections = [];
    $currentTitle = null;
    $currentBlocks = [];

    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        if (str_starts_with($block, '## ')) {
            if ($currentTitle !== null || $currentBlocks) {
                $sections[] = [$currentTitle, $currentBlocks];
            }
            $title = trim(mb_substr($block, 3));
            $currentTitle = $headingMap[$title] ?? $title;
            $currentBlocks = [];
            continue;
        }

        $currentBlocks[] = $block;
    }

    if ($currentTitle !== null || $currentBlocks) {
        $sections[] = [$currentTitle, $currentBlocks];
    }

    $htmlSections = [];
    foreach ($sections as [$title, $sectionBlocks]) {
        $sectionHtml = [];
        if ($title) {
            $sectionHtml[] = '<h2>' . htmlspecialchars($title, ENT_QUOTES) . '</h2>';
        }
        foreach ($sectionBlocks as $block) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $block)), static fn($line) => $line !== ''));
            $listItems = [];
            foreach ($lines as $line) {
                if (str_starts_with($line, '- ')) {
                    $listItems[] = mb_substr($line, 2);
                }
            }
            if ($listItems) {
                $itemsHtml = array_map(static fn($item) => '<li>' . htmlspecialchars($item, ENT_QUOTES) . '</li>', $listItems);
                $sectionHtml[] = '<ul>' . implode('', $itemsHtml) . '</ul>';
            } else {
                $paragraph = htmlspecialchars(implode(' ', $lines), ENT_QUOTES);
                $sectionHtml[] = '<p>' . $paragraph . '</p>';
            }
        }
        $htmlSections[] = '<section class="product-desc-section">' . implode("\n", $sectionHtml) . '</section>';
    }

    return implode("\n", $htmlSections);
}

function category_faq(string $categoryCode, string $language): array
{
    $faqMap = [
        'hatches' => [
            ['faq.hatches.q1', 'faq.hatches.a1'],
            ['faq.hatches.q2', 'faq.hatches.a2'],
            ['faq.hatches.q3', 'faq.hatches.a3'],
            ['faq.hatches.q4', 'faq.hatches.a4'],
            ['faq.hatches.q5', 'faq.hatches.a5'],
            ['faq.hatches.q6', 'faq.hatches.a6'],
            ['faq.hatches.q7', 'faq.hatches.a7'],
            ['faq.hatches.q8', 'faq.hatches.a8'],
            ['faq.hatches.q9', 'faq.hatches.a9'],
            ['faq.hatches.q10', 'faq.hatches.a10'],
        ],
        'electrical_cabinets' => [
            ['faq.rusp.q1', 'faq.rusp.a1'],
            ['faq.rusp.q2', 'faq.rusp.a2'],
            ['faq.rusp.q3', 'faq.rusp.a3'],
            ['faq.rusp.q4', 'faq.rusp.a4'],
            ['faq.rusp.q5', 'faq.rusp.a5'],
            ['faq.rusp.q6', 'faq.rusp.a6'],
        ],
    ];

    $items = [];
    foreach ($faqMap[$categoryCode] ?? [] as [$questionKey, $answerKey]) {
        $question = t($questionKey, $language);
        $answer = t($answerKey, $language);
        if (str_starts_with($question, '[[') || str_starts_with($answer, '[[')) {
            continue;
        }
        $items[] = [
            'question' => $question,
            'answer' => $answer,
        ];
    }

    return $items;
}

function store_uploaded_media(array $file, string $directory, string $type = 'image'): ?int
{
    if (empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $uploadRoot = __DIR__ . '/../storage/uploads/' . trim($directory, '/');
    if (!is_dir($uploadRoot)) {
        mkdir($uploadRoot, 0775, true);
    }

    $extension = pathinfo($file['name'] ?? '', PATHINFO_EXTENSION);
    $safeExtension = $extension ? '.' . strtolower($extension) : '';
    $fileName = uniqid('media_', true) . $safeExtension;
    $targetPath = $uploadRoot . '/' . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return null;
    }

    $mime = mime_content_type($targetPath) ?: ($type === 'image' ? 'image/jpeg' : 'application/octet-stream');
    $size = filesize($targetPath) ?: 0;
    $width = null;
    $height = null;
    if ($type === 'image') {
        $sizeData = @getimagesize($targetPath);
        if ($sizeData) {
            $width = $sizeData[0];
            $height = $sizeData[1];
        }
    }

    $relativePath = '/storage/uploads/' . trim($directory, '/') . '/' . $fileName;
    $stmt = db()->prepare(
        'INSERT INTO media (path, type, mime, size_bytes, width, height, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())'
    );
    $stmt->execute([$relativePath, $type, $mime, $size, $width, $height]);

    return (int) db()->lastInsertId();
}

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!admin_logged_in()) {
        $_SESSION['admin_redirect_to'] = $_SERVER['REQUEST_URI'] ?? '/admin/';
        redirect('/admin/login/');
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

function verify_csrf_token(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function admin_log_attempt(string $email, bool $success): void
{
    $logDir = __DIR__ . '/../storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0775, true);
    }

    $payload = [
        'time' => date('c'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'email' => $email,
        'success' => $success ? 1 : 0,
    ];
    $line = json_encode($payload, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    file_put_contents($logDir . '/admin_login.log', $line, FILE_APPEND);
}

function partners_list(string $language, ?string $type = null, bool $onlyActive = true): array
{
    $query = '
        SELECT p.id, p.type, p.name, p.url, p.city, p.sort_order,
               p.logo_media_id, p.logo_small_media_id, p.logo_large_media_id,
               pi.description,
               COALESCE(ms.path, m.path) AS logo_small_path,
               COALESCE(ml.path, m.path) AS logo_large_path
        FROM partners p
        JOIN partner_i18n pi ON pi.partner_id = p.id AND pi.locale = ?
        LEFT JOIN media m ON m.id = p.logo_media_id
        LEFT JOIN media ms ON ms.id = p.logo_small_media_id
        LEFT JOIN media ml ON ml.id = p.logo_large_media_id
    ';
    $params = [$language];
    $conditions = [];

    if ($onlyActive) {
        $conditions[] = 'p.is_active = 1';
    }
    if ($type) {
        $conditions[] = 'p.type = ?';
        $params[] = $type;
    }

    if ($conditions) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $query .= ' ORDER BY p.sort_order, p.id';

    $stmt = db()->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

function product_partner_links(int $productId, string $language): array
{
    $stmt = db()->prepare(
        'SELECT ppl.product_url, p.name, p.url, p.type, p.sort_order,
                COALESCE(ms.path, m.path) AS logo_small_path,
                pi.description
         FROM product_partner_links ppl
         JOIN partners p ON p.id = ppl.partner_id
         JOIN partner_i18n pi ON pi.partner_id = p.id AND pi.locale = ?
         LEFT JOIN media m ON m.id = p.logo_media_id
         LEFT JOIN media ms ON ms.id = p.logo_small_media_id
         WHERE ppl.product_id = ?
           AND ppl.is_active = 1
           AND p.is_active = 1
         ORDER BY p.sort_order, p.id'
    );
    $stmt->execute([$language, $productId]);

    return $stmt->fetchAll();
}

function media_by_id(?int $mediaId): ?array
{
    if (!$mediaId) {
        return null;
    }

    $stmt = db()->prepare('SELECT * FROM media WHERE id = ?');
    $stmt->execute([$mediaId]);

    $media = $stmt->fetch();

    return $media ?: null;
}

function media_path(?int $mediaId): ?string
{
    $media = media_by_id($mediaId);

    return $media['path'] ?? null;
}

function localized_url(string $url, string $language): string
{
    if (str_starts_with($url, '/ru/') || $url === '/ru/') {
        return preg_replace('#^/ru#', '/' . $language, $url);
    }
    if (str_starts_with($url, '/en/') || $url === '/en/') {
        return preg_replace('#^/en#', '/' . $language, $url);
    }

    return $url;
}

function cache_get(string $key): ?string
{
    if (!config('cache.enabled')) {
        return null;
    }

    $path = config('cache.path') . '/' . $key . '.html';
    if (!file_exists($path)) {
        return null;
    }

    $ttl = (int) config('cache.ttl');
    if (filemtime($path) + $ttl < time()) {
        unlink($path);
        return null;
    }

    return file_get_contents($path) ?: null;
}

function cache_put(string $key, string $content): void
{
    if (!config('cache.enabled')) {
        return;
    }

    $path = config('cache.path') . '/' . $key . '.html';
    file_put_contents($path, $content);
}
