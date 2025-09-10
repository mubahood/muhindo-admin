# Muhindo Admin Development Guide

## 🚀 Real-Time Asset Development Setup

This guide shows you how to set up the development environment so that changes to package assets (CSS, JS) are immediately reflected in your test Laravel application.

## 📋 Quick Setup

### 1. **Use the Development Script (Recommended)**

```bash
# Set up development mode (symlinks)
./dev-setup.sh dev

# Check current status
./dev-setup.sh status

# Switch to production mode (published assets)
./dev-setup.sh prod
```

### 2. **Manual Setup**

```bash
# Remove published assets
cd /Applications/MAMP/htdocs/muhindo-admin-testapp
rm -rf public/vendor/muhindo-admin

# Create symlink to package source
ln -s /Applications/MAMP/htdocs/muhindo-admin/resources/assets public/vendor/muhindo-admin
```

## 🔧 Development Workflow

### **Development Mode** (Real-time changes)
- ✅ **Assets**: Symlinked to `resources/assets`
- ✅ **CSS Changes**: Immediately visible on refresh
- ✅ **JS Changes**: Immediately available
- ✅ **New Assets**: Available instantly
- ⚠️ **Performance**: Slightly slower (no minification)

### **Production Mode** (Cached assets)
- 📦 **Assets**: Published to `public/vendor/muhindo-admin`
- 📝 **CSS Changes**: Requires republishing
- 📝 **JS Changes**: Requires republishing
- ✅ **Performance**: Optimized and cached

## 🧪 Testing Real-Time Changes

### Test CSS Changes:
1. Edit `/Applications/MAMP/htdocs/muhindo-admin/resources/assets/muhindo-core/main.css`
2. Add a test style:
   ```css
   .test-development-mode {
       background-color: #ff6b6b !important;
       color: white !important;
       padding: 10px !important;
   }
   ```
3. Refresh your browser - changes appear immediately!

### Test JS Changes:
1. Edit `/Applications/MAMP/htdocs/muhindo-admin/resources/assets/laravel-admin/laravel-admin.js`
2. Add a console log at the top:
   ```javascript
   console.log('🔥 Development mode active - JS changes work!');
   ```
3. Refresh browser and check console

## 🌐 URLs

- **Test App**: http://localhost:8888/muhindo-admin-testapp/public/
- **Assets Base**: http://localhost:8888/muhindo-admin-testapp/public/vendor/muhindo-admin/
- **CSS File**: http://localhost:8888/muhindo-admin-testapp/public/vendor/muhindo-admin/muhindo-core/main.css

## 🔄 Switching Between Modes

### Enable Development Mode:
```bash
./dev-setup.sh dev
```

### Enable Production Mode:
```bash
./dev-setup.sh prod
```

### Check Current Mode:
```bash
./dev-setup.sh status
```

## 📁 Directory Structure

```
muhindo-admin/                          # Package directory
├── resources/assets/                   # Source assets (edit these)
│   ├── muhindo-core/main.css          # Custom AdminLTE styles
│   ├── font-awesome-6.4.2/            # Font Awesome assets
│   ├── bootstrap5/                     # Bootstrap 5 assets
│   └── laravel-admin/laravel-admin.js  # Main JavaScript
├── dev-setup.sh                       # Development setup script
└── config/admin.php                   # Configuration

muhindo-admin-testapp/                  # Test Laravel app
└── public/vendor/muhindo-admin/        # Symlinked to source assets
```

## 🐛 Troubleshooting

### Assets Not Loading?
```bash
# Check symlink status
./dev-setup.sh status

# Recreate symlink
./dev-setup.sh dev
```

### Changes Not Appearing?
1. **Hard refresh** browser (Cmd+Shift+R / Ctrl+Shift+R)
2. **Clear browser cache**
3. **Check file permissions**: `ls -la public/vendor/muhindo-admin`

### Switch to Production for Testing:
```bash
# Test with published assets
./dev-setup.sh prod

# Switch back to development
./dev-setup.sh dev
```

## ⚡ Pro Tips

1. **Browser DevTools**: Use "Disable cache" in Network tab during development
2. **Hot Reloading**: Consider using Laravel Vite for even faster asset reloading
3. **Version Control**: The symlink is ignored in git, safe for commits
4. **Multiple Projects**: Script works with any Laravel app path

## 🎯 Benefits

- ⚡ **Instant feedback** on CSS/JS changes
- 🔄 **No republishing** required during development
- 🛠️ **Easy switching** between dev/prod modes
- 📊 **Status monitoring** with built-in script
- 🔧 **Automated setup** with single command
