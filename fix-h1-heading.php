<?php
/**
 * Fix H1 Heading - Replace special characters with SEO-optimized heading
 * This script finds and fixes the problematic H1 heading with special characters
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>H1 Heading Fix Implementation</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
    pre{background:#f4f4f4;padding:15px;border-radius:5px;overflow-x:auto;}
</style>";
echo "</head><body>";

echo "<h1>🔧 H1 Heading Fix Implementation</h1>";

// Step 1: Search for the problematic heading in database
echo "<h2>🔍 Step 1: Searching for Problematic H1 Heading</h2>";

global $wpdb;

// Search patterns for the special character heading
$search_patterns = [
    'ᗩ𝔱𝔥єղα 𝔖ø𝔩ʊեιΘղṩ',
    'ᗩTᕼᙓᑎᗩ',
    'Athena Solutions',
    'ATHENAS',
    'Empowering Your Business Success'
];

$found_content = [];

echo "<div class='info'>";
echo "<h3>🔍 Searching in WordPress database...</h3>";

// Search in posts content
foreach ($search_patterns as $pattern) {
    $posts = $wpdb->get_results($wpdb->prepare("
        SELECT ID, post_title, post_content, post_type 
        FROM {$wpdb->posts} 
        WHERE post_content LIKE %s 
        AND post_status = 'publish'
        LIMIT 10
    ", '%' . $pattern . '%'));
    
    if (!empty($posts)) {
        echo "<strong>Found in posts content (pattern: {$pattern}):</strong><br>";
        foreach ($posts as $post) {
            echo "• Post ID {$post->ID}: {$post->post_title} ({$post->post_type})<br>";
            $found_content[] = [
                'type' => 'post_content',
                'id' => $post->ID,
                'title' => $post->post_title,
                'pattern' => $pattern
            ];
        }
        echo "<br>";
    }
}

// Search in post meta (Elementor data)
foreach ($search_patterns as $pattern) {
    $meta_results = $wpdb->get_results($wpdb->prepare("
        SELECT pm.post_id, pm.meta_key, p.post_title, p.post_type
        FROM {$wpdb->postmeta} pm
        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_value LIKE %s 
        AND p.post_status = 'publish'
        LIMIT 10
    ", '%' . $pattern . '%'));
    
    if (!empty($meta_results)) {
        echo "<strong>Found in post meta (pattern: {$pattern}):</strong><br>";
        foreach ($meta_results as $meta) {
            echo "• Post ID {$meta->post_id}: {$meta->post_title} ({$meta->post_type}) - Meta: {$meta->meta_key}<br>";
            $found_content[] = [
                'type' => 'post_meta',
                'id' => $meta->post_id,
                'title' => $meta->post_title,
                'meta_key' => $meta->meta_key,
                'pattern' => $pattern
            ];
        }
        echo "<br>";
    }
}

// Search in options (theme customizer, etc.)
foreach ($search_patterns as $pattern) {
    $options = $wpdb->get_results($wpdb->prepare("
        SELECT option_name, option_value 
        FROM {$wpdb->options} 
        WHERE option_value LIKE %s 
        LIMIT 10
    ", '%' . $pattern . '%'));
    
    if (!empty($options)) {
        echo "<strong>Found in options (pattern: {$pattern}):</strong><br>";
        foreach ($options as $option) {
            echo "• Option: {$option->option_name}<br>";
            $found_content[] = [
                'type' => 'option',
                'option_name' => $option->option_name,
                'pattern' => $pattern
            ];
        }
        echo "<br>";
    }
}

echo "</div>";

// Step 2: Check homepage settings
echo "<h2>🏠 Step 2: Homepage Settings Analysis</h2>";

$show_on_front = get_option('show_on_front');
$page_on_front = get_option('page_on_front');
$page_for_posts = get_option('page_for_posts');

echo "<div class='info'>";
echo "<h3>📋 Current Homepage Configuration:</h3>";
echo "<strong>Show on front:</strong> {$show_on_front}<br>";
echo "<strong>Page on front ID:</strong> {$page_on_front}<br>";
echo "<strong>Posts page ID:</strong> {$page_for_posts}<br>";

if ($show_on_front === 'page' && $page_on_front) {
    $homepage = get_post($page_on_front);
    echo "<strong>Homepage title:</strong> {$homepage->post_title}<br>";
    echo "<strong>Homepage slug:</strong> {$homepage->post_name}<br>";
    
    // Check if this page has Elementor data
    $elementor_data = get_post_meta($page_on_front, '_elementor_data', true);
    if ($elementor_data) {
        echo "<strong>Elementor data:</strong> Found (this page uses Elementor)<br>";
        
        // Search for heading in Elementor data
        foreach ($search_patterns as $pattern) {
            if (strpos($elementor_data, $pattern) !== false) {
                echo "<div class='warning'>⚠️ Found pattern '{$pattern}' in homepage Elementor data!</div>";
                $found_content[] = [
                    'type' => 'elementor_homepage',
                    'id' => $page_on_front,
                    'title' => $homepage->post_title,
                    'pattern' => $pattern
                ];
            }
        }
    }
} else {
    echo "<strong>Homepage type:</strong> Blog posts (not static page)<br>";
}
echo "</div>";

// Step 3: Provide fix recommendations
echo "<h2>🔧 Step 3: Fix Recommendations</h2>";

if (empty($found_content)) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ No Problematic Content Found</h3>";
    echo "<p>The special character heading was not found in the database. This could mean:</p>";
    echo "<ul>";
    echo "<li>The heading has already been fixed</li>";
    echo "<li>It's stored in a different format or location</li>";
    echo "<li>It's generated dynamically by JavaScript</li>";
    echo "<li>It's in the theme customizer or a different storage location</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>🚨 Problematic Content Found - Immediate Action Required</h3>";
    echo "<p>Found " . count($found_content) . " instances of problematic content that need fixing:</p>";
    echo "</div>";
    
    foreach ($found_content as $content) {
        echo "<div class='action'>";
        echo "<h4>📝 Fix Required:</h4>";
        
        if ($content['type'] === 'elementor_homepage') {
            echo "<strong>Location:</strong> Homepage Elementor content<br>";
            echo "<strong>Post ID:</strong> {$content['id']}<br>";
            echo "<strong>Pattern found:</strong> {$content['pattern']}<br>";
            echo "<strong>Action:</strong> Edit homepage with Elementor and replace the heading<br>";
            echo "<strong>Steps:</strong><br>";
            echo "<ol>";
            echo "<li>Go to WordPress Admin → Pages → Edit Homepage</li>";
            echo "<li>Click 'Edit with Elementor'</li>";
            echo "<li>Find the heading widget with special characters</li>";
            echo "<li>Replace with: 'Accounting, HR & Compliance Services in Madurai | Athenas Business Solutions'</li>";
            echo "<li>Update the page</li>";
            echo "</ol>";
        } elseif ($content['type'] === 'post_content') {
            echo "<strong>Location:</strong> Post/Page content<br>";
            echo "<strong>Post ID:</strong> {$content['id']}<br>";
            echo "<strong>Title:</strong> {$content['title']}<br>";
            echo "<strong>Pattern found:</strong> {$content['pattern']}<br>";
            echo "<strong>Action:</strong> Edit the post/page and fix the heading<br>";
        } elseif ($content['type'] === 'post_meta') {
            echo "<strong>Location:</strong> Post meta data<br>";
            echo "<strong>Post ID:</strong> {$content['id']}<br>";
            echo "<strong>Meta key:</strong> {$content['meta_key']}<br>";
            echo "<strong>Pattern found:</strong> {$content['pattern']}<br>";
            echo "<strong>Action:</strong> Edit with Elementor or update meta data<br>";
        } elseif ($content['type'] === 'option') {
            echo "<strong>Location:</strong> WordPress option<br>";
            echo "<strong>Option name:</strong> {$content['option_name']}<br>";
            echo "<strong>Pattern found:</strong> {$content['pattern']}<br>";
            echo "<strong>Action:</strong> Update the option value<br>";
        }
        echo "</div>";
    }
}

// Step 4: Provide the correct H1 heading
echo "<h2>✅ Step 4: SEO-Optimized H1 Heading</h2>";

echo "<div class='success'>";
echo "<h3>🎯 Replace Your Current H1 With This SEO-Optimized Version:</h3>";
echo "<div class='code'>";
echo "Accounting, HR & Compliance Services in Madurai | Athenas Business Solutions";
echo "</div>";
echo "</div>";

echo "<div class='info'>";
echo "<h3>📋 Alternative H1 Options (Choose One):</h3>";
echo "<div class='code'>";
echo "<strong>Option 1 (Recommended):</strong><br>";
echo "Accounting, HR & Compliance Services in Madurai | Athenas Business Solutions<br><br>";

echo "<strong>Option 2 (Local Focus):</strong><br>";
echo "Professional Accounting & Business Services in Madurai<br><br>";

echo "<strong>Option 3 (Service Focus):</strong><br>";
echo "Expert Accounting, Compliance & HR Solutions for Startups<br><br>";

echo "<strong>Option 4 (Dual Business):</strong><br>";
echo "Athenas Business Solutions - Professional Services & Content Licensing<br>";
echo "</div>";
echo "</div>";

// Step 5: Additional SEO improvements
echo "<h2>🚀 Step 5: Additional SEO Improvements</h2>";

echo "<div class='action'>";
echo "<h3>📈 While You're Fixing the H1, Also Add These:</h3>";
echo "<ol>";
echo "<li><strong>Add Madurai mentions:</strong> Include 'Madurai' in the first paragraph</li>";
echo "<li><strong>Add service keywords:</strong> Mention 'GST registration', 'startup accounting', 'payroll services'</li>";
echo "<li><strong>Add contact info:</strong> Include your Madurai address and phone number</li>";
echo "<li><strong>Add clear CTAs:</strong> 'Get Free Consultation', 'Request Quote'</li>";
echo "</ol>";
echo "</div>";

// Step 6: Verification steps
echo "<h2>🔍 Step 6: Verification Steps</h2>";

echo "<div class='info'>";
echo "<h3>✅ After Making Changes, Verify:</h3>";
echo "<ol>";
echo "<li><strong>View source:</strong> Right-click homepage → View Page Source</li>";
echo "<li><strong>Find H1 tag:</strong> Search for '&lt;h1' in the source code</li>";
echo "<li><strong>Confirm text:</strong> Ensure it shows the new SEO-optimized heading</li>";
echo "<li><strong>Test mobile:</strong> Check how it appears on mobile devices</li>";
echo "<li><strong>Clear caches:</strong> Clear all caching plugins</li>";
echo "</ol>";
echo "</div>";

// Step 7: Next steps
echo "<h2>🎯 Step 7: Next Critical SEO Steps</h2>";

echo "<div class='warning'>";
echo "<h3>⚡ After Fixing H1, Immediately Do These:</h3>";
echo "<ol>";
echo "<li><strong>Add meta description:</strong> Go to Rank Math settings for homepage</li>";
echo "<li><strong>Create Google Business Profile:</strong> Essential for local SEO</li>";
echo "<li><strong>Add Madurai content:</strong> Include location throughout the page</li>";
echo "<li><strong>Optimize service pages:</strong> Add target keywords to each service page</li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎉 Fixing the H1 heading is the most critical first step for your SEO success!</strong></p>";
echo "<p><em>This single change can improve your search rankings significantly because Google uses H1 tags to understand what your page is about.</em></p>";

echo "</body></html>";
?>
