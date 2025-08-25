<?php
/**
 * Quick URL Fix - Immediate WordPress URL correction
 * Run this script to instantly fix WordPress database URLs
 */

// Load WordPress
require_once('wp-config.php');
require_once('wp-load.php');

echo "<html><head><title>Quick URL Fix</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:40px;} .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;} .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;} .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🚀 Quick URL Fix</h1>";

// Get current URLs
$current_home = get_option('home');
$current_siteurl = get_option('siteurl');

echo "<div class='info'>";
echo "<h3>Current URLs:</h3>";
echo "<p><strong>Home URL:</strong> {$current_home}</p>";
echo "<p><strong>Site URL:</strong> {$current_siteurl}</p>";
echo "</div>";

// Check if URLs need fixing
$needs_fix = (strpos($current_home, 'athenas.co.in') !== false) || 
             (strpos($current_siteurl, 'athenas.co.in') !== false);

if ($needs_fix) {
    echo "<div class='error'>";
    echo "<h3>🚨 URLs need fixing!</h3>";
    echo "</div>";
    
    // Fix the URLs
    $home_updated = update_option('home', 'https://athenas.co.in');
    $siteurl_updated = update_option('siteurl', 'https://athenas.co.in');
    
    if ($home_updated || $siteurl_updated) {
        echo "<div class='success'>";
        echo "<h3>✅ URLs Updated Successfully!</h3>";
        echo "<p>Home URL: https://athenas.co.in</p>";
        echo "<p>Site URL: https://athenas.co.in</p>";
        echo "</div>";
        
        // Clear any object cache
        if (function_exists('wp_cache_flush')) {
            wp_cache_flush();
        }
        
        echo "<div class='info'>";
        echo "<h3>🔄 Next Steps:</h3>";
        echo "<ol>";
        echo "<li>Clear your browser cache</li>";
        echo "<li>Try accessing athenas.co.in in an incognito window</li>";
        echo "<li>If still redirecting, check hosting panel for server-level redirects</li>";
        echo "</ol>";
        echo "</div>";
        
    } else {
        echo "<div class='error'>";
        echo "<h3>❌ Failed to update URLs</h3>";
        echo "<p>The URLs might already be correct or there's a permission issue.</p>";
        echo "</div>";
    }
    
} else {
    echo "<div class='success'>";
    echo "<h3>✅ URLs are already correct!</h3>";
    echo "<p>The redirection issue might be caused by:</p>";
    echo "<ul>";
    echo "<li>Server-level redirects (check hosting panel)</li>";
    echo "<li>CDN or proxy settings</li>";
    echo "<li>Browser cache (try incognito mode)</li>";
    echo "<li>Plugin redirects (check SEO plugins)</li>";
    echo "</ul>";
    echo "</div>";
}

// Additional database search
global $wpdb;

echo "<h3>🔍 Searching for remaining staging URLs...</h3>";

$staging_count = $wpdb->get_var("
    SELECT COUNT(*) FROM {$wpdb->options}
    WHERE option_value LIKE '%staging.athenas.co.in%'
");

if ($staging_count > 0) {
    echo "<div class='error'>";
    echo "<p>Found {$staging_count} options with staging URLs. Fixing...</p>";
    
    $fixed = $wpdb->query("
        UPDATE {$wpdb->options}
        SET option_value = REPLACE(option_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE option_value LIKE '%staging.athenas.co.in%'
    ");
    
    echo "<p>✅ Fixed {$fixed} database entries</p>";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<p>✅ No staging URLs found in options table</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><strong>🎯 If still redirecting, the issue is likely at the server/hosting level, not WordPress.</strong></p>";

echo "</body></html>";
?>
