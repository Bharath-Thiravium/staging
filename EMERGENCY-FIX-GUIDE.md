# 🚨 WordPress Critical Error - Emergency Fix Guide

## Immediate Actions to Restore Your Website

---

## 🔧 **Step 1: Access Your Website Files**

### **Via FTP/File Manager:**
1. **Login to cPanel** or your hosting control panel
2. **Open File Manager** or use FTP client
3. **Navigate to your website root** directory

### **Via SSH (Advanced):**
```bash
ssh username@athenas.co.in
cd public_html/
```

---

## 🛠️ **Step 2: Enable WordPress Debug Mode**

### **Edit wp-config.php:**
1. **Locate wp-config.php** in your website root
2. **Add these lines** before `/* That's all, stop editing! */`:

```php
// Enable WordPress debugging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

3. **Save the file**
4. **Check error logs** in `/wp-content/debug.log`

---

## 🔍 **Step 3: Identify the Problem**

### **Common Causes:**
- **Plugin Conflict** - Recently installed/activated plugin
- **Theme Issue** - Theme compatibility problem
- **PHP Memory Limit** - Insufficient memory
- **File Permissions** - Incorrect file permissions
- **Corrupted Files** - Damaged WordPress files

### **Check Error Logs:**
1. **cPanel Error Logs** - Check hosting control panel
2. **WordPress Debug Log** - `/wp-content/debug.log`
3. **Server Error Logs** - Contact hosting provider

---

## 🚑 **Step 4: Quick Fixes**

### **Fix 1: Deactivate All Plugins**
```bash
# Rename plugins folder to disable all plugins
mv wp-content/plugins wp-content/plugins-disabled
```

**Or via File Manager:**
1. Go to `/wp-content/`
2. Rename `plugins` folder to `plugins-disabled`
3. Check if site loads

### **Fix 2: Switch to Default Theme**
```bash
# Rename current theme folder
mv wp-content/themes/your-theme wp-content/themes/your-theme-disabled
```

**Or via File Manager:**
1. Go to `/wp-content/themes/`
2. Rename your active theme folder
3. WordPress will switch to default theme

### **Fix 3: Increase PHP Memory Limit**

**Edit wp-config.php:**
```php
// Add this line at the top of wp-config.php
ini_set('memory_limit', '512M');
define('WP_MEMORY_LIMIT', '512M');
```

**Edit .htaccess:**
```apache
# Add this line to .htaccess
php_value memory_limit 512M
```

### **Fix 4: Check File Permissions**
```bash
# Set correct permissions
find /path/to/wordpress/ -type d -exec chmod 755 {} \;
find /path/to/wordpress/ -type f -exec chmod 644 {} \;
chmod 600 wp-config.php
```

---

## 🔄 **Step 5: Restore Website**

### **Once Site is Working:**

1. **Re-enable plugins one by one:**
   - Rename `plugins-disabled` back to `plugins`
   - Activate plugins individually
   - Test after each activation

2. **Re-enable theme:**
   - Rename theme folder back
   - Or switch theme in WordPress admin

3. **Remove debug mode:**
   - Remove debug lines from wp-config.php

---

## 🛡️ **Step 6: Safe ATHENS Page Installation**

### **Method 1: Manual Elementor Import (Safest)**

1. **Create new page in WordPress:**
   - Go to Pages → Add New
   - Title: "ATHENS - Project Highlights"
   - Publish as draft

2. **Enable Elementor:**
   - Click "Edit with Elementor"
   - Start with blank template

3. **Import sections manually:**
   - Add sections one by one
   - Copy content from HTML version
   - Style to match homepage

### **Method 2: JSON Import (If Elementor Pro)**

1. **Export homepage design:**
   - Edit homepage with Elementor
   - Export as JSON template

2. **Create ATHENS page:**
   - New page with Elementor
   - Import homepage template
   - Modify content for ATHENS

### **Method 3: Copy Existing Page**

1. **Duplicate homepage:**
   - Use plugin like "Duplicate Page"
   - Or copy page content manually

2. **Modify content:**
   - Change text to ATHENS content
   - Update images and links
   - Adjust sections as needed

---

## 📋 **Safe Installation Checklist**

### **Before Making Changes:**
- [ ] **Backup website** (files + database)
- [ ] **Test on staging site** if available
- [ ] **Check plugin compatibility**
- [ ] **Verify PHP version** (7.4+ recommended)
- [ ] **Ensure sufficient memory** (512MB+)

### **During Installation:**
- [ ] **Install one component at a time**
- [ ] **Test after each step**
- [ ] **Monitor error logs**
- [ ] **Keep debug mode enabled**
- [ ] **Have rollback plan ready**

### **After Installation:**
- [ ] **Test all functionality**
- [ ] **Check mobile responsiveness**
- [ ] **Verify page speed**
- [ ] **Disable debug mode**
- [ ] **Clear all caches**

---

## 🆘 **Emergency Contacts**

### **If You Need Help:**

1. **Hosting Provider Support:**
   - Contact your hosting company
   - They can check server logs
   - May help with file restoration

2. **WordPress Developer:**
   - Hire emergency WordPress support
   - Can fix issues remotely
   - Usually available 24/7

3. **Backup Restoration:**
   - Restore from recent backup
   - Use hosting backup service
   - Or manual file restoration

---

## 🔧 **Alternative ATHENS Page Creation**

### **Simple HTML Block Method:**

1. **Create new WordPress page**
2. **Add HTML block** in Gutenberg editor
3. **Paste ATHENS HTML content**
4. **Style with Additional CSS:**

```css
/* Add to Appearance → Customize → Additional CSS */
.athens-page {
    font-family: 'Outfit', 'Inter', sans-serif;
}

.athens-hero {
    background: linear-gradient(135deg, #6F4898 0%, #4A3B6B 100%);
    color: white;
    padding: 100px 20px;
    text-align: center;
}

.athens-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    margin: 20px 0;
    box-shadow: 0 10px 30px rgba(111,72,152,0.1);
    border-left: 4px solid #6F4898;
}
```

### **Page Builder Alternative:**

1. **Use different page builder:**
   - Beaver Builder
   - Divi Builder
   - WPBakery
   - Gutenberg blocks

2. **Create sections manually:**
   - Hero with background image
   - Text blocks for content
   - Column layouts for highlights

---

## ✅ **Recovery Verification**

### **Site is Fixed When:**
- [ ] Homepage loads without errors
- [ ] WordPress admin accessible
- [ ] All plugins working
- [ ] Theme displaying correctly
- [ ] No error messages
- [ ] Debug log is clean

### **Ready for ATHENS Page:**
- [ ] Elementor plugin active
- [ ] No plugin conflicts
- [ ] Sufficient memory
- [ ] Backup completed
- [ ] Staging environment ready

---

## 📞 **Need Immediate Help?**

**Contact Information:**
- **Hosting Support:** Check your hosting provider's emergency contact
- **WordPress Emergency:** Search for "WordPress emergency support"
- **Developer:** Contact your website developer immediately

**Temporary Solution:**
- Use the standalone HTML page at `/athens.html`
- This will work while fixing the WordPress issue
- Redirect users temporarily if needed

---

*Remember: Always backup before making changes!*
