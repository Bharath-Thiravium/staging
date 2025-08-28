<?php
/**
 * Plugin Name: ATHENS Elementor Page Creator
 * Description: Creates ATHENS project highlights page with exact homepage design using Elementor
 * Version: 1.0.0
 * Author: Athenas Business Solutions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class AthensElementorPageCreator {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_create_athens_page', array($this, 'create_athens_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'ATHENS Page Creator',
            'ATHENS Creator',
            'manage_options',
            'athens-creator',
            array($this, 'admin_page'),
            'dashicons-hammer',
            30
        );
    }
    
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_athens-creator') {
            return;
        }
        
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'athens_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athens_nonce')
        ));
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>🚀 ATHENS Elementor Page Creator</h1>
            
            <div class="athens-admin-container">
                <div class="athens-info-box">
                    <h2>Create Professional ATHENS Page</h2>
                    <p>This will create a complete Elementor page with exact homepage design featuring:</p>
                    
                    <div class="athens-features-grid">
                        <div class="feature-item">
                            <h3>🎨 Exact Homepage Design</h3>
                            <p>Purple gradient backgrounds, Outfit & Inter fonts, exact color scheme</p>
                        </div>
                        <div class="feature-item">
                            <h3>🏗️ Elementor Structure</h3>
                            <p>Proper sections, columns, and widgets with responsive layouts</p>
                        </div>
                        <div class="feature-item">
                            <h3>📱 Responsive Design</h3>
                            <p>Mobile-optimized layouts with proper breakpoints</p>
                        </div>
                        <div class="feature-item">
                            <h3>🚀 10 Project Highlights</h3>
                            <p>Professional icon-box widgets with all content and styling</p>
                        </div>
                    </div>
                </div>
                
                <div class="athens-requirements">
                    <h3>📋 Requirements Check</h3>
                    <ul>
                        <li class="<?php echo is_plugin_active('elementor/elementor.php') ? 'check-pass' : 'check-fail'; ?>">
                            <?php echo is_plugin_active('elementor/elementor.php') ? '✅' : '❌'; ?> 
                            Elementor Plugin
                        </li>
                        <li class="check-pass">✅ WordPress Admin Access</li>
                        <li class="check-pass">✅ Theme Compatibility</li>
                    </ul>
                </div>
                
                <div class="athens-actions">
                    <?php if (is_plugin_active('elementor/elementor.php')): ?>
                        <button id="create-athens-page" class="button button-primary button-hero">
                            🚀 Create ATHENS Elementor Page
                        </button>
                    <?php else: ?>
                        <p class="error-message">❌ Please install and activate Elementor plugin first.</p>
                        <a href="<?php echo admin_url('plugin-install.php?s=elementor&tab=search&type=term'); ?>" class="button">
                            Install Elementor
                        </a>
                    <?php endif; ?>
                </div>
                
                <div id="athens-result" class="athens-result" style="display: none;"></div>
            </div>
        </div>
        
        <style>
            .athens-admin-container {
                max-width: 1200px;
                margin: 20px 0;
            }
            
            .athens-info-box {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 30px;
                margin-bottom: 30px;
            }
            
            .athens-features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }
            
            .feature-item {
                background: #ffffff;
                border: 1px solid #6F4898;
                border-radius: 8px;
                padding: 20px;
                border-left: 4px solid #6F4898;
            }
            
            .feature-item h3 {
                color: #6F4898;
                margin-bottom: 10px;
                font-size: 16px;
            }
            
            .feature-item p {
                color: #666;
                margin: 0;
                font-size: 14px;
                line-height: 1.5;
            }
            
            .athens-requirements {
                background: #ffffff;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 25px;
                margin-bottom: 30px;
            }
            
            .athens-requirements ul {
                list-style: none;
                padding: 0;
                margin: 15px 0 0 0;
            }
            
            .athens-requirements li {
                padding: 8px 0;
                font-size: 16px;
            }
            
            .check-pass {
                color: #28a745;
            }
            
            .check-fail {
                color: #dc3545;
            }
            
            .athens-actions {
                text-align: center;
                margin: 30px 0;
            }
            
            .button-hero {
                font-size: 18px !important;
                padding: 15px 30px !important;
                height: auto !important;
                background: #6F4898 !important;
                border-color: #6F4898 !important;
                text-shadow: none !important;
                box-shadow: 0 4px 15px rgba(111,72,152,0.3) !important;
            }
            
            .button-hero:hover {
                background: #5a3a7a !important;
                border-color: #5a3a7a !important;
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(111,72,152,0.4) !important;
            }
            
            .athens-result {
                background: #ffffff;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 25px;
                margin-top: 30px;
            }
            
            .success-message {
                color: #28a745;
                background: #f0f8f0;
                padding: 20px;
                border-radius: 8px;
                border-left: 4px solid #28a745;
            }
            
            .error-message {
                color: #dc3545;
                background: #f8f0f0;
                padding: 20px;
                border-radius: 8px;
                border-left: 4px solid #dc3545;
                margin: 20px 0;
            }
            
            .loading {
                text-align: center;
                padding: 40px;
                color: #6F4898;
            }
            
            .loading::after {
                content: '';
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 3px solid #6F4898;
                border-radius: 50%;
                border-top-color: transparent;
                animation: spin 1s ease-in-out infinite;
                margin-left: 10px;
            }
            
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            $('#create-athens-page').on('click', function() {
                var button = $(this);
                var resultDiv = $('#athens-result');
                
                button.prop('disabled', true).text('Creating...');
                resultDiv.show().html('<div class="loading">Creating ATHENS Elementor page...</div>');
                
                $.ajax({
                    url: athens_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'create_athens_page',
                        nonce: athens_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            resultDiv.html(
                                '<div class="success-message">' +
                                '<h3>✅ ATHENS Elementor Page Created Successfully!</h3>' +
                                '<p><strong>Page URL:</strong> <a href="' + response.data.url + '" target="_blank">' + response.data.url + '</a></p>' +
                                '<p><strong>Page ID:</strong> ' + response.data.page_id + '</p>' +
                                '<p><strong>Edit with Elementor:</strong> <a href="' + response.data.edit_url + '" target="_blank">Open in Elementor Editor</a></p>' +
                                '<div style="margin-top: 20px;">' +
                                '<a href="' + response.data.url + '" target="_blank" class="button button-primary">View Page</a> ' +
                                '<a href="' + response.data.edit_url + '" target="_blank" class="button">Edit with Elementor</a>' +
                                '</div>' +
                                '</div>'
                            );
                            
                            // Auto-redirect after 5 seconds
                            setTimeout(function() {
                                window.open(response.data.url, '_blank');
                            }, 3000);
                        } else {
                            resultDiv.html(
                                '<div class="error-message">' +
                                '<h3>❌ Error Creating Page</h3>' +
                                '<p>' + response.data + '</p>' +
                                '</div>'
                            );
                        }
                        
                        button.prop('disabled', false).text('🚀 Create ATHENS Elementor Page');
                    },
                    error: function() {
                        resultDiv.html(
                            '<div class="error-message">' +
                            '<h3>❌ Ajax Error</h3>' +
                            '<p>There was an error communicating with the server. Please try again.</p>' +
                            '</div>'
                        );
                        button.prop('disabled', false).text('🚀 Create ATHENS Elementor Page');
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    public function create_athens_page() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'athens_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
        }
        
        // Check if Elementor is active
        if (!is_plugin_active('elementor/elementor.php')) {
            wp_send_json_error('Elementor plugin is not active');
        }
        
        // Check if page already exists
        $existing_page = get_page_by_path('athens-project-highlights');
        if ($existing_page) {
            $page_id = $existing_page->ID;
            $action = 'update';
        } else {
            $action = 'create';
        }
        
        // Create/Update the page
        if ($action === 'create') {
            $page_id = wp_insert_post(array(
                'post_title' => 'ATHENS - Project Highlights',
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => 'athens-project-highlights',
                'meta_input' => array(
                    '_elementor_edit_mode' => 'builder',
                    '_elementor_template_type' => 'wp-page',
                    '_elementor_version' => '3.0.0',
                    '_wp_page_template' => 'elementor_header_footer'
                )
            ));
        } else {
            $page_id = $existing_page->ID;
            update_post_meta($page_id, '_elementor_edit_mode', 'builder');
            update_post_meta($page_id, '_elementor_template_type', 'wp-page');
            update_post_meta($page_id, '_elementor_version', '3.0.0');
        }
        
        if (!$page_id) {
            wp_send_json_error('Failed to create page');
        }
        
        // Create Elementor data structure
        $elementor_data = $this->get_elementor_data();
        
        // Save Elementor data
        update_post_meta($page_id, '_elementor_data', json_encode($elementor_data));
        update_post_meta($page_id, '_elementor_page_settings', json_encode([]));
        update_post_meta($page_id, '_elementor_controls_usage', json_encode([]));
        
        // Update SEO meta
        update_post_meta($page_id, 'rank_math_title', 'ATHENS - 10 Key Project Highlights | Athens Business Solutions');
        update_post_meta($page_id, 'rank_math_description', 'Discover 10 revolutionary project highlights of ATHENS platform. Complete safety management, AI-powered intelligence, real-time notifications, and enterprise solutions.');
        
        $page_url = get_permalink($page_id);
        $edit_url = admin_url('post.php?post=' . $page_id . '&action=elementor');
        
        wp_send_json_success(array(
            'page_id' => $page_id,
            'url' => $page_url,
            'edit_url' => $edit_url,
            'action' => $action
        ));
    }
    
    private function get_elementor_data() {
        // Include the complete data structure
        require_once(plugin_dir_path(__FILE__) . 'elementor-data-structure.php');
        return get_athens_elementor_data();
    }
}

// Initialize the plugin
new AthensElementorPageCreator();
?>
