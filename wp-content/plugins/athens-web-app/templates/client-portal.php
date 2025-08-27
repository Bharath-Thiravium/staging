<?php
/**
 * Athens Client Portal Template
 * Complete client portal interface for Athens Business Solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!is_user_logged_in()) {
    echo '<div class="athens-portal-login-required">';
    echo '<h2>Client Portal Access Required</h2>';
    echo '<p>Please log in to access your Athens client portal.</p>';
    echo '<a href="/athens-login/?redirect_to=' . urlencode($_SERVER['REQUEST_URI']) . '" class="athens-btn athens-btn-primary">Client Login</a>';
    echo '</div>';
    return;
}

$current_user = wp_get_current_user();
?>

<div class="athens-client-portal">
    <!-- Portal Header -->
    <div class="athens-portal-header">
        <div class="athens-portal-nav">
            <div class="athens-portal-logo">
                <h1>ATHENS</h1>
                <span>Client Portal</span>
            </div>
            <nav class="athens-portal-menu">
                <a href="#dashboard" class="athens-nav-link active" data-tab="dashboard">Dashboard</a>
                <a href="#documents" class="athens-nav-link" data-tab="documents">Documents</a>
                <a href="#services" class="athens-nav-link" data-tab="services">Services</a>
                <a href="#invoices" class="athens-nav-link" data-tab="invoices">Invoices</a>
                <a href="#support" class="athens-nav-link" data-tab="support">Support</a>
            </nav>
            <div class="athens-portal-user">
                <span>Welcome, <?php echo esc_html($current_user->display_name); ?></span>
                <a href="<?php echo wp_logout_url(); ?>" class="athens-logout-btn">Logout</a>
            </div>
        </div>
    </div>

    <!-- Portal Content -->
    <div class="athens-portal-content">
        <!-- Dashboard Tab -->
        <div id="athens-tab-dashboard" class="athens-tab-content active">
            <?php echo do_shortcode('[athens_dashboard]'); ?>
        </div>

        <!-- Documents Tab -->
        <div id="athens-tab-documents" class="athens-tab-content">
            <div class="athens-documents-section">
                <div class="athens-section-header">
                    <h2>Your Documents</h2>
                    <button class="athens-btn athens-btn-primary" onclick="uploadDocument()">Upload Document</button>
                </div>
                
                <div class="athens-documents-filter">
                    <select class="athens-filter-select" id="document-type-filter">
                        <option value="">All Document Types</option>
                        <option value="gst">GST Documents</option>
                        <option value="payroll">Payroll Documents</option>
                        <option value="compliance">Compliance Documents</option>
                        <option value="financial">Financial Reports</option>
                        <option value="legal">Legal Documents</option>
                    </select>
                    
                    <input type="text" class="athens-search-input" placeholder="Search documents..." id="document-search">
                </div>

                <div class="athens-documents-grid" id="documents-container">
                    <div class="athens-document-card">
                        <div class="athens-doc-icon">📄</div>
                        <div class="athens-doc-info">
                            <h4>GST Return - March 2024</h4>
                            <p>Filed on: March 20, 2024</p>
                            <span class="athens-doc-type">GST</span>
                        </div>
                        <div class="athens-doc-actions">
                            <button class="athens-btn-icon" title="Download">⬇️</button>
                            <button class="athens-btn-icon" title="View">👁️</button>
                        </div>
                    </div>
                    
                    <div class="athens-document-card">
                        <div class="athens-doc-icon">📊</div>
                        <div class="athens-doc-info">
                            <h4>Payroll Report - March 2024</h4>
                            <p>Generated on: March 31, 2024</p>
                            <span class="athens-doc-type">Payroll</span>
                        </div>
                        <div class="athens-doc-actions">
                            <button class="athens-btn-icon" title="Download">⬇️</button>
                            <button class="athens-btn-icon" title="View">👁️</button>
                        </div>
                    </div>
                    
                    <div class="athens-document-card">
                        <div class="athens-doc-icon">📋</div>
                        <div class="athens-doc-info">
                            <h4>Compliance Audit Report</h4>
                            <p>Completed on: March 15, 2024</p>
                            <span class="athens-doc-type">Compliance</span>
                        </div>
                        <div class="athens-doc-actions">
                            <button class="athens-btn-icon" title="Download">⬇️</button>
                            <button class="athens-btn-icon" title="View">👁️</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Tab -->
        <div id="athens-tab-services" class="athens-tab-content">
            <div class="athens-services-section">
                <div class="athens-section-header">
                    <h2>Your Services</h2>
                    <button class="athens-btn athens-btn-primary" onclick="requestService()">Request New Service</button>
                </div>

                <div class="athens-services-grid">
                    <div class="athens-service-card active">
                        <div class="athens-service-icon">📊</div>
                        <div class="athens-service-info">
                            <h3>Accounting Services</h3>
                            <p>Monthly bookkeeping, GST filing, TDS returns</p>
                            <div class="athens-service-status">
                                <span class="athens-status-badge active">Active</span>
                                <span class="athens-service-date">Since: Jan 2024</span>
                            </div>
                        </div>
                        <div class="athens-service-actions">
                            <button class="athens-btn athens-btn-secondary">View Details</button>
                        </div>
                    </div>
                    
                    <div class="athens-service-card active">
                        <div class="athens-service-icon">👥</div>
                        <div class="athens-service-info">
                            <h3>HR Services</h3>
                            <p>Payroll processing, PF/ESI compliance</p>
                            <div class="athens-service-status">
                                <span class="athens-status-badge active">Active</span>
                                <span class="athens-service-date">Since: Feb 2024</span>
                            </div>
                        </div>
                        <div class="athens-service-actions">
                            <button class="athens-btn athens-btn-secondary">View Details</button>
                        </div>
                    </div>
                    
                    <div class="athens-service-card pending">
                        <div class="athens-service-icon">✅</div>
                        <div class="athens-service-info">
                            <h3>Compliance Services</h3>
                            <p>Statutory compliance, audit support</p>
                            <div class="athens-service-status">
                                <span class="athens-status-badge pending">Setup in Progress</span>
                                <span class="athens-service-date">Requested: Mar 2024</span>
                            </div>
                        </div>
                        <div class="athens-service-actions">
                            <button class="athens-btn athens-btn-secondary">Track Progress</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Tab -->
        <div id="athens-tab-invoices" class="athens-tab-content">
            <div class="athens-invoices-section">
                <div class="athens-section-header">
                    <h2>Invoices & Payments</h2>
                    <div class="athens-invoice-summary">
                        <span class="athens-summary-item">Outstanding: ₹25,000</span>
                        <span class="athens-summary-item">Paid This Month: ₹15,000</span>
                    </div>
                </div>

                <div class="athens-invoices-table">
                    <table class="athens-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-2024-001</td>
                                <td>Mar 31, 2024</td>
                                <td>Accounting Services</td>
                                <td>₹15,000</td>
                                <td><span class="athens-status-badge paid">Paid</span></td>
                                <td>
                                    <button class="athens-btn-icon" title="Download">⬇️</button>
                                    <button class="athens-btn-icon" title="View">👁️</button>
                                </td>
                            </tr>
                            <tr>
                                <td>INV-2024-002</td>
                                <td>Apr 01, 2024</td>
                                <td>HR Services</td>
                                <td>₹12,000</td>
                                <td><span class="athens-status-badge pending">Pending</span></td>
                                <td>
                                    <button class="athens-btn-icon" title="Download">⬇️</button>
                                    <button class="athens-btn-icon" title="Pay Now">💳</button>
                                </td>
                            </tr>
                            <tr>
                                <td>INV-2024-003</td>
                                <td>Apr 05, 2024</td>
                                <td>Compliance Setup</td>
                                <td>₹8,000</td>
                                <td><span class="athens-status-badge overdue">Overdue</span></td>
                                <td>
                                    <button class="athens-btn-icon" title="Download">⬇️</button>
                                    <button class="athens-btn-icon" title="Pay Now">💳</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Support Tab -->
        <div id="athens-tab-support" class="athens-tab-content">
            <div class="athens-support-section">
                <div class="athens-section-header">
                    <h2>Support & Help</h2>
                    <button class="athens-btn athens-btn-primary" onclick="createTicket()">Create Support Ticket</button>
                </div>

                <div class="athens-support-grid">
                    <div class="athens-support-card">
                        <div class="athens-support-icon">💬</div>
                        <h3>Live Chat</h3>
                        <p>Get instant help from our support team</p>
                        <button class="athens-btn athens-btn-primary">Start Chat</button>
                    </div>
                    
                    <div class="athens-support-card">
                        <div class="athens-support-icon">📞</div>
                        <h3>Phone Support</h3>
                        <p>Call us directly for urgent matters</p>
                        <a href="tel:+914428505273" class="athens-btn athens-btn-secondary">Call Now</a>
                    </div>
                    
                    <div class="athens-support-card">
                        <div class="athens-support-icon">📧</div>
                        <h3>Email Support</h3>
                        <p>Send us detailed queries via email</p>
                        <a href="mailto:support@athenas.co.in" class="athens-btn athens-btn-secondary">Send Email</a>
                    </div>
                </div>

                <div class="athens-faq-section">
                    <h3>Frequently Asked Questions</h3>
                    <div class="athens-faq-list">
                        <div class="athens-faq-item">
                            <button class="athens-faq-question">How do I download my GST returns?</button>
                            <div class="athens-faq-answer">
                                <p>Go to the Documents tab, filter by "GST Documents", and click the download button next to your desired return.</p>
                            </div>
                        </div>
                        
                        <div class="athens-faq-item">
                            <button class="athens-faq-question">When will my monthly reports be ready?</button>
                            <div class="athens-faq-answer">
                                <p>Monthly reports are typically generated by the 5th of each month and will appear in your Documents section.</p>
                            </div>
                        </div>
                        
                        <div class="athens-faq-item">
                            <button class="athens-faq-question">How can I make payments for invoices?</button>
                            <div class="athens-faq-answer">
                                <p>You can pay invoices directly through the portal using UPI, net banking, or credit/debit cards. Click the "Pay Now" button next to any pending invoice.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Athens Client Portal Styles */
.athens-client-portal {
    min-height: 100vh;
    background: var(--athens-bg-light);
}

.athens-portal-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.athens-portal-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 40px;
    max-width: 1400px;
    margin: 0 auto;
}

.athens-portal-logo h1 {
    color: var(--athens-primary);
    font-size: 24px;
    font-weight: 800;
    letter-spacing: 2px;
    margin: 0;
}

.athens-portal-logo span {
    color: var(--athens-text-light);
    font-size: 12px;
    display: block;
    margin-top: -5px;
}

.athens-portal-menu {
    display: flex;
    gap: 30px;
}

.athens-nav-link {
    color: var(--athens-text);
    text-decoration: none;
    font-weight: 500;
    padding: 10px 0;
    border-bottom: 2px solid transparent;
    transition: var(--athens-transition);
}

.athens-nav-link:hover,
.athens-nav-link.active {
    color: var(--athens-primary);
    border-bottom-color: var(--athens-primary);
}

.athens-portal-user {
    display: flex;
    align-items: center;
    gap: 15px;
}

.athens-logout-btn {
    color: var(--athens-text-light);
    text-decoration: none;
    font-size: 14px;
}

.athens-portal-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px;
}

.athens-tab-content {
    display: none;
}

.athens-tab-content.active {
    display: block;
}

.athens-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.athens-section-header h2 {
    color: var(--athens-primary);
    font-size: 28px;
    margin: 0;
}

/* Documents Styles */
.athens-documents-filter {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.athens-filter-select {
    padding: 12px 15px;
    border: 2px solid var(--athens-border);
    border-radius: var(--athens-radius);
    background: white;
}

.athens-documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
}

.athens-document-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: var(--athens-shadow);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: var(--athens-transition);
}

.athens-document-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--athens-shadow-hover);
}

.athens-doc-icon {
    font-size: 32px;
    width: 50px;
    text-align: center;
}

.athens-doc-info {
    flex: 1;
}

.athens-doc-info h4 {
    margin: 0 0 5px 0;
    color: var(--athens-text);
}

.athens-doc-info p {
    margin: 0 0 8px 0;
    color: var(--athens-text-light);
    font-size: 14px;
}

.athens-doc-type {
    background: var(--athens-primary);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.athens-doc-actions {
    display: flex;
    gap: 10px;
}

.athens-btn-icon {
    background: none;
    border: 1px solid var(--athens-border);
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer;
    transition: var(--athens-transition);
}

.athens-btn-icon:hover {
    background: var(--athens-primary);
    border-color: var(--athens-primary);
    color: white;
}

/* Services Styles */
.athens-services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
}

.athens-service-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: var(--athens-shadow);
    border-left: 4px solid var(--athens-border);
}

.athens-service-card.active {
    border-left-color: var(--athens-secondary);
}

.athens-service-card.pending {
    border-left-color: #ffc107;
}

.athens-service-icon {
    font-size: 40px;
    margin-bottom: 15px;
}

.athens-service-info h3 {
    color: var(--athens-text);
    margin-bottom: 10px;
}

.athens-service-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 15px 0;
}

.athens-status-badge {
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.athens-status-badge.active {
    background: #d4edda;
    color: #155724;
}

.athens-status-badge.pending {
    background: #fff3cd;
    color: #856404;
}

.athens-status-badge.paid {
    background: #d4edda;
    color: #155724;
}

.athens-status-badge.overdue {
    background: #f8d7da;
    color: #721c24;
}

/* Table Styles */
.athens-table {
    width: 100%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--athens-shadow);
}

.athens-table th,
.athens-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid var(--athens-border);
}

.athens-table th {
    background: var(--athens-bg-light);
    font-weight: 600;
    color: var(--athens-text);
}

/* Support Styles */
.athens-support-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.athens-support-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: var(--athens-shadow);
    text-align: center;
}

.athens-support-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.athens-faq-item {
    background: white;
    border-radius: var(--athens-radius);
    margin-bottom: 10px;
    overflow: hidden;
    box-shadow: var(--athens-shadow);
}

.athens-faq-question {
    width: 100%;
    padding: 20px;
    background: none;
    border: none;
    text-align: left;
    font-weight: 600;
    cursor: pointer;
    color: var(--athens-text);
}

.athens-faq-answer {
    padding: 0 20px 20px 20px;
    display: none;
    color: var(--athens-text-light);
}

.athens-faq-answer.active {
    display: block;
}

@media (max-width: 768px) {
    .athens-portal-nav {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }
    
    .athens-portal-menu {
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }
    
    .athens-portal-content {
        padding: 20px;
    }
    
    .athens-section-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .athens-documents-filter {
        flex-direction: column;
    }
}
</style>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.athens-nav-link');
    const tabContents = document.querySelectorAll('.athens-tab-content');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all nav links and tab contents
            navLinks.forEach(nl => nl.classList.remove('active'));
            tabContents.forEach(tc => tc.classList.remove('active'));
            
            // Add active class to clicked nav link
            this.classList.add('active');
            
            // Show corresponding tab content
            const tabId = 'athens-tab-' + this.dataset.tab;
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // FAQ functionality
    const faqQuestions = document.querySelectorAll('.athens-faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            answer.classList.toggle('active');
        });
    });
});

// Portal functions
function uploadDocument() {
    alert('Document upload functionality would be implemented here');
}

function requestService() {
    alert('Service request functionality would be implemented here');
}

function createTicket() {
    alert('Support ticket creation would be implemented here');
}
</script>
