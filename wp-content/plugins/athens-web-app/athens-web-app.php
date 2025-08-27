<?php
/**
 * Plugin Name: Athens Web App Integration
 * Description: Custom web application integration for Athens Business Solutions with dashboard, search, and user management
 * Version: 1.0.0
 * Author: Athens Business Solutions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ATHENS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ATHENS_PLUGIN_PATH', plugin_dir_path(__FILE__));

class AthensWebAppIntegration {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        register_activation_hook(__FILE__, array($this, 'activate'));
    }
    
    public function init() {
        // Add shortcodes
        add_shortcode('athens_dashboard', array($this, 'user_dashboard_shortcode'));
        add_shortcode('athens_search', array($this, 'search_shortcode'));
        add_shortcode('athens_login', array($this, 'login_shortcode'));
        add_shortcode('athens_client_portal', array($this, 'client_portal_shortcode'));
        
        // Handle AJAX requests
        add_action('wp_ajax_athens_search', array($this, 'handle_search'));
        add_action('wp_ajax_nopriv_athens_search', array($this, 'handle_search'));
        add_action('wp_ajax_athens_client_data', array($this, 'handle_client_data'));
        
        // Add custom menu item
        add_action('wp_nav_menu_items', array($this, 'add_athens_menu_item'), 10, 2);
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('athens-app-js', ATHENS_PLUGIN_URL . 'assets/athens-app.js', array('jquery'), '1.0.0', true);
        wp_enqueue_style('athens-app-css', ATHENS_PLUGIN_URL . 'assets/athens-style.css', array(), '1.0.0');
        
        wp_localize_script('athens-app-js', 'athens_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athens_app_nonce')
        ));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Athens Web App',
            'Athens App',
            'manage_options',
            'athens-web-app',
            array($this, 'admin_page'),
            'dashicons-desktop',
            30
        );
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Athens Web App Integration</h1>
            <div class="athens-admin-dashboard">
                <div class="athens-admin-card">
                    <h2>Dashboard Statistics</h2>
                    <p>Active Users: <?php echo count_users()['total_users']; ?></p>
                    <p>Client Portal Access: <?php echo $this->get_client_portal_stats(); ?></p>
                </div>
                <div class="athens-admin-card">
                    <h2>Quick Setup</h2>
                    <p>Use these shortcodes on your pages:</p>
                    <ul>
                        <li><code>[athens_dashboard]</code> - Client Dashboard</li>
                        <li><code>[athens_search]</code> - Advanced Search</li>
                        <li><code>[athens_login]</code> - Client Login</li>
                        <li><code>[athens_client_portal]</code> - Full Client Portal</li>
                    </ul>
                </div>
            </div>
        </div>
        <style>
        .athens-admin-dashboard { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .athens-admin-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .athens-admin-card h2 { color: #0073aa; margin-top: 0; }
        .athens-admin-card code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }
        </style>
        <?php
    }
    
    public function activate() {
        $this->create_tables();
        $this->create_default_pages();
        flush_rewrite_rules();
    }
    
    private function create_tables() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'athens_client_data';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            client_type varchar(50) NOT NULL,
            service_category varchar(100) NOT NULL,
            data_value longtext NOT NULL,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY client_type (client_type)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    private function create_default_pages() {
        $pages = array(
            'athens-dashboard' => array(
                'title' => 'Athens Client Dashboard',
                'content' => '[athens_dashboard]',
                'template' => 'page-athens-dashboard.php'
            ),
            'athens-portal' => array(
                'title' => 'Athens Client Portal',
                'content' => '[athens_client_portal]',
                'template' => 'page-athens-portal.php'
            ),
            'athens-search' => array(
                'title' => 'Athens Advanced Search',
                'content' => '[athens_search]',
                'template' => 'page-athens-search.php'
            ),
            'athens-login' => array(
                'title' => 'Athens Client Login',
                'content' => '[athens_login]',
                'template' => 'page-athens-login.php'
            )
        );
        
        foreach ($pages as $slug => $page_data) {
            $existing_page = get_page_by_path($slug);
            if (!$existing_page) {
                $page_id = wp_insert_post(array(
                    'post_title' => $page_data['title'],
                    'post_content' => $page_data['content'],
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_name' => $slug
                ));
                
                if ($page_id) {
                    update_post_meta($page_id, '_wp_page_template', $page_data['template']);
                    update_post_meta($page_id, 'rank_math_title', $page_data['title'] . ' | Athens Business Solutions');
                    update_post_meta($page_id, 'rank_math_description', 'Access your ' . strtolower($page_data['title']) . ' at Athens Business Solutions. Secure client portal for managing your business services.');
                    update_post_meta($page_id, 'rank_math_focus_keyword', 'athens client portal');
                }
            }
        }
    }
    
    public function add_athens_menu_item($items, $args) {
        if ($args->theme_location == 'primary' || $args->theme_location == 'menu-1') {
            $athens_menu = '<li class="menu-item athens-menu-item"><a href="/athens-portal/" class="athens-portal-link">ATHENS</a></li>';
            $items = $items . $athens_menu;
        }
        return $items;
    }
    
    public function user_dashboard_shortcode() {
        if (!is_user_logged_in()) {
            return '<div class="athens-login-required">
                <h3>Client Access Required</h3>
                <p>Please log in to access your Athens dashboard.</p>
                <a href="/athens-login/" class="athens-btn athens-btn-primary">Client Login</a>
            </div>';
        }
        
        ob_start();
        include ATHENS_PLUGIN_PATH . 'templates/dashboard.php';
        return ob_get_clean();
    }
    
    public function search_shortcode() {
        ob_start();
        include ATHENS_PLUGIN_PATH . 'templates/search.php';
        return ob_get_clean();
    }
    
    public function login_shortcode() {
        if (is_user_logged_in()) {
            return '<div class="athens-already-logged">
                <h3>Welcome Back!</h3>
                <p>You are already logged in to Athens portal.</p>
                <a href="/athens-dashboard/" class="athens-btn athens-btn-primary">Go to Dashboard</a>
                <a href="' . wp_logout_url() . '" class="athens-btn athens-btn-secondary">Logout</a>
            </div>';
        }
        
        ob_start();
        include ATHENS_PLUGIN_PATH . 'templates/login.php';
        return ob_get_clean();
    }
    
    public function client_portal_shortcode() {
        ob_start();
        include ATHENS_PLUGIN_PATH . 'templates/client-portal.php';
        return ob_get_clean();
    }
    
    public function handle_search() {
        check_ajax_referer('athens_app_nonce', 'nonce');
        
        $search_term = sanitize_text_field($_POST['search_term']);
        $service_type = sanitize_text_field($_POST['service_type']);
        $date_range = sanitize_text_field($_POST['date_range']);
        
        $results = $this->perform_athens_search($search_term, $service_type, $date_range);
        
        wp_send_json_success($results);
    }
    
    public function handle_client_data() {
        check_ajax_referer('athens_app_nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('Authentication required');
        }
        
        $user_id = get_current_user_id();
        $action_type = sanitize_text_field($_POST['action_type']);
        
        switch ($action_type) {
            case 'get_documents':
                $documents = $this->get_client_documents($user_id);
                wp_send_json_success($documents);
                break;
            case 'get_services':
                $services = $this->get_client_services($user_id);
                wp_send_json_success($services);
                break;
            case 'get_invoices':
                $invoices = $this->get_client_invoices($user_id);
                wp_send_json_success($invoices);
                break;
            default:
                wp_send_json_error('Invalid action');
        }
    }
    
    private function perform_athens_search($term, $service_type, $date_range) {
        $args = array(
            'post_type' => array('page', 'post', 'service'),
            's' => $term,
            'posts_per_page' => 20,
            'meta_query' => array()
        );
        
        if (!empty($service_type)) {
            $args['meta_query'][] = array(
                'key' => 'service_type',
                'value' => $service_type,
                'compare' => 'LIKE'
            );
        }
        
        if (!empty($date_range)) {
            $args['date_query'] = array(
                array(
                    'after' => $date_range,
                    'inclusive' => true
                )
            );
        }
        
        $query = new WP_Query($args);
        return $query->posts;
    }
    
    private function get_client_documents($user_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'athens_client_data';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d AND client_type = 'document' ORDER BY created_at DESC",
            $user_id
        ));
    }
    
    private function get_client_services($user_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'athens_client_data';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d AND client_type = 'service' ORDER BY created_at DESC",
            $user_id
        ));
    }
    
    private function get_client_invoices($user_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'athens_client_data';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d AND client_type = 'invoice' ORDER BY created_at DESC",
            $user_id
        ));
    }
    
    private function get_client_portal_stats() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'athens_client_data';
        
        return $wpdb->get_var("SELECT COUNT(DISTINCT user_id) FROM $table_name WHERE status = 'active'");
    }
}

new AthensWebAppIntegration();
?>
