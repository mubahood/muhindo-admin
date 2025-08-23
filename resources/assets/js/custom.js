/* Custom JavaScript fixes for Muhindo Admin - Production ready */

$(document).ready(function() {
    
    // Development mode check
    var isDev = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    function devLog(msg) {
        if (isDev) console.log('[Admin Custom]', msg);
    }
    
    devLog('Post-load verification starting...');
    
    // Verify PJAX is working properly
    if (typeof $.fn.pjax !== 'undefined') {
        // Ensure proper error handling without excessive logging
        $(document).off('pjax:error').on('pjax:error', function(xhr, textStatus, error) {
            if (isDev) console.warn('PJAX navigation failed, using fallback:', textStatus);
            // Graceful fallback to normal navigation
            if (xhr.currentTarget && xhr.currentTarget.activeElement && xhr.currentTarget.activeElement.href) {
                window.location = xhr.currentTarget.activeElement.href;
            }
        });
    }

    // Verify Bootstrap Editable is working
    if (typeof $.fn.editable !== 'undefined') {
        try {
            // Set safe defaults without logging unless there's an issue
            if (!$.fn.editable.defaults) {
                $.fn.editable.defaults = {};
            }
            
            $.fn.editable.defaults.mode = 'popup';
            $.fn.editable.defaults.emptytext = 'Empty';
            $.fn.editable.defaults.showbuttons = true;
            
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                $.fn.editable.defaults.container = 'body';
            }
        } catch (e) {
            if (isDev) console.warn('Bootstrap Editable configuration warning:', e.message);
        }
    }
    
    // Verify essential dependencies are available
    var missingDeps = [];
    
    if (typeof toastr === 'undefined') {
        missingDeps.push('toastr');
    }
    
    if (typeof Swal === 'undefined' && typeof swal === 'undefined') {
        missingDeps.push('sweetalert');
    }
    
    // SlimScroll compatibility check
    if (typeof $.fn.slimscroll === 'undefined' && typeof $.fn.slimScroll !== 'undefined') {
        $.fn.slimscroll = $.fn.slimScroll;
    } else if (typeof $.fn.slimscroll === 'undefined' && typeof $.fn.slimScroll === 'undefined') {
        // Create minimal fallback only if both are missing
        $.fn.slimscroll = $.fn.slimScroll = function(options) {
            return this.css({
                'overflow': 'auto',
                'overflow-x': 'hidden'
            });
        };
        if (isDev) missingDeps.push('slimscroll');
    }
    
    // AdminLTE4 initialization check
    if (typeof AdminLTE !== 'undefined' && typeof AdminLTE.init === 'function') {
        try {
            AdminLTE.init();
        } catch (e) {
            if (isDev) console.warn('AdminLTE initialization issue:', e.message);
        }
    }
    
    // Only report missing dependencies in development
    if (isDev && missingDeps.length > 0) {
        console.info('Optional dependencies not found (fallbacks active):', missingDeps.join(', '));
    }
    
    devLog('Verification complete - admin panel ready');

});
