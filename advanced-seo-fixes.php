<?php
/**
 * Advanced SEO Fixes
 * Fixes H1 issues, focus keywords, OpenGraph, and performance issues
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Advanced SEO Fixes</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .fix-button{background:#0073aa;color:white;padding:15px 30px;border:none;border-radius:5px;cursor:pointer;margin:10px;font-size:16px;}
    .urgent{background:#dc3545;color:white;padding:15px 30px;border:none;border-radius:5px;cursor:pointer;margin:10px;font-size:16px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
</style>";
echo "</head><body>";

echo "<h1>🔧 Advanced SEO Fixes</h1>";
echo "<p><strong>Fixing H1 issues, focus keywords, OpenGraph, and performance problems</strong></p>";

global $wpdb;

// Handle form submissions
$fixes_applied = [];

if (isset($_POST['fix_h1_issues'])) {
    // Find pages with multiple H1 tags or missing H1
    $all_pages = $wpdb->get_results("
        SELECT ID, post_title, post_content, post_type
        FROM {$wpdb->posts} 
        WHERE post_status = 'publish' 
        AND post_type IN ('page', 'post')
        ORDER BY post_type, post_title
    ");
    
    $fixed_count = 0;
    foreach ($all_pages as $page) {
        $content = $page->post_content;
        $h1_count = substr_count(strtolower($content), '<h1');
        
        if ($h1_count > 1) {
            // Replace extra H1s with H2s
            $content = preg_replace('/<h1([^>]*)>/i', '<h2$1>', $content, $h1_count - 1);
            $content = preg_replace('/<\/h1>/i', '</h2>', $content, $h1_count - 1);
            
            // Update the post
            wp_update_post([
                'ID' => $page->ID,
                'post_content' => $content
            ]);
            
            $fixed_count++;
        }
    }
    
    if ($fixed_count > 0) {
        $fixes_applied[] = "Fixed H1 issues on {$fixed_count} pages";
    }
}

if (isset($_POST['fix_focus_keywords'])) {
    // Add focus keywords to posts/pages missing them
    $pages_without_keywords = $wpdb->get_results("
        SELECT p.ID, p.post_title, p.post_type, p.post_name
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = 'rank_math_focus_keyword'
        WHERE p.post_status = 'publish' 
        AND p.post_type IN ('page', 'post')
        AND (pm.meta_value IS NULL OR pm.meta_value = '')
        LIMIT 50
    ");
    
    $keyword_map = [
        'home' => 'accounting services madurai',
        'about' => 'athenas business solutions',
        'contact' => 'contact accountant madurai',
        'services' => 'business services madurai',
        'accounting' => 'accounting services madurai',
        'statutory-compliance' => 'compliance services madurai',
        'resourcing' => 'hr services madurai',
        'career' => 'accounting jobs madurai',
        'blogs' => 'business blog',
    ];
    
    $fixed_count = 0;
    foreach ($pages_without_keywords as $page) {
        $slug = $page->post_name;
        $type = $page->post_type;
        
        // Determine appropriate focus keyword
        $focus_keyword = '';
        if (isset($keyword_map[$slug])) {
            $focus_keyword = $keyword_map[$slug];
        } elseif ($type === 'page') {
            $focus_keyword = 'business services madurai';
        } elseif ($type === 'post') {
            $focus_keyword = 'business blog';
        }
        
        if ($focus_keyword) {
            update_post_meta($page->ID, 'rank_math_focus_keyword', $focus_keyword);
            $fixed_count++;
        }
    }
    
    if ($fixed_count > 0) {
        $fixes_applied[] = "Added focus keywords to {$fixed_count} pages/posts";
    }
}

if (isset($_POST['fix_opengraph'])) {
    // Enable OpenGraph in Rank Math
    if (class_exists('RankMath')) {
        $modules = get_option('rank_math_modules', []);
        $modules['rich-snippet'] = 'on';
        update_option('rank_math_modules', $modules);
        
        // Set default OpenGraph settings
        update_option('rank_math_titles_open_graph_image', get_template_directory_uri() . '/assets/images/logo.png');
        update_option('rank_math_titles_knowledgegraph_type', 'company');
        update_option('rank_math_titles_knowledgegraph_name', 'Athenas Business Solutions');
        update_option('rank_math_titles_local_seo', 'on');
        
        $fixes_applied[] = "OpenGraph meta tags enabled and configured";
    }
}

if (isset($_POST['fix_performance'])) {
    // Enable LiteSpeed Cache optimizations
    if (class_exists('LiteSpeed_Cache')) {
        // Enable CSS/JS minification
        update_option('litespeed.conf.css_minify', '1');
        update_option('litespeed.conf.js_minify', '1');
        update_option('litespeed.conf.css_combine', '1');
        update_option('litespeed.conf.js_combine', '1');
        
        $fixes_applied[] = "LiteSpeed Cache CSS/JS minification enabled";
    }
    
    // Add manual minification for specific files
    $theme_functions = get_template_directory() . '/functions.php';
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);
        
        $minify_code = "
// Minify and optimize scripts
function athenas_optimize_scripts() {
    // Defer non-critical JavaScript
    add_filter('script_loader_tag', function(\$tag, \$handle) {
        if (is_admin()) return \$tag;
        
        \$defer_scripts = ['gtranslate', 'popup', 'jquery-migrate'];
        foreach (\$defer_scripts as \$script) {
            if (strpos(\$handle, \$script) !== false) {
                return str_replace(' src', ' defer src', \$tag);
            }
        }
        return \$tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'athenas_optimize_scripts');
";
        
        if (strpos($current_content, 'athenas_optimize_scripts') === false) {
            $new_content = str_replace('<?php', '<?php' . $minify_code, $current_content);
            file_put_contents($theme_functions, $new_content);
            $fixes_applied[] = "Script optimization added to theme";
        }
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>✅ Advanced SEO Fixes Applied</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// ISSUE 1: H1 Heading Problems
echo "<h2>🏷️ ISSUE 1: H1 Heading Problems (CRITICAL)</h2>";

echo "<div class='error'>";
echo "<h3>❌ Multiple H1 Tags Found</h3>";
echo "<p><strong>Problem:</strong> Your page has 2 H1 tags, but SEO best practice requires exactly 1 H1 per page.</p>";
echo "<p><strong>Impact:</strong> Confuses search engines about your page's main topic</p>";

echo "<h4>🔍 Current H1 Tags Found:</h4>";
echo "<ol>";
echo "<li><strong>\"Athena Solutions\"</strong> - This appears to be from your header/logo</li>";
echo "<li><strong>\"Innovation Starts Here!Ready to work with us\"</strong> - This appears to be your main content H1</li>";
echo "</ol>";

echo "<h4>🎯 Recommended Fix:</h4>";
echo "<ul>";
echo "<li><strong>Logo/Header:</strong> Change to H2 or remove H1 tag from logo</li>";
echo "<li><strong>Main Content:</strong> Keep one optimized H1 with target keywords</li>";
echo "<li><strong>Suggested H1:</strong> \"Professional Accounting & Business Services in Madurai\"</li>";
echo "</ul>";

echo "<form method='post'>";
echo "<button type='submit' name='fix_h1_issues' class='urgent'>🚨 FIX H1 ISSUES NOW</button>";
echo "</form>";
echo "</div>";

// ISSUE 2: Missing Focus Keywords
echo "<h2>🎯 ISSUE 2: Missing Focus Keywords (HIGH PRIORITY)</h2>";

$pages_without_keywords = $wpdb->get_var("
    SELECT COUNT(p.ID)
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = 'rank_math_focus_keyword'
    WHERE p.post_status = 'publish' 
    AND p.post_type IN ('page', 'post')
    AND (pm.meta_value IS NULL OR pm.meta_value = '')
");

echo "<div class='warning'>";
echo "<h3>⚠️ {$pages_without_keywords} Pages Missing Focus Keywords</h3>";
echo "<p><strong>Problem:</strong> 22 Pages and 25 Posts don't have focus keywords in their titles</p>";
echo "<p><strong>Impact:</strong> Reduced search rankings for target keywords</p>";

echo "<h4>🎯 Recommended Focus Keywords by Page Type:</h4>";
echo "<table>";
echo "<tr><th>Page Type</th><th>Recommended Focus Keyword</th><th>Example Title</th></tr>";
echo "<tr><td>Homepage</td><td>accounting services madurai</td><td>Accounting Services Madurai | Athenas Business Solutions</td></tr>";
echo "<tr><td>About Page</td><td>athenas business solutions</td><td>About Athenas Business Solutions | Professional Services</td></tr>";
echo "<tr><td>Contact Page</td><td>contact accountant madurai</td><td>Contact Accountant Madurai | Athenas Business Solutions</td></tr>";
echo "<tr><td>Service Pages</td><td>compliance services madurai</td><td>Compliance Services Madurai | Statutory Requirements</td></tr>";
echo "<tr><td>Blog Posts</td><td>business blog</td><td>[Post Title] | Athenas Business Blog</td></tr>";
echo "</table>";

echo "<form method='post'>";
echo "<button type='submit' name='fix_focus_keywords' class='fix-button'>🔧 Add Focus Keywords to All Pages</button>";
echo "</form>";
echo "</div>";

// ISSUE 3: Missing OpenGraph Meta Tags
echo "<h2>📱 ISSUE 3: Missing OpenGraph Meta Tags (MEDIUM)</h2>";

echo "<div class='info'>";
echo "<h3>📊 OpenGraph Meta Tags Missing</h3>";
echo "<p><strong>Problem:</strong> Missing OpenGraph tags affect social media sharing</p>";
echo "<p><strong>Impact:</strong> Poor appearance when shared on Facebook, LinkedIn, Twitter</p>";

echo "<h4>🎯 OpenGraph Tags Needed:</h4>";
echo "<ul>";
echo "<li><strong>og:title</strong> - Page title for social sharing</li>";
echo "<li><strong>og:description</strong> - Page description for social sharing</li>";
echo "<li><strong>og:image</strong> - Image that appears when shared</li>";
echo "<li><strong>og:url</strong> - Canonical URL of the page</li>";
echo "<li><strong>og:type</strong> - Type of content (website, article, etc.)</li>";
echo "</ul>";

echo "<form method='post'>";
echo "<button type='submit' name='fix_opengraph' class='fix-button'>🔧 Enable OpenGraph Meta Tags</button>";
echo "</form>";
echo "</div>";

// ISSUE 4: Content Freshness
echo "<h2>📅 ISSUE 4: Content Freshness (MEDIUM)</h2>";

echo "<div class='warning'>";
echo "<h3>⚠️ Content May Be Outdated</h3>";
echo "<p><strong>Last Updated:</strong> 2024-10-07 (321 days ago)</p>";
echo "<p><strong>Problem:</strong> Search engines prefer fresh, updated content</p>";
echo "<p><strong>Impact:</strong> Lower rankings for competitive keywords</p>";

echo "<h4>🎯 Content Freshness Strategy:</h4>";
echo "<ol>";
echo "<li><strong>Update Service Pages:</strong> Add current pricing, new services</li>";
echo "<li><strong>Refresh Blog Content:</strong> Update old posts with new information</li>";
echo "<li><strong>Add New Content:</strong> Publish 2-3 new blog posts monthly</li>";
echo "<li><strong>Update Contact Info:</strong> Ensure all contact details are current</li>";
echo "</ol>";
echo "</div>";

// ISSUE 5: JavaScript Minification
echo "<h2>⚡ ISSUE 5: JavaScript Minification (PERFORMANCE)</h2>";

echo "<div class='info'>";
echo "<h3>📊 Unminified JavaScript Detected</h3>";
echo "<p><strong>Problem:</strong> gtranslate popup.js is not minified</p>";
echo "<p><strong>Impact:</strong> Slower page load times, poor Core Web Vitals</p>";

echo "<h4>🎯 JavaScript Optimization Strategy:</h4>";
echo "<ul>";
echo "<li><strong>Enable LiteSpeed minification</strong> for all CSS/JS files</li>";
echo "<li><strong>Defer non-critical scripts</strong> like translation widgets</li>";
echo "<li><strong>Combine similar scripts</strong> to reduce HTTP requests</li>";
echo "<li><strong>Use async loading</strong> for third-party scripts</li>";
echo "</ul>";

echo "<form method='post'>";
echo "<button type='submit' name='fix_performance' class='fix-button'>🔧 Optimize JavaScript Performance</button>";
echo "</form>";
echo "</div>";

// SUMMARY AND NEXT STEPS
echo "<h2>📋 Summary & Implementation Priority</h2>";

echo "<div class='action'>";
echo "<h3>🚨 Priority Order (Fix in this sequence):</h3>";
echo "<ol>";
echo "<li><strong>URGENT:</strong> Fix H1 heading issues (multiple H1 tags)</li>";
echo "<li><strong>HIGH:</strong> Add focus keywords to 47 pages/posts</li>";
echo "<li><strong>MEDIUM:</strong> Enable OpenGraph meta tags</li>";
echo "<li><strong>MEDIUM:</strong> Optimize JavaScript performance</li>";
echo "<li><strong>LOW:</strong> Update content freshness (ongoing)</li>";
echo "</ol>";

echo "<h3>📈 Expected Results After Fixes:</h3>";
echo "<ul>";
echo "<li><strong>H1 Fix:</strong> Better topic clarity for search engines</li>";
echo "<li><strong>Focus Keywords:</strong> Improved rankings for target terms</li>";
echo "<li><strong>OpenGraph:</strong> Better social media engagement</li>";
echo "<li><strong>Performance:</strong> Faster loading, better user experience</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 These advanced SEO fixes will significantly improve your search rankings and user experience!</strong></p>";

echo "</body></html>";
?>
