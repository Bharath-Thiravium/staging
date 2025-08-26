<?php
/**
 * Comprehensive Website Evaluator
 * Multi-faceted evaluation covering technical SEO, lead generation, UX, and conversion optimization
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Comprehensive Website Evaluation</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .score{font-size:2em;font-weight:bold;text-align:center;padding:20px;border-radius:10px;margin:20px 0;}
    .score.excellent{background:#d4edda;color:#155724;border:2px solid #c3e6cb;}
    .score.good{background:#d1ecf1;color:#0c5460;border:2px solid #bee5eb;}
    .score.fair{background:#fff3cd;color:#856404;border:2px solid #ffeaa7;}
    .score.poor{background:#f8d7da;color:#721c24;border:2px solid #f5c6cb;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .metric{display:flex;justify-content:space-between;align-items:center;padding:10px;margin:5px 0;border-radius:5px;}
    .metric.pass{background:#d4edda;color:#155724;}
    .metric.fail{background:#f8d7da;color:#721c24;}
    .metric.warning{background:#fff3cd;color:#856404;}
    .fix-button{background:#0073aa;color:white;padding:15px 30px;border:none;border-radius:5px;cursor:pointer;margin:10px;font-size:16px;}
</style>";
echo "</head><body>";

echo "<h1>🎯 Comprehensive Website Evaluation</h1>";
echo "<p><strong>Multi-faceted analysis covering technical SEO, lead generation, user experience, and conversion optimization</strong></p>";

global $wpdb;

// Initialize evaluation scores
$scores = [
    'technical_seo' => 0,
    'on_page_seo' => 0,
    'lead_generation' => 0,
    'user_experience' => 0,
    'conversion_optimization' => 0
];

$max_scores = [
    'technical_seo' => 100,
    'on_page_seo' => 100,
    'lead_generation' => 100,
    'user_experience' => 100,
    'conversion_optimization' => 100
];

// SECTION 1: TECHNICAL SEO EVALUATION
echo "<h2>🔧 Section 1: Technical SEO Implementation</h2>";

echo "<div class='info'>";
echo "<h3>📊 Technical SEO Checklist</h3>";

// Check HTTPS
$is_https = is_ssl();
echo "<div class='metric " . ($is_https ? "pass" : "fail") . "'>";
echo "<span>HTTPS/SSL Certificate</span>";
echo "<span>" . ($is_https ? "✅ PASS" : "❌ FAIL") . "</span>";
echo "</div>";
if ($is_https) $scores['technical_seo'] += 15;

// Check XML Sitemap
$sitemap_urls = [
    home_url('/sitemap.xml'),
    home_url('/sitemap_index.xml'),
    home_url('/wp-sitemap.xml')
];

$sitemap_exists = false;
foreach ($sitemap_urls as $sitemap_url) {
    $response = wp_remote_get($sitemap_url);
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $sitemap_exists = true;
        break;
    }
}

echo "<div class='metric " . ($sitemap_exists ? "pass" : "fail") . "'>";
echo "<span>XML Sitemap</span>";
echo "<span>" . ($sitemap_exists ? "✅ PASS" : "❌ FAIL") . "</span>";
echo "</div>";
if ($sitemap_exists) $scores['technical_seo'] += 15;

// Check robots.txt
$robots_url = home_url('/robots.txt');
$robots_response = wp_remote_get($robots_url);
$robots_exists = !is_wp_error($robots_response) && wp_remote_retrieve_response_code($robots_response) === 200;

echo "<div class='metric " . ($robots_exists ? "pass" : "fail") . "'>";
echo "<span>Robots.txt File</span>";
echo "<span>" . ($robots_exists ? "✅ PASS" : "❌ FAIL") . "</span>";
echo "</div>";
if ($robots_exists) $scores['technical_seo'] += 10;

// Check Google Analytics/GTM
$gtm_configured = get_option('athenas_gtm_id') ? true : false;

echo "<div class='metric " . ($gtm_configured ? "pass" : "fail") . "'>";
echo "<span>Google Tag Manager</span>";
echo "<span>" . ($gtm_configured ? "✅ PASS" : "❌ FAIL") . "</span>";
echo "</div>";
if ($gtm_configured) $scores['technical_seo'] += 15;

// Check mobile responsiveness (viewport meta tag)
$homepage_content = file_get_contents(home_url());
$has_viewport = strpos($homepage_content, 'viewport') !== false;

echo "<div class='metric " . ($has_viewport ? "pass" : "fail") . "'>";
echo "<span>Mobile Viewport Meta Tag</span>";
echo "<span>" . ($has_viewport ? "✅ PASS" : "❌ FAIL") . "</span>";
echo "</div>";
if ($has_viewport) $scores['technical_seo'] += 10;

// Check page speed (basic check)
$start_time = microtime(true);
$speed_test = wp_remote_get(home_url());
$load_time = microtime(true) - $start_time;
$speed_good = $load_time < 3.0;

echo "<div class='metric " . ($speed_good ? "pass" : "warning") . "'>";
echo "<span>Page Load Time</span>";
echo "<span>" . ($speed_good ? "✅ GOOD (" . round($load_time, 2) . "s)" : "⚠️ SLOW (" . round($load_time, 2) . "s)") . "</span>";
echo "</div>";
if ($speed_good) $scores['technical_seo'] += 15;

// Check URL structure
$permalink_structure = get_option('permalink_structure');
$clean_urls = !empty($permalink_structure) && $permalink_structure !== '/?p=%post_id%';

echo "<div class='metric " . ($clean_urls ? "pass" : "warning") . "'>";
echo "<span>Clean URL Structure</span>";
echo "<span>" . ($clean_urls ? "✅ PASS" : "⚠️ NEEDS IMPROVEMENT") . "</span>";
echo "</div>";
if ($clean_urls) $scores['technical_seo'] += 10;

// Check for SEO plugin
$seo_plugin_active = false;
$active_plugins = get_option('active_plugins');
if (in_array('seo-by-rank-math/rank-math.php', $active_plugins)) {
    $seo_plugin_active = 'Rank Math';
} elseif (in_array('wordpress-seo/wp-seo.php', $active_plugins)) {
    $seo_plugin_active = 'Yoast SEO';
}

echo "<div class='metric " . ($seo_plugin_active ? "pass" : "warning") . "'>";
echo "<span>SEO Plugin</span>";
echo "<span>" . ($seo_plugin_active ? "✅ " . $seo_plugin_active : "⚠️ NONE DETECTED") . "</span>";
echo "</div>";
if ($seo_plugin_active) $scores['technical_seo'] += 10;

echo "</div>";

// SECTION 2: ON-PAGE SEO EVALUATION
echo "<h2>📝 Section 2: On-Page SEO Quality</h2>";

// Get all published pages
$all_pages = $wpdb->get_results("
    SELECT ID, post_title, post_type, post_name, post_content
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND post_type IN ('page', 'post')
    ORDER BY post_type, post_title
    LIMIT 20
");

$pages_with_seo_issues = 0;
$total_pages = count($all_pages);

echo "<div class='info'>";
echo "<h3>📊 On-Page SEO Analysis</h3>";
echo "<p><strong>Pages Analyzed:</strong> {$total_pages}</p>";

foreach ($all_pages as $page) {
    $has_issues = false;
    
    // Check title length
    $title_length = strlen($page->post_title);
    if ($title_length > 60 || $title_length < 30) {
        $has_issues = true;
    }
    
    // Check for focus keyword (if Rank Math is active)
    if ($seo_plugin_active === 'Rank Math') {
        $focus_keyword = get_post_meta($page->ID, 'rank_math_focus_keyword', true);
        if (empty($focus_keyword)) {
            $has_issues = true;
        }
    }
    
    // Check meta description
    $meta_description = '';
    if ($seo_plugin_active === 'Rank Math') {
        $meta_description = get_post_meta($page->ID, 'rank_math_description', true);
    }
    if (empty($meta_description) || strlen($meta_description) > 160) {
        $has_issues = true;
    }
    
    if ($has_issues) {
        $pages_with_seo_issues++;
    }
}

$seo_quality_score = (($total_pages - $pages_with_seo_issues) / $total_pages) * 100;
$scores['on_page_seo'] = $seo_quality_score;

echo "<div class='metric " . ($seo_quality_score > 80 ? "pass" : ($seo_quality_score > 60 ? "warning" : "fail")) . "'>";
echo "<span>Pages with SEO Issues</span>";
echo "<span>{$pages_with_seo_issues} of {$total_pages} pages (" . round(100 - $seo_quality_score, 1) . "%)</span>";
echo "</div>";

// Check for duplicate content
$duplicate_titles = $wpdb->get_var("
    SELECT COUNT(*) - COUNT(DISTINCT post_title)
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND post_type IN ('page', 'post')
");

echo "<div class='metric " . ($duplicate_titles == 0 ? "pass" : "warning") . "'>";
echo "<span>Duplicate Titles</span>";
echo "<span>" . ($duplicate_titles == 0 ? "✅ NONE FOUND" : "⚠️ {$duplicate_titles} DUPLICATES") . "</span>";
echo "</div>";

echo "</div>";

// SECTION 3: LEAD GENERATION EVALUATION
echo "<h2>🎯 Section 3: Lead Generation Implementation</h2>";

echo "<div class='info'>";
echo "<h3>📊 Lead Generation Analysis</h3>";

// Check for contact forms
$contact_forms = 0;
$form_plugins = [
    'contact-form-7/wp-contact-form-7.php' => 'Contact Form 7',
    'wpforms-lite/wpforms.php' => 'WPForms',
    'formidable/formidable.php' => 'Formidable Forms',
    'elementor-pro/elementor-pro.php' => 'Elementor Pro Forms'
];

$active_form_plugin = false;
foreach ($form_plugins as $plugin_path => $plugin_name) {
    if (in_array($plugin_path, $active_plugins)) {
        $active_form_plugin = $plugin_name;
        break;
    }
}

echo "<div class='metric " . ($active_form_plugin ? "pass" : "fail") . "'>";
echo "<span>Contact Form Plugin</span>";
echo "<span>" . ($active_form_plugin ? "✅ " . $active_form_plugin : "❌ NONE DETECTED") . "</span>";
echo "</div>";
if ($active_form_plugin) $scores['lead_generation'] += 25;

// Check for lead magnets (downloadable content)
$lead_magnets = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND (post_content LIKE '%download%' OR post_content LIKE '%ebook%' OR post_content LIKE '%guide%' OR post_content LIKE '%checklist%')
");

echo "<div class='metric " . ($lead_magnets > 0 ? "pass" : "warning") . "'>";
echo "<span>Lead Magnets (Downloads/Guides)</span>";
echo "<span>" . ($lead_magnets > 0 ? "✅ {$lead_magnets} FOUND" : "⚠️ NONE FOUND") . "</span>";
echo "</div>";
if ($lead_magnets > 0) $scores['lead_generation'] += 20;

// Check for call-to-action buttons
$cta_count = 0;
foreach ($all_pages as $page) {
    if (strpos(strtolower($page->post_content), 'contact') !== false ||
        strpos(strtolower($page->post_content), 'call') !== false ||
        strpos(strtolower($page->post_content), 'quote') !== false) {
        $cta_count++;
    }
}

echo "<div class='metric " . ($cta_count > 5 ? "pass" : "warning") . "'>";
echo "<span>Pages with Call-to-Action</span>";
echo "<span>" . ($cta_count > 5 ? "✅ {$cta_count} PAGES" : "⚠️ {$cta_count} PAGES") . "</span>";
echo "</div>";
if ($cta_count > 5) $scores['lead_generation'] += 25;

// Check for thank you page
$thank_you_page = get_page_by_path('thank-you') || get_page_by_path('thanks');

echo "<div class='metric " . ($thank_you_page ? "pass" : "warning") . "'>";
echo "<span>Thank You Page</span>";
echo "<span>" . ($thank_you_page ? "✅ EXISTS" : "⚠️ MISSING") . "</span>";
echo "</div>";
if ($thank_you_page) $scores['lead_generation'] += 15;

// Check for live chat
$has_live_chat = strpos($homepage_content, 'chat') !== false || 
                 in_array('chaty-pro/chaty-pro.php', $active_plugins);

echo "<div class='metric " . ($has_live_chat ? "pass" : "warning") . "'>";
echo "<span>Live Chat/WhatsApp</span>";
echo "<span>" . ($has_live_chat ? "✅ DETECTED" : "⚠️ NOT DETECTED") . "</span>";
echo "</div>";
if ($has_live_chat) $scores['lead_generation'] += 15;

echo "</div>";

// Calculate overall score
$total_score = array_sum($scores);
$max_total_score = array_sum($max_scores);
$overall_percentage = ($total_score / $max_total_score) * 100;

// Display overall score
echo "<div class='score " . 
    ($overall_percentage >= 90 ? "excellent" : 
     ($overall_percentage >= 75 ? "good" : 
      ($overall_percentage >= 60 ? "fair" : "poor"))) . "'>";
echo "Overall Website Score: " . round($overall_percentage, 1) . "%";
echo "</div>";

echo "</body></html>";
?>
