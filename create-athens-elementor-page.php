<?php
/**
 * Create ATHENS Elementor Page with Homepage Design
 * Converts HTML to WordPress Elementor page with exact homepage styling
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Create ATHENS Elementor Page</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    h1{color:#6F4898;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .create-button{background:#6F4898;color:white;padding:15px 30px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:16px;font-weight:bold;}
    .feature-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin:20px 0;}
    .feature-item{background:#f8f9fa;padding:20px;border-radius:8px;border-left:4px solid #6F4898;}
</style>";
echo "</head><body>";

echo "<h1>🚀 Create ATHENS Elementor Page</h1>";

// Handle page creation
if (isset($_POST['create_elementor_page'])) {
    echo "<div class='info'>";
    echo "<h2>Creating ATHENS Elementor Page...</h2>";
    
    // Check if Elementor is active
    if (!is_plugin_active('elementor/elementor.php')) {
        echo "<div class='error'>";
        echo "<h3>❌ Elementor Plugin Required</h3>";
        echo "<p>Elementor plugin must be installed and activated to create this page.</p>";
        echo "<p>Please install Elementor first, then return to create the page.</p>";
        echo "</div>";
        echo "</div>";
        echo "</body></html>";
        return;
    }
    
    // Check if page already exists
    $existing_page = get_page_by_path('athens-elementor');
    if ($existing_page) {
        echo "<p>❌ Page 'athens-elementor' already exists. Updating content...</p>";
        $page_id = $existing_page->ID;
        $action = 'update';
    } else {
        echo "<p>✅ Creating new 'athens-elementor' page...</p>";
        $action = 'create';
    }
    
    // Create/Update the page
    if ($action === 'create') {
        $page_id = wp_insert_post(array(
            'post_title' => 'ATHENS',
            'post_content' => '', // Elementor will handle content
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'athens-elementor',
            'meta_input' => array(
                '_elementor_edit_mode' => 'builder',
                '_elementor_template_type' => 'wp-page',
                '_elementor_version' => '3.0.0',
                '_wp_page_template' => 'elementor_header_footer'
            )
        ));
    } else {
        $page_id = $existing_page->ID;
        // Enable Elementor for existing page
        update_post_meta($page_id, '_elementor_edit_mode', 'builder');
        update_post_meta($page_id, '_elementor_template_type', 'wp-page');
        update_post_meta($page_id, '_elementor_version', '3.0.0');
    }
    
    if ($page_id) {
        // Elementor page data structure - copying homepage design
        $elementor_data = [
            [
                'id' => 'hero-section',
                'elType' => 'section',
                'settings' => [
                    'layout' => 'boxed',
                    'content_width' => 'boxed',
                    'height' => 'min-height',
                    'height_tablet' => 'min-height',
                    'height_mobile' => 'min-height',
                    'custom_height' => ['size' => 100, 'unit' => 'vh'],
                    'background_background' => 'gradient',
                    'background_color' => '#6F4898',
                    'background_color_b' => '#4A3B6B',
                    'background_gradient_type' => 'linear',
                    'background_gradient_angle' => ['size' => 135, 'unit' => 'deg'],
                    'background_overlay_background' => 'classic',
                    'background_overlay_color' => 'rgba(0,0,0,0.1)',
                    'padding' => ['top' => '120', 'bottom' => '120', 'unit' => 'px'],
                    'margin' => ['top' => '0', 'bottom' => '0', 'unit' => 'px']
                ],
                'elements' => [
                    [
                        'id' => 'hero-column',
                        'elType' => 'column',
                        'settings' => [
                            'width' => '100',
                            'content_position' => 'middle',
                            '_column_size' => 100
                        ],
                        'elements' => [
                            [
                                'id' => 'hero-heading',
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
                                    'text_shadow_text_shadow_type' => 'yes',
                                    'text_shadow_text_shadow' => [
                                        'horizontal' => 0,
                                        'vertical' => 4,
                                        'blur' => 20,
                                        'color' => 'rgba(0,0,0,0.3)'
                                    ],
                                    'align' => 'center',
                                    'margin' => ['bottom' => '30', 'unit' => 'px']
                                ]
                            ],
                            [
                                'id' => 'hero-subtitle',
                                'elType' => 'widget',
                                'widgetType' => 'text-editor',
                                'settings' => [
                                    'editor' => '<p style="text-align: center; font-size: 28px; color: #FFFFFF; opacity: 0.9; font-weight: 300; margin-bottom: 40px;">Revolutionary Safety Management Platform</p>',
                                    'typography_typography' => 'custom',
                                    'typography_font_family' => 'Inter',
                                    'align' => 'center'
                                ]
                            ],
                            [
                                'id' => 'hero-badge',
                                'elType' => 'widget',
                                'widgetType' => 'button',
                                'settings' => [
                                    'text' => '🚀 10 KEY PROJECT HIGHLIGHTS',
                                    'size' => 'lg',
                                    'typography_typography' => 'custom',
                                    'typography_font_weight' => '600',
                                    'background_color' => 'rgba(255,255,255,0.15)',
                                    'border_border' => 'solid',
                                    'border_width' => ['top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'unit' => 'px'],
                                    'border_color' => 'rgba(255,255,255,0.2)',
                                    'border_radius' => ['top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => 'px'],
                                    'text_padding' => ['top' => '16', 'right' => '40', 'bottom' => '16', 'left' => '40', 'unit' => 'px'],
                                    'align' => 'center',
                                    'hover_animation' => 'grow'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'id' => 'intro-section',
                'elType' => 'section',
                'settings' => [
                    'layout' => 'boxed',
                    'background_background' => 'classic',
                    'background_color' => '#FFFFFF',
                    'padding' => ['top' => '80', 'bottom' => '80', 'unit' => 'px']
                ],
                'elements' => [
                    [
                        'id' => 'intro-column',
                        'elType' => 'column',
                        'settings' => ['width' => '100'],
                        'elements' => [
                            [
                                'id' => 'intro-heading',
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
                                    'align' => 'center',
                                    'margin' => ['bottom' => '30', 'unit' => 'px']
                                ]
                            ],
                            [
                                'id' => 'intro-text',
                                'elType' => 'widget',
                                'widgetType' => 'text-editor',
                                'settings' => [
                                    'editor' => '<p style="text-align: center; font-size: 20px; color: #7A7A7A; line-height: 1.6; max-width: 900px; margin: 0 auto;">Discover the revolutionary features that make ATHENS the most comprehensive safety management platform. From AI-powered intelligence to real-time notifications, experience the future of workplace safety.</p>',
                                    'typography_typography' => 'custom',
                                    'typography_font_family' => 'Inter',
                                    'align' => 'center'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        // Add highlights sections (10 cards)
        $highlights_data = [
            ['number' => '1', 'icon' => '🏢', 'title' => 'Complete Safety Management Platform', 'content' => '<p><strong>Transform your entire safety operations</strong> with 10 integrated modules in one system.</p><p>Eliminate multiple software costs and streamline all safety processes.</p><p>Get real-time visibility across incidents, permits, training, and compliance.</p>'],
            ['number' => '2', 'icon' => '🤖', 'title' => 'AI-Powered Intelligence System', 'content' => '<p><strong>Ask questions in plain English</strong> and get instant answers from your safety data.</p><p>Reduce report generation time from hours to minutes with smart automation.</p><p>Predict safety risks before they become incidents using advanced analytics.</p>'],
            ['number' => '3', 'icon' => '🔔', 'title' => 'Real-Time Notification System', 'content' => '<p><strong>Critical incidents reach the right people</strong> in under 3 seconds automatically.</p><p>Never miss important safety alerts with smart routing and escalation.</p><p>Improve emergency response times by 85% with instant communication.</p>'],
            ['number' => '4', 'icon' => '🔧', 'title' => '8D Problem Solving Methodology', 'content' => '<p><strong>Solve complex safety problems systematically</strong> using industry-proven methods.</p><p>Reduce incident recurrence by 75% with structured root cause analysis.</p><p>Track corrective actions from identification to completion automatically.</p>'],
            ['number' => '5', 'icon' => '📱', 'title' => 'Mobile-First Design', 'content' => '<p><strong>Field workers can report incidents</strong> and access permits from any device.</p><p>Photo capture and GPS location tracking work seamlessly on mobile.</p><p>95% of users become productive within 30 days with intuitive interface.</p>'],
            ['number' => '6', 'icon' => '📋', 'title' => 'Advanced Permit Management', 'content' => '<p><strong>Manage 26 different permit types</strong> with automated approval workflows.</p><p>Generate QR codes for instant mobile access to work permits.</p><p>Reduce permit processing time by 60% with digital signatures.</p>'],
            ['number' => '7', 'icon' => '👤', 'title' => 'Face Recognition Technology', 'content' => '<p><strong>Verify worker attendance automatically</strong> using advanced face recognition.</p><p>Eliminate buddy punching and ensure accurate workforce tracking.</p><p>Integrate seamlessly with existing worker management systems.</p>'],
            ['number' => '8', 'icon' => '🔒', 'title' => 'Enterprise Security & Compliance', 'content' => '<p><strong>Meet ISO 45001, OSHA, and GDPR requirements</strong> with built-in compliance.</p><p>Role-based access ensures only authorized users see sensitive data.</p><p>Complete audit trails track every action for regulatory reporting.</p>'],
            ['number' => '9', 'icon' => '💰', 'title' => 'Cost-Effective Solution', 'content' => '<p><strong>Save 40% compared to competitors</strong> with no hidden fees or surprise charges.</p><p>Achieve 300% ROI within 6 months through operational efficiency gains.</p><p>Eliminate multiple software licenses by consolidating into one platform.</p>'],
            ['number' => '10', 'icon' => '⚡', 'title' => 'Rapid 30-Day Implementation', 'content' => '<p><strong>Go live in 30 days</strong> with zero downtime migration from existing systems.</p><p>Get 24/7 expert support and dedicated success manager included.</p><p>Start seeing measurable results within the first week of deployment.</p>']
        ];
        
        // Create highlights section
        $highlights_section = [
            'id' => 'highlights-section',
            'elType' => 'section',
            'settings' => [
                'layout' => 'boxed',
                'background_background' => 'classic',
                'background_color' => '#F8F9FA',
                'padding' => ['top' => '80', 'bottom' => '80', 'unit' => 'px']
            ],
            'elements' => []
        ];
        
        // Add highlights in pairs (2 columns)
        for ($i = 0; $i < count($highlights_data); $i += 2) {
            $row_elements = [];
            
            // First column
            if (isset($highlights_data[$i])) {
                $highlight = $highlights_data[$i];
                $row_elements[] = [
                    'id' => 'highlight-col-' . ($i + 1),
                    'elType' => 'column',
                    'settings' => ['width' => '50'],
                    'elements' => [
                        [
                            'id' => 'highlight-card-' . ($i + 1),
                            'elType' => 'widget',
                            'widgetType' => 'icon-box',
                            'settings' => [
                                'view' => 'default',
                                'icon' => ['value' => 'fas fa-circle', 'library' => 'fa-solid'],
                                'primary_color' => '#6F4898',
                                'secondary_color' => '#FFFFFF',
                                'size' => 'custom',
                                'icon_size' => ['size' => 70, 'unit' => 'px'],
                                'icon_padding' => ['size' => 25, 'unit' => 'px'],
                                'rotate' => ['size' => 0, 'unit' => 'deg'],
                                'border_radius' => ['size' => 50, 'unit' => '%'],
                                'title_text' => $highlight['title'],
                                'description_text' => strip_tags($highlight['content']),
                                'title_color' => '#6F4898',
                                'description_color' => '#7A7A7A',
                                'content_vertical_alignment' => 'top',
                                'title_size' => 'custom',
                                'title_size_size' => ['size' => 24, 'unit' => 'px'],
                                'title_typography_typography' => 'custom',
                                'title_typography_font_family' => 'Outfit',
                                'title_typography_font_weight' => '700',
                                'description_typography_typography' => 'custom',
                                'description_typography_font_family' => 'Inter',
                                'background_background' => 'classic',
                                'background_color' => '#FFFFFF',
                                'border_border' => 'solid',
                                'border_width' => ['top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px'],
                                'border_color' => 'rgba(111,72,152,0.1)',
                                'border_radius' => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
                                'box_shadow_box_shadow_type' => 'yes',
                                'box_shadow_box_shadow' => [
                                    'horizontal' => 0,
                                    'vertical' => 10,
                                    'blur' => 40,
                                    'spread' => 0,
                                    'color' => 'rgba(111,72,152,0.08)'
                                ],
                                'padding' => ['top' => '50', 'right' => '40', 'bottom' => '50', 'left' => '40', 'unit' => 'px'],
                                'margin' => ['bottom' => '40', 'unit' => 'px'],
                                'hover_animation' => 'float'
                            ]
                        ]
                    ]
                ];
            }
            
            // Second column
            if (isset($highlights_data[$i + 1])) {
                $highlight = $highlights_data[$i + 1];
                $row_elements[] = [
                    'id' => 'highlight-col-' . ($i + 2),
                    'elType' => 'column',
                    'settings' => ['width' => '50'],
                    'elements' => [
                        [
                            'id' => 'highlight-card-' . ($i + 2),
                            'elType' => 'widget',
                            'widgetType' => 'icon-box',
                            'settings' => [
                                'view' => 'default',
                                'icon' => ['value' => 'fas fa-circle', 'library' => 'fa-solid'],
                                'primary_color' => '#6F4898',
                                'secondary_color' => '#FFFFFF',
                                'size' => 'custom',
                                'icon_size' => ['size' => 70, 'unit' => 'px'],
                                'icon_padding' => ['size' => 25, 'unit' => 'px'],
                                'rotate' => ['size' => 0, 'unit' => 'deg'],
                                'border_radius' => ['size' => 50, 'unit' => '%'],
                                'title_text' => $highlight['title'],
                                'description_text' => strip_tags($highlight['content']),
                                'title_color' => '#6F4898',
                                'description_color' => '#7A7A7A',
                                'content_vertical_alignment' => 'top',
                                'title_size' => 'custom',
                                'title_size_size' => ['size' => 24, 'unit' => 'px'],
                                'title_typography_typography' => 'custom',
                                'title_typography_font_family' => 'Outfit',
                                'title_typography_font_weight' => '700',
                                'description_typography_typography' => 'custom',
                                'description_typography_font_family' => 'Inter',
                                'background_background' => 'classic',
                                'background_color' => '#FFFFFF',
                                'border_border' => 'solid',
                                'border_width' => ['top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px'],
                                'border_color' => 'rgba(111,72,152,0.1)',
                                'border_radius' => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
                                'box_shadow_box_shadow_type' => 'yes',
                                'box_shadow_box_shadow' => [
                                    'horizontal' => 0,
                                    'vertical' => 10,
                                    'blur' => 40,
                                    'spread' => 0,
                                    'color' => 'rgba(111,72,152,0.08)'
                                ],
                                'padding' => ['top' => '50', 'right' => '40', 'bottom' => '50', 'left' => '40', 'unit' => 'px'],
                                'margin' => ['bottom' => '40', 'unit' => 'px'],
                                'hover_animation' => 'float'
                            ]
                        ]
                    ]
                ];
            }
            
            $highlights_section['elements'][] = [
                'id' => 'highlight-row-' . ($i / 2 + 1),
                'elType' => 'section',
                'settings' => [
                    'structure' => count($row_elements) == 2 ? '50' : '100',
                    'gap' => 'default'
                ],
                'elements' => $row_elements
            ];
        }
        
        $elementor_data[] = $highlights_section;
        
        // Add statistics section with actual stats
        $stats_data = [
            ['number' => '85%', 'label' => 'Faster Emergency Response'],
            ['number' => '75%', 'label' => 'Reduced Incident Recurrence'],
            ['number' => '60%', 'label' => 'Faster Permit Processing'],
            ['number' => '300%', 'label' => 'ROI Within 6 Months'],
            ['number' => '30', 'label' => 'Days to Implementation'],
            ['number' => '40%', 'label' => 'Cost Savings']
        ];

        $stats_section = [
            'id' => 'stats-section',
            'elType' => 'section',
            'settings' => [
                'layout' => 'boxed',
                'background_background' => 'gradient',
                'background_color' => '#6F4898',
                'background_color_b' => '#4A3B6B',
                'background_gradient_type' => 'linear',
                'background_gradient_angle' => ['size' => 135, 'unit' => 'deg'],
                'padding' => ['top' => '100', 'bottom' => '100', 'unit' => 'px']
            ],
            'elements' => [
                [
                    'id' => 'stats-heading-col',
                    'elType' => 'column',
                    'settings' => ['width' => '100'],
                    'elements' => [
                        [
                            'id' => 'stats-heading',
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'ATHENS by the Numbers',
                                'size' => 'custom',
                                'custom_size' => ['size' => 48, 'unit' => 'px'],
                                'color' => '#FFFFFF',
                                'typography_typography' => 'custom',
                                'typography_font_family' => 'Outfit',
                                'typography_font_weight' => '700',
                                'align' => 'center',
                                'margin' => ['bottom' => '60', 'unit' => 'px']
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // Add stats grid
        $stats_row_elements = [];
        foreach ($stats_data as $index => $stat) {
            $stats_row_elements[] = [
                'id' => 'stat-col-' . ($index + 1),
                'elType' => 'column',
                'settings' => ['width' => '16.666'],
                'elements' => [
                    [
                        'id' => 'stat-counter-' . ($index + 1),
                        'elType' => 'widget',
                        'widgetType' => 'counter',
                        'settings' => [
                            'ending_number' => $stat['number'],
                            'title' => $stat['label'],
                            'number_color' => '#FFFFFF',
                            'title_color' => 'rgba(255,255,255,0.9)',
                            'number_typography_typography' => 'custom',
                            'number_typography_font_family' => 'Outfit',
                            'number_typography_font_size' => ['size' => 56, 'unit' => 'px'],
                            'number_typography_font_weight' => '800',
                            'title_typography_typography' => 'custom',
                            'title_typography_font_family' => 'Inter',
                            'title_typography_font_size' => ['size' => 18, 'unit' => 'px'],
                            'title_typography_font_weight' => '500',
                            'text_align' => 'center',
                            'background_background' => 'classic',
                            'background_color' => 'rgba(255,255,255,0.1)',
                            'border_radius' => ['top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px'],
                            'padding' => ['top' => '40', 'right' => '30', 'bottom' => '40', 'left' => '30', 'unit' => 'px'],
                            'margin' => ['bottom' => '20', 'unit' => 'px'],
                            'hover_animation' => 'grow'
                        ]
                    ]
                ]
            ];
        }

        $stats_section['elements'][] = [
            'id' => 'stats-row',
            'elType' => 'section',
            'settings' => [
                'structure' => '16_16_16_16_16_16',
                'gap' => 'default'
            ],
            'elements' => $stats_row_elements
        ];
        
        $elementor_data[] = $stats_section;
        
        // Add CTA section
        $cta_section = [
            'id' => 'cta-section',
            'elType' => 'section',
            'settings' => [
                'layout' => 'boxed',
                'background_background' => 'classic',
                'background_color' => '#FFFFFF',
                'padding' => ['top' => '100', 'bottom' => '100', 'unit' => 'px']
            ],
            'elements' => [
                [
                    'id' => 'cta-column',
                    'elType' => 'column',
                    'settings' => ['width' => '100'],
                    'elements' => [
                        [
                            'id' => 'cta-heading',
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
                                'align' => 'center',
                                'margin' => ['bottom' => '30', 'unit' => 'px']
                            ]
                        ],
                        [
                            'id' => 'cta-text',
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p style="text-align: center; font-size: 20px; color: #7A7A7A; margin-bottom: 50px;">Join hundreds of companies already using ATHENS to revolutionize their safety management.</p>',
                                'typography_typography' => 'custom',
                                'typography_font_family' => 'Inter',
                                'align' => 'center'
                            ]
                        ],
                        [
                            'id' => 'cta-buttons',
                            'elType' => 'widget',
                            'widgetType' => 'button',
                            'settings' => [
                                'text' => 'Get Started Today',
                                'link' => ['url' => '/contact-us', 'is_external' => false],
                                'size' => 'lg',
                                'typography_typography' => 'custom',
                                'typography_font_family' => 'Inter',
                                'typography_font_weight' => '600',
                                'background_color' => '#6F4898',
                                'border_radius' => ['top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => 'px'],
                                'text_padding' => ['top' => '20', 'right' => '45', 'bottom' => '20', 'left' => '45', 'unit' => 'px'],
                                'align' => 'center',
                                'hover_animation' => 'grow'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        $elementor_data[] = $cta_section;
        
        // Save Elementor data
        update_post_meta($page_id, '_elementor_data', json_encode($elementor_data));
        update_post_meta($page_id, '_elementor_page_settings', json_encode([]));
        update_post_meta($page_id, '_elementor_controls_usage', json_encode([]));
        
        // Update SEO meta
        update_post_meta($page_id, 'rank_math_title', 'ATHENS - 10 Key Project Highlights | Athens Business Solutions');
        update_post_meta($page_id, 'rank_math_description', 'Discover 10 revolutionary project highlights of ATHENS platform. Complete safety management, AI-powered intelligence, real-time notifications, and enterprise solutions.');
        update_post_meta($page_id, 'rank_math_focus_keyword', 'athens project highlights');
        
        echo "<div class='success'>";
        echo "<h3>✅ ATHENS Elementor Page Created Successfully!</h3>";
        echo "<p><strong>Page URL:</strong> <a href='/athens-elementor/' target='_blank'>https://athenas.co.in/athens-elementor/</a></p>";
        echo "<p><strong>Page ID:</strong> {$page_id}</p>";
        echo "<p><strong>Elementor Features Added:</strong></p>";
        echo "<ul>";
        echo "<li>✅ Hero section with gradient background and typography</li>";
        echo "<li>✅ Introduction section with centered content</li>";
        echo "<li>✅ 10 highlight cards using Elementor icon-box widgets</li>";
        echo "<li>✅ Statistics section with gradient background</li>";
        echo "<li>✅ Call-to-action section with buttons</li>";
        echo "<li>✅ Responsive design with proper column layouts</li>";
        echo "<li>✅ Homepage color scheme and typography</li>";
        echo "<li>✅ Hover animations and effects</li>";
        echo "</ul>";
        echo "<p><strong>Edit with Elementor:</strong> <a href='/wp-admin/post.php?post={$page_id}&action=elementor' target='_blank'>Open in Elementor Editor</a></p>";
        echo "</div>";
        
        // Auto-redirect after 5 seconds
        echo "<script>setTimeout(function(){ window.location.href = '/athens-elementor/'; }, 5000);</script>";
        echo "<p><em>Redirecting to ATHENS Elementor page in 5 seconds...</em></p>";
    } else {
        echo "<div class='error'>";
        echo "<h3>❌ Failed to create ATHENS Elementor page</h3>";
        echo "<p>There was an error creating the page. Please try again.</p>";
        echo "</div>";
    }
    
    echo "</div>";
} else {
    // Show creation interface
    echo "<div class='info'>";
    echo "<h2>🎯 ATHENS Elementor Page Creation</h2>";
    echo "<p>This will create a professional Elementor page with exact homepage design featuring:</p>";
    echo "</div>";
    
    echo "<div class='feature-grid'>";
    echo "<div class='feature-item'>";
    echo "<h3>🎨 Exact Homepage Design</h3>";
    echo "<p>Purple gradient backgrounds, Outfit & Inter fonts, exact color scheme (#6F4898)</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>🏗️ Elementor Structure</h3>";
    echo "<p>Proper sections, columns, and widgets with responsive layouts</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>📱 Responsive Design</h3>";
    echo "<p>Mobile-optimized layouts with proper breakpoints</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>✨ Interactive Elements</h3>";
    echo "<p>Hover animations, gradient buttons, and smooth transitions</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>🚀 10 Project Highlights</h3>";
    echo "<p>Professional icon-box widgets with all content and styling</p>";
    echo "</div>";
    
    echo "<div class='feature-item'>";
    echo "<h3>⚙️ Full Functionality</h3>";
    echo "<p>Editable in Elementor with all widgets and settings</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h3>📋 Requirements</h3>";
    echo "<ul>";
    echo "<li>✅ <strong>Elementor Plugin:</strong> Must be installed and activated</li>";
    echo "<li>✅ <strong>WordPress Admin Access:</strong> Required for page creation</li>";
    echo "<li>✅ <strong>Theme Compatibility:</strong> Works with any Elementor-compatible theme</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<form method='post'>";
    echo "<button type='submit' name='create_elementor_page' class='create-button'>🚀 Create ATHENS Elementor Page</button>";
    echo "</form>";
}

echo "</body></html>";
?>
