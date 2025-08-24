<?php
/**
 * Lead Generation Setup
 * Implements CTAs, forms, tracking, and conversion optimization across all pages
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Lead Generation Setup</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .fix-button{background:#0073aa;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;margin:5px;}
    .cta-preview{background:#f9f9f9;padding:15px;border-radius:5px;margin:10px 0;border:1px solid #ddd;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;font-size:12px;}
    input[type='text'], input[type='tel']{padding:8px;margin:5px;border:1px solid #ddd;border-radius:3px;}
</style>";
echo "</head><body>";

echo "<h1>📞 Lead Generation Setup</h1>";
echo "<p><strong>Implementing CTAs, forms, tracking, and conversion optimization across all pages</strong></p>";

// Handle form submissions
$fixes_applied = [];

if (isset($_POST['setup_ctas'])) {
    // Add CTA CSS and JavaScript to theme
    $cta_css = "
/* Lead Generation CTAs */
.athenas-cta {
    background: linear-gradient(135deg, #0073aa, #005177);
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin: 10px 5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,115,170,0.3);
}

.athenas-cta:hover {
    background: linear-gradient(135deg, #005177, #003d5c);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,115,170,0.4);
    color: white;
    text-decoration: none;
}

.athenas-cta-primary {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.athenas-cta-primary:hover {
    background: linear-gradient(135deg, #1e7e34, #155724);
}

.athenas-cta-secondary {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
}

.athenas-cta-secondary:hover {
    background: linear-gradient(135deg, #117a8b, #0c5460);
}

.athenas-floating-cta {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    border-radius: 50px;
    padding: 15px 25px;
    font-size: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.athenas-cta-bar {
    background: #0073aa;
    color: white;
    padding: 15px;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 999;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .athenas-cta {
        padding: 12px 20px;
        font-size: 14px;
        margin: 5px 2px;
    }
    
    .athenas-floating-cta {
        bottom: 10px;
        right: 10px;
        padding: 12px 20px;
        font-size: 12px;
    }
}
";

    // Add to theme's style.css or create custom CSS file
    $theme_dir = get_template_directory();
    $css_file = $theme_dir . '/athenas-lead-generation.css';
    
    if (file_put_contents($css_file, $cta_css)) {
        $fixes_applied[] = "CTA styles added to theme";
        
        // Add CSS to theme functions
        $functions_file = $theme_dir . '/functions.php';
        if (file_exists($functions_file)) {
            $functions_content = file_get_contents($functions_file);
            
            $enqueue_code = "
// Enqueue lead generation styles
function athenas_enqueue_lead_generation_styles() {
    wp_enqueue_style('athenas-lead-generation', get_template_directory_uri() . '/athenas-lead-generation.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'athenas_enqueue_lead_generation_styles');
";
            
            if (strpos($functions_content, 'athenas_enqueue_lead_generation_styles') === false) {
                $new_content = str_replace('<?php', '<?php' . $enqueue_code, $functions_content);
                file_put_contents($functions_file, $new_content);
                $fixes_applied[] = "CTA styles enqueued in theme";
            }
        }
    }
}

if (isset($_POST['setup_tracking'])) {
    $gtm_id = sanitize_text_field($_POST['gtm_id']);
    $phone = sanitize_text_field($_POST['phone']);
    $whatsapp = sanitize_text_field($_POST['whatsapp']);
    
    if (!empty($gtm_id)) {
        update_option('athenas_gtm_id', $gtm_id);
        $fixes_applied[] = "Google Tag Manager ID saved: {$gtm_id}";
    }
    
    if (!empty($phone)) {
        update_option('athenas_phone', $phone);
        $fixes_applied[] = "Phone number saved: {$phone}";
    }
    
    if (!empty($whatsapp)) {
        update_option('athenas_whatsapp', $whatsapp);
        $fixes_applied[] = "WhatsApp number saved: {$whatsapp}";
    }
}

if (isset($_POST['create_thank_you_page'])) {
    // Create thank you page
    $thank_you_page = array(
        'post_title'    => 'Thank You',
        'post_content'  => '<h1>Thank You for Your Interest!</h1>
        <p>We have received your inquiry and will get back to you within 24 hours.</p>
        <p>In the meantime, feel free to:</p>
        <ul>
        <li>Call us directly at <strong>' . get_option('athenas_phone', '+91-XXXXXXXXXX') . '</strong></li>
        <li>WhatsApp us at <strong>' . get_option('athenas_whatsapp', '+91-XXXXXXXXXX') . '</strong></li>
        <li>Email us at <strong>info@athenas.co.in</strong></li>
        </ul>
        <p><a href="/" class="athenas-cta athenas-cta-primary">Return to Homepage</a></p>',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_name'     => 'thank-you'
    );
    
    $page_id = wp_insert_post($thank_you_page);
    if ($page_id) {
        $fixes_applied[] = "Thank you page created (ID: {$page_id})";
        update_option('athenas_thank_you_page', $page_id);
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>✅ Lead Generation Setup Applied</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// STEP 1: Contact Information Setup
echo "<h2>📱 Step 1: Contact Information Setup</h2>";

$current_phone = get_option('athenas_phone');
$current_whatsapp = get_option('athenas_whatsapp');
$current_gtm = get_option('athenas_gtm_id');

echo "<div class='info'>";
echo "<h3>📞 Current Contact Information</h3>";
echo "<p><strong>Phone:</strong> " . ($current_phone ? $current_phone : "Not set") . "</p>";
echo "<p><strong>WhatsApp:</strong> " . ($current_whatsapp ? $current_whatsapp : "Not set") . "</p>";
echo "<p><strong>GTM ID:</strong> " . ($current_gtm ? $current_gtm : "Not set") . "</p>";
echo "</div>";

if (!$current_phone || !$current_whatsapp || !$current_gtm) {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Setup Required</h3>";
    echo "<form method='post'>";
    echo "<p><strong>Phone Number:</strong> <input type='tel' name='phone' value='{$current_phone}' placeholder='+91-9876543210'></p>";
    echo "<p><strong>WhatsApp Number:</strong> <input type='tel' name='whatsapp' value='{$current_whatsapp}' placeholder='+91-9876543210'></p>";
    echo "<p><strong>Google Tag Manager ID:</strong> <input type='text' name='gtm_id' value='{$current_gtm}' placeholder='GTM-XXXXXXX'></p>";
    echo "<button type='submit' name='setup_tracking' class='fix-button'>💾 Save Contact Information</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 2: CTA Implementation
echo "<h2>🎯 Step 2: Call-to-Action Implementation</h2>";

$cta_file = get_template_directory() . '/athenas-lead-generation.css';
$ctas_installed = file_exists($cta_file);

if ($ctas_installed) {
    echo "<div class='success'>";
    echo "<h3>✅ CTA Styles Installed</h3>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Install CTA Styles</h3>";
    echo "<p>This will add professional call-to-action buttons and styles to your website.</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='setup_ctas' class='fix-button'>🎨 Install CTA Styles</button>";
    echo "</form>";
    echo "</div>";
}

// CTA Preview
echo "<div class='cta-preview'>";
echo "<h3>🎨 CTA Button Previews</h3>";
echo "<p>These buttons will be available after installation:</p>";
echo "<button class='athenas-cta athenas-cta-primary'>Get Free Consultation</button>";
echo "<button class='athenas-cta athenas-cta-secondary'>Request Quote</button>";
echo "<button class='athenas-cta'>Call Now</button>";
echo "<button class='athenas-cta'>WhatsApp Us</button>";
echo "</div>";

// STEP 3: Thank You Page
echo "<h2>📄 Step 3: Thank You Page Setup</h2>";

$thank_you_page_id = get_option('athenas_thank_you_page');
$thank_you_exists = false;

if ($thank_you_page_id) {
    $thank_you_page = get_post($thank_you_page_id);
    if ($thank_you_page && $thank_you_page->post_status === 'publish') {
        $thank_you_exists = true;
        $thank_you_url = get_permalink($thank_you_page_id);
    }
}

if ($thank_you_exists) {
    echo "<div class='success'>";
    echo "<h3>✅ Thank You Page Exists</h3>";
    echo "<p><strong>URL:</strong> <a href='{$thank_you_url}' target='_blank'>{$thank_you_url}</a></p>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<h3>⚠️ Create Thank You Page</h3>";
    echo "<p>A thank you page is essential for form submissions and conversion tracking.</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='create_thank_you_page' class='fix-button'>📄 Create Thank You Page</button>";
    echo "</form>";
    echo "</div>";
}

// STEP 4: CTA Implementation Guide
echo "<h2>📝 Step 4: CTA Implementation Guide</h2>";

echo "<div class='action'>";
echo "<h3>🎯 Where to Add CTAs</h3>";

echo "<h4>1. Homepage CTAs:</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<div style="text-align: center; margin: 30px 0;">
    <a href="/contact/" class="athenas-cta athenas-cta-primary">Get Free Consultation</a>
    <a href="tel:' . $current_phone . '" class="athenas-cta" onclick="gtag(\'event\', \'click_call\', {\'event_category\': \'engagement\'});">Call Now</a>
    <a href="https://wa.me/' . str_replace(['+', '-', ' '], '', $current_whatsapp) . '" class="athenas-cta athenas-cta-secondary" onclick="gtag(\'event\', \'click_whatsapp\', {\'event_category\': \'engagement\'});">WhatsApp Us</a>
</div>');
echo "</div>";

echo "<h4>2. Service Page CTAs:</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<div style="text-align: center; margin: 30px 0;">
    <a href="/contact/" class="athenas-cta athenas-cta-primary">Request Quote</a>
    <a href="tel:' . $current_phone . '" class="athenas-cta">Call for Details</a>
</div>');
echo "</div>";

echo "<h4>3. Floating CTA (Add to footer):</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<a href="tel:' . $current_phone . '" class="athenas-floating-cta athenas-cta-primary" onclick="gtag(\'event\', \'click_call\', {\'event_category\': \'engagement\'});">📞 Call Now</a>');
echo "</div>";

echo "<h4>4. Sticky CTA Bar (Add to header):</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<div class="athenas-cta-bar">
    🎉 Get FREE Business Consultation! 
    <a href="/contact/" class="athenas-cta" style="margin-left: 15px;">Get Started</a>
</div>');
echo "</div>";
echo "</div>";

// STEP 5: Form Optimization
echo "<h2>📋 Step 5: Form Optimization</h2>";

echo "<div class='info'>";
echo "<h3>📝 Contact Form Best Practices</h3>";
echo "<ol>";
echo "<li><strong>Keep it simple:</strong> Name, Email, Phone, Message only</li>";
echo "<li><strong>Add honeypot field:</strong> Hidden field to prevent spam</li>";
echo "<li><strong>Clear CTA button:</strong> 'Get Free Consultation' instead of 'Submit'</li>";
echo "<li><strong>Redirect to thank you page:</strong> For conversion tracking</li>";
echo "<li><strong>Auto-responder:</strong> Immediate confirmation email</li>";
echo "</ol>";

echo "<h4>🍯 Honeypot Anti-Spam Field:</h4>";
echo "<div class='code'>";
echo htmlspecialchars('<input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">');
echo "</div>";
echo "<p><em>Add this hidden field to your contact forms. Bots will fill it, humans won't.</em></p>";
echo "</div>";

// STEP 6: Conversion Tracking
echo "<h2>📊 Step 6: Conversion Tracking Setup</h2>";

if ($current_gtm) {
    echo "<div class='success'>";
    echo "<h3>✅ Google Tag Manager Configured</h3>";
    echo "<p><strong>GTM ID:</strong> {$current_gtm}</p>";
    
    echo "<h4>📈 Events to Track:</h4>";
    echo "<ul>";
    echo "<li><strong>form_submit:</strong> When contact form is submitted</li>";
    echo "<li><strong>click_call:</strong> When phone number is clicked</li>";
    echo "<li><strong>click_whatsapp:</strong> When WhatsApp link is clicked</li>";
    echo "<li><strong>page_view:</strong> When thank you page is viewed</li>";
    echo "</ul>";
    
    echo "<h4>🔧 GTM Container Setup:</h4>";
    echo "<ol>";
    echo "<li>Go to <a href='https://tagmanager.google.com' target='_blank'>Google Tag Manager</a></li>";
    echo "<li>Create triggers for: Click - Phone links, Click - WhatsApp links, Page View - Thank you page</li>";
    echo "<li>Create tags for: GA4 Event - form_submit, GA4 Event - click_call, GA4 Event - click_whatsapp</li>";
    echo "<li>Test with GTM Preview mode</li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>❌ Google Tag Manager Not Configured</h3>";
    echo "<p>Set up GTM in Step 1 to enable conversion tracking.</p>";
    echo "</div>";
}

// STEP 7: Implementation Checklist
echo "<h2>✅ Step 7: Implementation Checklist</h2>";

echo "<div class='action'>";
echo "<h3>📋 Lead Generation Checklist</h3>";
echo "<ul>";
echo "<li>" . ($current_phone ? "✅" : "❌") . " Phone number configured</li>";
echo "<li>" . ($current_whatsapp ? "✅" : "❌") . " WhatsApp number configured</li>";
echo "<li>" . ($current_gtm ? "✅" : "❌") . " Google Tag Manager setup</li>";
echo "<li>" . ($ctas_installed ? "✅" : "❌") . " CTA styles installed</li>";
echo "<li>" . ($thank_you_exists ? "✅" : "❌") . " Thank you page created</li>";
echo "<li>⏳ CTAs added to all pages (manual)</li>";
echo "<li>⏳ Contact forms optimized (manual)</li>";
echo "<li>⏳ Conversion tracking configured (manual)</li>";
echo "</ul>";

echo "<h3>🚀 Next Steps</h3>";
echo "<ol>";
echo "<li><strong>Add CTAs:</strong> Use the code snippets above to add CTAs to all pages</li>";
echo "<li><strong>Optimize Forms:</strong> Update contact forms with honeypot fields and better CTAs</li>";
echo "<li><strong>Test Tracking:</strong> Verify all conversion events are firing in GTM</li>";
echo "<li><strong>Performance:</strong> <a href='performance-optimizer.php'>Optimize website performance</a></li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 Lead generation is crucial for converting website visitors into customers!</strong></p>";

echo "</body></html>";
?>
