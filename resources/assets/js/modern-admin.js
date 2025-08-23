/**
 * MUHINDO ADMIN - MODERN UI INTERACTIONS
 * Complete JavaScript for modern admin experience
 */

(function($) {
    'use strict';

    // Configuration
    const Config = {
        sidebarBreakpoint: 992,
        animationDuration: 250,
        throttleDelay: 100,
        debounceDelay: 300
    };

    // State management
    const State = {
        sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true',
        darkMode: localStorage.getItem('dark-mode') === 'true',
        isMobile: window.innerWidth < Config.sidebarBreakpoint
    };

    class ModernAdmin {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.initSidebar();
            this.initTheme();
            this.initSearch();
            this.initTables();
            this.initForms();
            this.initDropdowns();
            this.initTooltips();
            this.initAnimations();
            
            // Apply saved states
            this.applySavedStates();
            
            // Initialize components after DOM is ready
            $(document).ready(() => {
                this.enhanceComponents();
                this.showPageContent();
            });
        }

        bindEvents() {
            // Sidebar toggle
            $(document).on('click', '[data-widget="pushmenu"], .sidebar-toggle', (e) => {
                e.preventDefault();
                this.toggleSidebar();
            });

            // Theme toggle
            $(document).on('click', '.theme-toggle', (e) => {
                e.preventDefault();
                this.toggleTheme();
            });

            // Window resize handler
            $(window).on('resize', this.throttle(() => {
                this.handleResize();
            }, Config.throttleDelay));

            // Dropdown toggles
            $(document).on('click', '[data-toggle="dropdown"]', (e) => {
                e.preventDefault();
                this.toggleDropdown($(e.currentTarget));
            });

            // Close dropdowns when clicking outside
            $(document).on('click', (e) => {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu.show').removeClass('show');
                }
            });

            // Form enhancements
            $(document).on('focus', '.form-control', (e) => {
                $(e.target).closest('.form-group').addClass('focused');
            });

            $(document).on('blur', '.form-control', (e) => {
                $(e.target).closest('.form-group').removeClass('focused');
            });

            // Button loading states
            $(document).on('click', '[data-loading]', (e) => {
                this.setButtonLoading($(e.currentTarget));
            });

            // Table row selection
            $(document).on('click', '.table tbody tr', (e) => {
                if (!$(e.target).is('input, button, a')) {
                    this.selectTableRow($(e.currentTarget));
                }
            });

            // Smooth scrolling for anchor links
            $(document).on('click', 'a[href^="#"]', (e) => {
                const target = $($(e.currentTarget).attr('href'));
                if (target.length) {
                    e.preventDefault();
                    this.scrollToElement(target);
                }
            });
        }

        applySavedStates() {
            // Apply sidebar state
            if (State.sidebarCollapsed && !State.isMobile) {
                $('body').addClass('sidebar-mini');
                $('.main-sidebar').addClass('sidebar-mini');
            }

            // Apply theme state
            if (State.darkMode) {
                $('html').attr('data-theme', 'dark');
                $('.theme-toggle i').removeClass('fa-moon').addClass('fa-sun');
            }
        }

        toggleSidebar() {
            const $body = $('body');
            const $sidebar = $('.main-sidebar');
            
            if (State.isMobile) {
                // Mobile: show/hide sidebar overlay
                $sidebar.toggleClass('show');
                if ($sidebar.hasClass('show')) {
                    this.createOverlay();
                } else {
                    this.removeOverlay();
                }
            } else {
                // Desktop: collapse/expand sidebar
                const isCollapsed = $body.hasClass('sidebar-mini');
                
                $body.toggleClass('sidebar-mini');
                $sidebar.toggleClass('sidebar-mini');
                
                State.sidebarCollapsed = !isCollapsed;
                localStorage.setItem('sidebar-collapsed', State.sidebarCollapsed);
                
                // Trigger resize event for charts/tables
                setTimeout(() => {
                    $(window).trigger('resize');
                }, Config.animationDuration);
            }
        }

        toggleTheme() {
            const $html = $('html');
            const $themeIcon = $('.theme-toggle i');
            
            State.darkMode = !State.darkMode;
            
            if (State.darkMode) {
                $html.attr('data-theme', 'dark');
                $themeIcon.removeClass('fa-moon').addClass('fa-sun');
            } else {
                $html.removeAttr('data-theme');
                $themeIcon.removeClass('fa-sun').addClass('fa-moon');
            }
            
            localStorage.setItem('dark-mode', State.darkMode);
            
            // Animate the transition
            $('body').addClass('theme-transitioning');
            setTimeout(() => {
                $('body').removeClass('theme-transitioning');
            }, Config.animationDuration);
        }

        handleResize() {
            const wasIsMobile = State.isMobile;
            State.isMobile = window.innerWidth < Config.sidebarBreakpoint;
            
            // Handle mobile/desktop transitions
            if (wasIsMobile !== State.isMobile) {
                const $sidebar = $('.main-sidebar');
                const $body = $('body');
                
                if (State.isMobile) {
                    // Switched to mobile
                    $sidebar.removeClass('sidebar-mini show');
                    $body.removeClass('sidebar-mini');
                    this.removeOverlay();
                } else {
                    // Switched to desktop
                    $sidebar.removeClass('show');
                    this.removeOverlay();
                    
                    // Restore saved sidebar state
                    if (State.sidebarCollapsed) {
                        $body.addClass('sidebar-mini');
                        $sidebar.addClass('sidebar-mini');
                    }
                }
            }
        }

        createOverlay() {
            if (!$('.sidebar-overlay').length) {
                const $overlay = $('<div class="sidebar-overlay"></div>');
                $overlay.css({
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    background: 'rgba(0,0,0,0.5)',
                    zIndex: 1019,
                    opacity: 0
                });
                
                $('body').append($overlay);
                
                // Animate in
                $overlay.animate({ opacity: 1 }, Config.animationDuration);
                
                // Close on click
                $overlay.on('click', () => {
                    this.toggleSidebar();
                });
            }
        }

        removeOverlay() {
            const $overlay = $('.sidebar-overlay');
            if ($overlay.length) {
                $overlay.animate({ opacity: 0 }, Config.animationDuration, () => {
                    $overlay.remove();
                });
            }
        }

        initSidebar() {
            // Add active state to current page
            const currentPath = window.location.pathname;
            $('.nav-sidebar .nav-link').each(function() {
                const link = $(this);
                const href = link.attr('href');
                
                if (href && currentPath.includes(href)) {
                    link.addClass('active');
                    // Expand parent menu if needed
                    link.closest('.has-treeview').addClass('menu-open');
                }
            });

            // Add smooth hover effects
            $('.nav-link').on('mouseenter', function() {
                $(this).addClass('animate-slide-in');
            }).on('mouseleave', function() {
                $(this).removeClass('animate-slide-in');
            });
        }

        initTheme() {
            // Add theme toggle button to navbar if not present
            if (!$('.theme-toggle').length) {
                const $themeButton = $(`
                    <button class="theme-toggle" title="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </button>
                `);
                
                $('.navbar-nav:last').append($('<li class="nav-item"></li>').append($themeButton));
            }
        }

        initSearch() {
            // Enhanced search functionality
            const $searchInput = $('.search-input, [data-search]');
            
            $searchInput.on('input', this.debounce((e) => {
                const query = $(e.target).val().toLowerCase();
                this.filterContent(query);
            }, Config.debounceDelay));
            
            // Search suggestions
            $searchInput.on('focus', function() {
                $(this).closest('.search-form').addClass('focused');
            }).on('blur', function() {
                setTimeout(() => {
                    $(this).closest('.search-form').removeClass('focused');
                }, 200);
            });
        }

        filterContent(query) {
            const $searchableRows = $('.table tbody tr, .card, .list-group-item');
            
            $searchableRows.each(function() {
                const $row = $(this);
                const text = $row.text().toLowerCase();
                const matches = text.includes(query);
                
                $row.toggle(matches || query === '');
                
                if (matches && query !== '') {
                    $row.addClass('search-highlight');
                } else {
                    $row.removeClass('search-highlight');
                }
            });
        }

        initTables() {
            // Enhanced table functionality
            $('.table').each(function() {
                const $table = $(this);
                
                // Add sortable headers
                $table.find('th[data-sort]').addClass('sortable').on('click', function() {
                    const $th = $(this);
                    const column = $th.data('sort');
                    const direction = $th.hasClass('sort-asc') ? 'desc' : 'asc';
                    
                    // Remove sort classes from other headers
                    $table.find('th').removeClass('sort-asc sort-desc');
                    
                    // Add sort class to current header
                    $th.addClass('sort-' + direction);
                    
                    // Sort the table (basic implementation)
                    this.sortTable($table, column, direction);
                });
                
                // Add row hover effects
                $table.find('tbody tr').on('mouseenter', function() {
                    $(this).addClass('table-row-hover');
                }).on('mouseleave', function() {
                    $(this).removeClass('table-row-hover');
                });
            });
        }

        sortTable($table, column, direction) {
            const $tbody = $table.find('tbody');
            const $rows = $tbody.find('tr').get();
            const columnIndex = $table.find(`th[data-sort="${column}"]`).index();
            
            $rows.sort(function(a, b) {
                const aVal = $(a).find('td').eq(columnIndex).text().trim();
                const bVal = $(b).find('td').eq(columnIndex).text().trim();
                
                // Try to parse as numbers
                const aNum = parseFloat(aVal.replace(/[^\d.-]/g, ''));
                const bNum = parseFloat(bVal.replace(/[^\d.-]/g, ''));
                
                let result = 0;
                
                if (!isNaN(aNum) && !isNaN(bNum)) {
                    result = aNum - bNum;
                } else {
                    result = aVal.localeCompare(bVal);
                }
                
                return direction === 'desc' ? -result : result;
            });
            
            $tbody.empty().append($rows);
        }

        selectTableRow($row) {
            // Toggle row selection
            $row.toggleClass('selected');
            
            // Update selection count
            const selectedCount = $row.closest('table').find('tr.selected').length;
            this.updateSelectionCount(selectedCount);
        }

        updateSelectionCount(count) {
            let $counter = $('.selection-counter');
            
            if (count > 0) {
                if (!$counter.length) {
                    $counter = $(`
                        <div class="selection-counter animate-fade-in">
                            <span class="count">0</span> items selected
                            <button class="btn btn-sm btn-outline-primary ms-2">Actions</button>
                        </div>
                    `);
                    $('.content-header').append($counter);
                }
                $counter.find('.count').text(count);
                $counter.show();
            } else {
                $counter.hide();
            }
        }

        initForms() {
            // Auto-resize textareas
            $('.form-control[data-autoresize]').each(function() {
                this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
            }).on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            
            // Form validation visual feedback
            $('.form-control').on('blur', function() {
                const $field = $(this);
                const $group = $field.closest('.form-group');
                
                if (this.checkValidity()) {
                    $group.removeClass('has-error').addClass('has-success');
                } else {
                    $group.removeClass('has-success').addClass('has-error');
                }
            });
            
            // Custom file inputs
            $('.custom-file-input').on('change', function() {
                const fileName = $(this)[0].files[0]?.name || 'Choose file...';
                $(this).next('.custom-file-label').text(fileName);
            });
        }

        initDropdowns() {
            // Enhanced dropdown functionality
            $('.dropdown').each(function() {
                const $dropdown = $(this);
                const $menu = $dropdown.find('.dropdown-menu');
                
                // Position dropdown intelligently
                $dropdown.on('show.bs.dropdown', function() {
                    const rect = this.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    const menuHeight = $menu.outerHeight();
                    
                    if (spaceBelow < menuHeight && rect.top > menuHeight) {
                        $menu.addClass('dropdown-menu-up');
                    } else {
                        $menu.removeClass('dropdown-menu-up');
                    }
                });
            });
        }

        toggleDropdown($trigger) {
            const $dropdown = $trigger.closest('.dropdown');
            const $menu = $dropdown.find('.dropdown-menu');
            
            // Close other dropdowns
            $('.dropdown-menu.show').not($menu).removeClass('show');
            
            // Toggle current dropdown
            $menu.toggleClass('show');
        }

        initTooltips() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').each(function() {
                const $el = $(this);
                const title = $el.attr('title') || $el.data('title');
                
                if (title) {
                    $el.on('mouseenter', function(e) {
                        this.showTooltip(e, title);
                    }).on('mouseleave', function() {
                        this.hideTooltip();
                    });
                }
            });
        }

        showTooltip(e, text) {
            const $tooltip = $(`<div class="modern-tooltip">${text}</div>`);
            $('body').append($tooltip);
            
            const rect = e.target.getBoundingClientRect();
            const tooltipRect = $tooltip[0].getBoundingClientRect();
            
            const left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
            const top = rect.top - tooltipRect.height - 8;
            
            $tooltip.css({
                position: 'absolute',
                left: Math.max(8, left),
                top: Math.max(8, top),
                zIndex: 9999
            }).addClass('show');
        }

        hideTooltip() {
            $('.modern-tooltip').remove();
        }

        initAnimations() {
            // Intersection Observer for scroll animations
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            $(entry.target).addClass('animate-fade-in');
                        }
                    });
                }, { threshold: 0.1 });
                
                $('.card, .table-responsive').each(function() {
                    observer.observe(this);
                });
            }
        }

        enhanceComponents() {
            // Add loading states to buttons
            $('.btn[type="submit"], .btn[data-loading]').on('click', function() {
                const $btn = $(this);
                if (!$btn.hasClass('loading')) {
                    setTimeout(() => $btn.removeClass('loading'), 2000);
                }
            });
            
            // Enhance pagination
            $('.pagination .page-link').on('click', function(e) {
                if (!$(this).parent().hasClass('disabled')) {
                    $('.pagination .page-item.active').removeClass('active');
                    $(this).parent().addClass('active');
                }
            });
            
            // Add smooth transitions to all interactive elements
            $('.btn, .form-control, .nav-link, .card').addClass('smooth-transition');
        }

        showPageContent() {
            // Fade in page content
            $('.content-wrapper').addClass('animate-fade-in');
            
            // Remove any loading overlays
            $('.page-loading').fadeOut();
        }

        setButtonLoading($button) {
            $button.addClass('loading').prop('disabled', true);
            
            const originalText = $button.text();
            $button.data('original-text', originalText);
            
            // Auto-remove loading state after 5 seconds
            setTimeout(() => {
                this.removeButtonLoading($button);
            }, 5000);
        }

        removeButtonLoading($button) {
            $button.removeClass('loading').prop('disabled', false);
            
            const originalText = $button.data('original-text');
            if (originalText) {
                $button.text(originalText);
            }
        }

        scrollToElement($element, offset = 80) {
            $('html, body').animate({
                scrollTop: $element.offset().top - offset
            }, 500);
        }

        // Utility methods
        throttle(func, limit) {
            let lastFunc;
            let lastRan;
            return function() {
                const context = this;
                const args = arguments;
                if (!lastRan) {
                    func.apply(context, args);
                    lastRan = Date.now();
                } else {
                    clearTimeout(lastFunc);
                    lastFunc = setTimeout(function() {
                        if ((Date.now() - lastRan) >= limit) {
                            func.apply(context, args);
                            lastRan = Date.now();
                        }
                    }, limit - (Date.now() - lastRan));
                }
            };
        }

        debounce(func, wait, immediate) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }
    }

    // Initialize the modern admin
    window.ModernAdmin = ModernAdmin;
    
    // Auto-initialize when DOM is ready
    $(function() {
        window.adminInstance = new ModernAdmin();
    });

    // Global utilities
    window.showNotification = function(message, type = 'info', duration = 5000) {
        const $notification = $(`
            <div class="modern-notification modern-notification-${type} animate-slide-in">
                <div class="notification-content">
                    <i class="notification-icon fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span class="notification-message">${message}</span>
                    <button class="notification-close">×</button>
                </div>
            </div>
        `);
        
        $('.notification-container, body').first().append($notification);
        
        // Auto-remove
        setTimeout(() => {
            $notification.addClass('fade-out');
            setTimeout(() => $notification.remove(), 250);
        }, duration);
        
        // Manual close
        $notification.find('.notification-close').on('click', function() {
            $notification.addClass('fade-out');
            setTimeout(() => $notification.remove(), 250);
        });
    };

    window.showModal = function(content, title = '', options = {}) {
        const modalId = 'modern-modal-' + Date.now();
        const $modal = $(`
            <div class="modern-modal" id="${modalId}">
                <div class="modern-modal-backdrop"></div>
                <div class="modern-modal-content">
                    <div class="modern-modal-header">
                        <h3 class="modern-modal-title">${title}</h3>
                        <button class="modern-modal-close">×</button>
                    </div>
                    <div class="modern-modal-body">
                        ${content}
                    </div>
                    ${options.showFooter !== false ? `
                        <div class="modern-modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" data-confirm="modal">Confirm</button>
                        </div>
                    ` : ''}
                </div>
            </div>
        `);
        
        $('body').append($modal);
        
        // Show modal
        setTimeout(() => $modal.addClass('show'), 10);
        
        // Close handlers
        $modal.find('.modern-modal-close, [data-dismiss="modal"]').on('click', function() {
            $modal.removeClass('show');
            setTimeout(() => $modal.remove(), 250);
        });
        
        $modal.find('.modern-modal-backdrop').on('click', function() {
            if (options.closeOnBackdrop !== false) {
                $modal.removeClass('show');
                setTimeout(() => $modal.remove(), 250);
            }
        });
        
        return $modal;
    };

})(jQuery);

// Additional CSS for new components (inject into head)
const additionalCSS = `
<style>
/* Modern Tooltip */
.modern-tooltip {
    position: absolute;
    background: var(--gray-800);
    color: var(--white);
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius-md);
    font-size: 0.8125rem;
    white-space: nowrap;
    opacity: 0;
    transform: translateY(4px);
    transition: all var(--transition-fast);
    z-index: var(--z-tooltip);
    pointer-events: none;
}

.modern-tooltip.show {
    opacity: 1;
    transform: translateY(0);
}

.modern-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: var(--gray-800);
}

/* Modern Notification */
.modern-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    min-width: 300px;
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: var(--z-modal);
    transform: translateX(100%);
    transition: all var(--transition-normal);
}

.modern-notification.animate-slide-in {
    transform: translateX(0);
}

.modern-notification.fade-out {
    opacity: 0;
    transform: translateX(100%);
}

.notification-content {
    display: flex;
    align-items: center;
    padding: 1rem 1.25rem;
    gap: 0.75rem;
}

.notification-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.modern-notification-success .notification-icon {
    color: var(--success-color);
}

.modern-notification-error .notification-icon {
    color: var(--danger-color);
}

.modern-notification-info .notification-icon {
    color: var(--info-color);
}

.notification-message {
    flex: 1;
    font-weight: 500;
}

.notification-close {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: var(--gray-400);
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-close:hover {
    color: var(--gray-600);
}

/* Modern Modal */
.modern-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: var(--z-modal);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-normal);
}

.modern-modal.show {
    opacity: 1;
    visibility: visible;
}

.modern-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modern-modal-content {
    position: relative;
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.95);
    transition: all var(--transition-normal);
}

.modern-modal.show .modern-modal-content {
    transform: scale(1);
}

.modern-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
}

.modern-modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-900);
}

.modern-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--gray-400);
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all var(--transition-fast);
}

.modern-modal-close:hover {
    color: var(--gray-600);
    background: var(--gray-100);
}

.modern-modal-body {
    padding: 1.5rem;
    max-height: 400px;
    overflow-y: auto;
}

.modern-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1.5rem;
    border-top: 1px solid var(--gray-200);
    background: var(--gray-50);
}

/* Theme transition */
.theme-transitioning * {
    transition: background-color var(--transition-normal), 
                color var(--transition-normal),
                border-color var(--transition-normal) !important;
}

/* Search highlight */
.search-highlight {
    background: var(--primary-light) !important;
    animation: searchHighlight 0.3s ease;
}

@keyframes searchHighlight {
    0% { background: transparent !important; }
    50% { background: var(--primary-light) !important; }
    100% { background: var(--primary-light) !important; }
}

/* Table enhancements */
.table th.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
    padding-right: 2rem;
}

.table th.sortable::after {
    content: '↕';
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 0.8rem;
}

.table th.sort-asc::after {
    content: '↑';
    color: var(--primary-color);
}

.table th.sort-desc::after {
    content: '↓';
    color: var(--primary-color);
}

.table tbody tr.selected {
    background: var(--primary-light) !important;
}

.table-row-hover {
    transform: scale(1.01);
}

/* Selection counter */
.selection-counter {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: var(--primary-color);
    color: var(--white);
    padding: 1rem 1.5rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--card-shadow-hover);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: var(--z-sticky);
}

/* Smooth transitions */
.smooth-transition {
    transition: all var(--transition-fast);
}

/* Form enhancements */
.form-group.focused .form-label {
    color: var(--primary-color);
}

.form-group.has-success .form-control {
    border-color: var(--success-color);
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}

.form-group.has-error .form-control {
    border-color: var(--danger-color);
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
}

/* Page loading */
.page-loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: var(--z-modal);
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid var(--gray-200);
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
</style>
`;

// Inject additional CSS
$(document).ready(function() {
    $('head').append(additionalCSS);
});
