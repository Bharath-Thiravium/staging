<?php
/**
 * Plugin Name: Full SEO Optimizer
 * Description: Comprehensive SEO optimization for all pages
 * Version: 1.0
 */

// Auto-optimize all pages and posts
add_action('save_post', 'auto_seo_optimize', 10, 3);
add_action('wp_head', 'enhanced_seo_meta', 1);

function auto_seo_optimize($post_id, $post, $update) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;
    
    $title = get_the_title($post_id);
    $content = $post->post_content;
    
    // Auto-generate meta description if empty
    if (!get_post_meta($post_id, 'rank_math_description', true)) {
        $desc = wp_trim_words(strip_tags($content), 25);
        update_post_meta($post_id, 'rank_math_description', $desc);
    }
    
    // Auto-generate focus keyword
    if (!get_post_meta($post_id, 'rank_math_focus_keyword', true)) {
        $keywords = extract_keywords($title . ' ' . $content);
        update_post_meta($post_id, 'rank_math_focus_keyword', $keywords);
    }
    
    // Set canonical URL
    update_post_meta($post_id, 'rank_math_canonical_url', get_permalink($post_id));
    
    // Enable breadcrumbs
    update_post_meta($post_id, 'rank_math_breadcrumb', 'on');
    
    // Set robots meta
    update_post_meta($post_id, 'rank_math_robots', ['index', 'follow']);
}

function extract_keywords($text) {
    $words = str_word_count(strtolower(strip_tags($text)), 1);
    $words = array_filter($words, function($w) { return strlen($w) > 4; });
    $freq = array_count_values($words);
    arsort($freq);
    return implode(', ', array_slice(array_keys($freq), 0, 3));
}

function enhanced_seo_meta() {
    global $post;
    if (!is_singular()) return;
    
    $title = get_the_title();
    $desc = get_post_meta($post->ID, 'rank_math_description', true) ?: wp_trim_words(strip_tags($post->post_content), 25);
    $keywords = get_post_meta($post->ID, 'rank_math_focus_keyword', true);
    $image = get_the_post_thumbnail_url($post->ID, 'full') ?: get_site_icon_url();
    
    echo "\n<!-- Enhanced SEO Meta -->\n";
    echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    if ($keywords) echo '<meta name="keywords" content="' . esc_attr($keywords) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
    echo '<meta property="og:type" content="article">' . "\n";
    if ($image) echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    if ($image) echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
}

// Schema markup
add_action('wp_footer', 'add_schema_markup');
function add_schema_markup() {
    if (!is_singular()) return;
    global $post;
    
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Article",
        "headline" => get_the_title(),
        "datePublished" => get_the_date('c'),
        "dateModified" => get_the_modified_date('c'),
        "author" => ["@type" => "Person", "name" => get_the_author()],
        "publisher" => [
            "@type" => "Organization",
            "name" => get_bloginfo('name'),
            "logo" => ["@type" => "ImageObject", "url" => get_site_icon_url()]
        ]
    ];
    
    if ($img = get_the_post_thumbnail_url($post->ID, 'full')) {
        $schema["image"] = $img;
    }
    
    echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
}

// Optimize images alt text
add_filter('wp_get_attachment_image_attributes', 'auto_image_alt', 10, 2);
function auto_image_alt($attr, $attachment) {
    if (empty($attr['alt'])) {
        $attr['alt'] = get_the_title($attachment->ID) ?: get_bloginfo('name');
    }
    return $attr;
}

// Add sitemap ping
add_action('publish_post', 'ping_search_engines');
function ping_search_engines($post_id) {
    $sitemap = home_url('/sitemap_index.xml');
    wp_remote_get("http://www.google.com/ping?sitemap=" . urlencode($sitemap));
}
