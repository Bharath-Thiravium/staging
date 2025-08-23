<?php
/**
 * Cache Clearing Script
 * Clears all WordPress and optimization caches
 */

// Clear WordPress object cache
wp_cache_flush();

// Clear LiteSpeed Cache if available
if (class_exists('LiteSpeed_Cache_API')) {
    LiteSpeed_Cache_API::purge_all();
    echo "✅ LiteSpeed Cache cleared\n";
}

// Clear WP Rocket cache if available
if (function_exists('rocket_clean_domain')) {
    rocket_clean_domain();
    echo "✅ WP Rocket cache cleared\n";
}

// Clear W3 Total Cache if available
if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
    echo "✅ W3 Total Cache cleared\n";
}

// Clear WP Super Cache if available
if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
    echo "✅ WP Super Cache cleared\n";
}

// Clear WordPress transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");

echo "✅ All caches cleared successfully!\n";
?>