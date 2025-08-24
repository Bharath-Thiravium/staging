<?php
/**
 * Google Tag Manager Installation Tool
 * Installs GTM-KWG3X3JD across all pages with proper placement
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Google Tag Manager Installation</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .install-button{background:#28a745;color:white;padding:20px 40px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:18px;font-weight:bold;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;font-size:12px;}
    .gtm-preview{background:#fff;border:2px solid #0073aa;padding:20px;border-radius:8px;margin:15px 0;}
</style>";
echo "</head><body>";

echo "<h1>📊 Google Tag Manager Installation</h1>";
echo "<p><strong>Installing GTM-KWG3X3JD across your entire WordPress website</strong></p>";

// Handle GTM installation
$fixes_applied = [];
$gtm_id = 'GTM-KWG3X3JD';

if (isset($_POST['install_gtm'])) {
    // Save GTM ID to options
    update_option('athenas_gtm_id', $gtm_id);
    
    // Add GTM code to theme functions.php
    $theme_functions = get_template_directory() . '/functions.php';
    
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);
        
        $gtm_code = "
// Google Tag Manager - GTM-KWG3X3JD
function athenas_gtm_head() {
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KWG3X3JD');</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action('wp_head', 'athenas_gtm_head', 1);

function athenas_gtm_body() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id=GTM-KWG3X3JD\"
    height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action('wp_body_open', 'athenas_gtm_body', 1);

// Initialize dataLayer for enhanced tracking
function athenas_gtm_datalayer() {
    ?>
    <script>
    window.dataLayer = window.dataLayer || [];
    
    // Track page type
    dataLayer.push({
        'page_type': '<?php echo (is_home() || is_front_page()) ? \"homepage\" : (is_page() ? \"page\" : (is_single() ? \"post\" : \"other\")); ?>',
        'page_title': '<?php echo esc_js(get_the_title()); ?>',
        'page_id': '<?php echo get_the_ID(); ?>'
    });
    
    // Enhanced ecommerce for lead generation
    function gtag_report_conversion(event_name, event_category) {
        dataLayer.push({
            'event': event_name,
            'event_category': event_category,
            'event_label': window.location.pathname
        });
    }
    
    // Auto-track form submissions
    document.addEventListener('DOMContentLoaded', function() {
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function() {
                gtag_report_conversion('form_submit', 'lead_generation');
            });
        });
        
        // Track phone clicks
        var phoneLinks = document.querySelectorAll('a[href^=\"tel:\"]');
        phoneLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                gtag_report_conversion('click_call', 'engagement');
            });
        });
        
        // Track WhatsApp clicks
        var whatsappLinks = document.querySelectorAll('a[href*=\"wa.me\"], a[href*=\"whatsapp\"]');
        whatsappLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                gtag_report_conversion('click_whatsapp', 'engagement');
            });
        });
    });
    </script>
    <?php
}
add_action('wp_head', 'athenas_gtm_datalayer', 2);
";
        
        if (strpos($current_content, 'athenas_gtm_head') === false) {
            $new_content = str_replace('<?php', '<?php' . $gtm_code, $current_content);
            if (file_put_contents($theme_functions, $new_content)) {
                $fixes_applied[] = "GTM code installed in theme functions.php";
                $fixes_applied[] = "GTM ID saved: {$gtm_id}";
                $fixes_applied[] = "Enhanced tracking events configured";
                $fixes_applied[] = "Auto-tracking for forms, phone, and WhatsApp clicks enabled";
            }
        } else {
            $fixes_applied[] = "GTM code already exists in theme";
        }
    }
}

if (isset($_POST['test_gtm'])) {
    // Test GTM installation
    $home_url = home_url();
    $response = wp_remote_get($home_url);
    
    if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        
        if (strpos($body, 'GTM-KWG3X3JD') !== false) {
            $fixes_applied[] = "✅ GTM code found on homepage - Installation successful!";
        } else {
            $fixes_applied[] = "❌ GTM code not found - Installation may have failed";
        }
        
        if (strpos($body, 'googletagmanager.com') !== false) {
            $fixes_applied[] = "✅ GTM script loading correctly";
        }
        
        if (strpos($body, 'dataLayer') !== false) {
            $fixes_applied[] = "✅ DataLayer initialized correctly";
        }
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>🎉 GTM Installation Results</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// STEP 1: GTM Installation Status
echo "<h2>📊 Step 1: GTM Installation Status</h2>";

$current_gtm = get_option('athenas_gtm_id');
$theme_functions = get_template_directory() . '/functions.php';
$gtm_installed = false;

if (file_exists($theme_functions)) {
    $functions_content = file_get_contents($theme_functions);
    $gtm_installed = (strpos($functions_content, 'athenas_gtm_head') !== false);
}

if ($gtm_installed && $current_gtm === $gtm_id) {
    echo "<div class='success'>";
    echo "<h3>✅ GTM Already Installed</h3>";
    echo "<p><strong>GTM ID:</strong> {$current_gtm}</p>";
    echo "<p><strong>Status:</strong> Active and tracking</p>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<h3>⚠️ GTM Installation Required</h3>";
    echo "<p><strong>GTM ID to Install:</strong> {$gtm_id}</p>";
    echo "<p><strong>Installation Method:</strong> WordPress theme integration (recommended)</p>";
    echo "</div>";
}

// STEP 2: Installation Preview
echo "<h2>🔍 Step 2: Installation Preview</h2>";

echo "<div class='gtm-preview'>";
echo "<h3>📋 GTM Code That Will Be Installed</h3>";

echo "<h4>1. Head Section Code (wp_head):</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-KWG3X3JD\');</script>
<!-- End Google Tag Manager -->');
echo "</div>";

echo "<h4>2. Body Section Code (wp_body_open):</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KWG3X3JD"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->');
echo "</div>";

echo "<h4>3. Enhanced Tracking Features Included:</h4>";
echo "<ul>";
echo "<li><strong>Automatic Form Tracking:</strong> All contact form submissions</li>";
echo "<li><strong>Phone Click Tracking:</strong> All tel: links</li>";
echo "<li><strong>WhatsApp Click Tracking:</strong> All WhatsApp links</li>";
echo "<li><strong>Page Type Tracking:</strong> Homepage, pages, posts identification</li>";
echo "<li><strong>Enhanced Ecommerce:</strong> Lead generation events</li>";
echo "</ul>";
echo "</div>";

// STEP 3: Installation Action
echo "<h2>🚀 Step 3: Install GTM</h2>";

if (!$gtm_installed) {
    echo "<div class='action'>";
    echo "<h3>🎯 Ready to Install GTM-KWG3X3JD</h3>";
    echo "<p><strong>This will:</strong></p>";
    echo "<ul>";
    echo "<li>Add GTM code to your theme's functions.php</li>";
    echo "<li>Install tracking on ALL pages automatically</li>";
    echo "<li>Enable enhanced conversion tracking</li>";
    echo "<li>Set up automatic event tracking for forms and clicks</li>";
    echo "</ul>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='install_gtm' class='install-button'>🚀 INSTALL GTM NOW</button>";
    echo "</form>";
    echo "</div>";
} else {
    echo "<div class='success'>";
    echo "<h3>✅ GTM Installation Complete</h3>";
    echo "<p>GTM is installed and active on your website!</p>";
    echo "</div>";
}

// STEP 4: Testing and Verification
echo "<h2>🔍 Step 4: Testing & Verification</h2>";

echo "<div class='info'>";
echo "<h3>📋 How to Verify GTM Installation</h3>";

echo "<h4>Method 1: Automatic Test</h4>";
echo "<form method='post'>";
echo "<button type='submit' name='test_gtm' style='background:#17a2b8;color:white;padding:10px 20px;border:none;border-radius:5px;'>🔍 Test GTM Installation</button>";
echo "</form>";

echo "<h4>Method 2: Manual Verification</h4>";
echo "<ol>";
echo "<li><strong>View Page Source:</strong> Right-click on your homepage → View Page Source</li>";
echo "<li><strong>Search for GTM:</strong> Press Ctrl+F and search for 'GTM-KWG3X3JD'</li>";
echo "<li><strong>Check for 2 instances:</strong> One in head, one in body</li>";
echo "</ol>";

echo "<h4>Method 3: GTM Preview Mode</h4>";
echo "<ol>";
echo "<li><strong>Go to GTM:</strong> <a href='https://tagmanager.google.com' target='_blank'>tagmanager.google.com</a></li>";
echo "<li><strong>Select your container:</strong> GTM-KWG3X3JD</li>";
echo "<li><strong>Click Preview:</strong> Enable preview mode</li>";
echo "<li><strong>Visit your site:</strong> You should see GTM debug panel</li>";
echo "</ol>";

echo "<h4>Method 4: Browser Developer Tools</h4>";
echo "<ol>";
echo "<li><strong>Open DevTools:</strong> Press F12 on your website</li>";
echo "<li><strong>Go to Network tab:</strong> Refresh the page</li>";
echo "<li><strong>Search for:</strong> 'googletagmanager.com' requests</li>";
echo "<li><strong>Check Console:</strong> Look for dataLayer messages</li>";
echo "</ol>";
echo "</div>";

// STEP 5: Next Steps
echo "<h2>🎯 Step 5: Next Steps After GTM Installation</h2>";

echo "<div class='action'>";
echo "<h3>📈 Configure GTM for Lead Generation</h3>";
echo "<p>After installing GTM, set up these tracking configurations:</p>";

echo "<h4>1. Google Analytics 4 (GA4) Setup:</h4>";
echo "<ul>";
echo "<li>Create GA4 property in Google Analytics</li>";
echo "<li>Add GA4 tag in GTM with your Measurement ID</li>";
echo "<li>Configure enhanced ecommerce for lead tracking</li>";
echo "</ul>";

echo "<h4>2. Conversion Events to Track:</h4>";
echo "<ul>";
echo "<li><strong>form_submit:</strong> Contact form submissions (auto-tracked)</li>";
echo "<li><strong>click_call:</strong> Phone number clicks (auto-tracked)</li>";
echo "<li><strong>click_whatsapp:</strong> WhatsApp link clicks (auto-tracked)</li>";
echo "<li><strong>page_view:</strong> Thank you page views</li>";
echo "<li><strong>file_download:</strong> Brochure/document downloads</li>";
echo "</ul>";

echo "<h4>3. Enhanced Tracking Setup:</h4>";
echo "<ul>";
echo "<li>Set up Goals in GA4 for each conversion event</li>";
echo "<li>Create Audiences for retargeting</li>";
echo "<li>Configure Google Ads conversion tracking</li>";
echo "<li>Set up Facebook Pixel integration (if needed)</li>";
echo "</ul>";
echo "</div>";

// STEP 6: Troubleshooting
echo "<h2>🔧 Step 6: Troubleshooting</h2>";

echo "<div class='warning'>";
echo "<h3>⚠️ Common Issues & Solutions</h3>";

echo "<h4>Issue: GTM not loading</h4>";
echo "<ul>";
echo "<li><strong>Check caching:</strong> Clear all caches (LiteSpeed, browser)</li>";
echo "<li><strong>Check conflicts:</strong> Disable other tracking plugins temporarily</li>";
echo "<li><strong>Check theme:</strong> Ensure theme supports wp_head and wp_body_open hooks</li>";
echo "</ul>";

echo "<h4>Issue: Events not firing</h4>";
echo "<ul>";
echo "<li><strong>Check dataLayer:</strong> Open browser console and type 'dataLayer'</li>";
echo "<li><strong>Check GTM Preview:</strong> Use preview mode to debug</li>";
echo "<li><strong>Check triggers:</strong> Verify trigger configuration in GTM</li>";
echo "</ul>";

echo "<h4>Issue: Duplicate tracking</h4>";
echo "<ul>";
echo "<li><strong>Remove old codes:</strong> Check for hardcoded GA/GTM codes</li>";
echo "<li><strong>Check plugins:</strong> Disable other analytics plugins</li>";
echo "<li><strong>Check theme:</strong> Remove any existing tracking codes</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 GTM installation enables comprehensive tracking of your lead generation efforts!</strong></p>";

echo "</body></html>";
?>
