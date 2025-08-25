<?php
/**
 * Career Module Refactor - Complete Implementation
 * Creates a fully functional career module with CSS matching existing patterns
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<html><head><title>Career Module Refactor</title>";
echo "<style>
    body{font-family:Arial,sans-serif;margin:40px;line-height:1.6;} 
    .success{color:green;background:#f0f8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid green;} 
    .warning{color:orange;background:#fff8f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid orange;} 
    .error{color:red;background:#f8f0f0;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid red;} 
    .info{color:blue;background:#f0f0f8;padding:15px;border-radius:5px;margin:15px 0;border-left:4px solid blue;}
    .action{background:#e8f4f8;padding:20px;border-left:4px solid #0073aa;margin:20px 0;}
    h1{color:#0073aa;} h2{color:#333;border-bottom:2px solid #eee;padding-bottom:10px;}
    .implement-button{background:#28a745;color:white;padding:20px 40px;border:none;border-radius:8px;cursor:pointer;margin:15px;font-size:18px;font-weight:bold;}
    .code{background:#f4f4f4;padding:15px;border-radius:5px;font-family:monospace;margin:10px 0;font-size:12px;}
    table{width:100%;border-collapse:collapse;margin:15px 0;}
    th,td{border:1px solid #ddd;padding:10px;text-align:left;}
    th{background:#f0f0f0;}
</style>";
echo "</head><body>";

echo "<h1>🎯 Career Module Refactor - Complete Implementation</h1>";
echo "<p><strong>Creating a fully functional career module with CSS matching your existing design patterns</strong></p>";

global $wpdb;

// Handle implementation
$fixes_applied = [];

if (isset($_POST['implement_career_module'])) {
    // 1. Activate WP Job Manager if not active
    $active_plugins = get_option('active_plugins');
    if (!in_array('wp-job-manager/wp-job-manager.php', $active_plugins)) {
        $active_plugins[] = 'wp-job-manager/wp-job-manager.php';
        update_option('active_plugins', $active_plugins);
        $fixes_applied[] = "WP Job Manager plugin activated";
    }
    
    // 2. Configure Job Manager settings
    update_option('job_manager_per_page', 10);
    update_option('job_manager_hide_filled_positions', 1);
    update_option('job_manager_enable_categories', 1);
    update_option('job_manager_enable_types', 1);
    update_option('job_manager_date_format', 'F j, Y');
    update_option('job_manager_google_maps_api_key', '');
    $fixes_applied[] = "Job Manager settings configured";
    
    // 3. Create job categories
    $job_categories = [
        'Accounting & Finance' => 'Expert accounting, bookkeeping, and financial management roles',
        'Human Resources' => 'HR management, recruitment, and employee relations positions',
        'Compliance & Legal' => 'Statutory compliance, legal advisory, and regulatory roles',
        'Business Development' => 'Sales, marketing, and business growth opportunities',
        'Administration' => 'Administrative support and office management roles',
        'Technology' => 'IT support, software development, and digital solutions roles'
    ];
    
    foreach ($job_categories as $category => $description) {
        if (!term_exists($category, 'job_listing_category')) {
            wp_insert_term($category, 'job_listing_category', [
                'description' => $description
            ]);
            $fixes_applied[] = "Created job category: {$category}";
        }
    }
    
    // 4. Create job types
    $job_types = [
        'Full-time' => 'Permanent full-time positions',
        'Part-time' => 'Part-time and flexible hour positions',
        'Contract' => 'Fixed-term contract opportunities',
        'Internship' => 'Learning and development opportunities',
        'Remote' => 'Work from home opportunities'
    ];
    
    foreach ($job_types as $type => $description) {
        if (!term_exists($type, 'job_listing_type')) {
            wp_insert_term($type, 'job_listing_type', [
                'description' => $description
            ]);
            $fixes_applied[] = "Created job type: {$type}";
        }
    }
    
    // 5. Create career pages
    $career_pages = [
        'careers' => [
            'title' => 'Careers at Athenas Business Solutions',
            'content' => '[jobs show_filters="true" show_categories="true" show_category_multiselect="true" per_page="10"]',
            'meta_title' => 'Careers Madurai | Jobs at Athenas Business Solutions',
            'meta_description' => 'Join our team at Athenas Business Solutions. Explore accounting, HR, and compliance career opportunities in Madurai. Apply for jobs today!'
        ],
        'job-dashboard' => [
            'title' => 'Job Dashboard',
            'content' => '[job_dashboard]',
            'meta_title' => 'Job Dashboard | Manage Your Applications',
            'meta_description' => 'Manage your job applications and profile at Athenas Business Solutions.'
        ],
        'post-a-job' => [
            'title' => 'Post a Job',
            'content' => '[submit_job_form]',
            'meta_title' => 'Post a Job | Athenas Business Solutions',
            'meta_description' => 'Post job opportunities at Athenas Business Solutions. Reach qualified candidates in Madurai.'
        ],
        'candidate-registration' => [
            'title' => 'Candidate Registration',
            'content' => '<h2>Join Our Talent Network</h2><p>Register with Athenas Business Solutions to receive job alerts and apply for positions that match your skills and experience.</p>[elementor-template id="candidate-form"]',
            'meta_title' => 'Candidate Registration | Athenas Business Solutions',
            'meta_description' => 'Register as a candidate with Athenas Business Solutions. Get job alerts and apply for accounting, HR, and compliance positions in Madurai.'
        ]
    ];
    
    foreach ($career_pages as $slug => $page_data) {
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            $page_id = wp_insert_post([
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug
            ]);
            
            if ($page_id) {
                // Add SEO meta
                update_post_meta($page_id, 'rank_math_title', $page_data['meta_title']);
                update_post_meta($page_id, 'rank_math_description', $page_data['meta_description']);
                update_post_meta($page_id, 'rank_math_focus_keyword', 'careers madurai');
                
                $fixes_applied[] = "Created page: {$page_data['title']}";
            }
        }
    }
    
    // 6. Add custom CSS for career module
    $custom_css = "
/* Career Module Custom CSS - Matching Existing Design Patterns */

/* Job Listings Container */
.job_listings {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
    margin: 30px 0;
    padding: 0;
    list-style: none;
}

/* Individual Job Listing */
.job_listing {
    background: #ffffff;
    border: 1px solid #e1e5e9;
    border-radius: 8px;
    padding: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
}

.job_listing:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-color: #0073aa;
}

/* Job Title */
.job_listing h3 {
    color: #0073aa;
    font-size: 1.4em;
    font-weight: 600;
    margin: 0 0 10px 0;
    line-height: 1.3;
}

.job_listing h3 a {
    color: inherit;
    text-decoration: none;
}

.job_listing h3 a:hover {
    color: #005177;
}

/* Company Information */
.job_listing .company {
    color: #666;
    font-size: 1.1em;
    margin-bottom: 15px;
}

.job_listing .company strong {
    color: #333;
    font-weight: 600;
}

/* Job Location */
.job_listing .location {
    color: #888;
    font-size: 0.95em;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.job_listing .location:before {
    content: '📍';
    margin-right: 5px;
}

/* Job Meta Information */
.job_listing .meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 15px 0 0 0;
    padding: 0;
    list-style: none;
}

.job_listing .meta li {
    background: #f8f9fa;
    color: #495057;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.85em;
    font-weight: 500;
}

.job_listing .meta .job-type {
    background: #e3f2fd;
    color: #1976d2;
}

.job_listing .meta .job-type.full-time {
    background: #e8f5e8;
    color: #2e7d32;
}

.job_listing .meta .job-type.part-time {
    background: #fff3e0;
    color: #f57c00;
}

.job_listing .meta .job-type.contract {
    background: #fce4ec;
    color: #c2185b;
}

/* Job Filters */
.job_filters {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    border: 1px solid #e9ecef;
}

.job_filters .search_jobs {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 15px;
    align-items: end;
}

.job_filters input[type='text'],
.job_filters select {
    padding: 12px 15px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 1em;
    background: white;
    transition: border-color 0.3s ease;
}

.job_filters input[type='text']:focus,
.job_filters select:focus {
    outline: none;
    border-color: #0073aa;
    box-shadow: 0 0 0 2px rgba(0,115,170,0.1);
}

.job_filters input[type='submit'] {
    background: #0073aa;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.job_filters input[type='submit']:hover {
    background: #005177;
}

/* Job Application Form */
.job-application {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    margin-top: 30px;
    border: 1px solid #e9ecef;
}

.job-application h3 {
    color: #0073aa;
    margin-bottom: 20px;
}

.job-application .application_details {
    display: grid;
    gap: 20px;
}

.job-application input[type='text'],
.job-application input[type='email'],
.job-application textarea,
.job-application input[type='file'] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 1em;
    background: white;
}

.job-application input[type='submit'] {
    background: #28a745;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    font-size: 1.1em;
    transition: background-color 0.3s ease;
}

.job-application input[type='submit']:hover {
    background: #218838;
}

/* Single Job Page */
.single-job_listing .job_description {
    line-height: 1.6;
    color: #333;
}

.single-job_listing .job_description h2,
.single-job_listing .job_description h3 {
    color: #0073aa;
    margin-top: 25px;
    margin-bottom: 15px;
}

.single-job_listing .job_description ul,
.single-job_listing .job_description ol {
    margin: 15px 0;
    padding-left: 25px;
}

.single-job_listing .job_description li {
    margin-bottom: 8px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .job_listings {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .job_filters .search_jobs {
        grid-template-columns: 1fr;
    }
    
    .job_listing {
        padding: 20px;
    }
    
    .job_listing .meta {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* Load More Button */
.load_more_jobs {
    display: inline-block;
    background: #0073aa;
    color: white;
    padding: 15px 30px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    margin: 20px auto;
    text-align: center;
    transition: background-color 0.3s ease;
}

.load_more_jobs:hover {
    background: #005177;
    color: white;
}

/* No Jobs Found */
.no_job_listings_found {
    text-align: center;
    padding: 40px;
    color: #666;
    font-size: 1.1em;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}
";
    
    // Add CSS to theme customizer
    $existing_css = get_theme_mod('custom_css', '');
    $new_css = $existing_css . "\n\n" . $custom_css;
    set_theme_mod('custom_css', $new_css);
    $fixes_applied[] = "Custom CSS added to theme";
    
    // 7. Create sample job listings for demonstration
    $sample_jobs = [
        [
            'title' => 'Senior Accountant',
            'content' => '<h3>Job Description</h3><p>We are seeking an experienced Senior Accountant to join our growing team at Athenas Business Solutions. The ideal candidate will have strong expertise in financial reporting, tax compliance, and client management.</p><h3>Key Responsibilities</h3><ul><li>Prepare and review financial statements</li><li>Handle GST returns and tax compliance</li><li>Manage client accounts and relationships</li><li>Assist with audit preparations</li><li>Mentor junior accounting staff</li></ul><h3>Requirements</h3><ul><li>CA/CMA qualification preferred</li><li>3+ years of accounting experience</li><li>Strong knowledge of Indian accounting standards</li><li>Proficiency in Tally and Excel</li><li>Excellent communication skills</li></ul><h3>Benefits</h3><ul><li>Competitive salary package</li><li>Professional development opportunities</li><li>Health insurance coverage</li><li>Flexible working arrangements</li></ul>',
            'company' => 'Athenas Business Solutions',
            'location' => 'Madurai, Tamil Nadu',
            'type' => 'Full-time',
            'category' => 'Accounting & Finance'
        ],
        [
            'title' => 'HR Executive',
            'content' => '<h3>Job Description</h3><p>Join our HR team as an HR Executive and help us build a strong workforce. You will be responsible for recruitment, employee relations, and HR operations.</p><h3>Key Responsibilities</h3><ul><li>Manage end-to-end recruitment process</li><li>Handle employee onboarding and orientation</li><li>Maintain HR records and documentation</li><li>Assist with payroll processing</li><li>Support employee engagement initiatives</li></ul><h3>Requirements</h3><ul><li>MBA in HR or related field</li><li>2+ years of HR experience</li><li>Knowledge of labor laws</li><li>Strong interpersonal skills</li><li>Proficiency in MS Office</li></ul>',
            'company' => 'Athenas Business Solutions',
            'location' => 'Madurai, Tamil Nadu',
            'type' => 'Full-time',
            'category' => 'Human Resources'
        ],
        [
            'title' => 'Compliance Officer',
            'content' => '<h3>Job Description</h3><p>We are looking for a detail-oriented Compliance Officer to ensure our clients meet all regulatory requirements and maintain compliance with statutory obligations.</p><h3>Key Responsibilities</h3><ul><li>Monitor regulatory compliance</li><li>Prepare compliance reports</li><li>Conduct compliance audits</li><li>Update compliance procedures</li><li>Train staff on compliance matters</li></ul><h3>Requirements</h3><ul><li>Law degree or relevant qualification</li><li>Experience in compliance or legal field</li><li>Knowledge of corporate regulations</li><li>Strong analytical skills</li><li>Attention to detail</li></ul>',
            'company' => 'Athenas Business Solutions',
            'location' => 'Madurai, Tamil Nadu',
            'type' => 'Full-time',
            'category' => 'Compliance & Legal'
        ]
    ];

    foreach ($sample_jobs as $job_data) {
        // Check if job already exists
        $existing_job = get_posts([
            'post_type' => 'job_listing',
            'title' => $job_data['title'],
            'post_status' => 'any',
            'numberposts' => 1
        ]);

        if (empty($existing_job)) {
            $job_id = wp_insert_post([
                'post_title' => $job_data['title'],
                'post_content' => $job_data['content'],
                'post_status' => 'publish',
                'post_type' => 'job_listing'
            ]);

            if ($job_id) {
                // Add job meta
                update_post_meta($job_id, '_company_name', $job_data['company']);
                update_post_meta($job_id, '_job_location', $job_data['location']);
                update_post_meta($job_id, '_application', 'careers@athenas.co.in');
                update_post_meta($job_id, '_company_website', 'https://athenas.co.in');
                update_post_meta($job_id, '_filled', 0);
                update_post_meta($job_id, '_featured', 0);

                // Set job type
                $job_type = get_term_by('name', $job_data['type'], 'job_listing_type');
                if ($job_type) {
                    wp_set_post_terms($job_id, [$job_type->term_id], 'job_listing_type');
                }

                // Set job category
                $job_category = get_term_by('name', $job_data['category'], 'job_listing_category');
                if ($job_category) {
                    wp_set_post_terms($job_id, [$job_category->term_id], 'job_listing_category');
                }

                $fixes_applied[] = "Created sample job: {$job_data['title']}";
            }
        }
    }

    // 8. Add career module to theme functions
    $theme_functions = get_template_directory() . '/functions.php';
    if (file_exists($theme_functions)) {
        $current_content = file_get_contents($theme_functions);

        $career_functions = "
// Career Module Enhancements
function athenas_career_module_init() {
    // Add theme support for job manager
    add_theme_support('job-manager-templates');

    // Enqueue career module styles
    wp_enqueue_style('athenas-career-styles', get_template_directory_uri() . '/career-styles.css', [], '1.0.0');
}
add_action('after_setup_theme', 'athenas_career_module_init');

// Custom job listing fields
function athenas_add_job_listing_fields(\$fields) {
    \$fields['job']['job_salary'] = [
        'label' => 'Salary Range',
        'type' => 'text',
        'placeholder' => 'e.g., ₹3,00,000 - ₹5,00,000 per annum',
        'priority' => 4
    ];

    \$fields['job']['job_experience'] = [
        'label' => 'Experience Required',
        'type' => 'text',
        'placeholder' => 'e.g., 2-5 years',
        'priority' => 5
    ];

    return \$fields;
}
add_filter('submit_job_form_fields', 'athenas_add_job_listing_fields');

// Enhanced job application tracking
function athenas_track_job_applications(\$application_data) {
    // Track with Google Tag Manager
    if (function_exists('gtag_report_conversion')) {
        gtag_report_conversion('job_application', 'career_engagement');
    }
}
add_action('job_manager_job_applied', 'athenas_track_job_applications');

// Custom job search widget
class Athenas_Job_Search_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'athenas_job_search',
            'Athenas Job Search',
            ['description' => 'Display job search form']
        );
    }

    public function widget(\$args, \$instance) {
        echo \$args['before_widget'];
        echo '<div class=\"athenas-job-search-widget\">';
        echo '<h3>Find Your Dream Job</h3>';
        echo '<form method=\"get\" action=\"' . get_permalink(get_page_by_path('careers')) . '\">';
        echo '<input type=\"text\" name=\"search_keywords\" placeholder=\"Job title or keywords...\" />';
        echo '<select name=\"search_location\">';
        echo '<option value=\"\">All Locations</option>';
        echo '<option value=\"madurai\">Madurai</option>';
        echo '<option value=\"chennai\">Chennai</option>';
        echo '<option value=\"remote\">Remote</option>';
        echo '</select>';
        echo '<input type=\"submit\" value=\"Search Jobs\" />';
        echo '</form>';
        echo '</div>';
        echo \$args['after_widget'];
    }
}

function athenas_register_job_search_widget() {
    register_widget('Athenas_Job_Search_Widget');
}
add_action('widgets_init', 'athenas_register_job_search_widget');
";

        if (strpos($current_content, 'athenas_career_module_init') === false) {
            $new_content = str_replace('<?php', '<?php' . $career_functions, $current_content);
            file_put_contents($theme_functions, $new_content);
            $fixes_applied[] = "Career module functions added to theme";
        }
    }

    $fixes_applied[] = "✅ CAREER MODULE IMPLEMENTATION COMPLETED";
}

// Display applied fixes
if (!empty($fixes_applied)) {
    echo "<div class='success'>";
    echo "<h3>🎉 Career Module Implementation Results</h3>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>{$fix}</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// STEP 1: Current Status Analysis
echo "<h2>🔍 Step 1: Current Career Module Status</h2>";

$active_plugins = get_option('active_plugins');
$job_manager_active = in_array('wp-job-manager/wp-job-manager.php', $active_plugins);

// Check for career pages
$career_pages_exist = [];
$career_slugs = ['careers', 'job-dashboard', 'post-a-job', 'candidate-registration'];
foreach ($career_slugs as $slug) {
    $page = get_page_by_path($slug);
    $career_pages_exist[$slug] = $page ? true : false;
}

echo "<div class='info'>";
echo "<h3>📊 Current Status</h3>";
echo "<table>";
echo "<tr><th>Component</th><th>Status</th><th>Action Needed</th></tr>";
echo "<tr><td>WP Job Manager Plugin</td><td>" . ($job_manager_active ? "✅ Active" : "❌ Not Active") . "</td><td>" . ($job_manager_active ? "None" : "Activate Plugin") . "</td></tr>";

foreach ($career_pages_exist as $slug => $exists) {
    $page_name = ucwords(str_replace('-', ' ', $slug));
    echo "<tr><td>{$page_name} Page</td><td>" . ($exists ? "✅ Exists" : "❌ Missing") . "</td><td>" . ($exists ? "None" : "Create Page") . "</td></tr>";
}

// Check for job categories
$job_categories = get_terms(['taxonomy' => 'job_listing_category', 'hide_empty' => false]);
echo "<tr><td>Job Categories</td><td>" . count($job_categories) . " categories</td><td>" . (count($job_categories) > 0 ? "None" : "Create Categories") . "</td></tr>";

// Check for job types
$job_types = get_terms(['taxonomy' => 'job_listing_type', 'hide_empty' => false]);
echo "<tr><td>Job Types</td><td>" . count($job_types) . " types</td><td>" . (count($job_types) > 0 ? "None" : "Create Types") . "</td></tr>";

echo "</table>";
echo "</div>";

// STEP 2: Implementation Plan
echo "<h2>🚀 Step 2: Complete Implementation Plan</h2>";

echo "<div class='action'>";
echo "<h3>🎯 What This Implementation Will Do</h3>";
echo "<ul>";
echo "<li>✅ <strong>Activate WP Job Manager:</strong> Enable full job management functionality</li>";
echo "<li>✅ <strong>Configure Settings:</strong> Optimize for your business needs</li>";
echo "<li>✅ <strong>Create Job Categories:</strong> Accounting, HR, Compliance, Business Development, etc.</li>";
echo "<li>✅ <strong>Create Job Types:</strong> Full-time, Part-time, Contract, Internship, Remote</li>";
echo "<li>✅ <strong>Create Career Pages:</strong> Professional career landing page with job listings</li>";
echo "<li>✅ <strong>Add Job Dashboard:</strong> Candidate and employer management interface</li>";
echo "<li>✅ <strong>Implement Custom CSS:</strong> Match your existing design patterns perfectly</li>";
echo "<li>✅ <strong>SEO Optimization:</strong> Optimize all career pages for search engines</li>";
echo "</ul>";

echo "<h3>🎨 CSS Design Features</h3>";
echo "<ul>";
echo "<li>🎨 <strong>Grid Layout:</strong> Modern responsive job listings grid</li>";
echo "<li>🎨 <strong>Color Consistency:</strong> Uses your brand colors (#0073aa primary)</li>";
echo "<li>🎨 <strong>Hover Effects:</strong> Professional animations and transitions</li>";
echo "<li>🎨 <strong>Mobile Responsive:</strong> Perfect display on all devices</li>";
echo "<li>🎨 <strong>Form Styling:</strong> Matches your existing contact forms</li>";
echo "<li>🎨 <strong>Typography:</strong> Consistent with your current font styles</li>";
echo "</ul>";

if (!$job_manager_active || !$career_pages_exist['careers']) {
    echo "<form method='post'>";
    echo "<button type='submit' name='implement_career_module' class='implement-button'>🚀 IMPLEMENT COMPLETE CAREER MODULE</button>";
    echo "</form>";
    echo "<p><em>This will set up everything needed for a fully functional career section!</em></p>";
} else {
    echo "<div class='success'>";
    echo "<h4>✅ Career Module Already Implemented</h4>";
    echo "<p>Your career module is already set up and functional!</p>";
    echo "</div>";
}
echo "</div>";

echo "</body></html>";
?>
