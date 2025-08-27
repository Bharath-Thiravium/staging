<?php
/**
 * Athens Login Template
 * Client login interface for Athens Business Solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

$redirect_to = $_GET['redirect_to'] ?? '/athens-dashboard/';
?>

<div class="athens-login-container">
    <div class="athens-login-card">
        <div class="athens-login-header">
            <div class="athens-login-logo">
                <h1>ATHENS</h1>
                <p>Business Solutions</p>
            </div>
            <h2>Client Portal Login</h2>
            <p>Access your secure dashboard</p>
        </div>

        <form class="athens-login-form" method="post" action="<?php echo esc_url(site_url('wp-login.php')); ?>">
            <div class="athens-form-group">
                <label for="user_login">Username or Email</label>
                <div class="athens-input-wrapper">
                    <span class="athens-input-icon">👤</span>
                    <input type="text" 
                           id="user_login" 
                           name="log" 
                           class="athens-form-input" 
                           placeholder="Enter your username or email"
                           required>
                </div>
            </div>

            <div class="athens-form-group">
                <label for="user_pass">Password</label>
                <div class="athens-input-wrapper">
                    <span class="athens-input-icon">🔒</span>
                    <input type="password" 
                           id="user_pass" 
                           name="pwd" 
                           class="athens-form-input" 
                           placeholder="Enter your password"
                           required>
                    <button type="button" class="athens-password-toggle" onclick="togglePassword()">👁️</button>
                </div>
            </div>

            <div class="athens-form-options">
                <label class="athens-checkbox-label">
                    <input type="checkbox" name="rememberme" value="forever">
                    <span class="athens-checkbox-custom"></span>
                    Remember me
                </label>
                <a href="<?php echo wp_lostpassword_url(); ?>" class="athens-forgot-link">Forgot password?</a>
            </div>

            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>">
            <?php wp_nonce_field('login', 'login_nonce'); ?>

            <button type="submit" class="athens-login-btn">
                <span>Login to Dashboard</span>
                <span class="athens-login-arrow">→</span>
            </button>
        </form>

        <div class="athens-login-divider">
            <span>or</span>
        </div>

        <div class="athens-social-login">
            <p>Don't have an account? <a href="/contact/" class="athens-register-link">Contact us to get started</a></p>
        </div>

        <div class="athens-login-features">
            <h4>Why Choose Athens Portal?</h4>
            <div class="athens-features-grid">
                <div class="athens-feature-item">
                    <div class="athens-feature-icon">🔐</div>
                    <h5>Secure Access</h5>
                    <p>Bank-level security for your business data</p>
                </div>
                <div class="athens-feature-item">
                    <div class="athens-feature-icon">⚡</div>
                    <h5>Real-time Updates</h5>
                    <p>Instant access to your latest documents and reports</p>
                </div>
                <div class="athens-feature-item">
                    <div class="athens-feature-icon">📊</div>
                    <h5>Comprehensive Dashboard</h5>
                    <p>All your business services in one place</p>
                </div>
            </div>
        </div>

        <div class="athens-login-stats">
            <div class="athens-stat-item">
                <div class="athens-stat-icon">👥</div>
                <div class="athens-stat-content">
                    <strong>500+</strong>
                    <span>Happy Clients</span>
                </div>
            </div>
            <div class="athens-stat-item">
                <div class="athens-stat-icon">🏢</div>
                <div class="athens-stat-content">
                    <strong>1000+</strong>
                    <span>Companies Served</span>
                </div>
            </div>
            <div class="athens-stat-item">
                <div class="athens-stat-icon">💰</div>
                <div class="athens-stat-content">
                    <strong>₹50L+</strong>
                    <span>Cost Savings</span>
                </div>
            </div>
        </div>

        <div class="athens-testimonial">
            <div class="athens-testimonial-content">
                <p>"Athens Business Solutions transformed our accounting processes. The portal makes everything so easy to track!"</p>
                <div class="athens-testimonial-author">
                    <div class="athens-author-avatar">👨‍💼</div>
                    <div class="athens-author-info">
                        <strong>Rajesh Kumar</strong>
                        <span>CEO, TechStart Solutions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="athens-login-footer">
        <p>&copy; 2024 Athens Business Solutions. All rights reserved.</p>
        <div class="athens-footer-links">
            <a href="/privacy-policy/">Privacy Policy</a>
            <a href="/terms-of-service/">Terms of Service</a>
            <a href="/contact/">Support</a>
        </div>
    </div>
</div>

<style>
/* Athens Login Specific Styles */
.athens-login-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

.athens-login-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 40px;
    width: 100%;
    max-width: 500px;
    margin-bottom: 30px;
}

.athens-login-header {
    text-align: center;
    margin-bottom: 40px;
}

.athens-login-logo h1 {
    color: var(--athens-primary);
    font-size: 36px;
    font-weight: 800;
    letter-spacing: 3px;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,115,170,0.2);
}

.athens-login-logo p {
    color: var(--athens-text-light);
    font-size: 14px;
    margin: 5px 0 30px 0;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.athens-login-header h2 {
    color: var(--athens-text);
    font-size: 24px;
    margin-bottom: 10px;
}

.athens-login-header p {
    color: var(--athens-text-light);
    margin: 0;
}

.athens-form-group {
    margin-bottom: 25px;
}

.athens-form-group label {
    display: block;
    color: var(--athens-text);
    font-weight: 600;
    margin-bottom: 8px;
}

.athens-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.athens-input-icon {
    position: absolute;
    left: 15px;
    font-size: 16px;
    z-index: 2;
}

.athens-form-input {
    width: 100%;
    padding: 15px 15px 15px 50px;
    border: 2px solid var(--athens-border);
    border-radius: var(--athens-radius);
    font-size: 16px;
    transition: var(--athens-transition);
    background: white;
}

.athens-form-input:focus {
    outline: none;
    border-color: var(--athens-primary);
    box-shadow: 0 0 0 3px rgba(0,115,170,0.1);
}

.athens-password-toggle {
    position: absolute;
    right: 15px;
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    padding: 5px;
    z-index: 2;
}

.athens-form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.athens-checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 14px;
    color: var(--athens-text);
}

.athens-checkbox-label input[type="checkbox"] {
    display: none;
}

.athens-checkbox-custom {
    width: 18px;
    height: 18px;
    border: 2px solid var(--athens-border);
    border-radius: 3px;
    margin-right: 8px;
    position: relative;
    transition: var(--athens-transition);
}

.athens-checkbox-label input[type="checkbox"]:checked + .athens-checkbox-custom {
    background: var(--athens-primary);
    border-color: var(--athens-primary);
}

.athens-checkbox-label input[type="checkbox"]:checked + .athens-checkbox-custom::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.athens-forgot-link {
    color: var(--athens-primary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.athens-forgot-link:hover {
    text-decoration: underline;
}

.athens-login-btn {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, var(--athens-primary) 0%, var(--athens-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: var(--athens-radius);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--athens-transition);
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.athens-login-btn:hover {
    background: linear-gradient(135deg, var(--athens-primary-dark) 0%, #003d5c 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,115,170,0.3);
}

.athens-login-arrow {
    transition: var(--athens-transition);
}

.athens-login-btn:hover .athens-login-arrow {
    transform: translateX(5px);
}

.athens-login-divider {
    text-align: center;
    margin: 30px 0;
    position: relative;
}

.athens-login-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--athens-border);
}

.athens-login-divider span {
    background: white;
    padding: 0 20px;
    color: var(--athens-text-light);
    font-size: 14px;
}

.athens-social-login {
    text-align: center;
    margin-bottom: 40px;
}

.athens-register-link {
    color: var(--athens-primary);
    text-decoration: none;
    font-weight: 600;
}

.athens-register-link:hover {
    text-decoration: underline;
}

.athens-login-features {
    margin-bottom: 30px;
}

.athens-login-features h4 {
    text-align: center;
    color: var(--athens-text);
    margin-bottom: 20px;
}

.athens-features-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.athens-feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: var(--athens-bg-light);
    border-radius: var(--athens-radius);
}

.athens-feature-icon {
    font-size: 24px;
    width: 40px;
    text-align: center;
}

.athens-feature-item h5 {
    color: var(--athens-text);
    margin: 0 0 5px 0;
    font-size: 14px;
}

.athens-feature-item p {
    color: var(--athens-text-light);
    margin: 0;
    font-size: 12px;
}

.athens-login-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: var(--athens-bg-light);
    border-radius: var(--athens-radius);
}

.athens-stat-item {
    text-align: center;
}

.athens-stat-icon {
    font-size: 24px;
    margin-bottom: 8px;
}

.athens-stat-content strong {
    display: block;
    color: var(--athens-primary);
    font-size: 18px;
    font-weight: 700;
}

.athens-stat-content span {
    color: var(--athens-text-light);
    font-size: 12px;
}

.athens-testimonial {
    background: var(--athens-bg-light);
    padding: 25px;
    border-radius: var(--athens-radius);
    margin-bottom: 20px;
}

.athens-testimonial-content p {
    color: var(--athens-text);
    font-style: italic;
    margin-bottom: 15px;
    font-size: 14px;
}

.athens-testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.athens-author-avatar {
    font-size: 24px;
}

.athens-author-info strong {
    display: block;
    color: var(--athens-text);
    font-size: 14px;
}

.athens-author-info span {
    color: var(--athens-text-light);
    font-size: 12px;
}

.athens-login-footer {
    text-align: center;
    color: var(--athens-text-light);
    font-size: 14px;
}

.athens-footer-links {
    margin-top: 10px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.athens-footer-links a {
    color: var(--athens-primary);
    text-decoration: none;
}

.athens-footer-links a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .athens-login-card {
        padding: 30px 20px;
    }
    
    .athens-login-stats {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .athens-footer-links {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('user_pass');
    const toggleButton = document.querySelector('.athens-password-toggle');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        toggleButton.textContent = '👁️';
    }
}

// Form validation
document.querySelector('.athens-login-form').addEventListener('submit', function(e) {
    const username = document.getElementById('user_login').value.trim();
    const password = document.getElementById('user_pass').value.trim();
    
    if (!username || !password) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return false;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('.athens-login-btn');
    submitBtn.innerHTML = '<span>Logging in...</span>';
    submitBtn.disabled = true;
});
</script>
