<?php
/**
 * Athens Search Template
 * Advanced search interface for Athens Business Solutions
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="athens-search-container">
    <div class="athens-search-header">
        <h2>Athens Advanced Search</h2>
        <p>Search through our services, documents, and resources</p>
    </div>

    <form class="athens-search-form" method="get">
        <div class="athens-search-row">
            <input type="text" 
                   class="athens-search-input" 
                   name="search_term" 
                   placeholder="Search for services, documents, or information..."
                   value="<?php echo esc_attr($_GET['search_term'] ?? ''); ?>">
            
            <button type="submit" class="athens-search-btn">
                🔍 Search
            </button>
        </div>
        
        <div class="athens-search-filters">
            <select class="athens-service-filter" name="service_type">
                <option value="">All Services</option>
                <option value="accounting" <?php selected($_GET['service_type'] ?? '', 'accounting'); ?>>Accounting Services</option>
                <option value="hr" <?php selected($_GET['service_type'] ?? '', 'hr'); ?>>HR Services</option>
                <option value="compliance" <?php selected($_GET['service_type'] ?? '', 'compliance'); ?>>Compliance Services</option>
                <option value="gst" <?php selected($_GET['service_type'] ?? '', 'gst'); ?>>GST Services</option>
                <option value="company" <?php selected($_GET['service_type'] ?? '', 'company'); ?>>Company Registration</option>
                <option value="statutory" <?php selected($_GET['service_type'] ?? '', 'statutory'); ?>>Statutory Services</option>
            </select>
            
            <select class="athens-date-filter" name="date_range">
                <option value="">Any Time</option>
                <option value="1 week ago" <?php selected($_GET['date_range'] ?? '', '1 week ago'); ?>>Last Week</option>
                <option value="1 month ago" <?php selected($_GET['date_range'] ?? '', '1 month ago'); ?>>Last Month</option>
                <option value="3 months ago" <?php selected($_GET['date_range'] ?? '', '3 months ago'); ?>>Last 3 Months</option>
                <option value="1 year ago" <?php selected($_GET['date_range'] ?? '', '1 year ago'); ?>>Last Year</option>
            </select>
            
            <select class="athens-content-filter" name="content_type">
                <option value="">All Content</option>
                <option value="page" <?php selected($_GET['content_type'] ?? '', 'page'); ?>>Pages</option>
                <option value="post" <?php selected($_GET['content_type'] ?? '', 'post'); ?>>Blog Posts</option>
                <option value="service" <?php selected($_GET['content_type'] ?? '', 'service'); ?>>Services</option>
                <option value="document" <?php selected($_GET['content_type'] ?? '', 'document'); ?>>Documents</option>
            </select>
        </div>
    </form>

    <div class="athens-search-suggestions">
        <h4>Popular Searches:</h4>
        <div class="athens-suggestion-tags">
            <a href="?search_term=GST+registration" class="athens-suggestion-tag">GST Registration</a>
            <a href="?search_term=payroll+services" class="athens-suggestion-tag">Payroll Services</a>
            <a href="?search_term=company+registration" class="athens-suggestion-tag">Company Registration</a>
            <a href="?search_term=tax+filing" class="athens-suggestion-tag">Tax Filing</a>
            <a href="?search_term=compliance+audit" class="athens-suggestion-tag">Compliance Audit</a>
            <a href="?search_term=bookkeeping" class="athens-suggestion-tag">Bookkeeping</a>
            <a href="?search_term=PF+ESI" class="athens-suggestion-tag">PF ESI</a>
            <a href="?search_term=TDS+return" class="athens-suggestion-tag">TDS Return</a>
        </div>
    </div>

    <div class="athens-search-results">
        <?php if (!empty($_GET['search_term'])): ?>
            <div class="athens-search-loading">
                <p>Searching for "<?php echo esc_html($_GET['search_term']); ?>"...</p>
            </div>
        <?php else: ?>
            <div class="athens-search-welcome">
                <div class="athens-search-icon">🔍</div>
                <h3>Start Your Search</h3>
                <p>Enter keywords above to search through our comprehensive database of services, documents, and resources.</p>
                
                <div class="athens-search-categories">
                    <div class="athens-category-card">
                        <div class="athens-category-icon">📊</div>
                        <h4>Accounting Services</h4>
                        <p>GST, TDS, bookkeeping, financial reports</p>
                        <a href="?search_term=accounting&service_type=accounting" class="athens-category-link">Explore</a>
                    </div>
                    
                    <div class="athens-category-card">
                        <div class="athens-category-icon">👥</div>
                        <h4>HR Services</h4>
                        <p>Payroll, PF ESI, employee management</p>
                        <a href="?search_term=hr&service_type=hr" class="athens-category-link">Explore</a>
                    </div>
                    
                    <div class="athens-category-card">
                        <div class="athens-category-icon">✅</div>
                        <h4>Compliance</h4>
                        <p>Statutory compliance, legal requirements</p>
                        <a href="?search_term=compliance&service_type=compliance" class="athens-category-link">Explore</a>
                    </div>
                    
                    <div class="athens-category-card">
                        <div class="athens-category-icon">🏢</div>
                        <h4>Company Setup</h4>
                        <p>Registration, licensing, documentation</p>
                        <a href="?search_term=company&service_type=company" class="athens-category-link">Explore</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="athens-search-help">
        <h4>Search Tips:</h4>
        <ul>
            <li><strong>Use specific terms:</strong> "GST registration" instead of just "GST"</li>
            <li><strong>Try synonyms:</strong> "payroll" or "salary processing"</li>
            <li><strong>Use filters:</strong> Select service type and date range for better results</li>
            <li><strong>Browse categories:</strong> Use the category cards above to explore services</li>
        </ul>
    </div>
</div>

<style>
/* Athens Search Specific Styles */
.athens-search-header {
    text-align: center;
    margin-bottom: 40px;
}

.athens-search-header h2 {
    color: var(--athens-primary);
    font-size: 32px;
    margin-bottom: 10px;
}

.athens-search-header p {
    color: var(--athens-text-light);
    font-size: 18px;
}

.athens-search-row {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 15px;
    margin-bottom: 20px;
}

.athens-search-filters {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.athens-service-filter,
.athens-date-filter,
.athens-content-filter {
    padding: 12px 15px;
    border: 2px solid var(--athens-border);
    border-radius: var(--athens-radius);
    font-size: 14px;
    background: white;
    transition: var(--athens-transition);
}

.athens-service-filter:focus,
.athens-date-filter:focus,
.athens-content-filter:focus {
    outline: none;
    border-color: var(--athens-primary);
    box-shadow: 0 0 0 3px rgba(0,115,170,0.1);
}

.athens-search-suggestions {
    margin-bottom: 30px;
    padding: 20px;
    background: var(--athens-bg-light);
    border-radius: var(--athens-radius);
}

.athens-search-suggestions h4 {
    margin: 0 0 15px 0;
    color: var(--athens-text);
    font-size: 16px;
}

.athens-suggestion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.athens-suggestion-tag {
    display: inline-block;
    padding: 8px 16px;
    background: white;
    color: var(--athens-primary);
    text-decoration: none;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    border: 1px solid var(--athens-border);
    transition: var(--athens-transition);
}

.athens-suggestion-tag:hover {
    background: var(--athens-primary);
    color: white;
    transform: translateY(-1px);
}

.athens-search-welcome {
    text-align: center;
    padding: 60px 20px;
}

.athens-search-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.athens-search-welcome h3 {
    color: var(--athens-primary);
    font-size: 28px;
    margin-bottom: 15px;
}

.athens-search-welcome p {
    color: var(--athens-text-light);
    font-size: 16px;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.athens-search-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-top: 40px;
}

.athens-category-card {
    background: white;
    padding: 30px 20px;
    border-radius: 12px;
    box-shadow: var(--athens-shadow);
    text-align: center;
    transition: var(--athens-transition);
    border: 1px solid var(--athens-border);
}

.athens-category-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--athens-shadow-hover);
}

.athens-category-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.athens-category-card h4 {
    color: var(--athens-primary);
    font-size: 18px;
    margin-bottom: 10px;
}

.athens-category-card p {
    color: var(--athens-text-light);
    font-size: 14px;
    margin-bottom: 20px;
}

.athens-category-link {
    display: inline-block;
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--athens-primary) 0%, var(--athens-primary-dark) 100%);
    color: white;
    text-decoration: none;
    border-radius: var(--athens-radius);
    font-weight: 600;
    transition: var(--athens-transition);
}

.athens-category-link:hover {
    background: linear-gradient(135deg, var(--athens-primary-dark) 0%, #003d5c 100%);
    transform: translateY(-1px);
    color: white;
}

.athens-search-help {
    margin-top: 40px;
    padding: 25px;
    background: var(--athens-bg-light);
    border-radius: var(--athens-radius);
    border-left: 4px solid var(--athens-primary);
}

.athens-search-help h4 {
    color: var(--athens-primary);
    margin-bottom: 15px;
}

.athens-search-help ul {
    margin: 0;
    padding-left: 20px;
}

.athens-search-help li {
    margin-bottom: 8px;
    color: var(--athens-text-light);
}

.athens-search-help strong {
    color: var(--athens-text);
}

.athens-search-loading {
    text-align: center;
    padding: 40px;
    color: var(--athens-text-light);
}

@media (max-width: 768px) {
    .athens-search-row {
        grid-template-columns: 1fr;
    }
    
    .athens-search-filters {
        grid-template-columns: 1fr;
    }
    
    .athens-search-categories {
        grid-template-columns: 1fr;
    }
    
    .athens-suggestion-tags {
        justify-content: center;
    }
}
</style>

<script>
// Auto-submit search form when filters change
jQuery(document).ready(function($) {
    $('.athens-service-filter, .athens-date-filter, .athens-content-filter').on('change', function() {
        if ($('.athens-search-input').val().trim()) {
            $('.athens-search-form').submit();
        }
    });
});
</script>
