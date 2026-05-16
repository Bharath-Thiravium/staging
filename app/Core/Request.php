<?php

namespace App\Core;

class Request
{
    public function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function uri(): string
    {
        // Strip query string and base path for subdirectory installs
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri  = substr($uri, strlen($base)) ?: '/';
        return '/' . trim($uri, '/') ?: '/';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return isset($_GET[$key]) ? htmlspecialchars($_GET[$key], ENT_QUOTES) : $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES) : $default;
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }
}
