<?php
/**
 * Athens Dashboard Template
 * Client dashboard interface for Athens Business Solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// Get client statistics
global $wpdb;
$table_name = $wpdb->prefix . 'athens_client_data';

$documents_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND client_type = 'document'",
    $user_id
));

$services_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND client_type = 'service'",
    $user_id
));

$invoices_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND client_type = 'invoice'",
    $user_id
));

$messages_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND client_type = 'message'",
    $user_id
));
?>

<div class="athens-web-dashboard">
    <!-- Dashboard Header -->
    <div class="athens-dashboard-header">
        <div class="athens-header-content">
            <h2>Welcome back, <?php echo esc_html($current_user->display_name); ?>!</h2>
            <div class="athens-brand">ATHENS</div>
        </div>
        <div class="athens-user-avatar">
            <?php echo get_avatar($user_id, 80); ?>
        </div>
    </div>

    <!-- Dashboard Statistics -->
    <div class="athens-dashboard-stats">
        <div class="athens-stat-card accounting">
            <div class="athens-stat-icon">📄</div>
            <div class="athens-stat-content">
                <h3>Documents</h3>
                <div class="athens-stat-number documents"><?php echo $documents_count ?: 0; ?></div>
            </div>
        </div>
        
        <div class="athens-stat-card hr">
            <div class="athens-stat-icon">💼</div>
            <div class="athens-stat-content">
                <h3>Active Services</h3>
                <div class="athens-stat-number services"><?php echo $services_count ?: 0; ?></div>
            </div>
        </div>
        
        <div class="athens-stat-card compliance">
            <div class="athens-stat-icon">📊</div>
            <div class="athens-stat-content">
                <h3>Invoices</h3>
                <div class="athens-stat-number invoices"><?php echo $invoices_count ?: 0; ?></div>
            </div>
        </div>
        
        <div class="athens-stat-card">
            <div class="athens-stat-icon">💬</div>
            <div class="athens-stat-content">
                <h3>Messages</h3>
                <div class="athens-stat-number messages"><?php echo $messages_count ?: 0; ?></div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="athens-dashboard-content">
        <!-- Main Content Area -->
        <div class="athens-main-content">
            <!-- Recent Activity -->
            <div class="athens-dashboard-section athens-recent-activity">
                <h3>Recent Activity</h3>
                <div class="athens-activity-list">
                    <div class="athens-activity-item">
                        <div class="athens-activity-icon">📄</div>
                        <div class="athens-activity-content">
                            <p>GST return filed successfully for March 2024</p>
                            <span class="athens-activity-time">2 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="athens-activity-item">
                        <div class="athens-activity-icon">💼</div>
                        <div class="athens-activity-content">
                            <p>Payroll processing completed</p>
                            <span class="athens-activity-time">4 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="athens-activity-item">
                        <div class="athens-activity-icon">📊</div>
                        <div class="athens-activity-content">
                            <p>Monthly financial report generated</p>
                            <span class="athens-activity-time">1 day ago</span>
                        </div>
                    </div>
                    
                    <div class="athens-activity-item">
                        <div class="athens-activity-icon">✅</div>
                        <div class="athens-activity-content">
                            <p>Compliance audit completed successfully</p>
                            <span class="athens-activity-time">2 days ago</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="athens-dashboard-section">
                <h3>Quick Actions</h3>
                <div class="athens-action-buttons">
                    <a href="#" class="athens-action-btn primary athens-load-documents" data-action="documents">
                        📄 View Documents
                    </a>
                    <a href="#" class="athens-action-btn secondary athens-load-services" data-action="services">
                        💼 Manage Services
                    </a>
                    <a href="#" class="athens-action-btn tertiary athens-load-invoices" data-action="invoices">
                        📊 View Invoices
                    </a>
                    <a href="/contact/" class="athens-action-btn primary" data-action="contact">
                        💬 Contact Support
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="athens-sidebar-content">
            <!-- Notifications -->
            <div class="athens-dashboard-section athens-notifications">
                <h3>Notifications</h3>
                <div class="athens-notification-list">
                    <div class="athens-notification-item unread">
                        <div class="athens-notification-icon">🔔</div>
                        <div class="athens-notification-content">
                            <p>Tax filing deadline approaching - April 30th</p>
                            <span class="athens-notification-time">1 hour ago</span>
                        </div>
                    </div>
                    
                    <div class="athens-notification-item">
                        <div class="athens-notification-icon">ℹ️</div>
                        <div class="athens-notification-content">
                            <p>New compliance regulations update available</p>
                            <span class="athens-notification-time">3 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="athens-notification-item">
                        <div class="athens-notification-icon">📅</div>
                        <div class="athens-notification-content">
                            <p>Quarterly review meeting scheduled</p>
                            <span class="athens-notification-time">1 day ago</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Tracker -->
            <div class="athens-dashboard-section athens-progress-tracker">
                <h3>Service Progress</h3>
                
                <div class="athens-progress-item">
                    <div class="athens-progress-header">
                        <span>GST Compliance</span>
                        <span>85%</span>
                    </div>
                    <div class="athens-progress-bar">
                        <div class="athens-progress-fill" data-width="85%" style="width: 85%;"></div>
                    </div>
                </div>
                
                <div class="athens-progress-item">
                    <div class="athens-progress-header">
                        <span>Payroll Processing</span>
                        <span>92%</span>
                    </div>
                    <div class="athens-progress-bar">
                        <div class="athens-progress-fill" data-width="92%" style="width: 92%;"></div>
                    </div>
                </div>
                
                <div class="athens-progress-item">
                    <div class="athens-progress-header">
                        <span>Annual Audit</span>
                        <span>67%</span>
                    </div>
                    <div class="athens-progress-bar">
                        <div class="athens-progress-fill" data-width="67%" style="width: 67%;"></div>
                    </div>
                </div>
                
                <div class="athens-progress-item">
                    <div class="athens-progress-header">
                        <span>Documentation</span>
                        <span>78%</span>
                    </div>
                    <div class="athens-progress-bar">
                        <div class="athens-progress-fill" data-width="78%" style="width: 78%;"></div>
                    </div>
                </div>
            </div>

            <!-- Service Summary -->
            <div class="athens-dashboard-section">
                <h3>Service Summary</h3>
                <div class="athens-service-summary">
                    <div class="athens-summary-item">
                        <strong>Accounting Services</strong>
                        <p>Monthly bookkeeping, GST filing, TDS returns</p>
                        <span class="athens-status active">Active</span>
                    </div>
                    
                    <div class="athens-summary-item">
                        <strong>HR Services</strong>
                        <p>Payroll processing, PF/ESI compliance</p>
                        <span class="athens-status active">Active</span>
                    </div>
                    
                    <div class="athens-summary-item">
                        <strong>Compliance</strong>
                        <p>Statutory compliance, audit support</p>
                        <span class="athens-status pending">In Progress</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Footer -->
    <div class="athens-dashboard-footer">
        <div class="athens-footer-content">
            <p>&copy; 2024 Athens Business Solutions. All rights reserved.</p>
            <div class="athens-footer-links">
                <a href="/privacy-policy/">Privacy Policy</a>
                <a href="/terms-of-service/">Terms of Service</a>
                <a href="/contact/">Support</a>
            </div>
        </div>
    </div>
</div>

<style>
/* Additional Dashboard Styles */
.athens-service-summary {
    space-y: 15px;
}

.athens-summary-item {
    padding: 15px;
    border: 1px solid var(--athens-border);
    border-radius: var(--athens-radius);
    margin-bottom: 15px;
}

.athens-summary-item strong {
    color: var(--athens-primary);
    display: block;
    margin-bottom: 5px;
}

.athens-summary-item p {
    color: var(--athens-text-light);
    font-size: 14px;
    margin: 5px 0;
}

.athens-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.athens-status.active {
    background: #d4edda;
    color: #155724;
}

.athens-status.pending {
    background: #fff3cd;
    color: #856404;
}

.athens-dashboard-footer {
    margin-top: 40px;
    padding: 30px;
    background: var(--athens-bg-white);
    border-radius: 12px;
    box-shadow: var(--athens-shadow);
    text-align: center;
}

.athens-footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.athens-footer-links {
    display: flex;
    gap: 20px;
}

.athens-footer-links a {
    color: var(--athens-primary);
    text-decoration: none;
    font-weight: 500;
}

.athens-footer-links a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .athens-footer-content {
        flex-direction: column;
        text-align: center;
    }
    
    .athens-footer-links {
        justify-content: center;
    }
}
</style>
