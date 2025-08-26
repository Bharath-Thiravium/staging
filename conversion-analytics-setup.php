<?php
/**
 * Conversion Analytics Setup
 * Implements comprehensive tracking for lead generation and conversion optimization
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Conversion Analytics Setup</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .setup-button{background:#17a2b8;color:white;padding:20px 40px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:18px;font-weight:bold;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;font-size:12px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .metric-card{background:#fff;border:1px solid #e9ecef;border-radius:8px;padding:20px;margin:15px 0;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    input[type='text']{padding:10px;margin:5px;border:1px solid #ddd;border-radius:3px;width:300px;}
</style>";
echo "</head><body>";

echo "<h1>📊 Conversion Analytics Setup</h1>";
echo "<p><strong>Implementing comprehensive tracking for lead generation and conversion optimization</strong></p>";

global $wpdb;

// Handle setup
$fixes_applied = [];

if (isset($_POST['setup_analytics'])) {
    $ga4_id = sanitize_text_field($_POST['ga4_id']);
    $gtm_id = get_option('athenas_gtm_id', 'GTM-KWG3X3JD');
    
    if (!empty($ga4_id)) {
        update_option('athenas_ga4_id', $ga4_id);
        $fixes_applied[] = "GA4 Measurement ID saved: {$ga4_id}";
        
        // Add GA4 configuration to GTM
        $ga4_config = "
// Google Analytics 4 Configuration
function athenas_add_ga4_config() {
    \$ga4_id = get_option('athenas_ga4_id');
    \$gtm_id = get_option('athenas_gtm_id');
    
    if (\$ga4_id && \$gtm_id) {
        ?>
        <script>
        // Configure GA4 through GTM
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        
        // GA4 Configuration
        gtag('config', '<?php echo \$ga4_id; ?>', {
            'page_title': '<?php echo esc_js(get_the_title()); ?>',
            'page_location': '<?php echo esc_js(get_permalink()); ?>',
            'content_group1': '<?php echo is_home() || is_front_page() ? \"Homepage\" : (is_page() ? \"Page\" : (is_single() ? \"Post\" : \"Other\")); ?>',
            'custom_map': {
                'dimension1': 'page_type',
                'dimension2': 'user_type'
            }
        });
        
        // Enhanced Ecommerce for Lead Generation
        gtag('config', '<?php echo \$ga4_id; ?>', {
            'custom_map': {
                'metric1': 'lead_score',
                'metric2': 'engagement_time'
            }
        });
        
        // Track page view with enhanced data
        gtag('event', 'page_view', {
            'page_type': '<?php echo is_home() || is_front_page() ? \"homepage\" : (is_page() ? \"page\" : (is_single() ? \"post\" : \"other\")); ?>',
            'page_category': '<?php echo is_page() ? get_post_meta(get_the_ID(), \"page_category\", true) : \"\"; ?>',
            'user_type': '<?php echo is_user_logged_in() ? \"logged_in\" : \"anonymous\"; ?>'
        });
        </script>
        <?php
    }
}
add_action('wp_head', 'athenas_add_ga4_config', 3);
";
        
        $theme_functions = get_template_directory() . '/functions.php';
        if (file_exists($theme_functions)) {
            $current_content = file_get_contents($theme_functions);
            
            if (strpos($current_content, 'athenas_add_ga4_config') === false) {
                $new_content = str_replace('<?php', '<?php' . $ga4_config, $current_content);
                file_put_contents($theme_functions, $new_content);
                $fixes_applied[] = "GA4 configuration added to theme";
            }
        }
    }
}

if (isset($_POST['setup_conversion_tracking'])) {
    // Set up conversion events
    $conversion_events = [
        'form_submit' => 'Contact form submission',
        'phone_click' => 'Phone number click',
        'whatsapp_click' => 'WhatsApp click',
        'email_click' => 'Email click',
        'download_guide' => 'Guide/resource download',
        'consultation_request' => 'Consultation request',
        'quote_request' => 'Quote request',
        'service_inquiry' => 'Service inquiry'
    ];
    
    update_option('athenas_conversion_events', $conversion_events);
    $fixes_applied[] = "Conversion events configured";
    
    // Add enhanced conversion tracking
    $conversion_tracking_code = "
// Enhanced Conversion Tracking
function athenas_enhanced_conversion_tracking() {
    ?>
    <script>
    // Lead scoring system
    let leadScore = 0;
    let engagementTime = 0;
    let startTime = Date.now();
    
    // Track engagement time
    setInterval(function() {
        engagementTime = Math.floor((Date.now() - startTime) / 1000);
        if (engagementTime > 30 && engagementTime % 30 === 0) {
            gtag('event', 'engagement_milestone', {
                'event_category': 'engagement',
                'event_label': engagementTime + '_seconds',
                'value': engagementTime
            });
        }
    }, 1000);
    
    // Track scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', function() {
        let scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
        if (scrollPercent > maxScroll && scrollPercent % 25 === 0) {
            maxScroll = scrollPercent;
            gtag('event', 'scroll_depth', {
                'event_category': 'engagement',
                'event_label': scrollPercent + '_percent',
                'value': scrollPercent
            });
            leadScore += 5;
        }
    });
    
    // Track form interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Form focus tracking
        var formInputs = document.querySelectorAll('input[type=\"text\"], input[type=\"email\"], input[type=\"tel\"], textarea');
        formInputs.forEach(function(input) {
            input.addEventListener('focus', function() {
                gtag('event', 'form_start', {
                    'event_category': 'form_interaction',
                    'event_label': this.name || this.placeholder || 'unknown_field'
                });
                leadScore += 10;
            });
        });
        
        // Form submission tracking with lead scoring
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                leadScore += 50;
                
                gtag('event', 'form_submit', {
                    'event_category': 'lead_generation',
                    'event_label': window.location.pathname,
                    'value': leadScore,
                    'custom_parameters': {
                        'lead_score': leadScore,
                        'engagement_time': engagementTime,
                        'form_type': this.className || 'unknown'
                    }
                });
                
                // Send lead data to server
                fetch('<?php echo admin_url(\"admin-ajax.php\"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=track_lead_conversion&lead_score=' + leadScore + '&engagement_time=' + engagementTime + '&nonce=<?php echo wp_create_nonce(\"athenas_lead_nonce\"); ?>'
                });
            });
        });
        
        // Click tracking for important elements
        var ctaButtons = document.querySelectorAll('.athenas-cta, .elementor-button, .wp-block-button__link');
        ctaButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                leadScore += 15;
                gtag('event', 'cta_click', {
                    'event_category': 'engagement',
                    'event_label': this.textContent.trim(),
                    'value': leadScore
                });
            });
        });
        
        // Phone click tracking
        var phoneLinks = document.querySelectorAll('a[href^=\"tel:\"]');
        phoneLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                leadScore += 30;
                gtag('event', 'phone_click', {
                    'event_category': 'lead_generation',
                    'event_label': this.href,
                    'value': leadScore
                });
            });
        });
        
        // WhatsApp click tracking
        var whatsappLinks = document.querySelectorAll('a[href*=\"wa.me\"], a[href*=\"whatsapp\"]');
        whatsappLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                leadScore += 25;
                gtag('event', 'whatsapp_click', {
                    'event_category': 'lead_generation',
                    'event_label': this.href,
                    'value': leadScore
                });
            });
        });
        
        // Email click tracking
        var emailLinks = document.querySelectorAll('a[href^=\"mailto:\"]');
        emailLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                leadScore += 20;
                gtag('event', 'email_click', {
                    'event_category': 'lead_generation',
                    'event_label': this.href,
                    'value': leadScore
                });
            });
        });
        
        // Download tracking
        var downloadLinks = document.querySelectorAll('a[href$=\".pdf\"], a[href*=\"download\"], a[href*=\"guide\"]');
        downloadLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                leadScore += 35;
                gtag('event', 'download', {
                    'event_category': 'lead_generation',
                    'event_label': this.href,
                    'value': leadScore
                });
            });
        });
    });
    
    // Track exit intent
    document.addEventListener('mouseleave', function(e) {
        if (e.clientY <= 0) {
            gtag('event', 'exit_intent', {
                'event_category': 'engagement',
                'event_label': window.location.pathname,
                'value': leadScore
            });
        }
    });
    
    // Send final engagement data before page unload
    window.addEventListener('beforeunload', function() {
        gtag('event', 'session_end', {
            'event_category': 'engagement',
            'event_label': 'final_score',
            'value': leadScore,
            'custom_parameters': {
                'final_lead_score': leadScore,
                'total_engagement_time': Math.floor((Date.now() - startTime) / 1000)
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'athenas_enhanced_conversion_tracking');

// Handle lead conversion tracking
function athenas_track_lead_conversion() {
    check_ajax_referer('athenas_lead_nonce', 'nonce');
    
    \$lead_data = [
        'lead_score' => intval(\$_POST['lead_score']),
        'engagement_time' => intval(\$_POST['engagement_time']),
        'page_url' => \$_SERVER['HTTP_REFERER'],
        'timestamp' => current_time('mysql'),
        'user_ip' => \$_SERVER['REMOTE_ADDR'],
        'user_agent' => \$_SERVER['HTTP_USER_AGENT']
    ];
    
    // Save to database
    \$leads = get_option('athenas_lead_conversions', []);
    \$leads[] = \$lead_data;
    update_option('athenas_lead_conversions', \$leads);
    
    wp_die();
}
add_action('wp_ajax_track_lead_conversion', 'athenas_track_lead_conversion');
add_action('wp_ajax_nopriv_track_lead_conversion', 'athenas_track_lead_conversion');
";
    
    $theme_functions = get_template_directory() . '/functions.php';
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);
        
        if (strpos($current_content, 'athenas_enhanced_conversion_tracking') === false) {
            $new_content = str_replace('<?php', '<?php' . $conversion_tracking_code, $current_content);
            file_put_contents($theme_functions, $new_content);
            $fixes_applied[] = "Enhanced conversion tracking added";
        }
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>🎉 Analytics Setup Results</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// Current status
$gtm_id = get_option('athenas_gtm_id');
$ga4_id = get_option('athenas_ga4_id');

echo "<h2>📊 Current Analytics Status</h2>";

echo "<div class='metric-card'>";
echo "<h3>🔧 Analytics Configuration</h3>";
echo "<table>";
echo "<tr><th>Component</th><th>Status</th><th>Value</th></tr>";
echo "<tr><td>Google Tag Manager</td><td>" . ($gtm_id ? "✅ Configured" : "❌ Missing") . "</td><td>" . ($gtm_id ?: "Not set") . "</td></tr>";
echo "<tr><td>Google Analytics 4</td><td>" . ($ga4_id ? "✅ Configured" : "❌ Missing") . "</td><td>" . ($ga4_id ?: "Not set") . "</td></tr>";
echo "</table>";
echo "</div>";

if (!$ga4_id) {
    echo "<div class='action'>";
    echo "<h3>🎯 Setup Google Analytics 4</h3>";
    echo "<p>Enter your GA4 Measurement ID to enable comprehensive analytics tracking:</p>";
    echo "<form method='post'>";
    echo "<p><strong>GA4 Measurement ID:</strong></p>";
    echo "<input type='text' name='ga4_id' placeholder='G-XXXXXXXXXX' required>";
    echo "<button type='submit' name='setup_analytics' class='setup-button'>🚀 Setup GA4 Analytics</button>";
    echo "</form>";
    echo "<p><em>Don't have GA4? <a href='https://analytics.google.com' target='_blank'>Create a free account here</a></em></p>";
    echo "</div>";
}

if (!isset($_POST['setup_conversion_tracking'])) {
    echo "<div class='action'>";
    echo "<h3>📈 Setup Enhanced Conversion Tracking</h3>";
    echo "<p>Enable advanced conversion tracking with lead scoring and engagement metrics:</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='setup_conversion_tracking' class='setup-button'>📊 Enable Conversion Tracking</button>";
    echo "</form>";
    echo "</div>";
}

echo "</body></html>";
?>
