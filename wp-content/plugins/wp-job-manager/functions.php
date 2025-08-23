<?php
// Function to create the custom background shortcode
function my_custom_background_shortcode($atts, $content = null) {
    // Define default attributes
    $atts = shortcode_atts(
        array(
            'bg_color' => 'black', // Default background color
        ), 
        $atts, 
        'custom_bg'
    );

    // Return HTML with inline style for background color
    return '<div style="background-color: ' . esc_attr($atts['bg_color']) . ';">' . do_shortcode($content) . '</div>';
}

// Register the shortcode with WordPress
add_shortcode('custom_bg', 'my_custom_background_shortcode');
?>
