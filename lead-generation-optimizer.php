<?php
/**
 * Lead Generation Optimizer
 * Implements comprehensive lead generation strategies and conversion optimization
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Lead Generation Optimizer</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .implement-button{background:#28a745;color:white;padding:20px 40px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:18px;font-weight:bold;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;font-size:12px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .strategy{background:#f8f9fa;padding:20px;border-radius:8px;margin:15px 0;border-left:4px solid #17a2b8;}
</style>";
echo "</head><body>";

echo "<h1>🎯 Lead Generation Optimizer</h1>";
echo "<p><strong>Implementing comprehensive lead generation strategies and conversion optimization</strong></p>";

global $wpdb;

// Handle implementation
$fixes_applied = [];

if (isset($_POST['implement_lead_generation'])) {
    // 1. Create lead magnets
    $lead_magnets = [
        'accounting-guide' => [
            'title' => 'Complete Guide to Business Accounting in India',
            'content' => '<h2>Download Your Free Accounting Guide</h2><p>Get our comprehensive 50-page guide covering everything you need to know about business accounting in India, including GST compliance, TDS procedures, and financial reporting requirements.</p><h3>What You\'ll Learn:</h3><ul><li>GST registration and compliance procedures</li><li>TDS calculation and filing requirements</li><li>Financial statement preparation</li><li>Tax planning strategies</li><li>Audit preparation checklist</li></ul><p><strong>Download this valuable resource for FREE!</strong></p>[contact-form-7 id="lead-magnet-form"]',
            'meta_title' => 'Free Accounting Guide | Business Accounting in India',
            'meta_description' => 'Download our free comprehensive guide to business accounting in India. Covers GST, TDS, financial reporting, and compliance requirements.'
        ],
        'hr-checklist' => [
            'title' => 'HR Compliance Checklist for Indian Businesses',
            'content' => '<h2>Free HR Compliance Checklist</h2><p>Ensure your business stays compliant with all HR regulations. Download our detailed checklist covering PF, ESI, labor law compliance, and employee documentation requirements.</p><h3>Checklist Includes:</h3><ul><li>Employee onboarding documentation</li><li>PF and ESI registration procedures</li><li>Labor law compliance requirements</li><li>Payroll processing guidelines</li><li>Employee grievance procedures</li></ul><p><strong>Get instant access to this essential HR resource!</strong></p>[contact-form-7 id="hr-checklist-form"]',
            'meta_title' => 'Free HR Compliance Checklist | Indian Labor Laws',
            'meta_description' => 'Download our free HR compliance checklist for Indian businesses. Covers PF, ESI, labor laws, and employee documentation requirements.'
        ],
        'business-consultation' => [
            'title' => 'Free Business Consultation',
            'content' => '<h2>Get Your Free Business Consultation</h2><p>Schedule a complimentary 30-minute consultation with our business experts. We\'ll analyze your current business setup and provide personalized recommendations for accounting, HR, and compliance improvements.</p><h3>What We\'ll Cover:</h3><ul><li>Current business structure analysis</li><li>Compliance gap assessment</li><li>Cost optimization opportunities</li><li>Growth strategy recommendations</li><li>Technology implementation suggestions</li></ul><p><strong>Book your free consultation today!</strong></p>[contact-form-7 id="consultation-form"]',
            'meta_title' => 'Free Business Consultation | Athenas Business Solutions',
            'meta_description' => 'Schedule a free 30-minute business consultation. Get expert advice on accounting, HR, compliance, and growth strategies for your business.'
        ]
    ];
    
    foreach ($lead_magnets as $slug => $magnet_data) {
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            $page_id = wp_insert_post([
                'post_title' => $magnet_data['title'],
                'post_content' => $magnet_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug
            ]);
            
            if ($page_id) {
                // Add SEO meta
                update_post_meta($page_id, 'rank_math_title', $magnet_data['meta_title']);
                update_post_meta($page_id, 'rank_math_description', $magnet_data['meta_description']);
                update_post_meta($page_id, 'rank_math_focus_keyword', 'business consultation madurai');
                
                $fixes_applied[] = "Created lead magnet: {$magnet_data['title']}";
            }
        }
    }
    
    // 2. Create thank you page
    $thank_you_page = get_page_by_path('thank-you');
    if (!$thank_you_page) {
        $thank_you_id = wp_insert_post([
            'post_title' => 'Thank You',
            'post_content' => '<h1>Thank You for Your Interest!</h1><p>We have received your request and will get back to you within 24 hours.</p><h3>What Happens Next?</h3><ul><li>Our team will review your information</li><li>We\'ll prepare personalized recommendations</li><li>You\'ll receive a call or email within 24 hours</li><li>We\'ll schedule a detailed consultation if needed</li></ul><h3>In the Meantime:</h3><p>Follow us on social media for business tips and updates:</p><ul><li><a href="#" target="_blank">LinkedIn</a></li><li><a href="#" target="_blank">Facebook</a></li><li><a href="#" target="_blank">Twitter</a></li></ul><p><strong>Need immediate assistance?</strong> Call us at <a href="tel:+919876543210">+91-98765-43210</a></p>',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'thank-you'
        ]);
        
        if ($thank_you_id) {
            update_post_meta($thank_you_id, 'rank_math_title', 'Thank You | Athenas Business Solutions');
            update_post_meta($thank_you_id, 'rank_math_description', 'Thank you for contacting Athenas Business Solutions. We will get back to you within 24 hours.');
            $fixes_applied[] = "Created thank you page";
        }
    }
    
    // 3. Add CTA buttons CSS and functionality
    $cta_css = "
/* Lead Generation CTA Styles */
.athenas-cta {
    display: inline-block;
    padding: 15px 30px;
    background: linear-gradient(135deg, #0073aa 0%, #005177 100%);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1em;
    margin: 10px 5px;
}

.athenas-cta:hover {
    background: linear-gradient(135deg, #005177 0%, #003d5c 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,115,170,0.3);
    color: white;
}

.athenas-cta-primary {
    background: linear-gradient(135deg, #28a745 0%, #218838 100%);
}

.athenas-cta-primary:hover {
    background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}

.athenas-cta-secondary {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.athenas-cta-secondary:hover {
    background: linear-gradient(135deg, #138496 0%, #117a8b 100%);
    box-shadow: 0 4px 12px rgba(23,162,184,0.3);
}

.athenas-floating-cta {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    border-radius: 50px;
    padding: 15px 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.athenas-cta-bar {
    background: linear-gradient(135deg, #0073aa 0%, #005177 100%);
    color: white;
    padding: 15px;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 999;
    font-weight: 600;
}

.athenas-lead-form {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    margin: 30px 0;
}

.athenas-lead-form h3 {
    color: #0073aa;
    margin-bottom: 20px;
    text-align: center;
}

.athenas-lead-form input[type='text'],
.athenas-lead-form input[type='email'],
.athenas-lead-form input[type='tel'],
.athenas-lead-form textarea,
.athenas-lead-form select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #ced4da;
    border-radius: 6px;
    font-size: 1em;
    margin-bottom: 15px;
    transition: border-color 0.3s ease;
}

.athenas-lead-form input:focus,
.athenas-lead-form textarea:focus,
.athenas-lead-form select:focus {
    outline: none;
    border-color: #0073aa;
    box-shadow: 0 0 0 3px rgba(0,115,170,0.1);
}

.athenas-lead-form .submit-btn {
    background: linear-gradient(135deg, #28a745 0%, #218838 100%);
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    font-size: 1.1em;
    width: 100%;
    transition: all 0.3s ease;
}

.athenas-lead-form .submit-btn:hover {
    background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .athenas-floating-cta {
        bottom: 10px;
        right: 10px;
        padding: 12px 20px;
        font-size: 0.9em;
    }
    
    .athenas-cta {
        display: block;
        text-align: center;
        margin: 10px 0;
    }
}
";
    
    // Add CSS to theme customizer
    $existing_css = get_theme_mod('custom_css', '');
    if (strpos($existing_css, 'athenas-cta') === false) {
        $new_css = $existing_css . "\n\n" . $cta_css;
        set_theme_mod('custom_css', $new_css);
        $fixes_applied[] = "CTA styles added to theme";
    }
    
    // 4. Add lead tracking functions
    $theme_functions = get_template_directory() . '/functions.php';
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);
        
        $lead_tracking_code = "
// Lead Generation Tracking and Optimization
function athenas_lead_generation_init() {
    // Add lead tracking scripts
    wp_enqueue_script('athenas-lead-tracking', get_template_directory_uri() . '/js/lead-tracking.js', ['jquery'], '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('athenas-lead-tracking', 'athenas_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('athenas_lead_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'athenas_lead_generation_init');

// Track form submissions
function athenas_track_form_submission() {
    check_ajax_referer('athenas_lead_nonce', 'nonce');
    
    \$form_data = [
        'form_type' => sanitize_text_field(\$_POST['form_type']),
        'page_url' => sanitize_url(\$_POST['page_url']),
        'timestamp' => current_time('mysql'),
        'user_ip' => \$_SERVER['REMOTE_ADDR']
    ];
    
    // Save to database or send to CRM
    update_option('athenas_lead_submissions', get_option('athenas_lead_submissions', []) + [\$form_data]);
    
    // Track with GTM
    if (function_exists('gtag_report_conversion')) {
        gtag_report_conversion('form_submit', 'lead_generation');
    }
    
    wp_die();
}
add_action('wp_ajax_track_form_submission', 'athenas_track_form_submission');
add_action('wp_ajax_nopriv_track_form_submission', 'athenas_track_form_submission');

// Add lead generation shortcodes
function athenas_cta_shortcode(\$atts) {
    \$atts = shortcode_atts([
        'text' => 'Get Free Consultation',
        'url' => '/contact/',
        'style' => 'primary',
        'size' => 'normal'
    ], \$atts);
    
    \$class = 'athenas-cta athenas-cta-' . \$atts['style'];
    if (\$atts['size'] === 'large') \$class .= ' athenas-cta-large';
    
    return '<a href=\"' . esc_url(\$atts['url']) . '\" class=\"' . \$class . '\" onclick=\"athenas_track_cta_click(this);\">' . esc_html(\$atts['text']) . '</a>';
}
add_shortcode('athenas_cta', 'athenas_cta_shortcode');

function athenas_lead_form_shortcode(\$atts) {
    \$atts = shortcode_atts([
        'title' => 'Get Your Free Consultation',
        'type' => 'consultation'
    ], \$atts);
    
    ob_start();
    ?>
    <div class=\"athenas-lead-form\">
        <h3><?php echo esc_html(\$atts['title']); ?></h3>
        <form class=\"athenas-lead-capture\" data-form-type=\"<?php echo esc_attr(\$atts['type']); ?>\">
            <input type=\"text\" name=\"name\" placeholder=\"Your Name *\" required>
            <input type=\"email\" name=\"email\" placeholder=\"Your Email *\" required>
            <input type=\"tel\" name=\"phone\" placeholder=\"Your Phone Number *\" required>
            <select name=\"service\" required>
                <option value=\"\">Select Service Interest</option>
                <option value=\"accounting\">Accounting Services</option>
                <option value=\"hr\">HR Services</option>
                <option value=\"compliance\">Compliance Services</option>
                <option value=\"business-setup\">Business Setup</option>
                <option value=\"consultation\">General Consultation</option>
            </select>
            <textarea name=\"message\" placeholder=\"Tell us about your requirements...\"></textarea>
            <button type=\"submit\" class=\"submit-btn\">Get Free Consultation</button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('athenas_lead_form', 'athenas_lead_form_shortcode');

// Add conversion tracking for phone clicks
function athenas_add_phone_tracking() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track phone clicks
        var phoneLinks = document.querySelectorAll('a[href^=\"tel:\"]');
        phoneLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'click_call', {
                        'event_category': 'engagement',
                        'event_label': this.href
                    });
                }
            });
        });
        
        // Track WhatsApp clicks
        var whatsappLinks = document.querySelectorAll('a[href*=\"wa.me\"], a[href*=\"whatsapp\"]');
        whatsappLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'click_whatsapp', {
                        'event_category': 'engagement',
                        'event_label': this.href
                    });
                }
            });
        });
    });
    
    function athenas_track_cta_click(element) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'click_cta', {
                'event_category': 'engagement',
                'event_label': element.href,
                'event_text': element.textContent
            });
        }
    }
    </script>
    <?php
}
add_action('wp_footer', 'athenas_add_phone_tracking');
";
        
        if (strpos($current_content, 'athenas_lead_generation_init') === false) {
            $new_content = str_replace('<?php', '<?php' . $lead_tracking_code, $current_content);
            file_put_contents($theme_functions, $new_content);
            $fixes_applied[] = "Lead tracking functions added to theme";
        }
    }
    
    $fixes_applied[] = "✅ LEAD GENERATION OPTIMIZATION COMPLETED";
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>🎉 Lead Generation Implementation Results</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

echo "</body></html>";
?>
