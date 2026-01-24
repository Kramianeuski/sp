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
    static $cache = [];
    static $missing = [];

    if (!isset($cache[$language])) {
        $stmt = db()->prepare('SELECT `key`, `value` FROM translations WHERE language = ?');
        $stmt->execute([$language]);
        $cache[$language] = [];
        foreach ($stmt->fetchAll() as $row) {
            $cache[$language][$row['key']] = $row['value'];
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

    return '[[' . $key . ']]';
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
        SELECT p.id, p.type, p.url, p.logo_path, p.city, p.lat, p.lng, p.sort_order,
               pt.name, pt.description
        FROM partners p
        JOIN partner_translations pt ON pt.partner_id = p.id AND pt.language = ?
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

function product_partners(int $productId, string $language): array
{
    $stmt = db()->prepare(
        'SELECT p.id, p.type, p.url, p.logo_path, p.city, p.lat, p.lng,
                pt.name, pt.description, pp.sort_order
         FROM product_partners pp
         JOIN partners p ON p.id = pp.partner_id
         JOIN partner_translations pt ON pt.partner_id = p.id AND pt.language = ?
         WHERE pp.product_id = ?
           AND p.is_active = 1
         ORDER BY pp.sort_order, p.sort_order, p.id'
    );
    $stmt->execute([$language, $productId]);

    return $stmt->fetchAll();
}

function documents_list(string $scope, string $language, ?int $productId = null): array
{
    if ($scope === 'product' && $productId !== null) {
        $stmt = db()->prepare(
            'SELECT d.id, d.title, d.file_path, d.doc_type
             FROM document_products dp
             JOIN documents d ON d.id = dp.document_id
             WHERE dp.product_id = ?
               AND d.scope = ?
               AND d.language = ?
               AND d.is_active = 1
             ORDER BY dp.sort_order, d.sort_order, d.id'
        );
        $stmt->execute([$productId, $scope, $language]);

        return $stmt->fetchAll();
    }

    $stmt = db()->prepare(
        'SELECT id, title, file_path, doc_type
         FROM documents
         WHERE scope = ?
           AND language = ?
           AND is_active = 1
         ORDER BY sort_order, id'
    );
    $stmt->execute([$scope, $language]);

    return $stmt->fetchAll();
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
