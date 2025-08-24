<?php
/**
 * Technical SEO Fixer
 * Fixes HTTPS, robots.txt, sitemap, and core technical SEO issues
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Technical SEO Fixer</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .fix-button{background:#0073aa;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;margin:5px;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
</style>";
echo "</head><body>";

echo "<h1>🔧 Technical SEO Fixer</h1>";
echo "<p><strong>Fixing core technical SEO issues across your website</strong></p>";

// Handle form submissions
$fixes_applied = [];

if (isset($_POST['fix_https'])) {
    // Fix HTTPS URLs
    $home_updated = update_option('home', 'https://athenas.co.in');
    $siteurl_updated = update_option('siteurl', 'https://athenas.co.in');
    
    if ($home_updated || $siteurl_updated) {
        $fixes_applied[] = "HTTPS URLs updated in WordPress settings";
    }
}

if (isset($_POST['fix_robots'])) {
    // Create/update robots.txt
    $robots_content = "User-agent: *
Allow: /

# Block admin and sensitive areas
Disallow: /wp-admin/
Disallow: /wp-includes/
Disallow: /wp-content/plugins/
Disallow: /wp-content/themes/
Disallow: /wp-login.php
Disallow: /wp-register.php
Disallow: /xmlrpc.php
Disallow: /?s=
Disallow: /search/
Disallow: /author/
Disallow: /users/
Disallow: */feed/
Disallow: */comments/
Disallow: */trackback/

# Allow important directories
Allow: /wp-content/uploads/
Allow: /wp-content/themes/*/css/
Allow: /wp-content/themes/*/js/
Allow: /wp-content/themes/*/images/

# Sitemap location
Sitemap: https://athenas.co.in/sitemap.xml
Sitemap: https://athenas.co.in/wp-sitemap.xml";

    $robots_file = ABSPATH . 'robots.txt';
    if (file_put_contents($robots_file, $robots_content)) {
        $fixes_applied[] = "robots.txt file created/updated";
    }
}

if (isset($_POST['fix_sitemap'])) {
    // Enable WordPress core sitemap if available
    if (function_exists('wp_sitemaps_get_server')) {
        add_filter('wp_sitemaps_enabled', '__return_true');
        $fixes_applied[] = "WordPress core sitemap enabled";
    }
    
    // If Rank Math is active, ensure sitemap is enabled
    if (class_exists('RankMath')) {
        update_option('rank_math_sitemap_general', 'on');
        $fixes_applied[] = "Rank Math sitemap enabled";
    }
}

if (isset($_POST['fix_gtm'])) {
    // Add Google Tag Manager code
    $gtm_id = sanitize_text_field($_POST['gtm_id']);
    if (!empty($gtm_id)) {
        update_option('athenas_gtm_id', $gtm_id);
        $fixes_applied[] = "Google Tag Manager ID saved: {$gtm_id}";
    }
}

if (isset($_POST['fix_meta_viewport'])) {
    // Add viewport meta tag to theme
    $theme_functions = get_template_directory() . '/functions.php';
    $viewport_code = "
// Add viewport meta tag for mobile responsiveness
function athenas_add_viewport_meta() {
    echo '<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">';
}
add_action('wp_head', 'athenas_add_viewport_meta', 1);
";
    
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);
        if (strpos($current_content, 'athenas_add_viewport_meta') === false) {
            $new_content = str_replace('<?php', '<?php' . $viewport_code, $current_content);
            if (file_put_contents($theme_functions, $new_content)) {
                $fixes_applied[] = "Viewport meta tag added to theme";
            }
        } else {
            $fixes_applied[] = "Viewport meta tag already exists";
        }
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>✅ Fixes Applied Successfully</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// STEP 1: HTTPS Check and Fix
echo "<h2>🔒 Step 1: HTTPS Configuration</h2>";

$site_url = get_option('siteurl');
$home_url = get_option('home');
$is_https = (strpos($site_url, 'https://') === 0 && strpos($home_url, 'https://') === 0);

if ($is_https) {
    echo "<div class='success'>";
    echo "<h3>✅ HTTPS is properly configured</h3>";
    echo "<p><strong>Site URL:</strong> {$site_url}</p>";
    echo "<p><strong>Home URL:</strong> {$home_url}</p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ HTTPS needs to be fixed</h3>";
    echo "<p><strong>Current Site URL:</strong> {$site_url}</p>";
    echo "<p><strong>Current Home URL:</strong> {$home_url}</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_https' class='fix-button'>🔧 Fix HTTPS URLs</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 2: Robots.txt Check and Fix
echo "<h2>🤖 Step 2: Robots.txt Configuration</h2>";

$robots_url = home_url('/robots.txt');
$robots_content = @file_get_contents($robots_url);
$robots_exists = ($robots_content !== false && !empty($robots_content));

if ($robots_exists) {
    echo "<div class='success'>";
    echo "<h3>✅ robots.txt file exists</h3>";
    echo "<p><strong>URL:</strong> <a href='{$robots_url}' target='_blank'>{$robots_url}</a></p>";
    echo "<p><strong>Content preview:</strong></p>";
    echo "<div class='code'>" . esc_html(substr($robots_content, 0, 500)) . "</div>";
    
    if (strpos($robots_content, 'Sitemap:') === false) {
        echo "<div class='warning'>";
        echo "<p>⚠️ Sitemap not referenced in robots.txt</p>";
        echo "<form method='post'>";
        echo "<button type='submit' name='fix_robots' class='fix-button'>🔧 Update robots.txt with sitemap</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ robots.txt file missing or empty</h3>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_robots' class='fix-button'>🔧 Create SEO-optimized robots.txt</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 3: Sitemap Check and Fix
echo "<h2>🗺️ Step 3: XML Sitemap Configuration</h2>";

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

if ($sitemap_found) {
    echo "<div class='success'>";
    echo "<h3>✅ XML Sitemap found</h3>";
    echo "<p><strong>URL:</strong> <a href='{$sitemap_found}' target='_blank'>{$sitemap_found}</a></p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ XML Sitemap not found</h3>";
    echo "<p>Checked URLs:</p>";
    echo "<ul>";
    foreach ($sitemap_urls as $url) {
        echo "<li><a href='{$url}' target='_blank'>{$url}</a></li>";
    }
    echo "</ul>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_sitemap' class='fix-button'>🔧 Enable XML Sitemap</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 4: Google Tag Manager Setup
echo "<h2>📊 Step 4: Google Tag Manager Setup</h2>";

$current_gtm = get_option('athenas_gtm_id');

if ($current_gtm) {
    echo "<div class='success'>";
    echo "<h3>✅ Google Tag Manager configured</h3>";
    echo "<p><strong>GTM ID:</strong> {$current_gtm}</p>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Google Tag Manager not configured</h3>";
    echo "<p>Add your GTM container ID to enable tracking:</p>";
    echo "<form method='post'>";
    echo "<input type='text' name='gtm_id' placeholder='GTM-XXXXXXX' style='padding:10px;margin:5px;'>";
    echo "<button type='submit' name='fix_gtm' class='fix-button'>🔧 Setup GTM</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 5: Mobile Responsiveness
echo "<h2>📱 Step 5: Mobile Responsiveness</h2>";

$theme_functions = get_template_directory() . '/functions.php';
$has_viewport = false;

if (file_exists($theme_functions)) {
    $functions_content = file_get_contents($theme_functions);
    $has_viewport = (strpos($functions_content, 'viewport') !== false);
}

if ($has_viewport) {
    echo "<div class='success'>";
    echo "<h3>✅ Viewport meta tag configured</h3>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Viewport meta tag missing</h3>";
    echo "<p>This is required for mobile responsiveness</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_meta_viewport' class='fix-button'>🔧 Add Viewport Meta Tag</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 6: Summary and Next Steps
echo "<h2>🎯 Step 6: Summary & Next Steps</h2>";

echo "<div class='action'>";
echo "<h3>📋 Technical SEO Checklist</h3>";
echo "<ul>";
echo "<li>" . ($is_https ? "✅" : "❌") . " HTTPS enforced</li>";
echo "<li>" . ($robots_exists ? "✅" : "❌") . " robots.txt configured</li>";
echo "<li>" . ($sitemap_found ? "✅" : "❌") . " XML sitemap available</li>";
echo "<li>" . ($current_gtm ? "✅" : "❌") . " Google Tag Manager setup</li>";
echo "<li>" . ($has_viewport ? "✅" : "❌") . " Mobile viewport configured</li>";
echo "</ul>";

echo "<h3>🚀 Next Steps</h3>";
echo "<ol>";
echo "<li><strong>Page SEO:</strong> <a href='page-seo-optimizer.php'>Optimize all page titles, meta descriptions, and H1 tags</a></li>";
echo "<li><strong>Lead Generation:</strong> <a href='lead-generation-setup.php'>Add CTAs and conversion tracking</a></li>";
echo "<li><strong>Performance:</strong> <a href='performance-optimizer.php'>Optimize images and enable caching</a></li>";
echo "<li><strong>Local SEO:</strong> <a href='local-seo-setup.php'>Add NAP and schema markup</a></li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎉 Technical SEO foundation is critical for all other SEO efforts to be effective!</strong></p>";

echo "</body></html>";
?>
