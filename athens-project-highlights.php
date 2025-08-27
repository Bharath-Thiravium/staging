<?php
/**
 * ATHENS Project Highlights Page
 * 10 Key Project Highlights with Homepage Styling
 */

// Security check
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
    require_once('wp-load.php');
}

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>ATHENS - 10 Key Project Highlights | Athens Business Solutions</title>";
echo "<meta name='description' content='Discover 10 revolutionary project highlights of ATHENS platform. Complete safety management, AI-powered intelligence, real-time notifications, and enterprise solutions.'>";

// Copy homepage styles
echo "<style>
/* ATHENS Project Highlights - Homepage Style */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    line-height: 1.6;
    color: #333;
    background: #f8f9fa;
}

.athens-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header Section */
.athens-header {
    background: linear-gradient(135deg, #0073aa 0%, #005177 50%, #003d5c 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.athens-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grid\" width=\"10\" height=\"10\" patternUnits=\"userSpaceOnUse\"><path d=\"M 10 0 L 0 0 0 10\" fill=\"none\" stroke=\"rgba(255,255,255,0.1)\" stroke-width=\"0.5\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grid)\"/></svg>');
    opacity: 0.3;
}

.athens-header-content {
    position: relative;
    z-index: 2;
}

.athens-logo {
    font-size: 4rem;
    font-weight: 900;
    letter-spacing: 8px;
    margin-bottom: 20px;
    text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    background: linear-gradient(45deg, #fff, #e3f2fd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.athens-subtitle {
    font-size: 1.5rem;
    margin-bottom: 30px;
    opacity: 0.95;
    font-weight: 300;
}

.athens-highlight-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    border: 2px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(10px);
}

/* Main Content */
.athens-main {
    padding: 80px 0;
}

.athens-intro {
    text-align: center;
    margin-bottom: 80px;
}

.athens-intro h2 {
    font-size: 3rem;
    color: #0073aa;
    margin-bottom: 20px;
    font-weight: 700;
}

.athens-intro p {
    font-size: 1.2rem;
    color: #666;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

/* Highlights Grid */
.athens-highlights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 40px;
    margin-bottom: 80px;
}

.athens-highlight-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid #e1e5e9;
    position: relative;
    overflow: hidden;
}

.athens-highlight-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #0073aa, #28a745, #17a2b8);
}

.athens-highlight-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.athens-highlight-number {
    display: inline-block;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #0073aa, #005177);
    color: white;
    border-radius: 50%;
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,115,170,0.3);
}

.athens-highlight-icon {
    width: 80px;
    height: 80px;
    margin: 20px auto;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.athens-highlight-title {
    font-size: 1.5rem;
    color: #0073aa;
    margin-bottom: 20px;
    font-weight: 700;
}

.athens-highlight-content {
    color: #555;
    line-height: 1.8;
}

.athens-highlight-content p {
    margin-bottom: 15px;
}

.athens-highlight-content strong {
    color: #0073aa;
    font-weight: 600;
}

/* Stats Section */
.athens-stats {
    background: linear-gradient(135deg, #0073aa 0%, #005177 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.athens-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    margin-top: 50px;
}

.athens-stat-item {
    padding: 30px;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.athens-stat-number {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 10px;
    background: linear-gradient(45deg, #fff, #e3f2fd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.athens-stat-label {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* CTA Section */
.athens-cta {
    background: #f8f9fa;
    padding: 80px 0;
    text-align: center;
}

.athens-cta h2 {
    font-size: 2.5rem;
    color: #0073aa;
    margin-bottom: 30px;
}

.athens-cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 40px;
}

.athens-btn {
    display: inline-block;
    padding: 18px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.athens-btn-primary {
    background: linear-gradient(135deg, #0073aa, #005177);
    color: white;
    box-shadow: 0 4px 15px rgba(0,115,170,0.3);
}

.athens-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,115,170,0.4);
    color: white;
}

.athens-btn-secondary {
    background: transparent;
    color: #0073aa;
    border-color: #0073aa;
}

.athens-btn-secondary:hover {
    background: #0073aa;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .athens-logo {
        font-size: 2.5rem;
        letter-spacing: 4px;
    }
    
    .athens-intro h2 {
        font-size: 2rem;
    }
    
    .athens-highlights-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .athens-highlight-card {
        padding: 30px 20px;
    }
    
    .athens-stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .athens-cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.athens-highlight-card {
    animation: fadeInUp 0.6s ease forwards;
}

.athens-highlight-card:nth-child(even) {
    animation-delay: 0.2s;
}

.athens-highlight-card:nth-child(odd) {
    animation-delay: 0.1s;
}
</style>";

echo "</head>";
echo "<body>";

// Header Section
echo "<header class='athens-header'>";
echo "<div class='athens-container'>";
echo "<div class='athens-header-content'>";
echo "<h1 class='athens-logo'>ATHENS</h1>";
echo "<p class='athens-subtitle'>Revolutionary Safety Management Platform</p>";
echo "<div class='athens-highlight-badge'>🚀 10 KEY PROJECT HIGHLIGHTS</div>";
echo "</div>";
echo "</div>";
echo "</header>";

// Main Content
echo "<main class='athens-main'>";
echo "<div class='athens-container'>";

// Introduction
echo "<section class='athens-intro'>";
echo "<h2>Transform Your Safety Operations</h2>";
echo "<p>Discover the revolutionary features that make ATHENS the most comprehensive safety management platform. From AI-powered intelligence to real-time notifications, experience the future of workplace safety.</p>";
echo "</section>";

// Highlights Grid
echo "<section class='athens-highlights-grid'>";

// Highlight 1
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>1</div>";
echo "<div class='athens-highlight-icon'>🏢</div>";
echo "<h3 class='athens-highlight-title'>Complete Safety Management Platform</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Transform your entire safety operations</strong> with 10 integrated modules in one system.</p>";
echo "<p>Eliminate multiple software costs and streamline all safety processes.</p>";
echo "<p>Get real-time visibility across incidents, permits, training, and compliance.</p>";
echo "</div>";
echo "</div>";

// Highlight 2
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>2</div>";
echo "<div class='athens-highlight-icon'>🤖</div>";
echo "<h3 class='athens-highlight-title'>AI-Powered Intelligence System</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Ask questions in plain English</strong> and get instant answers from your safety data.</p>";
echo "<p>Reduce report generation time from hours to minutes with smart automation.</p>";
echo "<p>Predict safety risks before they become incidents using advanced analytics.</p>";
echo "</div>";
echo "</div>";

// Highlight 3
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>3</div>";
echo "<div class='athens-highlight-icon'>🔔</div>";
echo "<h3 class='athens-highlight-title'>Real-Time Notification System</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Critical incidents reach the right people</strong> in under 3 seconds automatically.</p>";
echo "<p>Never miss important safety alerts with smart routing and escalation.</p>";
echo "<p>Improve emergency response times by 85% with instant communication.</p>";
echo "</div>";
echo "</div>";

// Highlight 4
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>4</div>";
echo "<div class='athens-highlight-icon'>🔧</div>";
echo "<h3 class='athens-highlight-title'>8D Problem Solving Methodology</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Solve complex safety problems systematically</strong> using industry-proven methods.</p>";
echo "<p>Reduce incident recurrence by 75% with structured root cause analysis.</p>";
echo "<p>Track corrective actions from identification to completion automatically.</p>";
echo "</div>";
echo "</div>";

// Highlight 5
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>5</div>";
echo "<div class='athens-highlight-icon'>📱</div>";
echo "<h3 class='athens-highlight-title'>Mobile-First Design</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Field workers can report incidents</strong> and access permits from any device.</p>";
echo "<p>Photo capture and GPS location tracking work seamlessly on mobile.</p>";
echo "<p>95% of users become productive within 30 days with intuitive interface.</p>";
echo "</div>";
echo "</div>";

// Highlight 6
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>6</div>";
echo "<div class='athens-highlight-icon'>📋</div>";
echo "<h3 class='athens-highlight-title'>Advanced Permit Management</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Manage 26 different permit types</strong> with automated approval workflows.</p>";
echo "<p>Generate QR codes for instant mobile access to work permits.</p>";
echo "<p>Reduce permit processing time by 60% with digital signatures.</p>";
echo "</div>";
echo "</div>";

// Highlight 7
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>7</div>";
echo "<div class='athens-highlight-icon'>👤</div>";
echo "<h3 class='athens-highlight-title'>Face Recognition Technology</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Verify worker attendance automatically</strong> using advanced face recognition.</p>";
echo "<p>Eliminate buddy punching and ensure accurate workforce tracking.</p>";
echo "<p>Integrate seamlessly with existing worker management systems.</p>";
echo "</div>";
echo "</div>";

// Highlight 8
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>8</div>";
echo "<div class='athens-highlight-icon'>🔒</div>";
echo "<h3 class='athens-highlight-title'>Enterprise Security & Compliance</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Meet ISO 45001, OSHA, and GDPR requirements</strong> with built-in compliance.</p>";
echo "<p>Role-based access ensures only authorized users see sensitive data.</p>";
echo "<p>Complete audit trails track every action for regulatory reporting.</p>";
echo "</div>";
echo "</div>";

// Highlight 9
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>9</div>";
echo "<div class='athens-highlight-icon'>💰</div>";
echo "<h3 class='athens-highlight-title'>Cost-Effective Solution</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Save 40% compared to competitors</strong> with no hidden fees or surprise charges.</p>";
echo "<p>Achieve 300% ROI within 6 months through operational efficiency gains.</p>";
echo "<p>Eliminate multiple software licenses by consolidating into one platform.</p>";
echo "</div>";
echo "</div>";

// Highlight 10
echo "<div class='athens-highlight-card'>";
echo "<div class='athens-highlight-number'>10</div>";
echo "<div class='athens-highlight-icon'>⚡</div>";
echo "<h3 class='athens-highlight-title'>Rapid 30-Day Implementation</h3>";
echo "<div class='athens-highlight-content'>";
echo "<p><strong>Go live in 30 days</strong> with zero downtime migration from existing systems.</p>";
echo "<p>Get 24/7 expert support and dedicated success manager included.</p>";
echo "<p>Start seeing measurable results within the first week of deployment.</p>";
echo "</div>";
echo "</div>";

echo "</section>";

// Stats Section
echo "<section class='athens-stats'>";
echo "<div class='athens-container'>";
echo "<h2>ATHENS by the Numbers</h2>";
echo "<div class='athens-stats-grid'>";
echo "<div class='athens-stat-item'>";
echo "<div class='athens-stat-number'>85%</div>";
echo "<div class='athens-stat-label'>Faster Emergency Response</div>";
echo "</div>";
echo "<div class='athens-stat-item'>";
echo "<div class='athens-stat-number'>75%</div>";
echo "<div class='athens-stat-label'>Reduced Incident Recurrence</div>";
echo "</div>";
echo "<div class='athens-stat-item'>";
echo "<div class='athens-stat-number'>60%</div>";
echo "<div class='athens-stat-label'>Faster Permit Processing</div>";
echo "</div>";
echo "<div class='athens-stat-item'>";
echo "<div class='athens-stat-number'>300%</div>";
echo "<div class='athens-stat-label'>ROI Within 6 Months</div>";
echo "</div>";
echo "<div class='athens-stat-item'>";
echo "<div class='athens-stat-number'>30</div>";
echo "<div class='athens-stat-label'>Days to Full Implementation</div>";
echo "</div>";
echo "<div class='athens-stat-item'>";
echo "<div class='athens-stat-number'>40%</div>";
echo "<div class='athens-stat-label'>Cost Savings vs Competitors</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</section>";

// CTA Section
echo "<section class='athens-cta'>";
echo "<div class='athens-container'>";
echo "<h2>Ready to Transform Your Safety Operations?</h2>";
echo "<p>Join hundreds of companies already using ATHENS to revolutionize their safety management.</p>";
echo "<div class='athens-cta-buttons'>";
echo "<a href='/contact/' class='athens-btn athens-btn-primary'>Get Started Today</a>";
echo "<a href='/athens-portal/' class='athens-btn athens-btn-secondary'>View Demo</a>";
echo "</div>";
echo "</div>";
echo "</section>";

echo "</div>";
echo "</main>";

// Add navigation back to main site
echo "<footer style='background:#333;color:white;padding:40px 0;text-align:center;'>";
echo "<div class='athens-container'>";
echo "<p>&copy; 2024 Athens Business Solutions. All rights reserved.</p>";
echo "<div style='margin-top:20px;'>";
echo "<a href='/' style='color:#0073aa;text-decoration:none;margin:0 15px;'>← Back to Homepage</a>";
echo "<a href='/contact/' style='color:#0073aa;text-decoration:none;margin:0 15px;'>Contact Us</a>";
echo "<a href='/athens-portal/' style='color:#0073aa;text-decoration:none;margin:0 15px;'>Client Portal</a>";
echo "</div>";
echo "</div>";
echo "</footer>";

echo "</body>";
echo "</html>";

// Also create as WordPress page
if (function_exists('wp_insert_post')) {
    $existing_page = get_page_by_path('athens');
    if (!$existing_page) {
        $page_content = '
        <div class="athens-project-page">
            <style>
            .athens-project-page { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
            .athens-hero { background: linear-gradient(135deg, #0073aa 0%, #005177 100%); color: white; padding: 80px 40px; text-align: center; border-radius: 20px; margin-bottom: 40px; }
            .athens-hero h1 { font-size: 4rem; font-weight: 900; letter-spacing: 8px; margin-bottom: 20px; }
            .athens-hero p { font-size: 1.5rem; margin-bottom: 30px; opacity: 0.95; }
            .athens-badge { display: inline-block; background: rgba(255,255,255,0.2); padding: 12px 30px; border-radius: 50px; font-weight: 600; }
            .athens-highlights { display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 30px; margin: 40px 0; }
            .athens-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 4px solid #0073aa; }
            .athens-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); transition: all 0.3s ease; }
            .athens-number { width: 60px; height: 60px; background: linear-gradient(135deg, #0073aa, #005177); color: white; border-radius: 50%; font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
            .athens-icon { width: 80px; height: 80px; margin: 20px auto; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; }
            .athens-title { font-size: 1.5rem; color: #0073aa; margin-bottom: 20px; font-weight: 700; }
            .athens-content { color: #555; line-height: 1.8; }
            .athens-content p { margin-bottom: 15px; }
            .athens-content strong { color: #0073aa; font-weight: 600; }
            .athens-stats { background: linear-gradient(135deg, #0073aa 0%, #005177 100%); color: white; padding: 60px 40px; text-align: center; border-radius: 20px; margin: 40px 0; }
            .athens-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 30px; margin-top: 40px; }
            .athens-stat { padding: 20px; background: rgba(255,255,255,0.1); border-radius: 15px; }
            .athens-stat-number { font-size: 2.5rem; font-weight: 900; margin-bottom: 10px; }
            .athens-cta { text-align: center; padding: 60px 40px; background: #f8f9fa; border-radius: 20px; margin: 40px 0; }
            .athens-btn { display: inline-block; padding: 18px 40px; border-radius: 50px; text-decoration: none; font-weight: 600; margin: 10px; background: linear-gradient(135deg, #0073aa, #005177); color: white; }
            .athens-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,115,170,0.4); color: white; }
            @media (max-width: 768px) { .athens-hero h1 { font-size: 2.5rem; letter-spacing: 4px; } .athens-highlights { grid-template-columns: 1fr; } }
            </style>

            <div class="athens-hero">
                <h1>ATHENS</h1>
                <p>Revolutionary Safety Management Platform</p>
                <div class="athens-badge">🚀 10 KEY PROJECT HIGHLIGHTS</div>
            </div>

            <div class="athens-highlights">
                <div class="athens-card">
                    <div class="athens-number">1</div>
                    <div class="athens-icon">🏢</div>
                    <h3 class="athens-title">Complete Safety Management Platform</h3>
                    <div class="athens-content">
                        <p><strong>Transform your entire safety operations</strong> with 10 integrated modules in one system.</p>
                        <p>Eliminate multiple software costs and streamline all safety processes.</p>
                        <p>Get real-time visibility across incidents, permits, training, and compliance.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">2</div>
                    <div class="athens-icon">🤖</div>
                    <h3 class="athens-title">AI-Powered Intelligence System</h3>
                    <div class="athens-content">
                        <p><strong>Ask questions in plain English</strong> and get instant answers from your safety data.</p>
                        <p>Reduce report generation time from hours to minutes with smart automation.</p>
                        <p>Predict safety risks before they become incidents using advanced analytics.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">3</div>
                    <div class="athens-icon">🔔</div>
                    <h3 class="athens-title">Real-Time Notification System</h3>
                    <div class="athens-content">
                        <p><strong>Critical incidents reach the right people</strong> in under 3 seconds automatically.</p>
                        <p>Never miss important safety alerts with smart routing and escalation.</p>
                        <p>Improve emergency response times by 85% with instant communication.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">4</div>
                    <div class="athens-icon">🔧</div>
                    <h3 class="athens-title">8D Problem Solving Methodology</h3>
                    <div class="athens-content">
                        <p><strong>Solve complex safety problems systematically</strong> using industry-proven methods.</p>
                        <p>Reduce incident recurrence by 75% with structured root cause analysis.</p>
                        <p>Track corrective actions from identification to completion automatically.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">5</div>
                    <div class="athens-icon">📱</div>
                    <h3 class="athens-title">Mobile-First Design</h3>
                    <div class="athens-content">
                        <p><strong>Field workers can report incidents</strong> and access permits from any device.</p>
                        <p>Photo capture and GPS location tracking work seamlessly on mobile.</p>
                        <p>95% of users become productive within 30 days with intuitive interface.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">6</div>
                    <div class="athens-icon">📋</div>
                    <h3 class="athens-title">Advanced Permit Management</h3>
                    <div class="athens-content">
                        <p><strong>Manage 26 different permit types</strong> with automated approval workflows.</p>
                        <p>Generate QR codes for instant mobile access to work permits.</p>
                        <p>Reduce permit processing time by 60% with digital signatures.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">7</div>
                    <div class="athens-icon">👤</div>
                    <h3 class="athens-title">Face Recognition Technology</h3>
                    <div class="athens-content">
                        <p><strong>Verify worker attendance automatically</strong> using advanced face recognition.</p>
                        <p>Eliminate buddy punching and ensure accurate workforce tracking.</p>
                        <p>Integrate seamlessly with existing worker management systems.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">8</div>
                    <div class="athens-icon">🔒</div>
                    <h3 class="athens-title">Enterprise Security & Compliance</h3>
                    <div class="athens-content">
                        <p><strong>Meet ISO 45001, OSHA, and GDPR requirements</strong> with built-in compliance.</p>
                        <p>Role-based access ensures only authorized users see sensitive data.</p>
                        <p>Complete audit trails track every action for regulatory reporting.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">9</div>
                    <div class="athens-icon">💰</div>
                    <h3 class="athens-title">Cost-Effective Solution</h3>
                    <div class="athens-content">
                        <p><strong>Save 40% compared to competitors</strong> with no hidden fees or surprise charges.</p>
                        <p>Achieve 300% ROI within 6 months through operational efficiency gains.</p>
                        <p>Eliminate multiple software licenses by consolidating into one platform.</p>
                    </div>
                </div>

                <div class="athens-card">
                    <div class="athens-number">10</div>
                    <div class="athens-icon">⚡</div>
                    <h3 class="athens-title">Rapid 30-Day Implementation</h3>
                    <div class="athens-content">
                        <p><strong>Go live in 30 days</strong> with zero downtime migration from existing systems.</p>
                        <p>Get 24/7 expert support and dedicated success manager included.</p>
                        <p>Start seeing measurable results within the first week of deployment.</p>
                    </div>
                </div>
            </div>

            <div class="athens-stats">
                <h2>ATHENS by the Numbers</h2>
                <div class="athens-stats-grid">
                    <div class="athens-stat">
                        <div class="athens-stat-number">85%</div>
                        <div>Faster Emergency Response</div>
                    </div>
                    <div class="athens-stat">
                        <div class="athens-stat-number">75%</div>
                        <div>Reduced Incident Recurrence</div>
                    </div>
                    <div class="athens-stat">
                        <div class="athens-stat-number">60%</div>
                        <div>Faster Permit Processing</div>
                    </div>
                    <div class="athens-stat">
                        <div class="athens-stat-number">300%</div>
                        <div>ROI Within 6 Months</div>
                    </div>
                    <div class="athens-stat">
                        <div class="athens-stat-number">30</div>
                        <div>Days to Implementation</div>
                    </div>
                    <div class="athens-stat">
                        <div class="athens-stat-number">40%</div>
                        <div>Cost Savings</div>
                    </div>
                </div>
            </div>

            <div class="athens-cta">
                <h2>Ready to Transform Your Safety Operations?</h2>
                <p>Join hundreds of companies already using ATHENS to revolutionize their safety management.</p>
                <a href="/contact/" class="athens-btn">Get Started Today</a>
                <a href="/athens-portal/" class="athens-btn">View Demo</a>
            </div>
        </div>';

        $page_id = wp_insert_post(array(
            'post_title' => 'ATHENS',
            'post_content' => $page_content,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'athens'
        ));

        if ($page_id) {
            update_post_meta($page_id, 'rank_math_title', 'ATHENS - 10 Key Project Highlights | Athens Business Solutions');
            update_post_meta($page_id, 'rank_math_description', 'Discover 10 revolutionary project highlights of ATHENS platform. Complete safety management, AI-powered intelligence, real-time notifications, and enterprise solutions.');
            update_post_meta($page_id, 'rank_math_focus_keyword', 'athens project highlights');
        }
    }
}
?>
