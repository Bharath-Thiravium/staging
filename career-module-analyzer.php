<?php
/**
 * Career Module Analyzer
 * Analyzes current career/job functionality and provides refactoring recommendations
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Career Module Analysis</title>";
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
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;}
    .fix-button{background:#0073aa;color:white;padding:15px 30px;border:none;border-radius:5px;cursor:pointer;margin:10px;font-size:16px;}
</style>";
echo "</head><body>";

echo "<h1>🎯 Career Module Analysis & Refactoring</h1>";
echo "<p><strong>Analyzing current career/job functionality and providing refactoring recommendations</strong></p>";

global $wpdb;

// STEP 1: Discover Career-Related Content
echo "<h2>🔍 Step 1: Career-Related Content Discovery</h2>";

// Find career-related pages
$career_pages = $wpdb->get_results("
    SELECT ID, post_title, post_type, post_name, post_status, post_content
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND (
        post_title LIKE '%career%' OR 
        post_title LIKE '%job%' OR 
        post_title LIKE '%candidate%' OR 
        post_title LIKE '%recruitment%' OR
        post_name LIKE '%career%' OR 
        post_name LIKE '%job%' OR 
        post_name LIKE '%candidate%' OR 
        post_name LIKE '%recruitment%'
    )
    ORDER BY post_type, post_title
");

echo "<div class='info'>";
echo "<h3>📋 Career-Related Pages Found</h3>";
if (!empty($career_pages)) {
    echo "<table>";
    echo "<tr><th>Page Title</th><th>Type</th><th>Slug</th><th>Status</th></tr>";
    foreach ($career_pages as $page) {
        echo "<tr>";
        echo "<td>{$page->post_title}</td>";
        echo "<td>{$page->post_type}</td>";
        echo "<td>{$page->post_name}</td>";
        echo "<td>{$page->post_status}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ No career-related pages found in database</p>";
}
echo "</div>";

// STEP 2: Check for Job Manager Plugin
echo "<h2>🔍 Step 2: Job Manager Plugin Analysis</h2>";

$active_plugins = get_option('active_plugins');
$job_manager_active = in_array('wp-job-manager/wp-job-manager.php', $active_plugins);

echo "<div class='info'>";
echo "<h3>🔌 Plugin Status</h3>";
echo "<p><strong>WP Job Manager:</strong> " . ($job_manager_active ? "✅ Active" : "❌ Not Active") . "</p>";

if ($job_manager_active) {
    // Check job listings
    $job_listings = $wpdb->get_var("
        SELECT COUNT(*) 
        FROM {$wpdb->posts} 
        WHERE post_type = 'job_listing' 
        AND post_status = 'publish'
    ");
    
    echo "<p><strong>Job Listings:</strong> {$job_listings} published</p>";
    
    // Check job categories
    $job_categories = $wpdb->get_var("
        SELECT COUNT(*) 
        FROM {$wpdb->terms} t
        JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
        WHERE tt.taxonomy = 'job_listing_category'
    ");
    
    echo "<p><strong>Job Categories:</strong> {$job_categories} categories</p>";
    
    // Check job types
    $job_types = $wpdb->get_var("
        SELECT COUNT(*) 
        FROM {$wpdb->terms} t
        JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
        WHERE tt.taxonomy = 'job_listing_type'
    ");
    
    echo "<p><strong>Job Types:</strong> {$job_types} types</p>";
}
echo "</div>";

// STEP 3: Check Current Theme CSS
echo "<h2>🎨 Step 3: Current Theme CSS Analysis</h2>";

$current_theme = wp_get_theme();
$theme_name = $current_theme->get('Name');
$theme_stylesheet = get_stylesheet_directory();

echo "<div class='info'>";
echo "<h3>🎨 Theme Information</h3>";
echo "<p><strong>Active Theme:</strong> {$theme_name}</p>";
echo "<p><strong>Theme Directory:</strong> {$theme_stylesheet}</p>";

// Check for theme CSS files
$css_files = [];
$theme_css_path = $theme_stylesheet . '/style.css';
if (file_exists($theme_css_path)) {
    $css_files[] = 'style.css';
}

// Check for additional CSS files
$additional_css_files = glob($theme_stylesheet . '/*.css');
foreach ($additional_css_files as $css_file) {
    $filename = basename($css_file);
    if ($filename !== 'style.css') {
        $css_files[] = $filename;
    }
}

echo "<p><strong>CSS Files Found:</strong> " . implode(', ', $css_files) . "</p>";
echo "</div>";

// STEP 4: Analyze Current CSS Patterns
echo "<h2>🔍 Step 4: CSS Pattern Analysis</h2>";

$css_patterns = [];
if (file_exists($theme_css_path)) {
    $css_content = file_get_contents($theme_css_path);
    
    // Extract color patterns
    preg_match_all('/#[0-9a-fA-F]{3,6}/', $css_content, $color_matches);
    $colors = array_unique($color_matches[0]);
    
    // Extract common class patterns
    preg_match_all('/\.([\w-]+)\s*{/', $css_content, $class_matches);
    $classes = array_unique($class_matches[1]);
    
    $css_patterns = [
        'colors' => array_slice($colors, 0, 10),
        'common_classes' => array_slice($classes, 0, 20)
    ];
}

echo "<div class='info'>";
echo "<h3>🎨 CSS Patterns Detected</h3>";
if (!empty($css_patterns['colors'])) {
    echo "<p><strong>Color Palette:</strong> " . implode(', ', $css_patterns['colors']) . "</p>";
}
if (!empty($css_patterns['common_classes'])) {
    echo "<p><strong>Common Classes:</strong> " . implode(', ', array_slice($css_patterns['common_classes'], 0, 10)) . "...</p>";
}
echo "</div>";

// STEP 5: Recommendations
echo "<h2>🎯 Step 5: Refactoring Recommendations</h2>";

echo "<div class='action'>";
echo "<h3>📋 Career Module Refactoring Plan</h3>";

if (!$job_manager_active) {
    echo "<div class='error'>";
    echo "<h4>❌ Missing Job Manager Plugin</h4>";
    echo "<p>WP Job Manager plugin is not active. This is required for a functional career module.</p>";
    echo "</div>";
}

echo "<h4>🔧 Recommended Improvements:</h4>";
echo "<ol>";
echo "<li><strong>Activate WP Job Manager:</strong> Enable the job management functionality</li>";
echo "<li><strong>Create Career Landing Page:</strong> Professional career page with job listings</li>";
echo "<li><strong>Style Job Listings:</strong> Match existing website design patterns</li>";
echo "<li><strong>Add Application Forms:</strong> Streamlined job application process</li>";
echo "<li><strong>Implement Job Categories:</strong> Organize jobs by department/type</li>";
echo "<li><strong>Add Candidate Registration:</strong> Allow candidates to create profiles</li>";
echo "<li><strong>Create Job Dashboard:</strong> Admin interface for managing jobs</li>";
echo "<li><strong>Integrate with Contact Forms:</strong> Connect applications to lead generation</li>";
echo "</ol>";

echo "<h4>🎨 CSS Integration Strategy:</h4>";
echo "<ul>";
echo "<li><strong>Color Consistency:</strong> Use existing color palette for job listings</li>";
echo "<li><strong>Typography Matching:</strong> Apply current font styles to job content</li>";
echo "<li><strong>Layout Harmony:</strong> Match existing page layouts and spacing</li>";
echo "<li><strong>Responsive Design:</strong> Ensure mobile-friendly job listings</li>";
echo "<li><strong>Button Styles:</strong> Use consistent button designs for applications</li>";
echo "</ul>";
echo "</div>";

// STEP 6: Implementation Plan
echo "<h2>🚀 Step 6: Implementation Plan</h2>";

echo "<div class='action'>";
echo "<h3>📅 Phase-by-Phase Implementation</h3>";

echo "<h4>Phase 1: Foundation (Week 1)</h4>";
echo "<ul>";
echo "<li>✅ Activate and configure WP Job Manager plugin</li>";
echo "<li>✅ Create basic job categories and types</li>";
echo "<li>✅ Set up job submission forms</li>";
echo "<li>✅ Configure basic settings and permissions</li>";
echo "</ul>";

echo "<h4>Phase 2: Design Integration (Week 2)</h4>";
echo "<ul>";
echo "<li>🎨 Create custom CSS for job listings</li>";
echo "<li>🎨 Style job application forms</li>";
echo "<li>🎨 Design career landing page</li>";
echo "<li>🎨 Implement responsive design</li>";
echo "</ul>";

echo "<h4>Phase 3: Advanced Features (Week 3)</h4>";
echo "<ul>";
echo "<li>⚙️ Add candidate registration system</li>";
echo "<li>⚙️ Create job dashboard for admins</li>";
echo "<li>⚙️ Implement email notifications</li>";
echo "<li>⚙️ Add job search and filtering</li>";
echo "</ul>";

echo "<h4>Phase 4: Integration & Testing (Week 4)</h4>";
echo "<ul>";
echo "<li>🔗 Integrate with existing contact forms</li>";
echo "<li>🔗 Connect to Google Tag Manager for tracking</li>";
echo "<li>🔗 Add SEO optimization for job pages</li>";
echo "<li>🔗 Test all functionality and fix issues</li>";
echo "</ul>";
echo "</div>";

// STEP 7: Next Steps
echo "<h2>🎯 Step 7: Immediate Next Steps</h2>";

echo "<div class='info'>";
echo "<h3>🚀 Ready to Start Implementation?</h3>";
echo "<p>Based on the analysis, here are the immediate actions needed:</p>";

if (!$job_manager_active) {
    echo "<div class='error'>";
    echo "<h4>🚨 Critical: Activate Job Manager Plugin</h4>";
    echo "<p>The WP Job Manager plugin needs to be activated before proceeding with career module development.</p>";
    echo "</div>";
}

echo "<h4>📋 Implementation Checklist:</h4>";
echo "<ul>";
echo "<li>☐ Activate WP Job Manager plugin</li>";
echo "<li>☐ Configure plugin settings</li>";
echo "<li>☐ Create job categories (Accounting, HR, Compliance, etc.)</li>";
echo "<li>☐ Set up job types (Full-time, Part-time, Contract, Internship)</li>";
echo "<li>☐ Create career landing page</li>";
echo "<li>☐ Design custom CSS matching existing theme</li>";
echo "<li>☐ Test job submission and application process</li>";
echo "<li>☐ Integrate with existing contact forms</li>";
echo "</ul>";

echo "<h4>🎨 CSS Development Priority:</h4>";
echo "<ol>";
echo "<li><strong>Job Listings Grid:</strong> Match existing service/product grid layouts</li>";
echo "<li><strong>Application Forms:</strong> Style to match contact forms</li>";
echo "<li><strong>Job Detail Pages:</strong> Consistent with service detail pages</li>";
echo "<li><strong>Search/Filter Interface:</strong> Match existing UI patterns</li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><strong>🎯 Ready to implement a fully functional career module that matches your existing design!</strong></p>";

echo "</body></html>";
?>
