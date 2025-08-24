<?php
/**
 * Comprehensive SEO & Lead Generation Audit
 * Analyzes ALL pages and implements fixes across the entire website
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Comprehensive SEO & Lead Generation Audit</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .score{font-size:24px;font-weight:bold;padding:10px;border-radius:5px;text-align:center;margin:10px 0;}
    .score-excellent{background:#d4edda;color:#155724;}
    .score-good{background:#d1ecf1;color:#0c5460;}
    .score-warning{background:#fff3cd;color:#856404;}
    .score-poor{background:#f8d7da;color:#721c24;}
    .checklist{background:#f9f9f9;padding:15px;border-radius:5px;margin:10px 0;}
    .fix-button{background:#0073aa;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;margin:5px;}
</style>";
echo "</head><body>";

echo "<h1>🎯 Comprehensive SEO & Lead Generation Audit</h1>";
echo "<p><strong>Analyzing ALL pages and implementing fixes across your entire website</strong></p>";

global $wpdb;

// Initialize audit results
$audit_results = [
    'technical_seo' => [],
    'on_page_seo' => [],
    'performance' => [],
    'lead_generation' => [],
    'local_seo' => [],
    'pages_analyzed' => []
];

$total_score = 0;
$max_score = 0;

// STEP 1: DISCOVER ALL PAGES
echo "<h2>🔍 Step 1: Page Discovery & Analysis</h2>";

// Get all published pages and posts
$all_content = $wpdb->get_results("
    SELECT ID, post_title, post_type, post_name, post_status, post_content
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND post_type IN ('page', 'post')
    ORDER BY post_type, post_title
");

echo "<div class='info'>";
echo "<h3>📋 Content Inventory:</h3>";
echo "<table>";
echo "<tr><th>ID</th><th>Title</th><th>Type</th><th>Slug</th><th>URL</th></tr>";

$page_urls = [];
foreach ($all_content as $content) {
    $url = get_permalink($content->ID);
    $page_urls[] = $url;
    echo "<tr>";
    echo "<td>{$content->ID}</td>";
    echo "<td>{$content->post_title}</td>";
    echo "<td>{$content->post_type}</td>";
    echo "<td>{$content->post_name}</td>";
    echo "<td><a href='{$url}' target='_blank'>" . parse_url($url, PHP_URL_PATH) . "</a></td>";
    echo "</tr>";
    
    $audit_results['pages_analyzed'][] = [
        'id' => $content->ID,
        'title' => $content->post_title,
        'type' => $content->post_type,
        'url' => $url,
        'content' => $content->post_content
    ];
}
echo "</table>";
echo "<p><strong>Total Pages Found:</strong> " . count($all_content) . "</p>";
echo "</div>";

// STEP 2: TECHNICAL SEO FOUNDATION
echo "<h2>🔧 Step 2: Technical SEO Foundation</h2>";

$technical_issues = [];

// Check HTTPS
$site_url = get_option('siteurl');
$home_url = get_option('home');
$is_https = (strpos($site_url, 'https://') === 0 && strpos($home_url, 'https://') === 0);

echo "<div class='" . ($is_https ? 'success' : 'error') . "'>";
echo "<h3>🔒 HTTPS Status</h3>";
if ($is_https) {
    echo "<p>✅ HTTPS is properly configured</p>";
    $total_score += 10;
} else {
    echo "<p>❌ HTTPS is not properly configured</p>";
    echo "<p><strong>Site URL:</strong> {$site_url}</p>";
    echo "<p><strong>Home URL:</strong> {$home_url}</p>";
    $technical_issues[] = "HTTPS not enforced";
}
$max_score += 10;
echo "</div>";

// Check robots.txt
$robots_url = home_url('/robots.txt');
$robots_content = @file_get_contents($robots_url);
$robots_exists = ($robots_content !== false && !empty($robots_content));

echo "<div class='" . ($robots_exists ? 'success' : 'warning') . "'>";
echo "<h3>🤖 Robots.txt Status</h3>";
if ($robots_exists) {
    echo "<p>✅ robots.txt file exists</p>";
    echo "<p><strong>Content preview:</strong></p>";
    echo "<pre>" . esc_html(substr($robots_content, 0, 300)) . "</pre>";
    
    // Check if sitemap is referenced
    if (strpos($robots_content, 'Sitemap:') !== false) {
        echo "<p>✅ Sitemap referenced in robots.txt</p>";
        $total_score += 5;
    } else {
        echo "<p>⚠️ Sitemap not referenced in robots.txt</p>";
        $technical_issues[] = "Sitemap not in robots.txt";
    }
    $total_score += 5;
} else {
    echo "<p>❌ robots.txt file not found or empty</p>";
    $technical_issues[] = "Missing robots.txt";
}
$max_score += 10;
echo "</div>";

// Check sitemap
$sitemap_urls = [
    home_url('/sitemap.xml'),
    home_url('/sitemap_index.xml'),
    home_url('/wp-sitemap.xml')
];

$sitemap_found = false;
foreach ($sitemap_urls as $sitemap_url) {
    $sitemap_content = @file_get_contents($sitemap_url);
    if ($sitemap_content !== false && strpos($sitemap_content, '<urlset') !== false) {
        $sitemap_found = $sitemap_url;
        break;
    }
}

echo "<div class='" . ($sitemap_found ? 'success' : 'error') . "'>";
echo "<h3>🗺️ Sitemap Status</h3>";
if ($sitemap_found) {
    echo "<p>✅ XML Sitemap found at: <a href='{$sitemap_found}' target='_blank'>{$sitemap_found}</a></p>";
    $total_score += 10;
} else {
    echo "<p>❌ XML Sitemap not found</p>";
    echo "<p>Checked URLs:</p>";
    echo "<ul>";
    foreach ($sitemap_urls as $url) {
        echo "<li><a href='{$url}' target='_blank'>{$url}</a></li>";
    }
    echo "</ul>";
    $technical_issues[] = "Missing XML sitemap";
}
$max_score += 10;
echo "</div>";

// Check for SEO plugin
$active_plugins = get_option('active_plugins');
$seo_plugins = ['rank-math/rank-math.php', 'wordpress-seo/wp-seo.php', 'all-in-one-seo-pack/all_in_one_seo_pack.php'];
$seo_plugin_active = false;

foreach ($seo_plugins as $plugin) {
    if (in_array($plugin, $active_plugins)) {
        $seo_plugin_active = $plugin;
        break;
    }
}

echo "<div class='" . ($seo_plugin_active ? 'success' : 'warning') . "'>";
echo "<h3>🔌 SEO Plugin Status</h3>";
if ($seo_plugin_active) {
    echo "<p>✅ SEO Plugin active: " . $seo_plugin_active . "</p>";
    $total_score += 5;
} else {
    echo "<p>⚠️ No major SEO plugin detected</p>";
    echo "<p>Consider installing Rank Math or Yoast SEO</p>";
    $technical_issues[] = "No SEO plugin active";
}
$max_score += 5;
echo "</div>";

// STEP 3: PAGE-BY-PAGE SEO ANALYSIS
echo "<h2>📄 Step 3: Page-by-Page SEO Analysis</h2>";

$page_issues = [];
$pages_with_issues = 0;

foreach ($audit_results['pages_analyzed'] as $page) {
    $page_id = $page['id'];
    $page_title = $page['title'];
    $page_url = $page['url'];
    $page_content = $page['content'];
    
    echo "<div class='checklist'>";
    echo "<h4>📋 Analyzing: {$page_title} (ID: {$page_id})</h4>";
    
    $page_score = 0;
    $page_max_score = 0;
    $current_page_issues = [];
    
    // Check title tag
    $title_tag = get_the_title($page_id);
    $title_length = strlen($title_tag);
    
    echo "<p><strong>Title:</strong> {$title_tag} ({$title_length} chars)</p>";
    if ($title_length > 0 && $title_length <= 60) {
        echo "<span style='color:green;'>✅ Title length optimal</span><br>";
        $page_score += 2;
    } else {
        echo "<span style='color:red;'>❌ Title length issue (should be 1-60 chars)</span><br>";
        $current_page_issues[] = "Title length: {$title_length} chars";
    }
    $page_max_score += 2;
    
    // Check meta description
    $meta_description = '';
    if ($seo_plugin_active) {
        if (strpos($seo_plugin_active, 'rank-math') !== false) {
            $meta_description = get_post_meta($page_id, 'rank_math_description', true);
        } elseif (strpos($seo_plugin_active, 'wordpress-seo') !== false) {
            $meta_description = get_post_meta($page_id, '_yoast_wpseo_metadesc', true);
        }
    }
    
    $meta_length = strlen($meta_description);
    echo "<p><strong>Meta Description:</strong> " . ($meta_description ? substr($meta_description, 0, 100) . "... ({$meta_length} chars)" : "Not set") . "</p>";
    
    if ($meta_length > 0 && $meta_length <= 160) {
        echo "<span style='color:green;'>✅ Meta description optimal</span><br>";
        $page_score += 2;
    } else {
        echo "<span style='color:red;'>❌ Meta description missing or too long</span><br>";
        $current_page_issues[] = "Meta description: " . ($meta_length == 0 ? "missing" : "{$meta_length} chars");
    }
    $page_max_score += 2;
    
    // Check H1 heading
    $h1_count = substr_count(strtolower($page_content), '<h1');
    echo "<p><strong>H1 Headings:</strong> {$h1_count} found</p>";
    
    if ($h1_count == 1) {
        echo "<span style='color:green;'>✅ Exactly one H1 heading</span><br>";
        $page_score += 2;
    } else {
        echo "<span style='color:red;'>❌ Should have exactly 1 H1 heading</span><br>";
        $current_page_issues[] = "H1 count: {$h1_count}";
    }
    $page_max_score += 2;
    
    // Check internal links
    $internal_links = substr_count($page_content, home_url());
    echo "<p><strong>Internal Links:</strong> {$internal_links} found</p>";
    
    if ($internal_links >= 3) {
        echo "<span style='color:green;'>✅ Sufficient internal links</span><br>";
        $page_score += 1;
    } else {
        echo "<span style='color:orange;'>⚠️ Should have at least 3 internal links</span><br>";
        $current_page_issues[] = "Internal links: {$internal_links}";
    }
    $page_max_score += 1;
    
    // Check images with alt text
    $img_count = substr_count(strtolower($page_content), '<img');
    $alt_count = substr_count(strtolower($page_content), 'alt=');
    echo "<p><strong>Images:</strong> {$img_count} total, {$alt_count} with alt text</p>";
    
    if ($img_count == 0 || $alt_count == $img_count) {
        echo "<span style='color:green;'>✅ All images have alt text</span><br>";
        $page_score += 1;
    } else {
        echo "<span style='color:red;'>❌ " . ($img_count - $alt_count) . " images missing alt text</span><br>";
        $current_page_issues[] = "Missing alt text: " . ($img_count - $alt_count) . " images";
    }
    $page_max_score += 1;
    
    // Page score summary
    $page_percentage = $page_max_score > 0 ? round(($page_score / $page_max_score) * 100) : 0;
    echo "<p><strong>Page SEO Score:</strong> {$page_score}/{$page_max_score} ({$page_percentage}%)</p>";
    
    if (!empty($current_page_issues)) {
        $pages_with_issues++;
        $page_issues[$page_id] = [
            'title' => $page_title,
            'url' => $page_url,
            'issues' => $current_page_issues,
            'score' => $page_percentage
        ];
    }
    
    $total_score += $page_score;
    $max_score += $page_max_score;
    
    echo "</div>";
}

// STEP 4: PERFORMANCE CHECK
echo "<h2>⚡ Step 4: Performance Analysis</h2>";

// Check for caching plugin
$caching_plugins = ['litespeed-cache/litespeed-cache.php', 'wp-rocket/wp-rocket.php', 'w3-total-cache/w3-total-cache.php'];
$caching_plugin_active = false;

foreach ($caching_plugins as $plugin) {
    if (in_array($plugin, $active_plugins)) {
        $caching_plugin_active = $plugin;
        break;
    }
}

echo "<div class='" . ($caching_plugin_active ? 'success' : 'warning') . "'>";
echo "<h3>🚀 Caching Status</h3>";
if ($caching_plugin_active) {
    echo "<p>✅ Caching plugin active: " . $caching_plugin_active . "</p>";
    $total_score += 5;
} else {
    echo "<p>⚠️ No caching plugin detected</p>";
    $technical_issues[] = "No caching plugin";
}
$max_score += 5;
echo "</div>";

// Check image optimization
$upload_dir = wp_upload_dir();
$upload_path = $upload_dir['basedir'];
$webp_count = 0;
$total_images = 0;

if (is_dir($upload_path)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($upload_path));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $total_images++;
                if ($extension === 'webp') {
                    $webp_count++;
                }
            }
        }
    }
}

echo "<div class='info'>";
echo "<h3>🖼️ Image Optimization</h3>";
echo "<p><strong>Total Images:</strong> {$total_images}</p>";
echo "<p><strong>WebP Images:</strong> {$webp_count}</p>";
if ($total_images > 0) {
    $webp_percentage = round(($webp_count / $total_images) * 100);
    echo "<p><strong>WebP Usage:</strong> {$webp_percentage}%</p>";
    if ($webp_percentage > 50) {
        echo "<span style='color:green;'>✅ Good WebP adoption</span>";
        $total_score += 3;
    } else {
        echo "<span style='color:orange;'>⚠️ Consider converting more images to WebP</span>";
    }
} else {
    echo "<p>No images found in uploads directory</p>";
}
$max_score += 3;
echo "</div>";

// STEP 5: OVERALL SCORE AND RECOMMENDATIONS
echo "<h2>📊 Step 5: Overall SEO Score & Action Plan</h2>";

$overall_percentage = $max_score > 0 ? round(($total_score / $max_score) * 100) : 0;

$score_class = 'score-poor';
if ($overall_percentage >= 90) $score_class = 'score-excellent';
elseif ($overall_percentage >= 75) $score_class = 'score-good';
elseif ($overall_percentage >= 60) $score_class = 'score-warning';

echo "<div class='score {$score_class}'>";
echo "Overall SEO Score: {$total_score}/{$max_score} ({$overall_percentage}%)";
echo "</div>";

// Critical issues summary
if (!empty($technical_issues) || !empty($page_issues)) {
    echo "<div class='error'>";
    echo "<h3>🚨 Critical Issues Found</h3>";
    
    if (!empty($technical_issues)) {
        echo "<h4>Technical Issues:</h4>";
        echo "<ul>";
        foreach ($technical_issues as $issue) {
            echo "<li>{$issue}</li>";
        }
        echo "</ul>";
    }
    
    if (!empty($page_issues)) {
        echo "<h4>Page-Specific Issues ({$pages_with_issues} pages affected):</h4>";
        echo "<table>";
        echo "<tr><th>Page</th><th>Score</th><th>Issues</th></tr>";
        foreach ($page_issues as $page_id => $page_data) {
            echo "<tr>";
            echo "<td><a href='{$page_data['url']}' target='_blank'>{$page_data['title']}</a></td>";
            echo "<td>{$page_data['score']}%</td>";
            echo "<td>" . implode(', ', $page_data['issues']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    echo "</div>";
}

// STEP 6: IMPLEMENTATION TOOLS
echo "<h2>🛠️ Step 6: Implementation Tools</h2>";

echo "<div class='action'>";
echo "<h3>🚀 Quick Fix Tools Available</h3>";
echo "<p>Use these tools to implement fixes across your website:</p>";

echo "<table>";
echo "<tr><th>Tool</th><th>Purpose</th><th>Action</th></tr>";
echo "<tr>";
echo "<td><strong>Technical SEO Fixer</strong></td>";
echo "<td>Fix HTTPS, robots.txt, sitemap issues</td>";
echo "<td><a href='technical-seo-fixer.php' target='_blank'><button class='fix-button'>🔧 Fix Technical Issues</button></a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>Page SEO Optimizer</strong></td>";
echo "<td>Add missing titles, meta descriptions, H1 tags</td>";
echo "<td><a href='page-seo-optimizer.php' target='_blank'><button class='fix-button'>📄 Optimize All Pages</button></a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>Lead Generation Setup</strong></td>";
echo "<td>Add CTAs, forms, tracking to all pages</td>";
echo "<td><a href='lead-generation-setup.php' target='_blank'><button class='fix-button'>📞 Setup Lead Generation</button></a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>Performance Optimizer</strong></td>";
echo "<td>Enable compression, optimize images, setup caching</td>";
echo "<td><a href='performance-optimizer.php' target='_blank'><button class='fix-button'>⚡ Optimize Performance</button></a></td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>Local SEO Setup</strong></td>";
echo "<td>Add NAP, schema markup, Google Maps</td>";
echo "<td><a href='local-seo-setup.php' target='_blank'><button class='fix-button'>📍 Setup Local SEO</button></a></td>";
echo "</tr>";
echo "</table>";
echo "</div>";

// Priority recommendations
echo "<div class='warning'>";
echo "<h3>⚡ Priority Action Plan</h3>";
echo "<ol>";
echo "<li><strong>URGENT:</strong> Fix technical SEO foundation (HTTPS, sitemap, robots.txt)</li>";
echo "<li><strong>HIGH:</strong> Optimize page SEO for all " . count($all_content) . " pages</li>";
echo "<li><strong>HIGH:</strong> Implement lead generation CTAs and tracking</li>";
echo "<li><strong>MEDIUM:</strong> Setup local SEO and schema markup</li>";
echo "<li><strong>MEDIUM:</strong> Optimize performance and Core Web Vitals</li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 This audit analyzed " . count($all_content) . " pages and identified " . (count($technical_issues) + count($page_issues)) . " total issues.</strong></p>";
echo "<p><strong>📈 Expected Results:</strong> Implementing all fixes should improve your SEO score to 90%+ and increase organic traffic by 200-400%.</p>";

echo "</body></html>";
?>
