{{-- Enhanced Collapsible Form Section Component --}}
{{-- Usage: @include('admin::form.collapsible', ['sections' => [['title' => 'Basic Info', 'content' => 'basic-content', 'collapsed' => false]]]) --}}

@php
$id = $id ?? 'collapsible-' . Str::random(6);
$sections = $sections ?? [];
$accordion = $accordion ?? false; // If true, only one section can be open at a time
$showToggleAll = $showToggleAll ?? true;
@endphp

<div class="form-collapsible-container" id="{{ $id }}" data-accordion="{{ $accordion ? 'true' : 'false' }}">
    
    {{-- Toggle All Controls --}}
    @if($showToggleAll && count($sections) > 1)
    <div class="collapsible-controls mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="collapsible-info">
                <small class="text-muted">
                    <i class="fas fa-layer-group me-1"></i>
                    {{ count($sections) }} sections available
                </small>
            </div>
            <div class="collapsible-actions">
                <button type="button" class="btn btn-sm btn-outline-primary me-2 expand-all-btn">
                    <i class="fas fa-expand-alt me-1"></i>Expand All
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary collapse-all-btn">
                    <i class="fas fa-compress-alt me-1"></i>Collapse All
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Collapsible Sections --}}
    <div class="form-sections-wrapper">
        @foreach($sections as $index => $section)
        @php
        $sectionId = $id . '-section-' . $index;
        $collapseId = $id . '-collapse-' . $index;
        $isCollapsed = $section['collapsed'] ?? false;
        $hasErrors = isset($section['errors']) && !empty($section['errors']);
        $isRequired = $section['required'] ?? false;
        @endphp

        <div class="form-section mb-3 {{ $hasErrors ? 'has-errors' : '' }}" data-section-index="{{ $index }}">
            {{-- Section Header --}}
            <div class="form-section-header">
                <button 
                    class="btn btn-link form-section-toggle w-100 text-start p-0"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{ $collapseId }}"
                    aria-expanded="{{ $isCollapsed ? 'false' : 'true' }}"
                    aria-controls="{{ $collapseId }}"
                    id="heading-{{ $sectionId }}"
                >
                    <div class="section-toggle-content">
                        <div class="section-header-main">
                            {{-- Toggle Icon --}}
                            <div class="toggle-icon-wrapper">
                                <i class="fas fa-chevron-right toggle-icon {{ $isCollapsed ? '' : 'rotated' }}"></i>
                            </div>

                            {{-- Section Info --}}
                            <div class="section-info">
                                <div class="section-title-wrapper">
                                    {{-- Custom Icon --}}
                                    @if(isset($section['icon']))
                                    <i class="{{ $section['icon'] }} section-icon me-2"></i>
                                    @endif

                                    {{-- Title --}}
                                    <h6 class="section-title mb-0">
                                        {{ $section['title'] }}
                                        @if($isRequired)
                                        <span class="text-danger ms-1">*</span>
                                        @endif
                                    </h6>

                                    {{-- Required Badge --}}
                                    @if($isRequired)
                                    <span class="badge bg-warning text-dark ms-2">Required</span>
                                    @endif
                                </div>

                                {{-- Description --}}
                                @if(isset($section['description']))
                                <p class="section-description mb-0 text-muted">
                                    {{ $section['description'] }}
                                </p>
                                @endif
                            </div>
                        </div>

                        {{-- Status Indicators --}}
                        <div class="section-status">
                            {{-- Progress Indicator --}}
                            @if(isset($section['total_fields']))
                            <div class="progress-indicator me-3">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: 0%" 
                                         data-section-progress="{{ $index }}">
                                    </div>
                                </div>
                                <small class="progress-text text-muted">0/{{ $section['total_fields'] }} completed</small>
                            </div>
                            @endif

                            {{-- Error Indicator --}}
                            @if($hasErrors)
                            <div class="error-indicator me-2">
                                <i class="fas fa-exclamation-circle text-danger" title="{{ count($section['errors']) }} errors"></i>
                                <span class="badge bg-danger">{{ count($section['errors']) }}</span>
                            </div>
                            @endif

                            {{-- Success Indicator --}}
                            <div class="success-indicator me-2 d-none">
                                <i class="fas fa-check-circle text-success" title="Section completed"></i>
                            </div>

                            {{-- Collapse Status --}}
                            <div class="collapse-status">
                                <small class="text-muted collapse-status-text">
                                    {{ $isCollapsed ? 'Click to expand' : 'Click to collapse' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </button>
            </div>

            {{-- Section Content --}}
            <div class="collapse {{ $isCollapsed ? '' : 'show' }}" 
                 id="{{ $collapseId }}"
                 aria-labelledby="heading-{{ $sectionId }}"
                 data-section-content="{{ $index }}">
                <div class="form-section-body">
                    {{-- Error Summary --}}
                    @if($hasErrors)
                    <div class="alert alert-danger mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($section['errors'] as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Dynamic Content --}}
                    <div class="section-content-wrapper">
                        @if(isset($section['view']))
                            @include($section['view'], $section['data'] ?? [])
                        @elseif(isset($section['content']))
                            @if(is_string($section['content']))
                                @include($section['content'])
                            @else
                                {!! $section['content'] !!}
                            @endif
                        @else
                            {{-- Placeholder Content --}}
                            <div class="section-placeholder">
                                <div class="text-center p-4">
                                    <i class="fas fa-edit fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted">{{ $section['title'] }}</h6>
                                    <p class="small text-muted">Add your form fields here</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Section Footer Actions --}}
                    @if(isset($section['actions']) && !empty($section['actions']))
                    <div class="section-footer mt-3 pt-3 border-top">
                        <div class="section-actions">
                            @foreach($section['actions'] as $action)
                            <button type="{{ $action['type'] ?? 'button' }}" 
                                    class="btn {{ $action['class'] ?? 'btn-secondary' }} me-2">
                                @if(isset($action['icon']))
                                <i class="{{ $action['icon'] }} me-1"></i>
                                @endif
                                {{ $action['label'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Loading State --}}
    <div class="collapsible-loading d-none">
        <div class="text-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading sections...</span>
            </div>
            <p class="mt-2 text-muted">Loading form sections...</p>
        </div>
    </div>
</div>

{{-- Enhanced CSS Styles --}}
<style>
.form-collapsible-container {
    --collapsible-primary: #0d6efd;
    --collapsible-secondary: #6c757d;
    --collapsible-success: #198754;
    --collapsible-danger: #dc3545;
    --collapsible-warning: #ffc107;
    --collapsible-border: #dee2e6;
    --collapsible-bg: #ffffff;
    --collapsible-hover: #f8f9fa;
    --collapsible-radius: 0.5rem;
    --collapsible-shadow: 0 2px 4px rgba(0,0,0,0.1);
    --collapsible-shadow-hover: 0 4px 12px rgba(0,0,0,0.15);
    --collapsible-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Controls Section */
.collapsible-controls {
    background: var(--collapsible-hover);
    padding: 1rem;
    border-radius: var(--collapsible-radius);
    border: 1px solid var(--collapsible-border);
}

.collapsible-info .text-muted {
    font-size: 0.875rem;
    font-weight: 500;
}

.collapsible-actions .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: calc(var(--collapsible-radius) * 0.8);
    transition: var(--collapsible-transition);
}

.collapsible-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--collapsible-shadow);
}

/* Form Sections */
.form-section {
    border: 1px solid var(--collapsible-border);
    border-radius: var(--collapsible-radius);
    background: var(--collapsible-bg);
    overflow: hidden;
    transition: var(--collapsible-transition);
    position: relative;
}

.form-section:hover {
    box-shadow: var(--collapsible-shadow);
    border-color: var(--collapsible-primary);
}

.form-section.has-errors {
    border-color: var(--collapsible-danger);
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.1);
}

/* Section Header */
.form-section-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid var(--collapsible-border);
    position: relative;
}

.form-section-toggle {
    border: none !important;
    text-decoration: none !important;
    color: inherit !important;
    padding: 1.25rem !important;
    transition: var(--collapsible-transition);
}

.form-section-toggle:hover {
    background: var(--collapsible-hover);
    color: var(--collapsible-primary) !important;
}

.form-section-toggle:focus {
    box-shadow: inset 0 0 0 2px var(--collapsible-primary);
    outline: none;
}

.section-toggle-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.section-header-main {
    display: flex;
    align-items: center;
    flex: 1;
}

/* Toggle Icon */
.toggle-icon-wrapper {
    margin-right: 1rem;
    width: 1.25rem;
    height: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toggle-icon {
    transition: transform 0.3s ease;
    color: var(--collapsible-primary);
    font-size: 0.875rem;
}

.toggle-icon.rotated {
    transform: rotate(90deg);
}

/* Section Info */
.section-info {
    flex: 1;
}

.section-title-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 0.25rem;
}

.section-icon {
    color: var(--collapsible-primary);
    font-size: 1rem;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1rem;
    margin: 0;
}

.section-description {
    font-size: 0.875rem;
    color: var(--collapsible-secondary);
    line-height: 1.4;
}

/* Status Indicators */
.section-status {
    display: flex;
    align-items: center;
    margin-left: 1rem;
}

.progress-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.progress-sm {
    height: 0.25rem;
    width: 60px;
    background: rgba(var(--collapsible-secondary), 0.2);
}

.progress-text {
    font-size: 0.75rem;
    white-space: nowrap;
    margin-top: 0.25rem;
}

.error-indicator,
.success-indicator {
    position: relative;
    display: flex;
    align-items: center;
}

.error-indicator .badge {
    position: absolute;
    top: -8px;
    right: -8px;
    font-size: 0.65rem;
    padding: 0.25em 0.4em;
}

.collapse-status-text {
    font-size: 0.75rem;
    white-space: nowrap;
}

/* Section Content */
.form-section-body {
    padding: 1.5rem;
    background: var(--collapsible-bg);
}

.section-content-wrapper {
    position: relative;
}

.section-placeholder {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px dashed var(--collapsible-border);
    border-radius: calc(var(--collapsible-radius) * 0.8);
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Section Footer */
.section-footer {
    background: var(--collapsible-hover);
    margin: 1.5rem -1.5rem -1.5rem;
    padding: 1rem 1.5rem;
}

.section-actions .btn {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: calc(var(--collapsible-radius) * 0.8);
    transition: var(--collapsible-transition);
}

.section-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--collapsible-shadow);
}

/* Loading State */
.collapsible-loading {
    background: var(--collapsible-bg);
    border: 1px solid var(--collapsible-border);
    border-radius: var(--collapsible-radius);
}

/* Animations */
.collapse {
    transition: height 0.35s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}

.form-section.expanding .form-section-body {
    animation: slideDown 0.3s ease;
}

.form-section.collapsing .form-section-body {
    animation: slideUp 0.3s ease;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .collapsible-controls {
        padding: 0.75rem;
    }
    
    .collapsible-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .collapsible-actions .btn {
        width: 100%;
        font-size: 0.8rem;
    }
    
    .form-section-toggle {
        padding: 1rem !important;
    }
    
    .section-toggle-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .section-status {
        margin-left: 0;
        margin-top: 0.75rem;
        width: 100%;
        justify-content: space-between;
    }
    
    .form-section-body {
        padding: 1rem;
    }
    
    .section-footer {
        margin: 1rem -1rem -1rem;
        padding: 0.75rem 1rem;
    }
    
    .section-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .section-actions .btn {
        width: 100%;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .form-collapsible-container {
        --collapsible-bg: #2b3035;
        --collapsible-hover: #343a40;
        --collapsible-border: #495057;
    }
    
    .form-section-header {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
    }
    
    .section-title {
        color: #ffffff;
    }
    
    .section-placeholder {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        color: #ffffff;
    }
}

/* Accessibility Enhancements */
@media (prefers-reduced-motion: reduce) {
    .form-collapsible-container * {
        transition: none !important;
        animation: none !important;
    }
}

/* Focus Management */
.form-section-toggle:focus-visible {
    outline: 2px solid var(--collapsible-primary);
    outline-offset: 2px;
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .form-section {
        border-width: 2px;
    }
    
    .form-section:hover {
        border-width: 3px;
    }
}
</style>

{{-- Enhanced JavaScript Functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('{{ $id }}');
    if (!container) return;

    const isAccordion = container.dataset.accordion === 'true';
    const sections = container.querySelectorAll('.form-section');
    const expandAllBtn = container.querySelector('.expand-all-btn');
    const collapseAllBtn = container.querySelector('.collapse-all-btn');
    
    let activeSections = new Set();

    // Initialize collapsible functionality
    function initializeCollapsible() {
        // Set up event listeners for section toggles
        sections.forEach((section, index) => {
            const toggle = section.querySelector('.form-section-toggle');
            const collapseElement = section.querySelector('.collapse');
            
            if (toggle && collapseElement) {
                // Track initial state
                if (collapseElement.classList.contains('show')) {
                    activeSections.add(index);
                }
                
                // Add click event listener
                toggle.addEventListener('click', (e) => handleSectionToggle(e, index));
                
                // Monitor collapse events
                collapseElement.addEventListener('shown.bs.collapse', () => {
                    activeSections.add(index);
                    updateSectionStatus(index, true);
                    updateToggleAllButtons();
                });
                
                collapseElement.addEventListener('hidden.bs.collapse', () => {
                    activeSections.delete(index);
                    updateSectionStatus(index, false);
                    updateToggleAllButtons();
                });
            }
            
            // Initialize form validation monitoring
            initializeSectionValidation(index);
        });

        // Set up toggle all buttons
        if (expandAllBtn) {
            expandAllBtn.addEventListener('click', expandAllSections);
        }
        
        if (collapseAllBtn) {
            collapseAllBtn.addEventListener('click', collapseAllSections);
        }

        // Initial state update
        updateToggleAllButtons();
        updateAllSectionProgress();
    }

    // Handle section toggle with accordion logic
    function handleSectionToggle(event, sectionIndex) {
        event.preventDefault();
        
        if (isAccordion) {
            // In accordion mode, close other sections
            sections.forEach((otherSection, otherIndex) => {
                if (otherIndex !== sectionIndex) {
                    const otherCollapse = otherSection.querySelector('.collapse');
                    if (otherCollapse && otherCollapse.classList.contains('show')) {
                        bootstrap.Collapse.getInstance(otherCollapse)?.hide();
                    }
                }
            });
        }
        
        // Toggle the clicked section
        const targetSection = sections[sectionIndex];
        const collapseElement = targetSection.querySelector('.collapse');
        
        if (collapseElement) {
            const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseElement);
            bsCollapse.toggle();
        }
    }

    // Update section status (expanded/collapsed state)
    function updateSectionStatus(sectionIndex, isExpanded) {
        const section = sections[sectionIndex];
        const toggle = section.querySelector('.form-section-toggle');
        const toggleIcon = section.querySelector('.toggle-icon');
        const statusText = section.querySelector('.collapse-status-text');
        
        if (toggleIcon) {
            toggleIcon.classList.toggle('rotated', isExpanded);
        }
        
        if (statusText) {
            statusText.textContent = isExpanded ? 'Click to collapse' : 'Click to expand';
        }
        
        if (toggle) {
            toggle.setAttribute('aria-expanded', isExpanded);
        }
    }

    // Update toggle all buttons state
    function updateToggleAllButtons() {
        const totalSections = sections.length;
        const activeSectionCount = activeSections.size;
        
        if (expandAllBtn) {
            expandAllBtn.disabled = activeSectionCount === totalSections;
            expandAllBtn.innerHTML = activeSectionCount === totalSections 
                ? '<i class="fas fa-check me-1"></i>All Expanded'
                : '<i class="fas fa-expand-alt me-1"></i>Expand All';
        }
        
        if (collapseAllBtn) {
            collapseAllBtn.disabled = activeSectionCount === 0;
            collapseAllBtn.innerHTML = activeSectionCount === 0 
                ? '<i class="fas fa-check me-1"></i>All Collapsed'
                : '<i class="fas fa-compress-alt me-1"></i>Collapse All';
        }
    }

    // Expand all sections
    function expandAllSections() {
        sections.forEach((section) => {
            const collapseElement = section.querySelector('.collapse');
            if (collapseElement && !collapseElement.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(collapseElement).show();
            }
        });
    }

    // Collapse all sections
    function collapseAllSections() {
        sections.forEach((section) => {
            const collapseElement = section.querySelector('.collapse');
            if (collapseElement && collapseElement.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(collapseElement).hide();
            }
        });
    }

    // Initialize section validation monitoring
    function initializeSectionValidation(sectionIndex) {
        const section = sections[sectionIndex];
        const formFields = section.querySelectorAll('input, select, textarea');
        
        formFields.forEach(field => {
            field.addEventListener('input', () => updateSectionProgress(sectionIndex));
            field.addEventListener('change', () => updateSectionProgress(sectionIndex));
        });
        
        // Initial progress update
        updateSectionProgress(sectionIndex);
    }

    // Update progress for a specific section
    function updateSectionProgress(sectionIndex) {
        const section = sections[sectionIndex];
        const progressBar = section.querySelector('[data-section-progress="' + sectionIndex + '"]');
        const progressText = section.querySelector('.progress-text');
        const successIndicator = section.querySelector('.success-indicator');
        
        if (!progressBar) return;
        
        const formFields = section.querySelectorAll('input:not([type="hidden"]), select, textarea');
        const requiredFields = section.querySelectorAll('[required]');
        const completedFields = Array.from(requiredFields).filter(field => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                return field.checked;
            }
            return field.value.trim() !== '';
        });
        
        const completedCount = completedFields.length;
        const totalCount = requiredFields.length;
        const progressPercentage = totalCount > 0 ? (completedCount / totalCount) * 100 : 0;
        
        // Update progress bar
        progressBar.style.width = progressPercentage + '%';
        
        // Update progress text
        if (progressText) {
            progressText.textContent = `${completedCount}/${totalCount} completed`;
        }
        
        // Update success indicator
        if (successIndicator && totalCount > 0) {
            successIndicator.classList.toggle('d-none', progressPercentage < 100);
        }
        
        // Update progress bar color based on completion
        progressBar.className = progressBar.className.replace(/bg-\w+/, '');
        if (progressPercentage === 100) {
            progressBar.classList.add('bg-success');
        } else if (progressPercentage >= 50) {
            progressBar.classList.add('bg-primary');
        } else {
            progressBar.classList.add('bg-warning');
        }
    }

    // Update progress for all sections
    function updateAllSectionProgress() {
        sections.forEach((section, index) => {
            updateSectionProgress(index);
        });
    }

    // Keyboard navigation support
    container.addEventListener('keydown', function(e) {
        if (e.target.matches('.form-section-toggle')) {
            const currentSection = e.target.closest('.form-section');
            const currentIndex = Array.from(sections).indexOf(currentSection);
            
            let targetIndex = currentIndex;
            
            switch(e.key) {
                case 'ArrowUp':
                    targetIndex = Math.max(0, currentIndex - 1);
                    e.preventDefault();
                    break;
                case 'ArrowDown':
                    targetIndex = Math.min(sections.length - 1, currentIndex + 1);
                    e.preventDefault();
                    break;
                case 'Home':
                    targetIndex = 0;
                    e.preventDefault();
                    break;
                case 'End':
                    targetIndex = sections.length - 1;
                    e.preventDefault();
                    break;
                default:
                    return;
            }
            
            const targetToggle = sections[targetIndex]?.querySelector('.form-section-toggle');
            if (targetToggle) {
                targetToggle.focus();
            }
        }
    });

    // Custom events
    container.addEventListener('sectionExpanded', function(e) {
        console.log('Section expanded:', e.detail);
    });
    
    container.addEventListener('sectionCollapsed', function(e) {
        console.log('Section collapsed:', e.detail);
    });

    // Initialize everything
    initializeCollapsible();

    // Export public methods for external access
    window.collapsibleSections = window.collapsibleSections || {};
    window.collapsibleSections['{{ $id }}'] = {
        expandAll: expandAllSections,
        collapseAll: collapseAllSections,
        expandSection: (index) => {
            const section = sections[index];
            const collapseElement = section?.querySelector('.collapse');
            if (collapseElement) {
                bootstrap.Collapse.getOrCreateInstance(collapseElement).show();
            }
        },
        collapseSection: (index) => {
            const section = sections[index];
            const collapseElement = section?.querySelector('.collapse');
            if (collapseElement) {
                bootstrap.Collapse.getOrCreateInstance(collapseElement).hide();
            }
        },
        updateProgress: updateAllSectionProgress,
        getActiveSections: () => Array.from(activeSections)
    };
});
</script>
