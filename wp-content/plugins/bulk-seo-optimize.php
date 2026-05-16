<?php
/**
 * Bulk SEO Optimization Script
 * Run this once: yoursite.com/wp-content/plugins/bulk-seo-optimize.php
 */

require_once(__DIR__ . '/../../../wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

set_time_limit(0);

$args = [
    'post_type' => ['post', 'page'],
    'post_status' => 'publish',
    'posts_per_page' => -1
];

$posts = get_posts($args);
$count = 0;

echo "<h1>SEO Optimization Progress</h1>";
echo "<style>body{font-family:Arial;padding:20px;}.success{color:green;}.item{padding:5px;border-bottom:1px solid #ddd;}</style>";

foreach ($posts as $post) {
    echo "<div class='item'>";
    
    $title = $post->post_title;
    $content = $post->post_content;
    
    // Meta Description
    if (!get_post_meta($post->ID, 'rank_math_description', true)) {
        $desc = wp_trim_words(strip_tags($content), 25);
        update_post_meta($post->ID, 'rank_math_description', $desc);
        echo "✓ Added meta description<br>";
    }
    
    // Focus Keyword
    if (!get_post_meta($post->ID, 'rank_math_focus_keyword', true)) {
        $words = str_word_count(strtolower(strip_tags($title . ' ' . $content)), 1);
        $words = array_filter($words, fn($w) => strlen($w) > 4);
        $freq = array_count_values($words);
        arsort($freq);
        $keywords = implode(', ', array_slice(array_keys($freq), 0, 3));
        update_post_meta($post->ID, 'rank_math_focus_keyword', $keywords);
        echo "✓ Added focus keywords: $keywords<br>";
    }
    
    // SEO Title
    if (!get_post_meta($post->ID, 'rank_math_title', true)) {
        update_post_meta($post->ID, 'rank_math_title', $title . ' | ' . get_bloginfo('name'));
        echo "✓ Optimized SEO title<br>";
    }
    
    // Canonical URL
    update_post_meta($post->ID, 'rank_math_canonical_url', get_permalink($post->ID));
    
    // Robots
    update_post_meta($post->ID, 'rank_math_robots', ['index', 'follow']);
    
    // Breadcrumbs
    update_post_meta($post->ID, 'rank_math_breadcrumb', 'on');
    
    // Schema
    update_post_meta($post->ID, 'rank_math_rich_snippet', 'article');
    
    // Social
    if ($thumb = get_the_post_thumbnail_url($post->ID, 'full')) {
        update_post_meta($post->ID, 'rank_math_facebook_image', $thumb);
        update_post_meta($post->ID, 'rank_math_twitter_image', $thumb);
    }
    
    $count++;
    echo "<strong class='success'>✓ Optimized: {$post->post_title}</strong></div>";
    flush();
}

echo "<h2 style='color:green;'>✓ Complete! Optimized $count pages/posts</h2>";
echo "<p><a href='/wp-admin'>Go to Dashboard</a></p>";
