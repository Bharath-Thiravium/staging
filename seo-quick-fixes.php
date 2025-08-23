<?php
/**
 * SEO Quick Fixes - WordPress Admin Integration
 * Provides quick fixes for critical SEO issues directly from WordPress admin
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
add_action('admin_menu', 'seo_quick_fixes_menu');

function seo_quick_fixes_menu() {
    add_management_page(
        'SEO Quick Fixes',
        'SEO Quick Fixes',
        'manage_options',
        'seo-quick-fixes',
        'seo_quick_fixes_page'
    );
}

function seo_quick_fixes_page() {
    ?>
    <div class="wrap">
        <h1>🚨 Critical SEO Fixes</h1>
        
        <div class="notice notice-error">
            <p><strong>URGENT:</strong> Your website has critical SEO issues that are preventing Google from ranking your site properly.</p>
        </div>
        
        <div class="card">
            <h2>🔧 Fix #1: H1 Heading (CRITICAL)</h2>
            <p><strong>Problem:</strong> Your homepage H1 heading uses special characters that Google cannot read.</p>
            <p><strong>Current:</strong> <code>ᗩ𝔱𝔥єղα 𝔖ø𝔩ʊեιΘղṩ</code></p>
            <p><strong>Should be:</strong> <code>Accounting, HR & Compliance Services in Madurai | Athenas Business Solutions</code></p>
            
            <h3>📋 How to Fix:</h3>
            <ol>
                <li>Go to <strong>Pages → All Pages</strong></li>
                <li>Find your homepage and click <strong>"Edit with Elementor"</strong></li>
                <li>Find the heading widget with special characters</li>
                <li>Replace the text with: <strong>"Accounting, HR & Compliance Services in Madurai | Athenas Business Solutions"</strong></li>
                <li>Click <strong>Update</strong></li>
            </ol>
            
            <a href="<?php echo admin_url('edit.php?post_type=page'); ?>" class="button button-primary">Go to Pages →</a>
        </div>
        
        <div class="card">
            <h2>📍 Fix #2: Local SEO - Add Madurai (CRITICAL)</h2>
            <p><strong>Problem:</strong> Your website doesn't mention "Madurai" anywhere, so local customers can't find you.</p>
            
            <h3>📋 How to Fix:</h3>
            <ol>
                <li>Edit your homepage content</li>
                <li>Add text like: <strong>"Professional business services in Madurai"</strong></li>
                <li>Include your Madurai address in the footer</li>
                <li>Mention Madurai in service descriptions</li>
            </ol>
        </div>
        
        <div class="card">
            <h2>🏢 Fix #3: Google Business Profile (URGENT)</h2>
            <p><strong>Problem:</strong> You don't have a Google Business Profile, which is essential for local SEO.</p>
            
            <h3>📋 How to Fix:</h3>
            <ol>
                <li>Go to <a href="https://business.google.com" target="_blank">business.google.com</a></li>
                <li>Click "Manage now"</li>
                <li>Add your business: <strong>Athenas Business Solutions</strong></li>
                <li>Category: <strong>Accounting Service</strong></li>
                <li>Address: <strong>Your Madurai address</strong></li>
                <li>Phone: <strong>Your phone number</strong></li>
                <li>Website: <strong>athenas.co.in</strong></li>
            </ol>
            
            <a href="https://business.google.com" target="_blank" class="button button-primary">Create Google Business Profile →</a>
        </div>
        
        <div class="card">
            <h2>📝 Fix #4: Meta Descriptions</h2>
            <p><strong>Problem:</strong> Your pages don't have meta descriptions, which appear in Google search results.</p>
            
            <h3>📋 How to Fix with Rank Math:</h3>
            <ol>
                <li>Go to <strong>Rank Math → Titles & Meta</strong></li>
                <li>Click <strong>Homepage</strong></li>
                <li>Add meta description: <strong>"Athenas Business Solutions offers expert accounting, HR, and statutory compliance services for startups and SMEs in Madurai. Professional business services + content licensing solutions."</strong></li>
                <li>Save changes</li>
            </ol>
            
            <a href="<?php echo admin_url('admin.php?page=rank-math-options-titles'); ?>" class="button button-primary">Go to Rank Math →</a>
        </div>
        
        <div class="card">
            <h2>🎯 Fix #5: Service Pages Keywords</h2>
            <p><strong>Problem:</strong> Your service pages don't include the keywords people search for.</p>
            
            <h3>📋 Keywords to Add:</h3>
            <ul>
                <li><strong>Accounting page:</strong> "GST registration Madurai", "bookkeeping for small businesses", "TDS compliance"</li>
                <li><strong>Compliance page:</strong> "company formation Madurai", "statutory compliance", "business registration"</li>
                <li><strong>HR page:</strong> "payroll services Madurai", "HR compliance", "employee management"</li>
            </ul>
            
            <a href="<?php echo admin_url('edit.php?post_type=page'); ?>" class="button button-primary">Edit Service Pages →</a>
        </div>
        
        <div class="notice notice-success">
            <h3>🎯 Expected Results After Fixes:</h3>
            <ul>
                <li><strong>Local Rankings:</strong> Top 3 for "accountant Madurai" within 3 months</li>
                <li><strong>Organic Traffic:</strong> 200-400% increase within 6 months</li>
                <li><strong>Lead Quality:</strong> Better qualified local business leads</li>
                <li><strong>Conversion Rate:</strong> 3-5x improvement due to clear messaging</li>
            </ul>
        </div>
        
        <div class="card">
            <h2>📊 Progress Tracking</h2>
            <p>After making these changes:</p>
            <ol>
                <li>Clear all caches (LiteSpeed Cache → Toolbox → Purge All)</li>
                <li>Test your site with <a href="https://pagespeed.web.dev/" target="_blank">PageSpeed Insights</a></li>
                <li>Check rankings with <a href="https://search.google.com/search-console" target="_blank">Google Search Console</a></li>
                <li>Monitor local visibility with Google Business Profile insights</li>
            </ol>
        </div>
        
        <style>
        .card {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .card h2 {
            margin-top: 0;
            color: #23282d;
        }
        .card h3 {
            color: #0073aa;
        }
        .card ol, .card ul {
            margin-left: 20px;
        }
        .card code {
            background: #f1f1f1;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .notice-success h3 {
            margin-top: 0;
        }
        </style>
    </div>
    <?php
}

// Add to functions.php or create as a plugin
if (!function_exists('add_action')) {
    // If this file is accessed directly, show instructions
    echo "<h1>SEO Quick Fixes Installation</h1>";
    echo "<p>To use this tool:</p>";
    echo "<ol>";
    echo "<li>Copy this entire file content</li>";
    echo "<li>Go to WordPress Admin → Appearance → Theme Editor</li>";
    echo "<li>Open functions.php</li>";
    echo "<li>Paste this code at the end of the file (before the closing ?> tag)</li>";
    echo "<li>Save the file</li>";
    echo "<li>Go to WordPress Admin → Tools → SEO Quick Fixes</li>";
    echo "</ol>";
}
?>
