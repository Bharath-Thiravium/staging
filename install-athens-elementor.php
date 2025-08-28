<?php
/**
 * Installation Script for ATHENS Elementor Page
 * Upload this file to your WordPress root directory and run it
 */

// Security check
if (!file_exists('wp-config.php')) {
    die('This script must be placed in the WordPress root directory.');
}

require_once('wp-config.php');
require_once('wp-load.php');

echo "<html><head><title>Install ATHENS Elementor Page</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;background:#f1f1f1;} 
    .container{max-width:800px;margin:0 auto;background:white;padding:40px;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);}
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    h1{color:#6F4898;text-align:center;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .install-button{background:#6F4898;color:white;padding:15px 30px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:16px;font-weight:bold;}
    .install-button:hover{background:#5a3a7a;}
    .step{background:#f8f9fa;padding:20px;margin:15px 0;border-radius:8px;border-left:4px solid #6F4898;}
    .step h3{margin-top:0;color:#6F4898;}
</style>";
echo "</head><body><div class='container'>";

echo "<h1>🚀 ATHENS Elementor Page Installation</h1>";

// Check WordPress environment
if (!function_exists('wp_insert_post')) {
    echo "<div class='error'>";
    echo "<h3>❌ WordPress Not Detected</h3>";
    echo "<p>This script must be run from a WordPress installation.</p>";
    echo "</div></div></body></html>";
    exit;
}

// Check if user is logged in as admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    echo "<div class='error'>";
    echo "<h3>❌ Admin Access Required</h3>";
    echo "<p>Please log in as an administrator first:</p>";
    echo "<p><a href='" . wp_login_url($_SERVER['REQUEST_URI']) . "'>Login to WordPress Admin</a></p>";
    echo "</div></div></body></html>";
    exit;
}

// Check if Elementor is installed
if (!is_plugin_active('elementor/elementor.php')) {
    echo "<div class='error'>";
    echo "<h3>❌ Elementor Plugin Required</h3>";
    echo "<p>Elementor plugin must be installed and activated.</p>";
    echo "<p><a href='" . admin_url('plugin-install.php?s=elementor&tab=search&type=term') . "'>Install Elementor Plugin</a></p>";
    echo "</div></div></body></html>";
    exit;
}

// Handle installation
if (isset($_POST['install_athens'])) {
    echo "<div class='info'>";
    echo "<h2>Installing ATHENS Elementor Page...</h2>";
    
    // Step 1: Create the page
    echo "<div class='step'>";
    echo "<h3>Step 1: Creating WordPress Page</h3>";
    
    $existing_page = get_page_by_path('athens-project-highlights');
    if ($existing_page) {
        echo "<p>✅ Page already exists. Updating content...</p>";
        $page_id = $existing_page->ID;
        $action = 'update';
    } else {
        echo "<p>✅ Creating new page...</p>";
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
        $action = 'create';
    }
    
    if (!$page_id) {
        echo "<p>❌ Failed to create page</p>";
        echo "</div></div></div></body></html>";
        exit;
    }
    
    echo "<p>✅ Page created with ID: {$page_id}</p>";
    echo "</div>";
    
    // Step 2: Create Elementor data
    echo "<div class='step'>";
    echo "<h3>Step 2: Building Elementor Structure</h3>";
    
    // Include the data structure
    $highlights_data = [
        ['number' => '1', 'icon' => '🏢', 'title' => 'Complete Safety Management Platform', 'content' => 'Transform your entire safety operations with 10 integrated modules in one system. Eliminate multiple software costs and streamline all safety processes. Get real-time visibility across incidents, permits, training, and compliance.'],
        ['number' => '2', 'icon' => '🤖', 'title' => 'AI-Powered Intelligence System', 'content' => 'Ask questions in plain English and get instant answers from your safety data. Reduce report generation time from hours to minutes with smart automation. Predict safety risks before they become incidents using advanced analytics.'],
        ['number' => '3', 'icon' => '🔔', 'title' => 'Real-Time Notification System', 'content' => 'Critical incidents reach the right people in under 3 seconds automatically. Never miss important safety alerts with smart routing and escalation. Improve emergency response times by 85% with instant communication.'],
        ['number' => '4', 'icon' => '🔧', 'title' => '8D Problem Solving Methodology', 'content' => 'Solve complex safety problems systematically using industry-proven methods. Reduce incident recurrence by 75% with structured root cause analysis. Track corrective actions from identification to completion automatically.'],
        ['number' => '5', 'icon' => '📱', 'title' => 'Mobile-First Design', 'content' => 'Field workers can report incidents and access permits from any device. Photo capture and GPS location tracking work seamlessly on mobile. 95% of users become productive within 30 days with intuitive interface.'],
        ['number' => '6', 'icon' => '📋', 'title' => 'Advanced Permit Management', 'content' => 'Manage 26 different permit types with automated approval workflows. Generate QR codes for instant mobile access to work permits. Reduce permit processing time by 60% with digital signatures.'],
        ['number' => '7', 'icon' => '👤', 'title' => 'Face Recognition Technology', 'content' => 'Verify worker attendance automatically using advanced face recognition. Eliminate buddy punching and ensure accurate workforce tracking. Integrate seamlessly with existing worker management systems.'],
        ['number' => '8', 'icon' => '🔒', 'title' => 'Enterprise Security & Compliance', 'content' => 'Meet ISO 45001, OSHA, and GDPR requirements with built-in compliance. Role-based access ensures only authorized users see sensitive data. Complete audit trails track every action for regulatory reporting.'],
        ['number' => '9', 'icon' => '💰', 'title' => 'Cost-Effective Solution', 'content' => 'Save 40% compared to competitors with no hidden fees or surprise charges. Achieve 300% ROI within 6 months through operational efficiency gains. Eliminate multiple software licenses by consolidating into one platform.'],
        ['number' => '10', 'icon' => '⚡', 'title' => 'Rapid 30-Day Implementation', 'content' => 'Go live in 30 days with zero downtime migration from existing systems. Get 24/7 expert support and dedicated success manager included. Start seeing measurable results within the first week of deployment.']
    ];
    
    $stats_data = [
        ['number' => '85%', 'label' => 'Faster Emergency Response'],
        ['number' => '75%', 'label' => 'Reduced Incident Recurrence'],
        ['number' => '60%', 'label' => 'Faster Permit Processing'],
        ['number' => '300%', 'label' => 'ROI Within 6 Months'],
        ['number' => '30', 'label' => 'Days to Implementation'],
        ['number' => '40%', 'label' => 'Cost Savings']
    ];
    
    echo "<p>✅ Data structure prepared</p>";
    echo "<p>✅ 10 project highlights ready</p>";
    echo "<p>✅ 6 statistics ready</p>";
    echo "</div>";
    
    // Step 3: Build Elementor JSON
    echo "<div class='step'>";
    echo "<h3>Step 3: Creating Elementor JSON Structure</h3>";
    
    $elementor_data = [];
    
    // Hero Section
    $elementor_data[] = [
        'id' => uniqid(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'content_width' => 'boxed',
            'height' => 'min-height',
            'custom_height' => ['size' => 100, 'unit' => 'vh'],
            'background_background' => 'gradient',
            'background_color' => '#6F4898',
            'background_color_b' => '#4A3B6B',
            'background_gradient_type' => 'linear',
            'background_gradient_angle' => ['size' => 135, 'unit' => 'deg'],
            'padding' => ['top' => '120', 'bottom' => '120', 'unit' => 'px']
        ],
        'elements' => [
            [
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => ['_column_size' => 100, 'content_position' => 'middle'],
                'elements' => [
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'ATHENS',
                            'size' => 'custom',
                            'custom_size' => ['size' => 72, 'unit' => 'px'],
                            'color' => '#FFFFFF',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Outfit',
                            'typography_font_weight' => '800',
                            'typography_letter_spacing' => ['size' => 6, 'unit' => 'px'],
                            'align' => 'center'
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; font-size: 28px; color: #FFFFFF; opacity: 0.9; font-weight: 300;">Revolutionary Safety Management Platform</p>',
                            'align' => 'center'
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'button',
                        'settings' => [
                            'text' => '🚀 10 KEY PROJECT HIGHLIGHTS',
                            'size' => 'lg',
                            'background_color' => 'rgba(255,255,255,0.15)',
                            'border_border' => 'solid',
                            'border_width' => ['top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'unit' => 'px'],
                            'border_color' => 'rgba(255,255,255,0.2)',
                            'border_radius' => ['top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => 'px'],
                            'align' => 'center'
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    echo "<p>✅ Hero section created</p>";
    
    // Intro Section
    $elementor_data[] = [
        'id' => uniqid(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => ['top' => '80', 'bottom' => '80', 'unit' => 'px']
        ],
        'elements' => [
            [
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Transform Your Safety Operations',
                            'size' => 'custom',
                            'custom_size' => ['size' => 56, 'unit' => 'px'],
                            'color' => '#6F4898',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Outfit',
                            'typography_font_weight' => '700',
                            'align' => 'center'
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; font-size: 20px; color: #7A7A7A; line-height: 1.6;">Discover the revolutionary features that make ATHENS the most comprehensive safety management platform. From AI-powered intelligence to real-time notifications, experience the future of workplace safety.</p>',
                            'align' => 'center'
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    echo "<p>✅ Introduction section created</p>";
    
    // Create highlights section with simplified structure
    $highlights_section = [
        'id' => uniqid(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'background_background' => 'classic',
            'background_color' => '#F8F9FA',
            'padding' => ['top' => '80', 'bottom' => '80', 'unit' => 'px']
        ],
        'elements' => []
    ];
    
    // Add highlights in pairs
    for ($i = 0; $i < count($highlights_data); $i += 2) {
        $row_elements = [];
        
        // First column
        if (isset($highlights_data[$i])) {
            $highlight = $highlights_data[$i];
            $row_elements[] = [
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => ['_column_size' => 50],
                'elements' => [
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'icon-box',
                        'settings' => [
                            'view' => 'default',
                            'icon' => ['value' => 'fas fa-star', 'library' => 'fa-solid'],
                            'primary_color' => '#6F4898',
                            'title_text' => $highlight['number'] . '. ' . $highlight['title'],
                            'description_text' => $highlight['content'],
                            'title_color' => '#6F4898',
                            'description_color' => '#7A7A7A',
                            'background_background' => 'classic',
                            'background_color' => '#FFFFFF',
                            'border_border' => 'solid',
                            'border_width' => ['top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px'],
                            'border_color' => 'rgba(111,72,152,0.1)',
                            'border_radius' => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
                            'padding' => ['top' => '40', 'right' => '30', 'bottom' => '40', 'left' => '30', 'unit' => 'px'],
                            'margin' => ['bottom' => '30', 'unit' => 'px']
                        ]
                    ]
                ]
            ];
        }
        
        // Second column
        if (isset($highlights_data[$i + 1])) {
            $highlight = $highlights_data[$i + 1];
            $row_elements[] = [
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => ['_column_size' => 50],
                'elements' => [
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'icon-box',
                        'settings' => [
                            'view' => 'default',
                            'icon' => ['value' => 'fas fa-star', 'library' => 'fa-solid'],
                            'primary_color' => '#6F4898',
                            'title_text' => $highlight['number'] . '. ' . $highlight['title'],
                            'description_text' => $highlight['content'],
                            'title_color' => '#6F4898',
                            'description_color' => '#7A7A7A',
                            'background_background' => 'classic',
                            'background_color' => '#FFFFFF',
                            'border_border' => 'solid',
                            'border_width' => ['top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px'],
                            'border_color' => 'rgba(111,72,152,0.1)',
                            'border_radius' => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
                            'padding' => ['top' => '40', 'right' => '30', 'bottom' => '40', 'left' => '30', 'unit' => 'px'],
                            'margin' => ['bottom' => '30', 'unit' => 'px']
                        ]
                    ]
                ]
            ];
        }
        
        if (!empty($row_elements)) {
            $highlights_section['elements'][] = [
                'id' => uniqid(),
                'elType' => 'section',
                'settings' => [
                    'structure' => count($row_elements) == 2 ? '50' : '100',
                    'gap' => 'default'
                ],
                'elements' => $row_elements
            ];
        }
    }
    
    $elementor_data[] = $highlights_section;
    
    echo "<p>✅ 10 highlight cards created</p>";
    
    // CTA Section
    $elementor_data[] = [
        'id' => uniqid(),
        'elType' => 'section',
        'settings' => [
            'layout' => 'boxed',
            'background_background' => 'classic',
            'background_color' => '#FFFFFF',
            'padding' => ['top' => '100', 'bottom' => '100', 'unit' => 'px']
        ],
        'elements' => [
            [
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Ready to Transform Your Safety Operations?',
                            'size' => 'custom',
                            'custom_size' => ['size' => 48, 'unit' => 'px'],
                            'color' => '#6F4898',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Outfit',
                            'typography_font_weight' => '700',
                            'align' => 'center'
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; font-size: 20px; color: #7A7A7A;">Join hundreds of companies already using ATHENS to revolutionize their safety management.</p>',
                            'align' => 'center'
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'button',
                        'settings' => [
                            'text' => 'Get Started Today',
                            'link' => ['url' => '/contact-us', 'is_external' => false],
                            'size' => 'lg',
                            'background_color' => '#6F4898',
                            'border_radius' => ['top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => 'px'],
                            'align' => 'center'
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    echo "<p>✅ Call-to-action section created</p>";
    echo "</div>";
    
    // Step 4: Save to WordPress
    echo "<div class='step'>";
    echo "<h3>Step 4: Saving to WordPress</h3>";
    
    // Save Elementor data
    update_post_meta($page_id, '_elementor_data', json_encode($elementor_data));
    update_post_meta($page_id, '_elementor_page_settings', json_encode([]));
    update_post_meta($page_id, '_elementor_controls_usage', json_encode([]));
    
    // Update SEO meta
    update_post_meta($page_id, 'rank_math_title', 'ATHENS - 10 Key Project Highlights | Athens Business Solutions');
    update_post_meta($page_id, 'rank_math_description', 'Discover 10 revolutionary project highlights of ATHENS platform. Complete safety management, AI-powered intelligence, real-time notifications, and enterprise solutions.');
    
    echo "<p>✅ Elementor data saved</p>";
    echo "<p>✅ SEO metadata updated</p>";
    echo "</div>";
    
    // Success message
    $page_url = get_permalink($page_id);
    $edit_url = admin_url('post.php?post=' . $page_id . '&action=elementor');
    
    echo "<div class='success'>";
    echo "<h2>🎉 ATHENS Elementor Page Created Successfully!</h2>";
    echo "<p><strong>Page URL:</strong> <a href='{$page_url}' target='_blank'>{$page_url}</a></p>";
    echo "<p><strong>Page ID:</strong> {$page_id}</p>";
    echo "<p><strong>Edit with Elementor:</strong> <a href='{$edit_url}' target='_blank'>Open in Elementor Editor</a></p>";
    echo "<div style='margin-top: 30px;'>";
    echo "<a href='{$page_url}' target='_blank' class='install-button'>View Page</a> ";
    echo "<a href='{$edit_url}' target='_blank' class='install-button'>Edit with Elementor</a>";
    echo "</div>";
    echo "</div>";
    
    echo "</div>";
    
    // Auto-redirect
    echo "<script>setTimeout(function(){ window.open('{$page_url}', '_blank'); }, 3000);</script>";
    echo "<p><em>Opening page in 3 seconds...</em></p>";
    
} else {
    // Show installation interface
    echo "<div class='info'>";
    echo "<h2>🎯 Ready to Install ATHENS Elementor Page</h2>";
    echo "<p>This will create a complete Elementor page with:</p>";
    echo "<ul>";
    echo "<li>✅ Hero section with purple gradient background</li>";
    echo "<li>✅ Introduction section with centered content</li>";
    echo "<li>✅ 10 project highlight cards with icon-box widgets</li>";
    echo "<li>✅ Call-to-action section with buttons</li>";
    echo "<li>✅ Exact homepage color scheme and typography</li>";
    echo "<li>✅ Responsive design with proper layouts</li>";
    echo "<li>✅ Fully editable in Elementor</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h3>📋 System Check</h3>";
    echo "<ul>";
    echo "<li>✅ WordPress: " . get_bloginfo('version') . "</li>";
    echo "<li>✅ Elementor: Active</li>";
    echo "<li>✅ Admin Access: Confirmed</li>";
    echo "<li>✅ Page Creation: Ready</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<form method='post' style='text-align: center; margin: 40px 0;'>";
    echo "<button type='submit' name='install_athens' class='install-button'>🚀 Install ATHENS Elementor Page</button>";
    echo "</form>";
}

echo "</div></body></html>";
?>
