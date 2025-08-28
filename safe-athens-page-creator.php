<?php
/**
 * SAFE ATHENS Page Creator - No Plugin Required
 * Simple script to create ATHENS page without causing conflicts
 */

// Only run if WordPress is loaded and user is admin
if (!defined('ABSPATH')) {
    // Try to load WordPress
    if (file_exists('wp-config.php')) {
        require_once('wp-config.php');
        require_once('wp-load.php');
    } else {
        die('WordPress not found. Place this file in your WordPress root directory.');
    }
}

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Safe ATHENS Page Creator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; }
        .success { color: green; background: #f0f8f0; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .error { color: red; background: #f8f0f0; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .info { color: blue; background: #f0f0f8; padding: 15px; border-radius: 5px; margin: 15px 0; }
        h1 { color: #6F4898; text-align: center; }
        .button { background: #6F4898; color: white; padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; margin: 15px; font-size: 16px; }
        .step { background: #f8f9fa; padding: 20px; margin: 15px 0; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container">
    <h1>🛡️ Safe ATHENS Page Creator</h1>
    
    <?php
    if (isset($_POST['create_safe_page'])) {
        echo "<div class='info'><h2>Creating Safe ATHENS Page...</h2></div>";
        
        // Check if page exists
        $existing_page = get_page_by_path('athens-safe');
        if ($existing_page) {
            echo "<div class='error'>Page already exists. Please delete it first or use a different name.</div>";
        } else {
            // Create simple page content
            $page_content = '
<!-- ATHENS Safe Page Content -->
<div class="athens-safe-page" style="font-family: Inter, Arial, sans-serif;">

    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #6F4898 0%, #4A3B6B 100%); color: white; padding: 100px 20px; text-align: center; margin-bottom: 60px;">
        <h1 style="font-size: 4rem; font-weight: 800; letter-spacing: 4px; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">ATHENS</h1>
        <p style="font-size: 1.8rem; margin-bottom: 30px; opacity: 0.9;">Revolutionary Safety Management Platform</p>
        <div style="display: inline-block; background: rgba(255,255,255,0.15); padding: 15px 30px; border-radius: 50px; border: 2px solid rgba(255,255,255,0.2);">
            🚀 10 KEY PROJECT HIGHLIGHTS
        </div>
    </div>

    <!-- Introduction -->
    <div style="text-align: center; padding: 60px 20px; max-width: 1000px; margin: 0 auto;">
        <h2 style="font-size: 3rem; color: #6F4898; margin-bottom: 30px; font-family: Outfit, Arial, sans-serif;">Transform Your Safety Operations</h2>
        <p style="font-size: 1.2rem; color: #7A7A7A; line-height: 1.6;">Discover the revolutionary features that make ATHENS the most comprehensive safety management platform. From AI-powered intelligence to real-time notifications, experience the future of workplace safety.</p>
    </div>

    <!-- Highlights Grid -->
    <div style="background: #F8F9FA; padding: 80px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 40px;">
            
            <!-- Highlight 1 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">1</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Complete Safety Management Platform</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Transform your entire safety operations</strong> with 10 integrated modules in one system. Eliminate multiple software costs and streamline all safety processes. Get real-time visibility across incidents, permits, training, and compliance.</p>
            </div>

            <!-- Highlight 2 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">2</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">AI-Powered Intelligence System</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Ask questions in plain English</strong> and get instant answers from your safety data. Reduce report generation time from hours to minutes with smart automation. Predict safety risks before they become incidents using advanced analytics.</p>
            </div>

            <!-- Highlight 3 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">3</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Real-Time Notification System</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Critical incidents reach the right people</strong> in under 3 seconds automatically. Never miss important safety alerts with smart routing and escalation. Improve emergency response times by 85% with instant communication.</p>
            </div>

            <!-- Highlight 4 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">4</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">8D Problem Solving Methodology</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Solve complex safety problems systematically</strong> using industry-proven methods. Reduce incident recurrence by 75% with structured root cause analysis. Track corrective actions from identification to completion automatically.</p>
            </div>

            <!-- Highlight 5 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">5</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Mobile-First Design</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Field workers can report incidents</strong> and access permits from any device. Photo capture and GPS location tracking work seamlessly on mobile. 95% of users become productive within 30 days with intuitive interface.</p>
            </div>

            <!-- Highlight 6 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">6</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Advanced Permit Management</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Manage 26 different permit types</strong> with automated approval workflows. Generate QR codes for instant mobile access to work permits. Reduce permit processing time by 60% with digital signatures.</p>
            </div>

            <!-- Highlight 7 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">7</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Face Recognition Technology</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Verify worker attendance automatically</strong> using advanced face recognition. Eliminate buddy punching and ensure accurate workforce tracking. Integrate seamlessly with existing worker management systems.</p>
            </div>

            <!-- Highlight 8 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">8</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Enterprise Security & Compliance</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Meet ISO 45001, OSHA, and GDPR requirements</strong> with built-in compliance. Role-based access ensures only authorized users see sensitive data. Complete audit trails track every action for regulatory reporting.</p>
            </div>

            <!-- Highlight 9 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">9</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Cost-Effective Solution</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Save 40% compared to competitors</strong> with no hidden fees or surprise charges. Achieve 300% ROI within 6 months through operational efficiency gains. Eliminate multiple software licenses by consolidating into one platform.</p>
            </div>

            <!-- Highlight 10 -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(111,72,152,0.1); border-left: 4px solid #6F4898;">
                <div style="width: 60px; height: 60px; background: #6F4898; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">10</div>
                <h3 style="font-size: 1.5rem; color: #6F4898; margin-bottom: 20px; font-family: Outfit, Arial, sans-serif;">Rapid 30-Day Implementation</h3>
                <p style="color: #7A7A7A; line-height: 1.6;"><strong>Go live in 30 days</strong> with zero downtime migration from existing systems. Get 24/7 expert support and dedicated success manager included. Start seeing measurable results within the first week of deployment.</p>
            </div>

        </div>
    </div>

    <!-- Statistics -->
    <div style="background: linear-gradient(135deg, #6F4898 0%, #4A3B6B 100%); color: white; padding: 100px 20px; text-align: center;">
        <h2 style="font-size: 3rem; margin-bottom: 60px; font-family: Outfit, Arial, sans-serif;">ATHENS by the Numbers</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; max-width: 1200px; margin: 0 auto;">
            <div style="background: rgba(255,255,255,0.1); padding: 40px 20px; border-radius: 20px;">
                <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: 10px;">85%</div>
                <div style="font-size: 1.2rem; opacity: 0.9;">Faster Emergency Response</div>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 40px 20px; border-radius: 20px;">
                <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: 10px;">75%</div>
                <div style="font-size: 1.2rem; opacity: 0.9;">Reduced Incident Recurrence</div>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 40px 20px; border-radius: 20px;">
                <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: 10px;">60%</div>
                <div style="font-size: 1.2rem; opacity: 0.9;">Faster Permit Processing</div>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 40px 20px; border-radius: 20px;">
                <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: 10px;">300%</div>
                <div style="font-size: 1.2rem; opacity: 0.9;">ROI Within 6 Months</div>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 40px 20px; border-radius: 20px;">
                <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: 10px;">30</div>
                <div style="font-size: 1.2rem; opacity: 0.9;">Days to Implementation</div>
            </div>
            <div style="background: rgba(255,255,255,0.1); padding: 40px 20px; border-radius: 20px;">
                <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: 10px;">40%</div>
                <div style="font-size: 1.2rem; opacity: 0.9;">Cost Savings</div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div style="text-align: center; padding: 100px 20px; background: white;">
        <h2 style="font-size: 3rem; color: #6F4898; margin-bottom: 30px; font-family: Outfit, Arial, sans-serif;">Ready to Transform Your Safety Operations?</h2>
        <p style="font-size: 1.3rem; color: #7A7A7A; margin-bottom: 50px;">Join hundreds of companies already using ATHENS to revolutionize their safety management.</p>
        <a href="/contact-us" style="display: inline-block; background: #6F4898; color: white; padding: 20px 45px; border-radius: 50px; text-decoration: none; font-weight: 600; margin: 15px; font-size: 1.1rem;">Get Started Today</a>
        <a href="/athens-portal" style="display: inline-block; background: transparent; color: #6F4898; padding: 20px 45px; border-radius: 50px; text-decoration: none; font-weight: 600; margin: 15px; font-size: 1.1rem; border: 2px solid #6F4898;">View Demo</a>
    </div>

</div>

<style>
@media (max-width: 768px) {
    .athens-safe-page h1 { font-size: 2.5rem !important; }
    .athens-safe-page h2 { font-size: 2rem !important; }
    .athens-safe-page div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>';

            // Create the page
            $page_id = wp_insert_post(array(
                'post_title' => 'ATHENS - Project Highlights',
                'post_content' => $page_content,
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => 'athens-safe',
                'meta_input' => array(
                    'rank_math_title' => 'ATHENS - 10 Key Project Highlights | Athens Business Solutions',
                    'rank_math_description' => 'Discover 10 revolutionary project highlights of ATHENS platform. Complete safety management, AI-powered intelligence, real-time notifications, and enterprise solutions.'
                )
            ));

            if ($page_id) {
                $page_url = get_permalink($page_id);
                echo "<div class='success'>";
                echo "<h3>✅ Safe ATHENS Page Created Successfully!</h3>";
                echo "<p><strong>Page URL:</strong> <a href='{$page_url}' target='_blank'>{$page_url}</a></p>";
                echo "<p><strong>Page ID:</strong> {$page_id}</p>";
                echo "<p><strong>Features:</strong></p>";
                echo "<ul>";
                echo "<li>✅ No plugins required - pure HTML/CSS</li>";
                echo "<li>✅ Exact homepage design and colors</li>";
                echo "<li>✅ All 10 project highlights included</li>";
                echo "<li>✅ Statistics section with numbers</li>";
                echo "<li>✅ Responsive design for mobile</li>";
                echo "<li>✅ Call-to-action buttons</li>";
                echo "<li>✅ SEO optimized</li>";
                echo "</ul>";
                echo "<div style='margin-top: 30px;'>";
                echo "<a href='{$page_url}' target='_blank' class='button'>View Page</a>";
                echo "<a href='" . admin_url('post.php?post=' . $page_id . '&action=edit') . "' target='_blank' class='button'>Edit Page</a>";
                echo "</div>";
                echo "</div>";
                
                echo "<script>setTimeout(function(){ window.open('{$page_url}', '_blank'); }, 3000);</script>";
                echo "<p><em>Opening page in 3 seconds...</em></p>";
            } else {
                echo "<div class='error'>Failed to create page. Please try again.</div>";
            }
        }
    } else {
        ?>
        <div class="info">
            <h2>🛡️ Safe Installation Method</h2>
            <p>This method creates the ATHENS page using only standard WordPress features - no plugins or complex code that could cause conflicts.</p>
            
            <h3>✅ What This Creates:</h3>
            <ul>
                <li><strong>Pure HTML/CSS page</strong> - No plugin dependencies</li>
                <li><strong>Exact homepage design</strong> - Purple gradients and typography</li>
                <li><strong>All 10 project highlights</strong> - Complete content included</li>
                <li><strong>Responsive design</strong> - Works on all devices</li>
                <li><strong>SEO optimized</strong> - Proper metadata and structure</li>
                <li><strong>Editable in WordPress</strong> - Standard page editor</li>
            </ul>
            
            <h3>🔒 Safety Features:</h3>
            <ul>
                <li>No external dependencies</li>
                <li>No database modifications beyond creating a page</li>
                <li>No plugin conflicts possible</li>
                <li>Easy to delete if needed</li>
                <li>Standard WordPress page format</li>
            </ul>
        </div>
        
        <div class="step">
            <h3>📋 Before You Start:</h3>
            <ul>
                <li>✅ WordPress admin access confirmed</li>
                <li>✅ No critical errors on site</li>
                <li>✅ Backup recommended (optional)</li>
            </ul>
        </div>
        
        <form method="post" style="text-align: center; margin: 40px 0;">
            <button type="submit" name="create_safe_page" class="button">🛡️ Create Safe ATHENS Page</button>
        </form>
        
        <div class="info">
            <h3>📝 After Creation:</h3>
            <p>You can edit the page content in WordPress admin under Pages → ATHENS. The design uses inline CSS so it won't conflict with your theme or plugins.</p>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>
