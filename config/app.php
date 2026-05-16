<?php

// Load .env file
$envFile = dirname(__DIR__) . '/config/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? $default;
}

define('APP_ENV',   env('APP_ENV', 'production'));
define('APP_URL',   env('APP_URL', ''));
define('APP_DEBUG', env('APP_DEBUG', false));
define('WP_API_URL', env('WP_API_URL', ''));
define('CACHE_ENABLED', env('CACHE_ENABLED', true));
define('CACHE_TTL', (int) env('CACHE_TTL', 300));
define('ROOT_PATH', dirname(__DIR__));
