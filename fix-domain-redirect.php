<?php
/**
 * Fix Domain Redirect - Update WordPress URLs from staging to production
 * This script fixes the redirection issue by updating WordPress database URLs
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Fix Domain Redirect</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
</style>";
echo "</head><body>";

echo "<h1>🔧 Fix Domain Redirect Issue</h1>";
echo "<p><strong>This tool will identify and fix the redirection from staging.athenas.co.in to athenas.co.in</strong></p>";

global $wpdb;

// Step 1: Check current WordPress URLs
echo "<h2>🔍 Step 1: Current WordPress URL Settings</h2>";

$site_url = get_option('siteurl');
$home_url = get_option('home');
$admin_email = get_option('admin_email');

echo "<div class='info'>";
echo "<h3>📋 Current WordPress Settings:</h3>";
echo "<table>";
echo "<tr><th>Setting</th><th>Current Value</th><th>Status</th></tr>";
echo "<tr><td><strong>Site URL (siteurl)</strong></td><td>{$site_url}</td>";
if (strpos($site_url, 'staging.athenas.co.in') !== false) {
    echo "<td style='color:red;'>❌ Needs Fix</td>";
} else {
    echo "<td style='color:green;'>✅ Correct</td>";
}
echo "</tr>";

echo "<tr><td><strong>Home URL (home)</strong></td><td>{$home_url}</td>";
if (strpos($home_url, 'staging.athenas.co.in') !== false) {
    echo "<td style='color:red;'>❌ Needs Fix</td>";
} else {
    echo "<td style='color:green;'>✅ Correct</td>";
}
echo "</tr>";

echo "<tr><td><strong>Admin Email</strong></td><td>{$admin_email}</td><td>ℹ️ Info</td></tr>";
echo "</table>";
echo "</div>";

// Step 2: Check for staging URLs in database
echo "<h2>🔍 Step 2: Database URL Analysis</h2>";

$staging_urls_found = [];

// Check options table
$options_with_staging = $wpdb->get_results("
    SELECT option_name, option_value 
    FROM {$wpdb->options} 
    WHERE option_value LIKE '%staging.athenas.co.in%'
    LIMIT 20
");

if (!empty($options_with_staging)) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Found staging URLs in wp_options:</h3>";
    echo "<table>";
    echo "<tr><th>Option Name</th><th>Current Value</th></tr>";
    foreach ($options_with_staging as $option) {
        echo "<tr><td>{$option->option_name}</td><td>" . esc_html(substr($option->option_value, 0, 100)) . "...</td></tr>";
        $staging_urls_found[] = $option->option_name;
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<h3>✅ No staging URLs found in wp_options table</h3>";
    echo "</div>";
}

// Check post content
$posts_with_staging = $wpdb->get_results("
    SELECT ID, post_title, post_type 
    FROM {$wpdb->posts} 
    WHERE post_content LIKE '%staging.athenas.co.in%'
    AND post_status = 'publish'
    LIMIT 10
");

if (!empty($posts_with_staging)) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Found staging URLs in post content:</h3>";
    echo "<table>";
    echo "<tr><th>Post ID</th><th>Title</th><th>Type</th></tr>";
    foreach ($posts_with_staging as $post) {
        echo "<tr><td>{$post->ID}</td><td>{$post->post_title}</td><td>{$post->post_type}</td></tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<h3>✅ No staging URLs found in post content</h3>";
    echo "</div>";
}

// Check post meta
$meta_with_staging = $wpdb->get_results("
    SELECT post_id, meta_key 
    FROM {$wpdb->postmeta} 
    WHERE meta_value LIKE '%staging.athenas.co.in%'
    LIMIT 10
");

if (!empty($meta_with_staging)) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Found staging URLs in post meta:</h3>";
    echo "<table>";
    echo "<tr><th>Post ID</th><th>Meta Key</th></tr>";
    foreach ($meta_with_staging as $meta) {
        echo "<tr><td>{$meta->post_id}</td><td>{$meta->meta_key}</td></tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<h3>✅ No staging URLs found in post meta</h3>";
    echo "</div>";
}

// Step 3: Check .htaccess file
echo "<h2>🔍 Step 3: Server Configuration Check</h2>";

$htaccess_path = ABSPATH . '.htaccess';
if (file_exists($htaccess_path)) {
    $htaccess_content = file_get_contents($htaccess_path);
    if (strpos($htaccess_content, 'staging.athenas.co.in') !== false) {
        echo "<div class='error'>";
        echo "<h3>🚨 Found staging URLs in .htaccess file!</h3>";
        echo "<p>The .htaccess file contains redirects to staging.athenas.co.in</p>";
        echo "</div>";
    } else {
        echo "<div class='success'>";
        echo "<h3>✅ No staging URLs found in .htaccess</h3>";
        echo "</div>";
    }
} else {
    echo "<div class='info'>";
    echo "<h3>ℹ️ No .htaccess file found</h3>";
    echo "</div>";
}

// Step 4: Provide fix actions
echo "<h2>🔧 Step 4: Fix Actions</h2>";

if (!empty($staging_urls_found) || !empty($posts_with_staging) || !empty($meta_with_staging)) {
    echo "<div class='error'>";
    echo "<h3>🚨 Action Required: Database URLs Need Updating</h3>";
    echo "</div>";
    
    echo "<div class='action'>";
    echo "<h3>📝 Manual Fix Steps:</h3>";
    echo "<ol>";
    echo "<li><strong>WordPress Admin Method:</strong>";
    echo "<ul>";
    echo "<li>Go to WordPress Admin → Settings → General</li>";
    echo "<li>Change 'WordPress Address (URL)' to: <code>https://athenas.co.in</code></li>";
    echo "<li>Change 'Site Address (URL)' to: <code>https://athenas.co.in</code></li>";
    echo "<li>Save Changes</li>";
    echo "</ul></li>";
    
    echo "<li><strong>Database Method (if admin is inaccessible):</strong>";
    echo "<ul>";
    echo "<li>Run these SQL commands in phpMyAdmin or database tool:</li>";
    echo "<div class='code'>";
    echo "UPDATE wp_options SET option_value = 'https://athenas.co.in' WHERE option_name = 'home';<br>";
    echo "UPDATE wp_options SET option_value = 'https://athenas.co.in' WHERE option_name = 'siteurl';";
    echo "</div>";
    echo "</ul></li>";
    
    echo "<li><strong>wp-config.php Method (temporary):</strong>";
    echo "<ul>";
    echo "<li>Add these lines to wp-config.php (before 'That's all, stop editing!'):</li>";
    echo "<div class='code'>";
    echo "define('WP_HOME','https://athenas.co.in');<br>";
    echo "define('WP_SITEURL','https://athenas.co.in');";
    echo "</div>";
    echo "</ul></li>";
    echo "</ol>";
    echo "</div>";
    
} else {
    echo "<div class='success'>";
    echo "<h3>✅ Database URLs Look Correct</h3>";
    echo "<p>The redirection might be caused by:</p>";
    echo "<ul>";
    echo "<li>Server-level redirects (Apache/Nginx configuration)</li>";
    echo "<li>CDN or proxy settings</li>";
    echo "<li>Plugin redirects</li>";
    echo "<li>Browser cache</li>";
    echo "</ul>";
    echo "</div>";
}

// Step 5: Additional checks
echo "<h2>🔍 Step 5: Additional Checks</h2>";

echo "<div class='info'>";
echo "<h3>🔧 Other Possible Causes:</h3>";
echo "<ol>";
echo "<li><strong>Plugin Redirects:</strong> Check if any SEO or redirect plugins are active</li>";
echo "<li><strong>Theme Functions:</strong> Check if theme has hardcoded staging URLs</li>";
echo "<li><strong>Server Configuration:</strong> Check hosting panel for domain redirects</li>";
echo "<li><strong>DNS Settings:</strong> Verify DNS is pointing to correct server</li>";
echo "<li><strong>SSL Certificate:</strong> Ensure SSL is configured for athenas.co.in</li>";
echo "</ol>";
echo "</div>";

// Step 6: Quick fix script
echo "<h2>⚡ Step 6: Quick Fix Script</h2>";

echo "<div class='action'>";
echo "<h3>🚀 Automatic Database Update</h3>";
echo "<p><strong>⚠️ Warning:</strong> This will update your database. Make sure you have a backup!</p>";

if (isset($_POST['fix_urls'])) {
    echo "<div class='info'>";
    echo "<h4>🔄 Updating database URLs...</h4>";
    
    // Update WordPress URLs
    $updated_home = update_option('home', 'https://athenas.co.in');
    $updated_siteurl = update_option('siteurl', 'https://athenas.co.in');
    
    if ($updated_home || $updated_siteurl) {
        echo "<p>✅ WordPress URLs updated successfully!</p>";
    }
    
    // Update post content
    $posts_updated = $wpdb->query("
        UPDATE {$wpdb->posts} 
        SET post_content = REPLACE(post_content, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE post_content LIKE '%staging.athenas.co.in%'
    ");
    
    if ($posts_updated > 0) {
        echo "<p>✅ Updated {$posts_updated} posts with staging URLs</p>";
    }
    
    // Update post meta
    $meta_updated = $wpdb->query("
        UPDATE {$wpdb->postmeta} 
        SET meta_value = REPLACE(meta_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE meta_value LIKE '%staging.athenas.co.in%'
    ");
    
    if ($meta_updated > 0) {
        echo "<p>✅ Updated {$meta_updated} meta entries with staging URLs</p>";
    }
    
    // Update options
    $options_updated = $wpdb->query("
        UPDATE {$wpdb->options} 
        SET option_value = REPLACE(option_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE option_value LIKE '%staging.athenas.co.in%'
        AND option_name NOT IN ('home', 'siteurl')
    ");
    
    if ($options_updated > 0) {
        echo "<p>✅ Updated {$options_updated} options with staging URLs</p>";
    }
    
    echo "<div class='success'>";
    echo "<h4>🎉 Database update completed!</h4>";
    echo "<p>Clear your browser cache and try accessing athenas.co.in again.</p>";
    echo "</div>";
    echo "</div>";
    
} else {
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_urls' style='background:#0073aa;color:white;padding:15px 30px;border:none;border-radius:5px;font-size:16px;cursor:pointer;'>🔧 Fix Database URLs Now</button>";
    echo "</form>";
    echo "<p><em>This will replace all instances of 'staging.athenas.co.in' with 'athenas.co.in' in your WordPress database.</em></p>";
}
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 After fixing, clear all caches and test athenas.co.in in an incognito browser window.</strong></p>";

echo "</body></html>";
?>
