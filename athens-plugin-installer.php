<?php
/**
 * Athens Web App Plugin Installer & Activator
 * Installs and activates the Athens Web App Integration plugin
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Athens Plugin Installer</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;background:#f8f9fa;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .install-card{background:white;padding:30px;border-radius:12px;box-shadow:0 4px 6px rgba(0,0,0,0.1);margin:20px 0;}
    h1{color:#0073aa;text-align:center;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .install-button{background:#0073aa;color:white;padding:15px 30px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:16px;font-weight:bold;}
    .install-button:hover{background:#005177;}
    .feature-list{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin:20px 0;}
    .feature-item{background:#f8f9fa;padding:20px;border-radius:8px;border-left:4px solid #0073aa;}
    .step-list{counter-reset:step-counter;list-style:none;padding:0;}
    .step-list li{counter-increment:step-counter;margin:15px 0;padding:15px;background:white;border-radius:8px;border-left:4px solid #28a745;}
    .step-list li::before{content:counter(step-counter);background:#28a745;color:white;border-radius:50%;width:25px;height:25px;display:inline-flex;align-items:center;justify-content:center;margin-right:15px;font-weight:bold;}
</style>";
echo "</head><body>";

echo "<h1>🚀 Athens Web App Integration Installer</h1>";

// Handle installation
if (isset($_POST['install_athens_plugin'])) {
    echo "<div class='install-card'>";
    echo "<h2>Installing Athens Web App Plugin...</h2>";
    
    $installation_steps = [];
    
    // Step 1: Check if plugin directory exists
    $plugin_dir = WP_CONTENT_DIR . '/plugins/athens-web-app';
    if (!file_exists($plugin_dir)) {
        echo "<div class='error'>❌ Plugin directory not found at: {$plugin_dir}</div>";
        echo "<p><strong>Manual Installation Required:</strong></p>";
        echo "<ol>";
        echo "<li>Copy the 'athens-web-app' folder to: <code>/wp-content/plugins/</code></li>";
        echo "<li>Ensure all files are properly uploaded</li>";
        echo "<li>Return to this page and try again</li>";
        echo "</ol>";
    } else {
        $installation_steps[] = "✅ Plugin directory found";
        
        // Step 2: Activate the plugin
        if (!is_plugin_active('athens-web-app/athens-web-app.php')) {
            $result = activate_plugin('athens-web-app/athens-web-app.php');
            if (is_wp_error($result)) {
                $installation_steps[] = "❌ Plugin activation failed: " . $result->get_error_message();
            } else {
                $installation_steps[] = "✅ Plugin activated successfully";
                
                // Step 3: Create menu item
                $menu_locations = get_theme_mod('nav_menu_locations');
                if ($menu_locations) {
                    $installation_steps[] = "✅ Menu integration ready";
                }
                
                // Step 4: Check pages creation
                $pages_created = 0;
                $required_pages = ['athens-dashboard', 'athens-portal', 'athens-search', 'athens-login'];
                foreach ($required_pages as $page_slug) {
                    if (get_page_by_path($page_slug)) {
                        $pages_created++;
                    }
                }
                $installation_steps[] = "✅ Created {$pages_created}/4 required pages";
                
                // Step 5: Database tables
                global $wpdb;
                $table_name = $wpdb->prefix . 'athens_client_data';
                if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
                    $installation_steps[] = "✅ Database tables created";
                } else {
                    $installation_steps[] = "❌ Database tables creation failed";
                }
                
                // Step 6: Assets check
                $css_file = WP_CONTENT_DIR . '/plugins/athens-web-app/assets/athens-style.css';
                $js_file = WP_CONTENT_DIR . '/plugins/athens-web-app/assets/athens-app.js';
                if (file_exists($css_file) && file_exists($js_file)) {
                    $installation_steps[] = "✅ Assets files found";
                } else {
                    $installation_steps[] = "❌ Some asset files missing";
                }
            }
        } else {
            $installation_steps[] = "✅ Plugin already activated";
        }
    }
    
    // Display installation results
    foreach ($installation_steps as $step) {
        echo "<p>{$step}</p>";
    }
    
    if (is_plugin_active('athens-web-app/athens-web-app.php')) {
        echo "<div class='success'>";
        echo "<h3>🎉 Installation Completed Successfully!</h3>";
        echo "<p><strong>Athens Web App Integration is now active on your website.</strong></p>";
        echo "<h4>Next Steps:</h4>";
        echo "<ul>";
        echo "<li>Visit your website homepage - you'll see 'ATHENS' in the menu</li>";
        echo "<li>Test the client portal: <a href='/athens-portal/' target='_blank'>Athens Client Portal</a></li>";
        echo "<li>Test the login page: <a href='/athens-login/' target='_blank'>Athens Login</a></li>";
        echo "<li>Test the search: <a href='/athens-search/' target='_blank'>Athens Search</a></li>";
        echo "<li>Access admin panel: <a href='/wp-admin/admin.php?page=athens-web-app' target='_blank'>Athens Admin</a></li>";
        echo "</ul>";
        echo "</div>";
        
        // Auto-redirect after 5 seconds
        echo "<script>setTimeout(function(){ window.location.href = '/'; }, 5000);</script>";
        echo "<p><em>Redirecting to homepage in 5 seconds...</em></p>";
    }
    
    echo "</div>";
} else {
    // Show installation interface
    echo "<div class='install-card'>";
    echo "<h2>🎯 Athens Web App Features</h2>";
    echo "<div class='feature-list'>";
    
    echo "<div class='feature-item'>";
    echo "<h3>🏠 Client Dashboard</h3>";
    echo "<p>Comprehensive dashboard for clients to view their services, documents, and progress tracking.</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>🔍 Advanced Search</h3>";
    echo "<p>Powerful search functionality with filters for services, documents, and content.</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>🔐 Secure Login</h3>";
    echo "<p>Professional login interface with Athens branding and security features.</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>📄 Document Management</h3>";
    echo "<p>Upload, download, and manage client documents with categorization.</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>💼 Service Tracking</h3>";
    echo "<p>Track active services, progress, and service requests.</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>💳 Invoice Management</h3>";
    echo "<p>View invoices, payment status, and make online payments.</p>";
    echo "</div>";
    
    echo "</div>";
    echo "</div>";
    
    echo "<div class='install-card'>";
    echo "<h2>📋 Installation Steps</h2>";
    echo "<ol class='step-list'>";
    echo "<li><strong>Plugin Activation:</strong> Activate the Athens Web App Integration plugin</li>";
    echo "<li><strong>Database Setup:</strong> Create required database tables for client data</li>";
    echo "<li><strong>Page Creation:</strong> Create Athens portal pages with proper SEO</li>";
    echo "<li><strong>Menu Integration:</strong> Add 'ATHENS' menu item to your website header</li>";
    echo "<li><strong>Asset Loading:</strong> Ensure CSS and JavaScript files are properly loaded</li>";
    echo "<li><strong>Testing:</strong> Verify all functionality works correctly</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='install-card'>";
    echo "<h2>🚀 Ready to Install?</h2>";
    echo "<p>This will install and configure the Athens Web App Integration plugin with all features.</p>";
    
    echo "<div class='info'>";
    echo "<h4>What will be created:</h4>";
    echo "<ul>";
    echo "<li><strong>Pages:</strong> Athens Dashboard, Client Portal, Search, Login</li>";
    echo "<li><strong>Menu Item:</strong> 'ATHENS' link in your website header</li>";
    echo "<li><strong>Database:</strong> Client data table for documents and services</li>";
    echo "<li><strong>Admin Panel:</strong> Athens management interface in WordPress admin</li>";
    echo "<li><strong>Shortcodes:</strong> [athens_dashboard], [athens_search], [athens_login], [athens_client_portal]</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='install_athens_plugin' class='install-button'>🚀 Install Athens Web App Now</button>";
    echo "</form>";
    echo "</div>";
}

echo "<div class='install-card'>";
echo "<h2>📞 Support Information</h2>";
echo "<p>If you encounter any issues during installation:</p>";
echo "<ul>";
echo "<li><strong>Check file permissions:</strong> Ensure wp-content/plugins/ is writable</li>";
echo "<li><strong>Plugin conflicts:</strong> Temporarily deactivate other plugins if issues occur</li>";
echo "<li><strong>Theme compatibility:</strong> The plugin works with most WordPress themes</li>";
echo "<li><strong>Manual installation:</strong> Upload files via FTP if automatic installation fails</li>";
echo "</ul>";
echo "<p><strong>Contact:</strong> For technical support, contact Athens Business Solutions team.</p>";
echo "</div>";

echo "</body></html>";
?>
