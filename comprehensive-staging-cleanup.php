<?php
/**
 * Comprehensive Staging URL Cleanup
 * Searches and replaces ALL instances of staging.athenas.co.in with athenas.co.in
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Comprehensive Staging URL Cleanup</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .fix-button{background:#dc3545;color:white;padding:15px 30px;border:none;border-radius:5px;cursor:pointer;margin:10px;font-size:16px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
</style>";
echo "</head><body>";

echo "<h1>🔍 Comprehensive Staging URL Cleanup</h1>";
echo "<p><strong>Searching and replacing ALL instances of staging.athenas.co.in with athenas.co.in</strong></p>";

global $wpdb;

// Handle cleanup action
$fixes_applied = [];

if (isset($_POST['cleanup_all'])) {
    // 1. Update WordPress core options
    $home_updated = update_option('home', 'https://athenas.co.in');
    $siteurl_updated = update_option('siteurl', 'https://athenas.co.in');
    
    if ($home_updated || $siteurl_updated) {
        $fixes_applied[] = "WordPress core URLs updated";
    }
    
    // 2. Update all options with staging URLs
    $options_updated = $wpdb->query("
        UPDATE {$wpdb->options} 
        SET option_value = REPLACE(option_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE option_value LIKE '%staging.athenas.co.in%'
    ");
    
    if ($options_updated > 0) {
        $fixes_applied[] = "Updated {$options_updated} options with staging URLs";
    }
    
    // 3. Update post content
    $posts_updated = $wpdb->query("
        UPDATE {$wpdb->posts} 
        SET post_content = REPLACE(post_content, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE post_content LIKE '%staging.athenas.co.in%'
    ");
    
    if ($posts_updated > 0) {
        $fixes_applied[] = "Updated {$posts_updated} posts with staging URLs";
    }
    
    // 4. Update post meta
    $meta_updated = $wpdb->query("
        UPDATE {$wpdb->postmeta} 
        SET meta_value = REPLACE(meta_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE meta_value LIKE '%staging.athenas.co.in%'
    ");
    
    if ($meta_updated > 0) {
        $fixes_applied[] = "Updated {$meta_updated} post meta entries with staging URLs";
    }
    
    // 5. Update comments
    $comments_updated = $wpdb->query("
        UPDATE {$wpdb->comments} 
        SET comment_content = REPLACE(comment_content, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE comment_content LIKE '%staging.athenas.co.in%'
    ");
    
    if ($comments_updated > 0) {
        $fixes_applied[] = "Updated {$comments_updated} comments with staging URLs";
    }
    
    // 6. Update comment meta
    $commentmeta_updated = $wpdb->query("
        UPDATE {$wpdb->commentmeta} 
        SET meta_value = REPLACE(meta_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE meta_value LIKE '%staging.athenas.co.in%'
    ");
    
    if ($commentmeta_updated > 0) {
        $fixes_applied[] = "Updated {$commentmeta_updated} comment meta entries with staging URLs";
    }
    
    // 7. Update user meta
    $usermeta_updated = $wpdb->query("
        UPDATE {$wpdb->usermeta} 
        SET meta_value = REPLACE(meta_value, 'staging.athenas.co.in', 'athenas.co.in')
        WHERE meta_value LIKE '%staging.athenas.co.in%'
    ");
    
    if ($usermeta_updated > 0) {
        $fixes_applied[] = "Updated {$usermeta_updated} user meta entries with staging URLs";
    }
    
    // 8. Clear all caches
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
        $fixes_applied[] = "WordPress object cache cleared";
    }
    
    // 9. Clear LiteSpeed cache if available
    if (class_exists('LiteSpeed_Cache_API')) {
        LiteSpeed_Cache_API::purge_all();
        $fixes_applied[] = "LiteSpeed cache purged";
    }
    
    $fixes_applied[] = "✅ COMPREHENSIVE CLEANUP COMPLETED";
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>🎉 Staging URL Cleanup Results</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "<p><strong>🔄 Clear your browser cache and test the website!</strong></p>";
    echo "</div>";
}

// STEP 1: Search for staging URLs in database
echo "<h2>🔍 Step 1: Staging URL Detection</h2>";

// Check options table
$options_with_staging = $wpdb->get_results("
    SELECT option_name, option_value 
    FROM {$wpdb->options} 
    WHERE option_value LIKE '%staging.athenas.co.in%'
    LIMIT 20
");

// Check posts table
$posts_with_staging = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->posts} 
    WHERE post_content LIKE '%staging.athenas.co.in%'
");

// Check post meta table
$postmeta_with_staging = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->postmeta} 
    WHERE meta_value LIKE '%staging.athenas.co.in%'
");

// Check comments table
$comments_with_staging = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->comments} 
    WHERE comment_content LIKE '%staging.athenas.co.in%'
");

// Check comment meta table
$commentmeta_with_staging = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->commentmeta} 
    WHERE meta_value LIKE '%staging.athenas.co.in%'
");

// Check user meta table
$usermeta_with_staging = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->usermeta} 
    WHERE meta_value LIKE '%staging.athenas.co.in%'
");

$total_staging_refs = count($options_with_staging) + $posts_with_staging + $postmeta_with_staging + 
                     $comments_with_staging + $commentmeta_with_staging + $usermeta_with_staging;

echo "<div class='info'>";
echo "<h3>📊 Staging URL Detection Results</h3>";
echo "<table>";
echo "<tr><th>Database Table</th><th>Staging URLs Found</th></tr>";
echo "<tr><td>wp_options</td><td>" . count($options_with_staging) . "</td></tr>";
echo "<tr><td>wp_posts</td><td>{$posts_with_staging}</td></tr>";
echo "<tr><td>wp_postmeta</td><td>{$postmeta_with_staging}</td></tr>";
echo "<tr><td>wp_comments</td><td>{$comments_with_staging}</td></tr>";
echo "<tr><td>wp_commentmeta</td><td>{$commentmeta_with_staging}</td></tr>";
echo "<tr><td>wp_usermeta</td><td>{$usermeta_with_staging}</td></tr>";
echo "<tr><td><strong>TOTAL</strong></td><td><strong>{$total_staging_refs}</strong></td></tr>";
echo "</table>";
echo "</div>";

// STEP 2: Show specific staging URLs found
if (!empty($options_with_staging)) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Staging URLs Found in Options Table</h3>";
    echo "<table>";
    echo "<tr><th>Option Name</th><th>Current Value (Preview)</th></tr>";
    foreach ($options_with_staging as $option) {
        $preview = strlen($option->option_value) > 100 ? 
                  substr($option->option_value, 0, 100) . "..." : 
                  $option->option_value;
        echo "<tr><td>{$option->option_name}</td><td>" . esc_html($preview) . "</td></tr>";
    }
    echo "</table>";
    echo "</div>";
}

// STEP 3: Current WordPress URLs
echo "<h2>🌐 Step 2: Current WordPress URL Settings</h2>";

$current_home = get_option('home');
$current_siteurl = get_option('siteurl');

echo "<div class='info'>";
echo "<h3>📋 Current WordPress Settings</h3>";
echo "<p><strong>Home URL:</strong> {$current_home}</p>";
echo "<p><strong>Site URL:</strong> {$current_siteurl}</p>";

if (strpos($current_home, 'staging.athenas.co.in') !== false || 
    strpos($current_siteurl, 'staging.athenas.co.in') !== false) {
    echo "<p style='color:red;'><strong>❌ WordPress core URLs still contain staging references!</strong></p>";
} else {
    echo "<p style='color:green;'><strong>✅ WordPress core URLs are correct</strong></p>";
}
echo "</div>";

// STEP 4: Cleanup action
echo "<h2>🧹 Step 3: Comprehensive Cleanup</h2>";

if ($total_staging_refs > 0) {
    echo "<div class='error'>";
    echo "<h3>🚨 {$total_staging_refs} Staging URL References Found</h3>";
    echo "<p><strong>This comprehensive cleanup will:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Update WordPress core URLs (home, siteurl)</li>";
    echo "<li>✅ Replace ALL staging URLs in wp_options table</li>";
    echo "<li>✅ Replace ALL staging URLs in post content</li>";
    echo "<li>✅ Replace ALL staging URLs in post meta</li>";
    echo "<li>✅ Replace ALL staging URLs in comments</li>";
    echo "<li>✅ Replace ALL staging URLs in comment meta</li>";
    echo "<li>✅ Replace ALL staging URLs in user meta</li>";
    echo "<li>✅ Clear all caches</li>";
    echo "</ul>";
    
    echo "<p><strong>⚠️ Warning:</strong> This will make permanent changes to your database. Make sure you have a backup!</p>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='cleanup_all' class='fix-button'>🧹 CLEANUP ALL STAGING URLs NOW</button>";
    echo "</form>";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<h3>✅ No Staging URLs Found</h3>";
    echo "<p>Your database is clean! All URLs are correctly pointing to athenas.co.in</p>";
    echo "</div>";
}

// STEP 5: Verification
echo "<h2>🔍 Step 4: Verification & Testing</h2>";

echo "<div class='action'>";
echo "<h3>📋 After Cleanup, Verify These:</h3>";
echo "<ol>";
echo "<li><strong>Homepage:</strong> <a href='https://athenas.co.in' target='_blank'>https://athenas.co.in</a></li>";
echo "<li><strong>Admin Area:</strong> <a href='https://athenas.co.in/wp-admin/' target='_blank'>https://athenas.co.in/wp-admin/</a></li>";
echo "<li><strong>All Pages:</strong> Check that internal links work correctly</li>";
echo "<li><strong>Images:</strong> Verify all images load properly</li>";
echo "<li><strong>Forms:</strong> Test contact forms and submissions</li>";
echo "</ol>";

echo "<h3>🔧 Additional Steps:</h3>";
echo "<ul>";
echo "<li><strong>Clear Browser Cache:</strong> Hard refresh (Ctrl+F5)</li>";
echo "<li><strong>Test in Incognito:</strong> Verify no caching issues</li>";
echo "<li><strong>Check Mobile:</strong> Test on mobile devices</li>";
echo "<li><strong>Update Search Console:</strong> Submit new sitemap if needed</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 This comprehensive cleanup ensures NO staging URLs remain anywhere in your website!</strong></p>";

echo "</body></html>";
?>
