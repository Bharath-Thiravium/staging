<?php
/**
 * SEO Fix Direct - Comprehensive SEO Optimization
 */

if (!defined('ABSPATH')) {
    require_once('../../../wp-config.php');
}

// Meta tags optimization
add_action('wp_head', 'seo_meta_optimization', 1);
function seo_meta_optimization() {
    if (is_front_page()) {
        echo '<meta name="description" content="Professional services and solutions - Your trusted partner for business growth and success.">' . "\n";
        echo '<meta name="keywords" content="professional services, business solutions, consulting, expertise">' . "\n";
    }
    echo '<meta name="robots" content="index, follow">' . "\n";
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
}

// Schema markup
add_action('wp_head', 'add_schema_markup');
function add_schema_markup() {
    if (is_front_page()) {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => get_bloginfo('name'),
            "url" => home_url(),
            "description" => get_bloginfo('description')
        ];
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
    }
}

// Image optimization
add_filter('wp_get_attachment_image_attributes', 'add_image_seo_attributes', 10, 3);
function add_image_seo_attributes($attr, $attachment, $size) {
    $attr['loading'] = 'lazy';
    if (empty($attr['alt'])) {
        $attr['alt'] = get_the_title($attachment->ID);
    }
    return $attr;
}

// Clean URLs
add_action('init', 'seo_url_cleanup');
function seo_url_cleanup() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
}

echo "✅ SEO optimizations applied successfully!";
?>