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
               pi.description
        FROM partners p
        JOIN partner_i18n pi ON pi.partner_id = p.id AND pi.locale = ?
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
