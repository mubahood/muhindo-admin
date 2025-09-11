// Comprehensive JavaScript compatibility fixes for Muhindo Admin
// Runs before problematic libraries to prevent errors

(function(window) {
    'use strict';
    
    var $ = window.jQuery;

    // Fix 1: Ensure jQuery event system is properly initialized for PJAX
    if ($ && typeof $.event === 'undefined') {
        $.event = {};
    }
    if ($ && $.event && !Array.isArray($.event.props)) {
        $.event.props = [];
    }
    
    // Fix 2: Bootstrap compatibility for bootstrap-editable
    if (typeof window.bootstrap !== 'undefined') {
        var bs = window.bootstrap;
        
        // Safely add Constructor properties
        ['Modal', 'Tooltip', 'Popover'].forEach(function(component) {
            if (bs[component] && !bs[component].Constructor) {
                bs[component].Constructor = bs[component];
            }
        });
        
        // Create Bootstrap 3 style reference for compatibility
        if (!window.Bootstrap) {
            window.Bootstrap = bs;
        }
    } else {
        // Create minimal Bootstrap object for compatibility
        var minimalBootstrap = {};
        ['Modal', 'Tooltip', 'Popover'].forEach(function(component) {
            minimalBootstrap[component] = function() { return {}; };
            minimalBootstrap[component].Constructor = minimalBootstrap[component];
        });
        
        window.bootstrap = minimalBootstrap;
        window.Bootstrap = minimalBootstrap;
    }
    
    // Fix 3: PJAX defaults initialization
    function ensurePjaxDefaults() {
        if ($ && $.pjax && !$.pjax.defaults) {
            $.pjax.defaults = {
                timeout: 5000,
                maxCacheLength: 0,
                push: true,
                replace: false
            };
        }
    }
    
    // Fix 4: Global error suppression for known issues
    var originalOnError = window.onerror;
    window.onerror = function(msg, url, line, col, error) {
        // Suppress known bootstrap-editable constructor errors
        if (msg && msg.includes('Cannot read properties of undefined') && 
            msg.includes('Constructor') && url && url.includes('bootstrap-editable')) {
            return true; // Prevent default error handling
        }
        
        // Call original error handler if it exists
        if (originalOnError) {
            return originalOnError.apply(this, arguments);
        }
        return false;
    };
    
    // Fix 5: Initialize when DOM is ready
    $(document).ready(function() {
        // Small delay to ensure all scripts are loaded
        setTimeout(function() {
            ensurePjaxDefaults();
            
            // Ensure toastr exists for laravel-admin.js
            if (typeof window.toastr === 'undefined') {
                window.toastr = {
                    success: function(msg) { /* Silent success */ },
                    error: function(msg) { console.error('Error:', msg); },
                    warning: function(msg) { /* Silent warning */ },
                    info: function(msg) { /* Silent info */ }
                };
            }
        }, 50);
    });
    
})(window);
