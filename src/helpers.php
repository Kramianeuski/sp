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

function partners_list(string $language): array
{
    if ($language === 'en') {
        return [
            [
                'name' => 'Argument Energo (Moscow)',
                'url' => 'https://argument-energo.ru',
                'note' => 'Official distributor',
                'description' => 'Structured System Power catalog by series and configurations for fast selection. Project-oriented supply with attention to documentation and delivery terms.',
            ],
            [
                'name' => 'Systemnye Resheniya / SISSOL (Smolensk)',
                'url' => 'https://sissol.ru',
                'note' => 'Official distributor',
                'description' => '10+ years in power supply and lighting. Direct distributor contracts ensure documented origin, quality and warranty support, plus engineering guidance for project-specific selection.',
            ],
            [
                'name' => 'Vseinstrumenti',
                'url' => 'https://www.vseinstrumenti.ru',
                'note' => 'Marketplace channel',
                'description' => 'Marketplace access for quick purchasing and logistics. Terms depend on the specific marketplace sales format.',
            ],
        ];
    }

    return [
        [
            'name' => 'Аргумент Энерго (Москва)',
            'url' => 'https://argument-energo.ru',
            'note' => 'Официальный дистрибьютор',
            'description' => 'Партнёр специализируется на поставках электротехнической продукции для объектов и монтажных организаций. Каталог System Power структурирован по сериям и исполнениям, что упрощает выбор конфигурации. Компания ориентирована на корректную работу с документацией и сопровождение поставки. Подходит для проектов, где важны сроки, ассортимент и понятные условия.',
        ],
        [
            'name' => 'ООО «Системные Решения» / SISSOL (Смоленск)',
            'url' => 'https://sissol.ru',
            'note' => 'Официальный дистрибьютор',
            'description' => 'Компания работает в сфере электроснабжения и электроосвещения более 10 лет. Продукция поставляется по прямым дистрибьюторским контрактам, что позволяет подтверждать происхождение, качество и гарантийные обязательства. Партнёр помогает с подбором оптимального решения и сопровождает проектные задачи. География проектов включает регионы России и страны ЕАЭС.',
        ],
        [
            'name' => 'ВсеИнструменты',
            'url' => 'https://www.vseinstrumenti.ru',
            'note' => 'Маркетплейс / онлайн-гипермаркет',
            'description' => 'Канал для оперативных закупок и широкого доступа к ассортименту. Маркетплейс удобен для сравнения характеристик и быстрой логистики, особенно для типовых потребностей. Подходит как массовый канал доступности System Power для монтажников и конечных заказчиков. Условия поставки и документооборот зависят от формата конкретной продажи на платформе.',
        ],
    ];
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
