<?php

require_once __DIR__ . '/config/app.php';

// Autoloader — maps App\Foo\Bar → app/Foo/Bar.php
spl_autoload_register(function (string $class): void {
    $map = [
        'App\\' => ROOT_PATH . '/app/',
    ];
    foreach ($map as $prefix => $base) {
        if (!str_starts_with($class, $prefix)) continue;
        $file = $base . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (file_exists($file)) require_once $file;
    }
});

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
