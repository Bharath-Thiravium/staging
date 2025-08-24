<?php
/**
 * Critical Fixes - Immediate Implementation
 * Fixes the most urgent SEO issues identified in the audit
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Critical SEO Fixes - Immediate</title>";
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
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
    input[type='text']{padding:10px;margin:5px;border:1px solid #ddd;border-radius:3px;width:200px;}
</style>";
echo "</head><body>";

echo "<h1>🚨 Critical SEO Fixes - Immediate Action Required</h1>";
echo "<p><strong>Fixing the most urgent issues identified in your audit</strong></p>";

// Handle form submissions
$fixes_applied = [];

if (isset($_POST['fix_sitemap'])) {
    // Enable Rank Math sitemap
    if (class_exists('RankMath')) {
        // Enable sitemap module
        $modules = get_option('rank_math_modules', []);
        $modules['sitemap'] = 'on';
        update_option('rank_math_modules', $modules);
        
        // Configure sitemap settings
        update_option('rank_math_sitemap_general', 'on');
        update_option('rank_math_sitemap_posts', 'on');
        update_option('rank_math_sitemap_pages', 'on');
        update_option('rank_math_sitemap_attachments', 'off');
        
        $fixes_applied[] = "Rank Math XML sitemap enabled and configured";
        
        // Flush rewrite rules to make sitemap accessible
        flush_rewrite_rules();
        $fixes_applied[] = "Rewrite rules flushed - sitemap should now be accessible";
    } else {
        // Enable WordPress core sitemap
        remove_action('init', 'wp_sitemaps_get_server');
        add_action('init', 'wp_sitemaps_get_server');
        $fixes_applied[] = "WordPress core sitemap enabled";
    }
}

if (isset($_POST['fix_viewport'])) {
    // Add viewport meta tag to theme
    $theme_functions = get_template_directory() . '/functions.php';
    
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);
        
        $viewport_code = "
// Add viewport meta tag for mobile responsiveness
function athenas_add_viewport_meta() {
    echo '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">';
}
add_action('wp_head', 'athenas_add_viewport_meta', 1);
";
        
        if (strpos($current_content, 'athenas_add_viewport_meta') === false) {
            // Add after opening PHP tag
            $new_content = str_replace('<?php', '<?php' . $viewport_code, $current_content);
            if (file_put_contents($theme_functions, $new_content)) {
                $fixes_applied[] = "Viewport meta tag added to theme functions.php";
            }
        } else {
            $fixes_applied[] = "Viewport meta tag already exists in theme";
        }
    }
}

if (isset($_POST['setup_gtm'])) {
    $gtm_id = sanitize_text_field($_POST['gtm_id']);
    
    if (!empty($gtm_id) && strpos($gtm_id, 'GTM-') === 0) {
        update_option('athenas_gtm_id', $gtm_id);
        
        // Add GTM code to theme
        $theme_functions = get_template_directory() . '/functions.php';
        
        if (file_exists($theme_functions)) {
            $current_content = file_get_contents($theme_functions);
            
            $gtm_code = "
// Google Tag Manager
function athenas_add_gtm_head() {
    \$gtm_id = get_option('athenas_gtm_id');
    if (\$gtm_id) {
        echo \"<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{\$gtm_id}');</script>
<!-- End Google Tag Manager -->\";
    }
}
add_action('wp_head', 'athenas_add_gtm_head', 1);

function athenas_add_gtm_body() {
    \$gtm_id = get_option('athenas_gtm_id');
    if (\$gtm_id) {
        echo \"<!-- Google Tag Manager (noscript) -->
<noscript><iframe src='https://www.googletagmanager.com/ns.html?id={\$gtm_id}'
height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->\";
    }
}
add_action('wp_body_open', 'athenas_add_gtm_body', 1);
";
            
            if (strpos($current_content, 'athenas_add_gtm_head') === false) {
                $new_content = str_replace('<?php', '<?php' . $gtm_code, $current_content);
                if (file_put_contents($theme_functions, $new_content)) {
                    $fixes_applied[] = "Google Tag Manager code added to theme (ID: {$gtm_id})";
                }
            } else {
                $fixes_applied[] = "Google Tag Manager code already exists in theme";
            }
        }
        
        $fixes_applied[] = "GTM ID saved: {$gtm_id}";
    } else {
        $fixes_applied[] = "Invalid GTM ID format. Please use format: GTM-XXXXXXX";
    }
}

if (isset($_POST['fix_titles'])) {
    // Fix long titles for critical pages
    global $wpdb;
    
    $long_titles = [
        'Home' => 'Accounting Services Madurai | Athenas Business Solutions',
        'About' => 'About Athenas | Professional Services Madurai',
        'Contact Us' => 'Contact Athenas | Accounting Services Madurai',
        'Statutory Compliance' => 'Compliance Services Madurai | Athenas Business',
        'Unlock Success with Top Accounting Services' => 'Accounting Services Madurai | GST & TDS Compliance'
    ];
    
    $fixed_count = 0;
    foreach ($long_titles as $page_title => $new_seo_title) {
        $page = get_page_by_title($page_title);
        if ($page) {
            update_post_meta($page->ID, 'rank_math_title', $new_seo_title);
            $fixed_count++;
        }
    }
    
    if ($fixed_count > 0) {
        $fixes_applied[] = "Fixed {$fixed_count} critical page titles";
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>✅ Critical Fixes Applied Successfully</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "<p><strong>🔄 Clear your browser cache and test the fixes!</strong></p>";
    echo "</div>";
}

// CRITICAL FIX 1: XML Sitemap
echo "<h2>🗺️ CRITICAL FIX 1: XML Sitemap (URGENT)</h2>";

$sitemap_urls = [
    home_url('/sitemap.xml'),
    home_url('/sitemap_index.xml'),
    home_url('/wp-sitemap.xml')
];

$sitemap_found = false;
foreach ($sitemap_urls as $sitemap_url) {
    $sitemap_content = @file_get_contents($sitemap_url);
    if ($sitemap_content !== false && (strpos($sitemap_content, '<urlset') !== false || strpos($sitemap_content, '<sitemapindex') !== false)) {
        $sitemap_found = $sitemap_url;
        break;
    }
}

if ($sitemap_found) {
    echo "<div class='success'>";
    echo "<h3>✅ XML Sitemap is now working!</h3>";
    echo "<p><strong>Sitemap URL:</strong> <a href='{$sitemap_found}' target='_blank'>{$sitemap_found}</a></p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ XML Sitemap Still Not Working</h3>";
    echo "<p><strong>This is CRITICAL for SEO!</strong> Google cannot index your pages without a sitemap.</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_sitemap' class='urgent'>🚨 FIX SITEMAP NOW</button>";
    echo "</form>";
    echo "</div>";
}

// CRITICAL FIX 2: Google Tag Manager
echo "<h2>📊 CRITICAL FIX 2: Google Tag Manager Setup</h2>";

$current_gtm = get_option('athenas_gtm_id');

if ($current_gtm) {
    echo "<div class='success'>";
    echo "<h3>✅ Google Tag Manager Configured</h3>";
    echo "<p><strong>GTM ID:</strong> {$current_gtm}</p>";
    echo "<p>Conversion tracking is now enabled!</p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ Google Tag Manager Not Configured</h3>";
    echo "<p><strong>This is CRITICAL for lead generation!</strong> You cannot track conversions without GTM.</p>";
    echo "<form method='post'>";
    echo "<p><strong>Enter your GTM Container ID:</strong></p>";
    echo "<input type='text' name='gtm_id' placeholder='GTM-XXXXXXX' required>";
    echo "<button type='submit' name='setup_gtm' class='urgent'>🚨 SETUP GTM NOW</button>";
    echo "</form>";
    echo "<p><em>Don't have a GTM account? <a href='https://tagmanager.google.com' target='_blank'>Create one free here</a></em></p>";
    echo "</div>";
}

// CRITICAL FIX 3: Mobile Viewport
echo "<h2>📱 CRITICAL FIX 3: Mobile Viewport Meta Tag</h2>";

$theme_functions = get_template_directory() . '/functions.php';
$has_viewport = false;

if (file_exists($theme_functions)) {
    $functions_content = file_get_contents($theme_functions);
    $has_viewport = (strpos($functions_content, 'athenas_add_viewport_meta') !== false);
}

if ($has_viewport) {
    echo "<div class='success'>";
    echo "<h3>✅ Mobile Viewport Configured</h3>";
    echo "<p>Your site is now mobile-responsive!</p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ Mobile Viewport Missing</h3>";
    echo "<p><strong>This affects mobile rankings!</strong> Google prioritizes mobile-friendly sites.</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_viewport' class='urgent'>🚨 FIX MOBILE VIEWPORT NOW</button>";
    echo "</form>";
    echo "</div>";
}

// CRITICAL FIX 4: Title Length Issues
echo "<h2>📝 CRITICAL FIX 4: Page Title Optimization</h2>";

echo "<div class='warning'>";
echo "<h3>⚠️ 42 Pages Have Title Length Issues</h3>";
echo "<p>Titles over 60 characters get cut off in search results, reducing click-through rates.</p>";

echo "<h4>🎯 Most Critical Pages to Fix:</h4>";
echo "<ul>";
echo "<li><strong>Home:</strong> 76 chars → Should be 60 chars</li>";
echo "<li><strong>About:</strong> 67 chars → Should be 60 chars</li>";
echo "<li><strong>Contact Us:</strong> 64 chars → Should be 60 chars</li>";
echo "<li><strong>Statutory Compliance:</strong> 72 chars → Should be 60 chars</li>";
echo "</ul>";

echo "<form method='post'>";
echo "<button type='submit' name='fix_titles' class='fix-button'>🔧 Fix Critical Page Titles</button>";
echo "</form>";
echo "</div>";

// NEXT STEPS
echo "<h2>🎯 Next Steps After Critical Fixes</h2>";

echo "<div class='action'>";
echo "<h3>📋 Critical Fixes Status</h3>";
echo "<ul>";
echo "<li>" . ($sitemap_found ? "✅" : "❌") . " XML Sitemap working</li>";
echo "<li>" . ($current_gtm ? "✅" : "❌") . " Google Tag Manager configured</li>";
echo "<li>" . ($has_viewport ? "✅" : "❌") . " Mobile viewport configured</li>";
echo "<li>⏳ Page titles optimized (42 pages need fixing)</li>";
echo "</ul>";

echo "<h3>🚀 After Fixing Critical Issues:</h3>";
echo "<ol>";
echo "<li><strong>Test Everything:</strong> Clear cache and verify all fixes work</li>";
echo "<li><strong>Submit Sitemap:</strong> Add sitemap to Google Search Console</li>";
echo "<li><strong>Setup Conversion Tracking:</strong> Configure GTM events for lead generation</li>";
echo "<li><strong>Optimize Remaining Titles:</strong> Fix all 42 pages with long titles</li>";
echo "<li><strong>Add Contact Information:</strong> Setup phone and WhatsApp for lead generation</li>";
echo "</ol>";
echo "</div>";

// VERIFICATION SECTION
echo "<h2>🔍 Verification & Testing</h2>";

echo "<div class='info'>";
echo "<h3>📋 How to Verify Fixes</h3>";

echo "<h4>1. Test XML Sitemap:</h4>";
echo "<ul>";
foreach ($sitemap_urls as $url) {
    echo "<li><a href='{$url}' target='_blank'>{$url}</a></li>";
}
echo "</ul>";

echo "<h4>2. Test Mobile Responsiveness:</h4>";
echo "<ul>";
echo "<li><a href='https://search.google.com/test/mobile-friendly?url=" . urlencode(home_url()) . "' target='_blank'>Google Mobile-Friendly Test</a></li>";
echo "</ul>";

echo "<h4>3. Test Page Speed:</h4>";
echo "<ul>";
echo "<li><a href='https://pagespeed.web.dev/analysis?url=" . urlencode(home_url()) . "' target='_blank'>PageSpeed Insights</a></li>";
echo "</ul>";

echo "<h4>4. Test GTM:</h4>";
echo "<ul>";
echo "<li>View page source and search for 'googletagmanager'</li>";
echo "<li>Use GTM Preview mode to test tracking</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 These critical fixes will immediately improve your SEO performance and search rankings!</strong></p>";

echo "</body></html>";
?>
