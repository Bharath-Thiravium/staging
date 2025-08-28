<?php
/**
 * Complete Elementor Data Structure for ATHENS Page
 * This file contains the complete Elementor JSON structure
 */

function get_athens_elementor_data() {
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
            'padding' => ['top' => '120', 'bottom' => '120', 'unit' => 'px'],
            'margin' => ['top' => '0', 'bottom' => '0', 'unit' => 'px']
        ],
        'elements' => [
            [
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 100,
                    'content_position' => 'middle'
                ],
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
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; font-size: 28px; color: #FFFFFF; opacity: 0.9; font-weight: 300; margin-bottom: 40px; font-family: Inter;">Revolutionary Safety Management Platform</p>',
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
                            'typography_typography' => 'custom',
                            'typography_font_weight' => '600',
                            'typography_font_family' => 'Inter',
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
    ];
    
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
                            'align' => 'center',
                            'margin' => ['bottom' => '30', 'unit' => 'px']
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; font-size: 20px; color: #7A7A7A; line-height: 1.6; max-width: 900px; margin: 0 auto; font-family: Inter;">Discover the revolutionary features that make ATHENS the most comprehensive safety management platform. From AI-powered intelligence to real-time notifications, experience the future of workplace safety.</p>',
                            'align' => 'center'
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    // Highlights Section
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
    
    // Add highlights in pairs (2 columns per row)
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
                            'secondary_color' => '#FFFFFF',
                            'size' => 'custom',
                            'icon_size' => ['size' => 70, 'unit' => 'px'],
                            'icon_padding' => ['size' => 25, 'unit' => 'px'],
                            'border_radius' => ['size' => 50, 'unit' => '%'],
                            'title_text' => $highlight['number'] . '. ' . $highlight['title'],
                            'description_text' => $highlight['content'],
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
                            'description_typography_font_size' => ['size' => 16, 'unit' => 'px'],
                            'description_typography_line_height' => ['size' => 1.6, 'unit' => 'em'],
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
                            'secondary_color' => '#FFFFFF',
                            'size' => 'custom',
                            'icon_size' => ['size' => 70, 'unit' => 'px'],
                            'icon_padding' => ['size' => 25, 'unit' => 'px'],
                            'border_radius' => ['size' => 50, 'unit' => '%'],
                            'title_text' => $highlight['number'] . '. ' . $highlight['title'],
                            'description_text' => $highlight['content'],
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
                            'description_typography_font_size' => ['size' => 16, 'unit' => 'px'],
                            'description_typography_line_height' => ['size' => 1.6, 'unit' => 'em'],
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
        
        // Add row to highlights section
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
    
    // Statistics Section
    $stats_section = [
        'id' => uniqid(),
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
                'id' => uniqid(),
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => uniqid(),
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
    
    // Add stats row
    $stats_row_elements = [];
    foreach ($stats_data as $index => $stat) {
        $stats_row_elements[] = [
            'id' => uniqid(),
            'elType' => 'column',
            'settings' => ['_column_size' => 16.666],
            'elements' => [
                [
                    'id' => uniqid(),
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
        'id' => uniqid(),
        'elType' => 'section',
        'settings' => [
            'structure' => '16_16_16_16_16_16',
            'gap' => 'default'
        ],
        'elements' => $stats_row_elements
    ];
    
    $elementor_data[] = $stats_section;
    
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
                            'align' => 'center',
                            'margin' => ['bottom' => '30', 'unit' => 'px']
                        ]
                    ],
                    [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="text-align: center; font-size: 20px; color: #7A7A7A; margin-bottom: 50px; font-family: Inter;">Join hundreds of companies already using ATHENS to revolutionize their safety management.</p>',
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
    
    return $elementor_data;
}
?>
