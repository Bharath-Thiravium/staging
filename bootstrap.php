<?php

require_once __DIR__ . '/config/app.php';

// Autoloader — maps App\Foo\Bar → app/Foo/Bar.php
// Also maps App\Modules\X → modules/x/ (legacy view folder)
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = ROOT_PATH . '/app/' . $relative . '.php';
    if (file_exists($file)) require_once $file;
});

// Global helpers
function esc(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset(string $path): string
{
    return APP_URL . '/assets/' . ltrim($path, '/');
}

// Error handling
if (APP_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/error.log');
}

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
