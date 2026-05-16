<?php

namespace App\Services;

use App\Cache\FileCache;

class WordPressAPI
{
    private string $base;
    private FileCache $cache;

    public function __construct()
    {
        $this->base  = rtrim(WP_API_URL, '/');
        $this->cache = new FileCache();
    }

    // ── Posts ──────────────────────────────────────────────

    public function getPosts(array $params = []): array
    {
        $defaults = ['per_page' => 10, '_embed' => 1];
        return $this->fetch('/posts', array_merge($defaults, $params));
    }

    public function getPost(int|string $slug): ?array
    {
        if (is_int($slug)) {
            return $this->fetch("/posts/{$slug}", ['_embed' => 1])[0] ?? null;
        }
        $results = $this->fetch('/posts', ['slug' => $slug, '_embed' => 1]);
        return $results[0] ?? null;
    }

    // ── Pages ──────────────────────────────────────────────

    public function getPage(string $slug): ?array
    {
        $results = $this->fetch('/pages', ['slug' => $slug, '_embed' => 1]);
        return $results[0] ?? null;
    }

    // ── Categories / Tags ──────────────────────────────────

    public function getCategories(): array
    {
        return $this->fetch('/categories', ['per_page' => 50]);
    }

    public function getPostsByCategory(int $categoryId, int $perPage = 10): array
    {
        return $this->fetch('/posts', ['categories' => $categoryId, 'per_page' => $perPage, '_embed' => 1]);
    }

    // ── Menus (requires WP REST API Menus plugin or WP 5.9+) ──

    public function getMenu(string $slug): array
    {
        return $this->fetch("/menus/{$slug}") ?: [];
    }

    // ── Custom Post Types ──────────────────────────────────

    public function getCustomPosts(string $type, array $params = []): array
    {
        return $this->fetch("/{$type}", array_merge(['_embed' => 1], $params));
    }

    // ── Helpers ───────────────────────────────────────────

    public static function featuredImage(array $post): string
    {
        return $post['_embedded']['wp:featuredmedia'][0]['source_url'] ?? '';
    }

    public static function excerpt(array $post, int $words = 25): string
    {
        $text = wp_strip_all_tags($post['excerpt']['rendered'] ?? $post['content']['rendered'] ?? '');
        $arr  = explode(' ', $text);
        return implode(' ', array_slice($arr, 0, $words)) . (count($arr) > $words ? '…' : '');
    }

    public static function seoMeta(array $post): array
    {
        // Compatible with Yoast SEO REST API fields
        $yoast = $post['yoast_head_json'] ?? [];
        return [
            'title'       => $yoast['title']       ?? $post['title']['rendered'] ?? '',
            'description' => $yoast['description']  ?? self::excerpt($post),
            'og_image'    => $yoast['og_image'][0]['url'] ?? self::featuredImage($post),
            'canonical'   => $yoast['canonical']    ?? '',
        ];
    }

    // ── Core HTTP ─────────────────────────────────────────

    private function fetch(string $endpoint, array $params = []): array
    {
        $url      = $this->base . $endpoint . ($params ? '?' . http_build_query($params) : '');
        $cacheKey = md5($url);

        if (CACHE_ENABLED && $cached = $this->cache->get($cacheKey)) {
            return $cached;
        }

        $ctx  = stream_context_create(['http' => ['timeout' => 8, 'ignore_errors' => true]]);
        $body = @file_get_contents($url, false, $ctx);

        if ($body === false) {
            error_log("WP API error: {$url}");
            return [];
        }

        $data = json_decode($body, true) ?? [];
        $data = is_array($data) ? $data : [$data];

        if (CACHE_ENABLED) {
            $this->cache->set($cacheKey, $data, CACHE_TTL);
        }

        return $data;
    }
}

// Tiny helper — avoids pulling in WP core just for strip_tags
function wp_strip_all_tags(string $html): string
{
    return trim(strip_tags($html));
}
