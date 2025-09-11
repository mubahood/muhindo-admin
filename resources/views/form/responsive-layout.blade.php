{{-- Responsive Form Layout Component --}}
{{-- Usage: @include('admin::form.responsive-layout', ['layout' => 'stack', 'breakpoint' => 'md', 'columns' => 2]) --}}

@php
$layout = $layout ?? 'auto'; // auto, stack, grid, columns
$breakpoint = $breakpoint ?? 'md'; // sm, md, lg, xl
$columns = $columns ?? 2;
$spacing = $spacing ?? 3; // 1-5 for spacing levels
$mobileStack = $mobileStack ?? true;
$formId = $formId ?? 'responsive-form-' . Str::random(6);
$showFieldLabels = $showFieldLabels ?? true;
$compactMode = $compactMode ?? false;
$stickyActions = $stickyActions ?? false;
@endphp

<div class="responsive-form-layout {{ $layout }}-layout {{ $compactMode ? 'compact-mode' : '' }}" 
     id="{{ $formId }}"
     data-layout="{{ $layout }}"
     data-breakpoint="{{ $breakpoint }}"
     data-columns="{{ $columns }}"
     data-mobile-stack="{{ $mobileStack ? 'true' : 'false' }}">

    {{-- Form Layout Container --}}
    <div class="form-layout-container">
        
        {{-- Form Header Section --}}
        @if(isset($header))
        <div class="form-header-section">
            <div class="form-header-content">
                @if(isset($header['title']))
                <h3 class="form-title">{{ $header['title'] }}</h3>
                @endif
                
                @if(isset($header['description']))
                <p class="form-description">{{ $header['description'] }}</p>
                @endif
                
                @if(isset($header['actions']))
                <div class="form-header-actions">
                    @foreach($header['actions'] as $action)
                    <button type="{{ $action['type'] ?? 'button' }}" 
                            class="btn {{ $action['class'] ?? 'btn-secondary' }} btn-sm">
                        @if(isset($action['icon']))
                        <i class="{{ $action['icon'] }} me-1"></i>
                        @endif
                        {{ $action['label'] }}
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Form Content --}}
        <div class="form-content-section">
            {{-- Progress Indicator (if provided) --}}
            @if(isset($progress))
            <div class="form-progress-section mb-4">
                <div class="progress form-progress-bar">
                    <div class="progress-bar bg-primary" 
                         role="progressbar" 
                         style="width: {{ $progress['percentage'] ?? 0 }}%"
                         aria-valuenow="{{ $progress['percentage'] ?? 0 }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>
                <div class="progress-text mt-2">
                    <small class="text-muted">
                        {{ $progress['text'] ?? 'Progress' }}: {{ $progress['percentage'] ?? 0 }}%
                    </small>
                </div>
            </div>
            @endif

            {{-- Form Fields Container --}}
            <div class="form-fields-container">
                @if($layout === 'grid')
                    {{-- CSS Grid Layout --}}
                    <div class="form-grid" style="--form-columns: {{ $columns }};">
                        {{ $slot ?? '' }}
                    </div>
                
                @elseif($layout === 'columns')
                    {{-- Bootstrap Columns Layout --}}
                    <div class="row g-{{ $spacing }}">
                        {{ $slot ?? '' }}
                    </div>
                
                @elseif($layout === 'stack')
                    {{-- Stacked Layout --}}
                    <div class="form-stack g-{{ $spacing }}">
                        {{ $slot ?? '' }}
                    </div>
                
                @else
                    {{-- Auto Layout (Default) --}}
                    <div class="form-auto-layout">
                        {{ $slot ?? '' }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Form Actions Section --}}
        @if(isset($actions))
        <div class="form-actions-section {{ $stickyActions ? 'sticky-actions' : '' }}">
            <div class="form-actions-content">
                <div class="form-actions-wrapper">
                    {{-- Primary Actions --}}
                    @if(isset($actions['primary']))
                    <div class="primary-actions">
                        @foreach($actions['primary'] as $action)
                        <button type="{{ $action['type'] ?? 'button' }}" 
                                class="btn {{ $action['class'] ?? 'btn-primary' }}">
                            @if(isset($action['icon']))
                            <i class="{{ $action['icon'] }} me-2"></i>
                            @endif
                            {{ $action['label'] }}
                        </button>
                        @endforeach
                    </div>
                    @endif

                    {{-- Secondary Actions --}}
                    @if(isset($actions['secondary']))
                    <div class="secondary-actions">
                        @foreach($actions['secondary'] as $action)
                        <button type="{{ $action['type'] ?? 'button' }}" 
                                class="btn {{ $action['class'] ?? 'btn-outline-secondary' }}">
                            @if(isset($action['icon']))
                            <i class="{{ $action['icon'] }} me-2"></i>
                            @endif
                            {{ $action['label'] }}
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Form Status Information --}}
                @if(isset($status))
                <div class="form-status-info">
                    <small class="text-muted">
                        @if(isset($status['saved_at']))
                        <i class="fas fa-save me-1"></i>
                        Last saved: {{ $status['saved_at'] }}
                        @endif
                        
                        @if(isset($status['modified']))
                        <span class="text-warning ms-3">
                            <i class="fas fa-edit me-1"></i>
                            Modified
                        </span>
                        @endif
                    </small>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Mobile Navigation (for multi-step forms) --}}
    @if(isset($mobileNav) && $mobileNav)
    <div class="mobile-form-navigation d-md-none">
        <div class="mobile-nav-container">
            <div class="mobile-nav-content">
                @if(isset($mobileNav['prev']))
                <button type="button" class="btn btn-outline-primary mobile-nav-btn prev-btn">
                    <i class="fas fa-chevron-left me-1"></i>
                    {{ $mobileNav['prev']['label'] ?? 'Previous' }}
                </button>
                @endif

                <div class="mobile-nav-info">
                    <span class="current-section">{{ $mobileNav['current'] ?? 'Form' }}</span>
                </div>

                @if(isset($mobileNav['next']))
                <button type="button" class="btn btn-primary mobile-nav-btn next-btn">
                    {{ $mobileNav['next']['label'] ?? 'Next' }}
                    <i class="fas fa-chevron-right ms-1"></i>
                </button>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Floating Save Button (Mobile) --}}
    @if(isset($floatingSave) && $floatingSave)
    <div class="floating-save-container d-md-none">
        <button type="button" class="btn btn-primary floating-save-btn">
            <i class="fas fa-save"></i>
            <span class="save-text">Save</span>
        </button>
    </div>
    @endif
</div>

{{-- Enhanced CSS Styles --}}
<style>
.responsive-form-layout {
    --form-primary: #0d6efd;
    --form-secondary: #6c757d;
    --form-success: #198754;
    --form-danger: #dc3545;
    --form-warning: #ffc107;
    --form-light: #f8f9fa;
    --form-dark: #212529;
    --form-border: #dee2e6;
    --form-radius: 0.5rem;
    --form-shadow: 0 2px 8px rgba(0,0,0,0.1);
    --form-shadow-lg: 0 4px 16px rgba(0,0,0,0.15);
    --form-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --form-spacing: 1rem;
    
    width: 100%;
    max-width: none;
    margin: 0;
}

/* Layout Container */
.form-layout-container {
    background: white;
    border-radius: var(--form-radius);
    box-shadow: var(--form-shadow);
    overflow: hidden;
}

/* Form Header */
.form-header-section {
    background: linear-gradient(135deg, var(--form-light) 0%, #e9ecef 100%);
    border-bottom: 1px solid var(--form-border);
    padding: 1.5rem 2rem;
}

.form-header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.form-title {
    color: var(--form-dark);
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.form-description {
    color: var(--form-secondary);
    font-size: 1rem;
    line-height: 1.5;
    margin: 0;
}

.form-header-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
    margin-left: 2rem;
}

/* Form Content */
.form-content-section {
    padding: 2rem;
}

.form-progress-section .form-progress-bar {
    height: 6px;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 3px;
}

.form-progress-section .progress-bar {
    border-radius: 3px;
    transition: width 0.6s ease;
}

/* Layout Specific Styles */

/* Grid Layout */
.form-grid {
    display: grid;
    grid-template-columns: repeat(var(--form-columns), 1fr);
    gap: var(--form-spacing);
    align-items: start;
}

.form-grid > .form-group,
.form-grid > .mb-3,
.form-grid > .form-floating {
    margin-bottom: 0;
}

/* Full width items in grid */
.form-grid > .form-group.full-width,
.form-grid > .mb-3.full-width,
.form-grid > .form-floating.full-width {
    grid-column: 1 / -1;
}

/* Columns Layout */
.row.g-1 { --bs-gutter-x: 0.25rem; --bs-gutter-y: 0.25rem; }
.row.g-2 { --bs-gutter-x: 0.5rem; --bs-gutter-y: 0.5rem; }
.row.g-3 { --bs-gutter-x: 1rem; --bs-gutter-y: 1rem; }
.row.g-4 { --bs-gutter-x: 1.5rem; --bs-gutter-y: 1.5rem; }
.row.g-5 { --bs-gutter-x: 3rem; --bs-gutter-y: 3rem; }

/* Stack Layout */
.form-stack {
    display: flex;
    flex-direction: column;
}

.form-stack.g-1 > * + * { margin-top: 0.25rem; }
.form-stack.g-2 > * + * { margin-top: 0.5rem; }
.form-stack.g-3 > * + * { margin-top: 1rem; }
.form-stack.g-4 > * + * { margin-top: 1.5rem; }
.form-stack.g-5 > * + * { margin-top: 3rem; }

/* Auto Layout */
.form-auto-layout {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* Compact Mode */
.compact-mode .form-header-section {
    padding: 1rem 1.5rem;
}

.compact-mode .form-content-section {
    padding: 1.5rem;
}

.compact-mode .form-title {
    font-size: 1.25rem;
}

.compact-mode .form-grid {
    gap: 0.75rem;
}

.compact-mode .form-auto-layout {
    gap: 1rem;
}

/* Form Actions */
.form-actions-section {
    background: var(--form-light);
    border-top: 1px solid var(--form-border);
    padding: 1.5rem 2rem;
}

.form-actions-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-actions-wrapper {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.primary-actions,
.secondary-actions {
    display: flex;
    gap: 0.75rem;
}

.primary-actions .btn {
    font-weight: 600;
}

.form-status-info {
    color: var(--form-secondary);
    font-size: 0.875rem;
}

/* Sticky Actions */
.sticky-actions {
    position: sticky;
    bottom: 0;
    z-index: 100;
    box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
}

/* Mobile Navigation */
.mobile-form-navigation {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: white;
    border-top: 1px solid var(--form-border);
    box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
}

.mobile-nav-container {
    padding: 1rem;
}

.mobile-nav-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 100%;
}

.mobile-nav-btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: calc(var(--form-radius) * 0.8);
}

.mobile-nav-info {
    text-align: center;
    flex: 1;
    margin: 0 1rem;
}

.current-section {
    font-weight: 600;
    color: var(--form-dark);
}

/* Floating Save Button */
.floating-save-container {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
}

.floating-save-btn {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: var(--form-shadow-lg);
    transition: var(--form-transition);
}

.floating-save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
}

.floating-save-btn .save-text {
    font-size: 0.6rem;
    line-height: 1;
    margin-top: 0.125rem;
}

/* Responsive Breakpoints */

/* Small devices (landscape phones, 576px and up) */
@media (max-width: 575.98px) {
    .responsive-form-layout[data-mobile-stack="true"] .form-grid {
        grid-template-columns: 1fr !important;
    }
    
    .form-header-section {
        padding: 1rem 1.25rem;
    }
    
    .form-header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .form-header-actions {
        margin-left: 0;
        margin-top: 1rem;
        justify-content: flex-end;
    }
    
    .form-content-section {
        padding: 1.25rem;
    }
    
    .form-actions-section {
        padding: 1rem 1.25rem;
    }
    
    .form-actions-content {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-actions-wrapper {
        width: 100%;
        justify-content: center;
    }
    
    .primary-actions,
    .secondary-actions {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    /* Stack all form controls on mobile */
    .form-grid > *,
    .row > [class*="col-"] > * {
        margin-bottom: 1rem;
    }
}

/* Medium devices (tablets, 768px and up) */
@media (min-width: 576px) and (max-width: 767.98px) {
    .responsive-form-layout[data-breakpoint="md"] .form-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .form-header-actions {
        margin-left: 1rem;
    }
}

/* Large devices (desktops, 992px and up) */
@media (min-width: 768px) {
    .responsive-form-layout[data-breakpoint="sm"] .form-grid {
        grid-template-columns: repeat(var(--form-columns), 1fr);
    }
}

@media (min-width: 992px) {
    .responsive-form-layout[data-breakpoint="md"] .form-grid {
        grid-template-columns: repeat(var(--form-columns), 1fr);
    }
    
    /* Hide mobile-only elements */
    .mobile-form-navigation,
    .floating-save-container {
        display: none !important;
    }
}

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) {
    .responsive-form-layout[data-breakpoint="lg"] .form-grid {
        grid-template-columns: repeat(var(--form-columns), 1fr);
    }
    
    .form-layout-container {
        margin: 0 auto;
    }
}

/* XXL devices (larger desktops, 1400px and up) */
@media (min-width: 1400px) {
    .responsive-form-layout[data-breakpoint="xl"] .form-grid {
        grid-template-columns: repeat(var(--form-columns), 1fr);
    }
}

/* Form Field Responsive Utilities */
.form-field-sm {
    grid-column: span 1;
}

.form-field-md {
    grid-column: span 2;
}

.form-field-lg {
    grid-column: span 3;
}

.form-field-full {
    grid-column: 1 / -1;
}

/* Mobile-specific field sizing */
@media (max-width: 575.98px) {
    .form-field-sm,
    .form-field-md,
    .form-field-lg {
        grid-column: 1 / -1;
    }
}

/* Print Styles */
@media print {
    .form-actions-section,
    .mobile-form-navigation,
    .floating-save-container {
        display: none !important;
    }
    
    .form-layout-container {
        box-shadow: none;
        border: 1px solid #ccc;
    }
    
    .form-header-section {
        background: none !important;
        border-bottom: 2px solid #000;
    }
    
    .form-grid {
        gap: 0.5rem;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .responsive-form-layout {
        --form-light: #343a40;
        --form-dark: #ffffff;
        --form-border: #495057;
    }
    
    .form-layout-container {
        background: #2b3035;
    }
    
    .form-header-section {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
    }
    
    .form-actions-section {
        background: #1e2124;
    }
    
    .mobile-form-navigation {
        background: #2b3035;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .form-layout-container {
        border: 2px solid #000;
    }
    
    .form-header-section,
    .form-actions-section {
        border-width: 2px;
    }
    
    .floating-save-btn {
        border: 2px solid #000;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .responsive-form-layout * {
        transition: none !important;
        animation: none !important;
    }
}

/* Focus Management */
.form-layout-container:focus-within {
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
}

/* Touch Target Optimization */
@media (pointer: coarse) {
    .mobile-nav-btn,
    .floating-save-btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    .form-header-actions .btn {
        padding: 0.6rem 1.2rem;
    }
}

/* Landscape Orientation on Mobile */
@media screen and (orientation: landscape) and (max-height: 500px) {
    .mobile-form-navigation {
        position: relative;
        margin-top: 1rem;
    }
    
    .floating-save-container {
        bottom: 1rem;
        right: 1rem;
    }
}
</style>

{{-- Enhanced JavaScript Functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formLayout = document.getElementById('{{ $formId }}');
    if (!formLayout) return;

    const layout = formLayout.dataset.layout;
    const breakpoint = formLayout.dataset.breakpoint;
    const columns = parseInt(formLayout.dataset.columns);
    const mobileStack = formLayout.dataset.mobileStack === 'true';

    // Initialize responsive behavior
    function initializeResponsiveForm() {
        handleViewportChanges();
        initializeFloatingSave();
        initializeMobileNavigation();
        initializeFormValidation();
        initializeAutoSave();
        
        // Custom initialization event
        formLayout.dispatchEvent(new CustomEvent('responsiveFormInitialized', {
            detail: {
                layout,
                breakpoint,
                columns,
                mobileStack,
                element: formLayout
            }
        }));
    }

    // Handle viewport changes
    function handleViewportChanges() {
        let currentBreakpoint = getCurrentBreakpoint();
        
        window.addEventListener('resize', debounce(() => {
            const newBreakpoint = getCurrentBreakpoint();
            if (newBreakpoint !== currentBreakpoint) {
                currentBreakpoint = newBreakpoint;
                updateLayoutForBreakpoint(newBreakpoint);
                
                formLayout.dispatchEvent(new CustomEvent('breakpointChanged', {
                    detail: { breakpoint: newBreakpoint, layout }
                }));
            }
        }, 250));
        
        // Initial layout update
        updateLayoutForBreakpoint(currentBreakpoint);
    }

    // Get current breakpoint
    function getCurrentBreakpoint() {
        const width = window.innerWidth;
        if (width < 576) return 'xs';
        if (width < 768) return 'sm';
        if (width < 992) return 'md';
        if (width < 1200) return 'lg';
        if (width < 1400) return 'xl';
        return 'xxl';
    }

    // Update layout for breakpoint
    function updateLayoutForBreakpoint(bp) {
        const formGrid = formLayout.querySelector('.form-grid');
        if (!formGrid) return;

        // Adjust columns based on breakpoint
        let adaptiveColumns = columns;
        
        if (mobileStack && (bp === 'xs')) {
            adaptiveColumns = 1;
        } else if (bp === 'sm') {
            adaptiveColumns = Math.min(2, columns);
        } else if (bp === 'md') {
            adaptiveColumns = Math.min(3, columns);
        }
        
        formGrid.style.setProperty('--form-columns', adaptiveColumns);
        
        // Update container classes
        formLayout.className = formLayout.className.replace(/\b\w*-breakpoint\b/g, '');
        formLayout.classList.add(`${bp}-breakpoint`);
    }

    // Initialize floating save functionality
    function initializeFloatingSave() {
        const floatingBtn = formLayout.querySelector('.floating-save-btn');
        if (!floatingBtn) return;

        let isVisible = false;
        let hideTimeout;

        function showFloatingButton() {
            if (!isVisible) {
                floatingBtn.style.display = 'flex';
                setTimeout(() => {
                    floatingBtn.style.opacity = '1';
                    floatingBtn.style.transform = 'translateY(0)';
                }, 10);
                isVisible = true;
            }
            
            clearTimeout(hideTimeout);
            hideTimeout = setTimeout(hideFloatingButton, 3000);
        }

        function hideFloatingButton() {
            if (isVisible) {
                floatingBtn.style.opacity = '0';
                floatingBtn.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    floatingBtn.style.display = 'none';
                }, 300);
                isVisible = false;
            }
        }

        // Show on form interaction
        formLayout.addEventListener('input', showFloatingButton);
        formLayout.addEventListener('change', showFloatingButton);
        
        // Hide initially
        floatingBtn.style.opacity = '0';
        floatingBtn.style.transform = 'translateY(10px)';
        floatingBtn.style.transition = 'all 0.3s ease';

        // Save functionality
        floatingBtn.addEventListener('click', () => {
            triggerFormSave();
            showSaveIndicator();
        });
    }

    // Initialize mobile navigation
    function initializeMobileNavigation() {
        const mobileNav = formLayout.querySelector('.mobile-form-navigation');
        if (!mobileNav) return;

        const prevBtn = mobileNav.querySelector('.prev-btn');
        const nextBtn = mobileNav.querySelector('.next-btn');

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                formLayout.dispatchEvent(new CustomEvent('mobilePrevious'));
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (validateVisibleFields()) {
                    formLayout.dispatchEvent(new CustomEvent('mobileNext'));
                }
            });
        }

        // Auto-hide on scroll up
        let lastScrollY = window.scrollY;
        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            const shouldHide = currentScrollY > lastScrollY && currentScrollY > 100;
            
            mobileNav.style.transform = shouldHide ? 'translateY(100%)' : 'translateY(0)';
            lastScrollY = currentScrollY;
        });
    }

    // Initialize form validation
    function initializeFormValidation() {
        const formFields = formLayout.querySelectorAll('input, select, textarea');
        
        formFields.forEach(field => {
            // Real-time validation
            field.addEventListener('blur', () => validateField(field));
            field.addEventListener('input', debounce(() => validateField(field), 500));
        });
    }

    // Initialize auto-save functionality
    function initializeAutoSave() {
        let autoSaveTimeout;
        let hasChanges = false;

        function scheduleAutoSave() {
            if (!hasChanges) return;
            
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                if (hasChanges) {
                    triggerFormSave(true); // Auto-save flag
                    hasChanges = false;
                }
            }, 30000); // Auto-save every 30 seconds
        }

        // Track changes
        formLayout.addEventListener('input', () => {
            hasChanges = true;
            scheduleAutoSave();
        });

        formLayout.addEventListener('change', () => {
            hasChanges = true;
            scheduleAutoSave();
        });

        // Clear auto-save on manual save
        formLayout.addEventListener('formSaved', () => {
            hasChanges = false;
            clearTimeout(autoSaveTimeout);
        });
    }

    // Validate individual field
    function validateField(field) {
        const isValid = field.checkValidity();
        
        field.classList.toggle('is-invalid', !isValid);
        field.classList.toggle('is-valid', isValid && field.value.trim() !== '');
        
        // Custom validation feedback
        const feedback = field.parentNode.querySelector('.invalid-feedback');
        if (!isValid && !feedback) {
            const feedbackElement = document.createElement('div');
            feedbackElement.className = 'invalid-feedback';
            feedbackElement.textContent = field.validationMessage;
            field.parentNode.appendChild(feedbackElement);
        } else if (isValid && feedback) {
            feedback.remove();
        }
        
        return isValid;
    }

    // Validate visible fields
    function validateVisibleFields() {
        const visibleFields = Array.from(formLayout.querySelectorAll('input:not([type="hidden"]), select, textarea'))
            .filter(field => field.offsetParent !== null);
        
        let allValid = true;
        visibleFields.forEach(field => {
            if (!validateField(field)) {
                allValid = false;
            }
        });
        
        return allValid;
    }

    // Trigger form save
    function triggerFormSave(isAutoSave = false) {
        const form = formLayout.closest('form');
        if (!form) return;

        const formData = new FormData(form);
        
        // Custom save event
        const saveEvent = new CustomEvent('formSave', {
            detail: {
                formData,
                isAutoSave,
                element: formLayout
            },
            cancelable: true
        });

        if (formLayout.dispatchEvent(saveEvent)) {
            // Default save behavior (you can customize this)
            
            // Simulate save success
            setTimeout(() => {
                formLayout.dispatchEvent(new CustomEvent('formSaved', {
                    detail: { isAutoSave, success: true }
                }));
            }, 1000);
        }
    }

    // Show save indicator
    function showSaveIndicator() {
        const floatingBtn = formLayout.querySelector('.floating-save-btn');
        if (!floatingBtn) return;

        const originalContent = floatingBtn.innerHTML;
        floatingBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span class="save-text">Saving</span>';
        floatingBtn.disabled = true;

        setTimeout(() => {
            floatingBtn.innerHTML = '<i class="fas fa-check"></i><span class="save-text">Saved</span>';
            
            setTimeout(() => {
                floatingBtn.innerHTML = originalContent;
                floatingBtn.disabled = false;
            }, 1500);
        }, 1000);
    }

    // Utility function for debouncing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Public API for external access
    window.responsiveForm = window.responsiveForm || {};
    window.responsiveForm['{{ $formId }}'] = {
        validate: validateVisibleFields,
        save: () => triggerFormSave(false),
        getCurrentBreakpoint,
        getLayout: () => layout,
        getColumns: () => columns
    };

    // Initialize everything
    initializeResponsiveForm();
});
</script>
