{{-- Enhanced Tabbed Form Section Component --}}
{{-- Usage: @include('admin::form.tabs', ['id' => 'form-tabs', 'tabs' => [['title' => 'Basic Info', 'content' => 'basic-tab', 'active' => true], ['title' => 'Advanced', 'content' => 'advanced-tab']]]) --}}

@php
$id = $id ?? 'form-tabs-' . Str::random(6);
$tabs = $tabs ?? [];
$activeTab = null;
foreach($tabs as $index => $tab) {
    if (isset($tab['active']) && $tab['active']) {
        $activeTab = $index;
        break;
    }
}
$activeTab = $activeTab ?? 0;
@endphp

<div class="form-tabs-container" id="{{ $id }}">
    {{-- Tab Navigation --}}
    <div class="form-tabs-nav-wrapper">
        <ul class="nav nav-tabs form-tabs-nav" role="tablist" aria-label="Form sections">
            @foreach($tabs as $index => $tab)
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link form-tab-button {{ $index === $activeTab ? 'active' : '' }}"
                    id="{{ $id }}-tab-{{ $index }}"
                    data-bs-toggle="tab"
                    data-bs-target="#{{ $id }}-content-{{ $index }}"
                    type="button"
                    role="tab"
                    aria-controls="{{ $id }}-content-{{ $index }}"
                    aria-selected="{{ $index === $activeTab ? 'true' : 'false' }}"
                    data-tab-index="{{ $index }}"
                >
                    @if(isset($tab['icon']))
                    <i class="{{ $tab['icon'] }} me-2"></i>
                    @endif
                    {{ $tab['title'] }}
                    
                    {{-- Validation Error Indicator --}}
                    <span class="tab-error-indicator d-none">
                        <i class="fas fa-exclamation-circle text-danger"></i>
                    </span>
                    
                    {{-- Progress Indicator --}}
                    @if(isset($tab['required_fields']))
                    <span class="tab-progress-indicator">
                        <small class="text-muted">(<span class="completed-count">0</span>/<span class="total-count">{{ count($tab['required_fields']) }}</span>)</small>
                    </span>
                    @endif
                </button>
            </li>
            @endforeach
            
            {{-- Mobile Dropdown Toggle --}}
            <li class="nav-item dropdown d-md-none">
                <button class="nav-link dropdown-toggle mobile-tabs-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="dropdown-menu">
                    @foreach($tabs as $index => $tab)
                    <li>
                        <button class="dropdown-item mobile-tab-option" data-tab-index="{{ $index }}">
                            @if(isset($tab['icon']))
                            <i class="{{ $tab['icon'] }} me-2"></i>
                            @endif
                            {{ $tab['title'] }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        
        {{-- Progress Bar --}}
        <div class="form-tabs-progress">
            <div class="progress-bar-container">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ 100 / count($tabs) }}%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="{{ count($tabs) }}">
                        <span class="visually-hidden">Progress: 1 of {{ count($tabs) }} completed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="tab-content form-tabs-content">
        @foreach($tabs as $index => $tab)
        <div 
            class="tab-pane fade {{ $index === $activeTab ? 'show active' : '' }}"
            id="{{ $id }}-content-{{ $index }}"
            role="tabpanel"
            aria-labelledby="{{ $id }}-tab-{{ $index }}"
            data-tab-index="{{ $index }}"
        >
            <div class="form-tab-content-inner">
                {{-- Tab Header --}}
                @if(isset($tab['description']))
                <div class="tab-header mb-4">
                    <h5 class="tab-title">{{ $tab['title'] }}</h5>
                    <p class="tab-description text-muted">{{ $tab['description'] }}</p>
                </div>
                @endif

                {{-- Dynamic Content Inclusion --}}
                @if(isset($tab['view']))
                    @include($tab['view'], $tab['data'] ?? [])
                @elseif(isset($tab['content']))
                    @if(is_string($tab['content']))
                        @include($tab['content'])
                    @else
                        {!! $tab['content'] !!}
                    @endif
                @else
                    <div class="tab-placeholder">
                        <div class="text-center p-4">
                            <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">{{ $tab['title'] }} Content</h6>
                            <p class="small text-muted">Add your form fields here</p>
                        </div>
                    </div>
                @endif
                
                {{-- Navigation Buttons --}}
                <div class="form-tab-navigation mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between">
                        <button 
                            type="button" 
                            class="btn btn-outline-secondary tab-nav-btn tab-prev-btn {{ $index === 0 ? 'd-none' : '' }}"
                            data-target-tab="{{ $index - 1 }}"
                        >
                            <i class="fas fa-chevron-left me-2"></i>Previous
                        </button>
                        
                        <div class="tab-info">
                            <small class="text-muted">Step {{ $index + 1 }} of {{ count($tabs) }}</small>
                        </div>
                        
                        @if($index === count($tabs) - 1)
                        <button type="button" class="btn btn-success tab-nav-btn tab-finish-btn">
                            <i class="fas fa-check me-2"></i>Complete
                        </button>
                        @else
                        <button 
                            type="button" 
                            class="btn btn-primary tab-nav-btn tab-next-btn"
                            data-target-tab="{{ $index + 1 }}"
                        >
                            Next<i class="fas fa-chevron-right ms-2"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Enhanced CSS Styles --}}
<style>
.form-tabs-container {
    --tab-primary: #0d6efd;
    --tab-secondary: #6c757d;
    --tab-success: #198754;
    --tab-danger: #dc3545;
    --tab-border: #dee2e6;
    --tab-hover: #f8f9fa;
    --tab-radius: 0.5rem;
    --tab-shadow: 0 2px 4px rgba(0,0,0,0.1);
    --tab-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Tab Navigation Styles */
.form-tabs-nav-wrapper {
    background: white;
    border-radius: var(--tab-radius) var(--tab-radius) 0 0;
    box-shadow: var(--tab-shadow);
    margin-bottom: 0;
}

.form-tabs-nav {
    border-bottom: 2px solid var(--tab-border);
    padding: 0.5rem 1rem 0;
    margin-bottom: 0;
    position: relative;
}

.form-tab-button {
    border: none;
    border-radius: var(--tab-radius) var(--tab-radius) 0 0;
    padding: 1rem 1.5rem;
    font-weight: 500;
    transition: var(--tab-transition);
    position: relative;
    background: transparent;
    color: var(--tab-secondary);
}

.form-tab-button:hover {
    background: var(--tab-hover);
    color: var(--tab-primary);
    transform: translateY(-2px);
}

.form-tab-button.active {
    background: var(--tab-primary);
    color: white;
    border-bottom: 3px solid var(--tab-primary);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
}

.form-tab-button:focus {
    outline: 2px solid var(--tab-primary);
    outline-offset: 2px;
}

/* Error and Progress Indicators */
.tab-error-indicator {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    animation: pulse 2s infinite;
}

.tab-progress-indicator {
    margin-left: 0.5rem;
    font-size: 0.75rem;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Progress Bar */
.form-tabs-progress {
    padding: 0 1rem 0.5rem;
    background: white;
}

.progress-bar-container .progress {
    height: 4px;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 2px;
}

.progress-bar {
    transition: width 0.6s ease;
    border-radius: 2px;
}

/* Tab Content */
.form-tabs-content {
    background: white;
    border-radius: 0 0 var(--tab-radius) var(--tab-radius);
    box-shadow: var(--tab-shadow);
    min-height: 400px;
}

.form-tab-content-inner {
    padding: 2rem;
}

.tab-header .tab-title {
    color: var(--tab-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.tab-header .tab-description {
    font-size: 0.95rem;
    line-height: 1.5;
}

/* Navigation Buttons */
.form-tab-navigation {
    background: var(--tab-hover);
    margin: 2rem -2rem -2rem;
    padding: 1.5rem 2rem;
    border-radius: 0 0 var(--tab-radius) var(--tab-radius);
}

.tab-nav-btn {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: var(--tab-radius);
    transition: var(--tab-transition);
}

.tab-nav-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.tab-prev-btn:hover {
    background: var(--tab-secondary);
    border-color: var(--tab-secondary);
    color: white;
}

.tab-next-btn:hover {
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.tab-finish-btn:hover {
    box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .form-tabs-nav .nav-item:not(.dropdown) {
        display: none;
    }
    
    .mobile-tabs-toggle {
        display: block !important;
        width: 100%;
        text-align: center;
    }
    
    .form-tab-content-inner {
        padding: 1.5rem;
    }
    
    .form-tab-navigation {
        margin: 1.5rem -1.5rem -1.5rem;
        padding: 1rem 1.5rem;
    }
    
    .tab-nav-btn {
        font-size: 0.9rem;
        padding: 0.6rem 1.2rem;
    }
}

/* Placeholder Content */
.tab-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px dashed var(--tab-border);
    border-radius: var(--tab-radius);
}

/* Animation Classes */
.tab-pane {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.tab-pane:not(.active) {
    transform: translateX(20px);
    opacity: 0;
}

.tab-pane.active {
    transform: translateX(0);
    opacity: 1;
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .form-tabs-container {
        --tab-border: #495057;
        --tab-hover: #343a40;
    }
    
    .form-tabs-nav-wrapper,
    .form-tabs-content,
    .tab-placeholder {
        background: #2b3035;
        color: #ffffff;
    }
    
    .form-tab-navigation {
        background: #1e2124;
    }
}
</style>

{{-- Enhanced JavaScript Functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabContainer = document.getElementById('{{ $id }}');
    if (!tabContainer) return;

    const tabs = tabContainer.querySelectorAll('.form-tab-button');
    const tabPanes = tabContainer.querySelectorAll('.tab-pane');
    const progressBar = tabContainer.querySelector('.progress-bar');
    const nextBtns = tabContainer.querySelectorAll('.tab-next-btn');
    const prevBtns = tabContainer.querySelectorAll('.tab-prev-btn');
    const finishBtn = tabContainer.querySelector('.tab-finish-btn');
    
    let currentTab = {{ $activeTab }};
    const totalTabs = {{ count($tabs) }};

    // Initialize tab functionality
    function initializeTabs() {
        updateProgressBar();
        validateTabContent();
        
        // Add event listeners
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', (e) => switchToTab(index));
        });
        
        nextBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const targetTab = parseInt(btn.dataset.targetTab);
                if (validateCurrentTab()) {
                    switchToTab(targetTab);
                }
            });
        });
        
        prevBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const targetTab = parseInt(btn.dataset.targetTab);
                switchToTab(targetTab);
            });
        });
        
        if (finishBtn) {
            finishBtn.addEventListener('click', handleFormCompletion);
        }

        // Mobile dropdown functionality
        const mobileTabOptions = tabContainer.querySelectorAll('.mobile-tab-option');
        mobileTabOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                const targetTab = parseInt(option.dataset.tabIndex);
                switchToTab(targetTab);
            });
        });
    }

    // Switch to specific tab
    function switchToTab(tabIndex) {
        if (tabIndex < 0 || tabIndex >= totalTabs) return;

        // Update active states
        tabs.forEach((tab, index) => {
            tab.classList.toggle('active', index === tabIndex);
            tab.setAttribute('aria-selected', index === tabIndex);
        });

        tabPanes.forEach((pane, index) => {
            if (index === tabIndex) {
                pane.classList.add('show', 'active');
            } else {
                pane.classList.remove('show', 'active');
            }
        });

        currentTab = tabIndex;
        updateProgressBar();
        
        // Smooth scroll to top of tab content
        tabContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Focus management for accessibility
        const activeTab = tabs[tabIndex];
        if (activeTab) {
            activeTab.focus();
        }

        // Custom event for integration
        tabContainer.dispatchEvent(new CustomEvent('tabChanged', {
            detail: { 
                currentTab: tabIndex,
                tabElement: tabs[tabIndex],
                contentElement: tabPanes[tabIndex]
            }
        }));
    }

    // Update progress bar
    function updateProgressBar() {
        if (progressBar) {
            const progress = ((currentTab + 1) / totalTabs) * 100;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', currentTab + 1);
            
            const progressText = progressBar.querySelector('.visually-hidden');
            if (progressText) {
                progressText.textContent = `Progress: ${currentTab + 1} of ${totalTabs} completed`;
            }
        }
    }

    // Validate current tab content
    function validateCurrentTab() {
        const currentPane = tabPanes[currentTab];
        if (!currentPane) return true;

        const requiredFields = currentPane.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                
                // Show error message
                let errorMsg = field.parentNode.querySelector('.invalid-feedback');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'invalid-feedback';
                    errorMsg.textContent = 'This field is required';
                    field.parentNode.appendChild(errorMsg);
                }
            } else {
                field.classList.remove('is-invalid');
                const errorMsg = field.parentNode.querySelector('.invalid-feedback');
                if (errorMsg) errorMsg.remove();
            }
        });

        // Update tab error indicator
        const currentTabBtn = tabs[currentTab];
        const errorIndicator = currentTabBtn?.querySelector('.tab-error-indicator');
        if (errorIndicator) {
            errorIndicator.classList.toggle('d-none', isValid);
        }

        return isValid;
    }

    // Validate all tab content
    function validateTabContent() {
        tabs.forEach((tab, index) => {
            const pane = tabPanes[index];
            const requiredFields = pane.querySelectorAll('[required]');
            const completedFields = Array.from(requiredFields).filter(field => field.value.trim());
            
            // Update progress indicator
            const progressIndicator = tab.querySelector('.tab-progress-indicator');
            if (progressIndicator) {
                const completedCount = progressIndicator.querySelector('.completed-count');
                const totalCount = progressIndicator.querySelector('.total-count');
                if (completedCount) completedCount.textContent = completedFields.length;
                if (totalCount) totalCount.textContent = requiredFields.length;
            }
        });
    }

    // Handle form completion
    function handleFormCompletion() {
        if (validateCurrentTab()) {
            // Custom event for form completion
            tabContainer.dispatchEvent(new CustomEvent('formCompleted', {
                detail: { 
                    totalTabs: totalTabs,
                    formData: new FormData(tabContainer.closest('form'))
                }
            }));
            
            // Optional: Show completion animation
            tabContainer.classList.add('form-completed');
            
            // Form completion logic
        }
    }

    // Real-time validation
    tabContainer.addEventListener('input', function(e) {
        if (e.target.matches('[required]')) {
            validateTabContent();
        }
    });

    // Keyboard navigation
    tabContainer.addEventListener('keydown', function(e) {
        if (e.target.matches('.form-tab-button')) {
            let newIndex = currentTab;
            
            switch(e.key) {
                case 'ArrowLeft':
                    newIndex = Math.max(0, currentTab - 1);
                    break;
                case 'ArrowRight':
                    newIndex = Math.min(totalTabs - 1, currentTab + 1);
                    break;
                case 'Home':
                    newIndex = 0;
                    break;
                case 'End':
                    newIndex = totalTabs - 1;
                    break;
                default:
                    return;
            }
            
            e.preventDefault();
            switchToTab(newIndex);
        }
    });

    // Initialize everything
    initializeTabs();
});
</script>
