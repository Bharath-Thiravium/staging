/**
 * Athens Web App JavaScript
 * Handles interactive features for Athens Business Solutions web app
 */

jQuery(document).ready(function($) {
    
    // Initialize Athens App
    AthensApp.init();
    
});

var AthensApp = {
    
    init: function() {
        this.bindEvents();
        this.loadDashboardData();
        this.initializeSearch();
        this.setupNotifications();
    },
    
    bindEvents: function() {
        // Search functionality
        $(document).on('submit', '.athens-search-form', this.handleSearch);
        $(document).on('click', '.athens-search-btn', this.handleSearch);
        
        // Dashboard actions
        $(document).on('click', '.athens-action-btn', this.handleActionClick);
        
        // Client data requests
        $(document).on('click', '.athens-load-documents', this.loadClientDocuments);
        $(document).on('click', '.athens-load-services', this.loadClientServices);
        $(document).on('click', '.athens-load-invoices', this.loadClientInvoices);
        
        // Notification interactions
        $(document).on('click', '.athens-notification-item', this.markNotificationRead);
        
        // Progress tracking
        this.animateProgressBars();
    },
    
    handleSearch: function(e) {
        e.preventDefault();
        
        var searchTerm = $('.athens-search-input').val();
        var serviceType = $('.athens-service-filter').val() || '';
        var dateRange = $('.athens-date-filter').val() || '';
        
        if (!searchTerm.trim()) {
            AthensApp.showMessage('Please enter a search term', 'warning');
            return;
        }
        
        $('.athens-search-btn').text('Searching...').prop('disabled', true);
        
        $.ajax({
            url: athens_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'athens_search',
                search_term: searchTerm,
                service_type: serviceType,
                date_range: dateRange,
                nonce: athens_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    AthensApp.displaySearchResults(response.data);
                } else {
                    AthensApp.showMessage('Search failed. Please try again.', 'error');
                }
            },
            error: function() {
                AthensApp.showMessage('Search error. Please check your connection.', 'error');
            },
            complete: function() {
                $('.athens-search-btn').text('Search').prop('disabled', false);
            }
        });
    },
    
    displaySearchResults: function(results) {
        var resultsContainer = $('.athens-search-results');
        resultsContainer.empty();
        
        if (results.length === 0) {
            resultsContainer.html('<div class="athens-no-results"><p>No results found. Try different search terms.</p></div>');
            return;
        }
        
        var resultsHtml = '<h3>Search Results (' + results.length + ')</h3>';
        
        $.each(results, function(index, result) {
            resultsHtml += '<div class="athens-search-result">';
            resultsHtml += '<h4><a href="' + result.permalink + '">' + result.post_title + '</a></h4>';
            resultsHtml += '<p>' + (result.post_excerpt || result.post_content.substring(0, 200) + '...') + '</p>';
            resultsHtml += '<div class="athens-result-meta">';
            resultsHtml += '<span class="athens-result-type">' + result.post_type.toUpperCase() + '</span>';
            resultsHtml += '<span class="athens-result-date">' + result.post_date + '</span>';
            resultsHtml += '</div>';
            resultsHtml += '</div>';
        });
        
        resultsContainer.html(resultsHtml);
        resultsContainer.hide().fadeIn(500);
    },
    
    handleActionClick: function(e) {
        var action = $(this).data('action');
        var actionText = $(this).text();
        
        $(this).text('Processing...').prop('disabled', true);
        
        // Simulate action processing
        setTimeout(function() {
            AthensApp.showMessage('Action "' + actionText + '" completed successfully!', 'success');
            $(e.target).text(actionText).prop('disabled', false);
        }, 1500);
    },
    
    loadDashboardData: function() {
        // Load real-time dashboard statistics
        this.updateStatistics();
        this.loadRecentActivity();
        this.loadNotifications();
        
        // Refresh data every 5 minutes
        setInterval(function() {
            AthensApp.updateStatistics();
            AthensApp.loadRecentActivity();
        }, 300000);
    },
    
    updateStatistics: function() {
        // Simulate real-time statistics updates
        var stats = [
            { selector: '.athens-stat-number.documents', min: 15, max: 50 },
            { selector: '.athens-stat-number.services', min: 5, max: 15 },
            { selector: '.athens-stat-number.messages', min: 0, max: 25 }
        ];
        
        $.each(stats, function(index, stat) {
            var currentValue = parseInt($(stat.selector).text()) || 0;
            var newValue = Math.max(stat.min, Math.min(stat.max, currentValue + Math.floor(Math.random() * 3) - 1));
            
            if (newValue !== currentValue) {
                AthensApp.animateNumber(stat.selector, currentValue, newValue);
            }
        });
    },
    
    animateNumber: function(selector, from, to) {
        var element = $(selector);
        var duration = 1000;
        var steps = 20;
        var stepValue = (to - from) / steps;
        var currentStep = 0;
        
        var interval = setInterval(function() {
            currentStep++;
            var currentValue = Math.round(from + (stepValue * currentStep));
            element.text(currentValue);
            
            if (currentStep >= steps) {
                clearInterval(interval);
                element.text(to);
            }
        }, duration / steps);
    },
    
    loadRecentActivity: function() {
        // Simulate loading recent activity
        var activities = [
            { icon: '📄', text: 'GST return filed successfully', time: '2 hours ago' },
            { icon: '💼', text: 'Payroll processed for March', time: '4 hours ago' },
            { icon: '📊', text: 'Financial report generated', time: '1 day ago' },
            { icon: '✅', text: 'Compliance check completed', time: '2 days ago' }
        ];
        
        var activityHtml = '';
        $.each(activities, function(index, activity) {
            activityHtml += '<div class="athens-activity-item">';
            activityHtml += '<div class="athens-activity-icon">' + activity.icon + '</div>';
            activityHtml += '<div class="athens-activity-content">';
            activityHtml += '<p>' + activity.text + '</p>';
            activityHtml += '<span class="athens-activity-time">' + activity.time + '</span>';
            activityHtml += '</div>';
            activityHtml += '</div>';
        });
        
        $('.athens-recent-activity .athens-activity-list').html(activityHtml);
    },
    
    loadNotifications: function() {
        // Simulate loading notifications
        var notifications = [
            { icon: '🔔', text: 'Tax filing deadline approaching', time: '1 hour ago', unread: true },
            { icon: 'ℹ️', text: 'New compliance update available', time: '3 hours ago', unread: false },
            { icon: '📅', text: 'Meeting scheduled for tomorrow', time: '1 day ago', unread: false }
        ];
        
        var notificationHtml = '';
        $.each(notifications, function(index, notification) {
            var unreadClass = notification.unread ? ' unread' : '';
            notificationHtml += '<div class="athens-notification-item' + unreadClass + '">';
            notificationHtml += '<div class="athens-notification-icon">' + notification.icon + '</div>';
            notificationHtml += '<div class="athens-notification-content">';
            notificationHtml += '<p>' + notification.text + '</p>';
            notificationHtml += '<span class="athens-notification-time">' + notification.time + '</span>';
            notificationHtml += '</div>';
            notificationHtml += '</div>';
        });
        
        $('.athens-notifications .athens-notification-list').html(notificationHtml);
    },
    
    loadClientDocuments: function() {
        AthensApp.loadClientData('get_documents', 'Documents loaded successfully');
    },
    
    loadClientServices: function() {
        AthensApp.loadClientData('get_services', 'Services loaded successfully');
    },
    
    loadClientInvoices: function() {
        AthensApp.loadClientData('get_invoices', 'Invoices loaded successfully');
    },
    
    loadClientData: function(actionType, successMessage) {
        $.ajax({
            url: athens_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'athens_client_data',
                action_type: actionType,
                nonce: athens_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    AthensApp.showMessage(successMessage, 'success');
                    // Process and display the data
                    console.log('Client data:', response.data);
                } else {
                    AthensApp.showMessage('Failed to load data: ' + response.data, 'error');
                }
            },
            error: function() {
                AthensApp.showMessage('Error loading client data', 'error');
            }
        });
    },
    
    markNotificationRead: function() {
        $(this).removeClass('unread');
        // Here you would typically send an AJAX request to mark as read in the database
    },
    
    animateProgressBars: function() {
        $('.athens-progress-fill').each(function() {
            var width = $(this).data('width') || $(this).css('width');
            $(this).css('width', '0%').animate({ width: width }, 1500);
        });
    },
    
    initializeSearch: function() {
        // Add search suggestions/autocomplete if needed
        $('.athens-search-input').on('input', function() {
            var term = $(this).val();
            if (term.length > 2) {
                // Implement search suggestions here
                AthensApp.showSearchSuggestions(term);
            }
        });
    },
    
    showSearchSuggestions: function(term) {
        // Implement search suggestions dropdown
        var suggestions = [
            'GST Registration',
            'Payroll Services',
            'Tax Filing',
            'Company Registration',
            'Compliance Services'
        ];
        
        var filteredSuggestions = suggestions.filter(function(suggestion) {
            return suggestion.toLowerCase().includes(term.toLowerCase());
        });
        
        // Display suggestions (implement UI as needed)
        console.log('Search suggestions for "' + term + '":', filteredSuggestions);
    },
    
    setupNotifications: function() {
        // Check for browser notification permissions
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    },
    
    showBrowserNotification: function(title, message) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body: message,
                icon: '/wp-content/plugins/athens-web-app/assets/images/athens-icon.png'
            });
        }
    },
    
    showMessage: function(message, type) {
        type = type || 'info';
        
        var messageHtml = '<div class="athens-message athens-message-' + type + '">';
        messageHtml += '<span class="athens-message-text">' + message + '</span>';
        messageHtml += '<button class="athens-message-close">&times;</button>';
        messageHtml += '</div>';
        
        var messageElement = $(messageHtml);
        $('body').append(messageElement);
        
        messageElement.hide().fadeIn(300);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            messageElement.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
        
        // Manual close
        messageElement.find('.athens-message-close').on('click', function() {
            messageElement.fadeOut(300, function() {
                $(this).remove();
            });
        });
    }
};

// Message styles (add to CSS)
var messageStyles = `
<style>
.athens-message {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    z-index: 10000;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.athens-message-success { background: #28a745; }
.athens-message-error { background: #dc3545; }
.athens-message-warning { background: #ffc107; color: #333; }
.athens-message-info { background: #17a2b8; }

.athens-message-close {
    background: none;
    border: none;
    color: inherit;
    font-size: 20px;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}
</style>
`;

$('head').append(messageStyles);
