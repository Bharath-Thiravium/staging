<?php
/**
 * WordPress SEO Settings Checker
 *
 * This script checks critical SEO settings that might be blocking search engines.
 * Upload this file to your WordPress root directory and access it via web browser.
 */

// Security check - only allow access from localhost or if you add your IP
$allowed_ips = ['127.0.0.1', '::1', 'localhost'];
$client_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Comment out the next 4 lines if you want to access this from any IP (less secure)
if (!in_array($client_ip, $allowed_ips)) {
    die('Access denied. This script can only be accessed from localhost for security.');
}

// Load WordPress
require_once('wp-config.php');
require_once('wp-includes/wp-db.php');

// Create database connection
$wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

echo "<html><head><title>SEO Settings Check</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:40px;} .good{color:green;} .warning{color:orange;} .error{color:red;} .code{background:#f0f0f0;padding:10px;margin:10px 0;}</style>";
echo "</head><body>";

echo "<h1>🔍 WordPress SEO Settings Check</h1>";

// Check if we should fix the blog_public setting
if (isset($_GET['fix_blog_public']) && $_GET['fix_blog_public'] == '1') {
    $result = $wpdb->update(
        $wpdb->prefix . 'options',
        array('option_value' => '1'),
        array('option_name' => 'blog_public')
    );

    if ($result !== false) {
        echo "<div class='good'>✅ <strong>FIXED:</strong> Search engine visibility has been set to ALLOW indexing!</div>";
        echo "<div>Please clear all caches and test your site again.</div>";
    } else {
        echo "<div class='error'>❌ Failed to update the setting. Please try manually.</div>";
    }
}

// Check blog_public setting
$blog_public = $wpdb->get_var("SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = 'blog_public'");

echo "<h2>1. WordPress Search Engine Visibility</h2>";
echo "<div class='code'>Current blog_public setting: <strong>" . $blog_public . "</strong></div>";

if ($blog_public == '0') {
    echo "<div class='error'>❌ <strong>CRITICAL ISSUE:</strong> Search engine visibility is set to DISCOURAGE indexing!</div>";
    echo "<div class='error'>This means search engines are told NOT to index your site.</div>";
    echo "<div><strong>Quick Fix:</strong> <a href='?fix_blog_public=1' style='background:#0073aa;color:white;padding:10px;text-decoration:none;border-radius:3px;'>Click here to fix this automatically</a></div>";
    echo "<div style='margin-top:10px;'><strong>Manual Fix:</strong> Go to WordPress Admin > Settings > Reading and uncheck 'Discourage search engines from indexing this site'</div>";
} else {
    echo "<div class='good'>✅ Good: Search engines are allowed to index your site.</div>";
}

// Check robots.txt content
echo "<h2>2. Robots.txt File Check</h2>";
$robots_content = file_get_contents('robots.txt');
if (strpos($robots_content, 'Disallow: /') !== false && strpos($robots_content, 'Allow: /') === false) {
    echo "<div class='error'>❌ <strong>ISSUE:</strong> robots.txt contains 'Disallow: /' which blocks search engines</div>";
} else {
    echo "<div class='good'>✅ robots.txt appears to be properly configured</div>";
}

// Check for posts with noindex
echo "<h2>3. Individual Posts/Pages with NoIndex</h2>";
$noindex_posts = $wpdb->get_results("
    SELECT p.ID, p.post_title, pm.meta_value, p.post_type
    FROM {$wpdb->prefix}posts p
    JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id
    WHERE pm.meta_key = 'rank_math_robots'
    AND pm.meta_value LIKE '%noindex%'
    AND p.post_status = 'publish'
    LIMIT 10
");

if (!empty($noindex_posts)) {
    echo "<div class='warning'>⚠️ Found posts/pages with noindex set:</div>";
    echo "<ul>";
    foreach ($noindex_posts as $post) {
        echo "<li>Post ID {$post->ID}: <strong>{$post->post_title}</strong> ({$post->post_type}) - robots: {$post->meta_value}</li>";
    }
    echo "</ul>";
    echo "<div>Review these in WordPress Admin to ensure they should be excluded from search engines.</div>";
} else {
    echo "<div class='good'>✅ No published posts/pages found with noindex setting</div>";
}

// Check active theme
$active_theme = $wpdb->get_var("SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = 'stylesheet'");
echo "<h2>4. Active Theme</h2>";
echo "<div>Active theme: <strong>" . $active_theme . "</strong></div>";

// Check for common SEO plugins
echo "<h2>5. SEO Plugins Detected</h2>";
$seo_plugins = $wpdb->get_results("
    SELECT option_value FROM {$wpdb->prefix}options
    WHERE option_name = 'active_plugins'
");

if (!empty($seo_plugins)) {
    $plugins = unserialize($seo_plugins[0]->option_value);
    $seo_plugin_found = false;

    foreach ($plugins as $plugin) {
        if (strpos($plugin, 'seo-by-rank-math') !== false) {
            echo "<div class='good'>✅ Rank Math SEO plugin detected</div>";
            echo "<div>Check Rank Math > Titles & Meta settings for any global noindex rules</div>";
            $seo_plugin_found = true;
        }
        if (strpos($plugin, 'wordpress-seo') !== false) {
            echo "<div class='good'>✅ Yoast SEO plugin detected</div>";
            $seo_plugin_found = true;
        }
    }

    if (!$seo_plugin_found) {
        echo "<div>No major SEO plugins detected in active plugins list</div>";
    }
}

echo "<h2>📋 Summary & Next Steps</h2>";
echo "<ol>";
echo "<li>If any issues are marked with ❌, fix those immediately</li>";
echo "<li>After making changes, clear all caches</li>";
echo "<li>Test your site with Google PageSpeed Insights</li>";
echo "<li>Submit your sitemap to Google Search Console</li>";
echo "</ol>";

echo "<div style='margin-top:30px; padding:15px; background:#f9f9f9; border-left:4px solid #0073aa;'>";
echo "<strong>Security Note:</strong> Delete this file after checking your settings for security.";
echo "</div>";

echo "</body></html>";
?>
