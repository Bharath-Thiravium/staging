<?php

namespace App\Cache;

class FileCache
{
    private string $dir;

    public function __construct()
    {
        $this->dir = ROOT_PATH . '/cache/';
    }

    public function get(string $key): mixed
    {
        $file = $this->path($key);
        if (!file_exists($file)) return null;

        $data = unserialize(file_get_contents($file));
        if ($data['expires'] < time()) {
            unlink($file);
            return null;
        }

        return $data['value'];
    }

    public function set(string $key, mixed $value, int $ttl = 300): void
    {
        file_put_contents(
            $this->path($key),
            serialize(['expires' => time() + $ttl, 'value' => $value]),
            LOCK_EX
        );
    }

    public function flush(): void
    {
        foreach (glob($this->dir . '*.cache') as $file) unlink($file);
    }

    private function path(string $key): string
    {
        return $this->dir . $key . '.cache';
    }
}
