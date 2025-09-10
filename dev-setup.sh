#!/bin/bash

# Muhindo Admin Development Setup Script
# This script sets up the development environment for real-time asset changes

set -e

echo "🚀 Setting up Muhindo Admin Development Environment..."

# Configuration
PACKAGE_PATH="/Applications/MAMP/htdocs/muhindo-admin"
TEST_APP_PATH="/Applications/MAMP/htdocs/muhindo-admin-testapp"
ASSETS_SOURCE="$PACKAGE_PATH/resources/assets"
ASSETS_TARGET="$TEST_APP_PATH/public/vendor/muhindo-admin"

# Function to display usage
usage() {
    echo "Usage: $0 [command]"
    echo ""
    echo "Commands:"
    echo "  dev       - Set up development symlinks (default)"
    echo "  prod      - Switch to production published assets"
    echo "  status    - Show current setup status"
    echo "  help      - Show this help message"
    echo ""
    exit 1
}

# Function to set up development symlinks
setup_dev() {
    echo "📁 Setting up development symlinks..."
    
    # Remove existing assets if they exist
    if [ -e "$ASSETS_TARGET" ]; then
        echo "🗑️  Removing existing assets..."
        rm -rf "$ASSETS_TARGET"
    fi
    
    # Create vendor directory if it doesn't exist
    mkdir -p "$(dirname "$ASSETS_TARGET")"
    
    # Create symlink
    echo "🔗 Creating symlink: $ASSETS_TARGET -> $ASSETS_SOURCE"
    ln -s "$ASSETS_SOURCE" "$ASSETS_TARGET"
    
    echo "✅ Development setup complete!"
    echo "📝 Changes to package assets will now be reflected immediately in the test app"
    echo ""
    echo "🌐 Test URL: http://localhost:8888/muhindo-admin-testapp/public/"
    echo "📂 Assets URL: http://localhost:8888/muhindo-admin-testapp/public/vendor/muhindo-admin/"
}

# Function to set up production assets
setup_prod() {
    echo "📦 Setting up production published assets..."
    
    # Remove symlink if it exists
    if [ -L "$ASSETS_TARGET" ]; then
        echo "🗑️  Removing development symlink..."
        rm "$ASSETS_TARGET"
    elif [ -d "$ASSETS_TARGET" ]; then
        echo "🗑️  Removing existing assets directory..."
        rm -rf "$ASSETS_TARGET"
    fi
    
    # Publish assets using Laravel artisan
    echo "📋 Publishing assets..."
    cd "$TEST_APP_PATH"
    php artisan vendor:publish --provider="Muhindo\\Admin\\AdminServiceProvider" --tag=muhindo-admin-assets --force
    
    echo "✅ Production setup complete!"
    echo "📝 Assets are now published and cached"
}

# Function to show current status
show_status() {
    echo "📊 Current Development Setup Status:"
    echo ""
    
    if [ -L "$ASSETS_TARGET" ]; then
        echo "🔗 Status: DEVELOPMENT MODE (symlinked)"
        echo "📂 Symlink: $ASSETS_TARGET"
        echo "🎯 Points to: $(readlink "$ASSETS_TARGET")"
        echo "✅ Real-time asset changes: ENABLED"
    elif [ -d "$ASSETS_TARGET" ]; then
        echo "📦 Status: PRODUCTION MODE (published)"
        echo "📂 Directory: $ASSETS_TARGET"
        echo "⚠️  Real-time asset changes: DISABLED"
        echo "📝 Run '$0 dev' to enable real-time changes"
    else
        echo "❌ Status: NOT CONFIGURED"
        echo "📝 Run '$0 dev' to set up development mode"
    fi
    
    echo ""
    echo "🌐 Test URLs:"
    echo "   App: http://localhost:8888/muhindo-admin-testapp/public/"
    echo "   Assets: http://localhost:8888/muhindo-admin-testapp/public/vendor/muhindo-admin/"
}

# Main script logic
case "${1:-dev}" in
    "dev"|"development")
        setup_dev
        ;;
    "prod"|"production")
        setup_prod
        ;;
    "status")
        show_status
        ;;
    "help"|"-h"|"--help")
        usage
        ;;
    *)
        echo "❌ Unknown command: $1"
        usage
        ;;
esac
