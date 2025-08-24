<?php
/**
 * Page SEO Optimizer
 * Optimizes titles, meta descriptions, H1 tags, and on-page SEO for ALL pages
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Page SEO Optimizer</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
    .fix-button{background:#0073aa;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;margin:5px;}
    .page-row{margin:20px 0;padding:15px;border:1px solid #ddd;border-radius:5px;}
    input[type='text'], textarea{width:100%;padding:8px;margin:5px 0;border:1px solid #ddd;border-radius:3px;}
    textarea{height:60px;resize:vertical;}
</style>";
echo "</head><body>";

echo "<h1>📄 Page SEO Optimizer</h1>";
echo "<p><strong>Optimizing titles, meta descriptions, and on-page SEO for ALL pages</strong></p>";

global $wpdb;

// Handle bulk optimization
$fixes_applied = [];

if (isset($_POST['optimize_all'])) {
    // Get all pages that need optimization
    $all_pages = $wpdb->get_results("
        SELECT ID, post_title, post_type, post_name, post_content
        FROM {$wpdb->posts} 
        WHERE post_status = 'publish' 
        AND post_type IN ('page', 'post')
        ORDER BY post_type, post_title
    ");
    
    foreach ($all_pages as $page) {
        $page_id = $page->ID;
        $page_title = $page->post_title;
        $page_type = $page->post_type;
        
        // Generate SEO-optimized title and meta description
        $seo_title = '';
        $meta_description = '';
        
        // Customize based on page type and content
        if ($page_type === 'page') {
            switch (strtolower($page->post_name)) {
                case 'home':
                case '':
                    $seo_title = 'Accounting, HR & Compliance Services in Madurai | Athenas Business Solutions';
                    $meta_description = 'Expert accounting, HR, and statutory compliance services for startups and SMEs in Madurai. Professional business solutions with 15+ years of experience.';
                    break;
                case 'about':
                case 'about-us':
                    $seo_title = 'About Athenas Business Solutions | Professional Services in Madurai';
                    $meta_description = 'Learn about Athenas Business Solutions - your trusted partner for accounting, compliance, and HR services in Madurai. 15+ years of expertise.';
                    break;
                case 'contact':
                case 'contact-us':
                    $seo_title = 'Contact Athenas Business Solutions | Accounting Services Madurai';
                    $meta_description = 'Contact Athenas Business Solutions for expert accounting, compliance, and HR services in Madurai. Get free consultation today.';
                    break;
                case 'services':
                    $seo_title = 'Business Services | Accounting, HR & Compliance in Madurai';
                    $meta_description = 'Comprehensive business services including accounting, HR, compliance, and virtual office solutions for startups and SMEs in Madurai.';
                    break;
                case 'accounting':
                case 'accounting-services':
                    $seo_title = 'Professional Accounting Services in Madurai | GST, TDS, Bookkeeping';
                    $meta_description = 'Expert accounting services in Madurai including GST registration, TDS compliance, bookkeeping, and financial reporting for small businesses.';
                    break;
                case 'compliance':
                case 'statutory-compliance':
                    $seo_title = 'Statutory Compliance Services Madurai | Company Formation & Registration';
                    $meta_description = 'Complete statutory compliance services in Madurai including company formation, GST registration, PF/ESI compliance, and annual filing.';
                    break;
                case 'hr-services':
                case 'hr':
                    $seo_title = 'HR Services Madurai | Payroll, Recruitment & Employee Management';
                    $meta_description = 'Professional HR services in Madurai including payroll processing, recruitment, employee management, and HR compliance solutions.';
                    break;
                default:
                    $seo_title = $page_title . ' | Athenas Business Solutions Madurai';
                    $meta_description = 'Professional business services in Madurai. ' . substr(strip_tags($page->post_content), 0, 120) . '...';
            }
        } else {
            // For blog posts
            $seo_title = $page_title . ' | Athenas Business Solutions Blog';
            $meta_description = substr(strip_tags($page->post_content), 0, 140) . '...';
        }
        
        // Update SEO fields using Rank Math if available
        if (class_exists('RankMath')) {
            update_post_meta($page_id, 'rank_math_title', $seo_title);
            update_post_meta($page_id, 'rank_math_description', $meta_description);
            update_post_meta($page_id, 'rank_math_focus_keyword', 'accounting services madurai');
            update_post_meta($page_id, 'rank_math_robots', array('index', 'follow'));
            
            $fixes_applied[] = "Optimized: {$page_title} (ID: {$page_id})";
        }
    }
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>✅ Pages Optimized Successfully</h3>";
    echo "<p>Optimized " . count($fixes_applied) . " pages:</p>";
    echo "<ul>";
    foreach (array_slice($fixes_applied, 0, 10) as $fix) {
        echo "<li>{$fix}</li>";
    }
    if (count($fixes_applied) > 10) {
        echo "<li>... and " . (count($fixes_applied) - 10) . " more pages</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// STEP 1: Analyze current pages
echo "<h2>🔍 Step 1: Current Page Analysis</h2>";

$all_pages = $wpdb->get_results("
    SELECT ID, post_title, post_type, post_name, post_content
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND post_type IN ('page', 'post')
    ORDER BY post_type, post_title
");

$pages_needing_optimization = [];
$seo_plugin_active = false;

// Check for SEO plugin
$active_plugins = get_option('active_plugins');
if (in_array('seo-by-rank-math/rank-math.php', $active_plugins)) {
    $seo_plugin_active = 'rank-math';
} elseif (in_array('wordpress-seo/wp-seo.php', $active_plugins)) {
    $seo_plugin_active = 'yoast';
}

echo "<div class='info'>";
echo "<h3>📊 Page Inventory</h3>";
echo "<p><strong>Total Pages Found:</strong> " . count($all_pages) . "</p>";
echo "<p><strong>SEO Plugin:</strong> " . ($seo_plugin_active ? ucfirst($seo_plugin_active) : "None detected") . "</p>";
echo "</div>";

if (!$seo_plugin_active) {
    echo "<div class='error'>";
    echo "<h3>❌ No SEO Plugin Detected</h3>";
    echo "<p>Install Rank Math or Yoast SEO plugin first for proper SEO optimization.</p>";
    echo "</div>";
} else {
    // Analyze each page
    echo "<div class='action'>";
    echo "<h3>📋 Page-by-Page Analysis</h3>";
    
    echo "<table>";
    echo "<tr><th>Page</th><th>Type</th><th>Current Title</th><th>Meta Description</th><th>Status</th></tr>";
    
    foreach ($all_pages as $page) {
        $page_id = $page->ID;
        $page_title = $page->post_title;
        $page_type = $page->post_type;
        $page_url = get_permalink($page_id);
        
        // Get current SEO data
        $current_title = '';
        $current_meta = '';
        
        if ($seo_plugin_active === 'rank-math') {
            $current_title = get_post_meta($page_id, 'rank_math_title', true);
            $current_meta = get_post_meta($page_id, 'rank_math_description', true);
        } elseif ($seo_plugin_active === 'yoast') {
            $current_title = get_post_meta($page_id, '_yoast_wpseo_title', true);
            $current_meta = get_post_meta($page_id, '_yoast_wpseo_metadesc', true);
        }
        
        $needs_optimization = false;
        $issues = [];
        
        // Check title
        if (empty($current_title)) {
            $needs_optimization = true;
            $issues[] = "Missing SEO title";
        } elseif (strlen($current_title) > 60) {
            $needs_optimization = true;
            $issues[] = "Title too long (" . strlen($current_title) . " chars)";
        }
        
        // Check meta description
        if (empty($current_meta)) {
            $needs_optimization = true;
            $issues[] = "Missing meta description";
        } elseif (strlen($current_meta) > 160) {
            $needs_optimization = true;
            $issues[] = "Meta description too long (" . strlen($current_meta) . " chars)";
        }
        
        if ($needs_optimization) {
            $pages_needing_optimization[] = $page_id;
        }
        
        echo "<tr>";
        echo "<td><a href='{$page_url}' target='_blank'>{$page_title}</a></td>";
        echo "<td>{$page_type}</td>";
        echo "<td>" . ($current_title ? substr($current_title, 0, 50) . "..." : "<em>Not set</em>") . "</td>";
        echo "<td>" . ($current_meta ? substr($current_meta, 0, 50) . "..." : "<em>Not set</em>") . "</td>";
        echo "<td>" . ($needs_optimization ? "<span style='color:red;'>❌ " . implode(", ", $issues) . "</span>" : "<span style='color:green;'>✅ Optimized</span>") . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</div>";
    
    // STEP 2: Bulk Optimization
    echo "<h2>🚀 Step 2: Bulk SEO Optimization</h2>";
    
    if (!empty($pages_needing_optimization)) {
        echo "<div class='warning'>";
        echo "<h3>⚠️ " . count($pages_needing_optimization) . " pages need optimization</h3>";
        echo "<p>This tool will automatically generate SEO-optimized titles and meta descriptions for all pages based on their content and purpose.</p>";
        
        echo "<h4>📝 Optimization Strategy:</h4>";
        echo "<ul>";
        echo "<li><strong>Homepage:</strong> Focus on main services + location (Madurai)</li>";
        echo "<li><strong>Service Pages:</strong> Include specific keywords + location</li>";
        echo "<li><strong>About/Contact:</strong> Brand-focused with location</li>";
        echo "<li><strong>Blog Posts:</strong> Content-focused with brand mention</li>";
        echo "</ul>";
        
        echo "<form method='post'>";
        echo "<button type='submit' name='optimize_all' class='fix-button' style='font-size:18px;padding:15px 30px;'>🔧 Optimize All " . count($pages_needing_optimization) . " Pages</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<div class='success'>";
        echo "<h3>✅ All pages are already optimized!</h3>";
        echo "<p>Your pages have proper SEO titles and meta descriptions.</p>";
        echo "</div>";
    }
}

// STEP 3: Additional On-Page SEO
echo "<h2>📝 Step 3: Additional On-Page SEO Recommendations</h2>";

echo "<div class='info'>";
echo "<h3>🎯 Manual Optimizations Needed</h3>";
echo "<p>After running the bulk optimizer, manually review these elements:</p>";

echo "<ol>";
echo "<li><strong>H1 Headings:</strong> Ensure each page has exactly one H1 with target keyword</li>";
echo "<li><strong>Internal Links:</strong> Add at least 3 internal links per page</li>";
echo "<li><strong>Image Alt Text:</strong> Add descriptive alt text to all images</li>";
echo "<li><strong>Content Quality:</strong> Ensure unique, valuable content on each page</li>";
echo "<li><strong>Schema Markup:</strong> Add structured data for better search results</li>";
echo "</ol>";
echo "</div>";

// STEP 4: Keyword Strategy
echo "<h2>🎯 Step 4: Keyword Strategy Implementation</h2>";

echo "<div class='action'>";
echo "<h3>📊 Target Keywords by Page Type</h3>";

echo "<table>";
echo "<tr><th>Page Type</th><th>Primary Keywords</th><th>Secondary Keywords</th></tr>";
echo "<tr><td><strong>Homepage</strong></td><td>accounting services madurai, business solutions madurai</td><td>chartered accountant, compliance services</td></tr>";
echo "<tr><td><strong>Accounting Page</strong></td><td>accounting services madurai, GST registration madurai</td><td>bookkeeping, TDS compliance, financial reporting</td></tr>";
echo "<tr><td><strong>Compliance Page</strong></td><td>statutory compliance madurai, company formation madurai</td><td>business registration, PF ESI registration</td></tr>";
echo "<tr><td><strong>HR Services Page</strong></td><td>HR services madurai, payroll services madurai</td><td>recruitment, employee management</td></tr>";
echo "<tr><td><strong>Contact Page</strong></td><td>contact accountant madurai, business services contact</td><td>free consultation, expert advice</td></tr>";
echo "</table>";
echo "</div>";

// STEP 5: Next Steps
echo "<h2>🎯 Step 5: Next Steps</h2>";

echo "<div class='action'>";
echo "<h3>📋 SEO Optimization Checklist</h3>";
echo "<ul>";
echo "<li>" . (empty($pages_needing_optimization) ? "✅" : "❌") . " Page titles and meta descriptions optimized</li>";
echo "<li>⏳ H1 headings optimized (manual review needed)</li>";
echo "<li>⏳ Internal linking strategy implemented</li>";
echo "<li>⏳ Image alt text added</li>";
echo "<li>⏳ Schema markup implemented</li>";
echo "</ul>";

echo "<h3>🚀 Continue with Other Optimizations</h3>";
echo "<ol>";
echo "<li><strong>Lead Generation:</strong> <a href='lead-generation-setup.php'>Add CTAs and conversion tracking</a></li>";
echo "<li><strong>Performance:</strong> <a href='performance-optimizer.php'>Optimize images and enable caching</a></li>";
echo "<li><strong>Local SEO:</strong> <a href='local-seo-setup.php'>Add NAP and schema markup</a></li>";
echo "<li><strong>Technical SEO:</strong> <a href='technical-seo-fixer.php'>Fix remaining technical issues</a></li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎉 Page SEO optimization is crucial for ranking in search results!</strong></p>";

echo "</body></html>";
?>
