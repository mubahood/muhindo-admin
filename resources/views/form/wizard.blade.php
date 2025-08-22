{{-- Advanced Form Wizard/Stepper Component --}}
{{-- Usage: @include('admin::form.wizard', ['steps' => [['title' => 'Personal Info', 'description' => 'Basic information', 'content' => 'step1']]]) --}}

@php
$id = $id ?? 'form-wizard-' . Str::random(6);
$steps = $steps ?? [];
$currentStep = $currentStep ?? 0;
$showProgress = $showProgress ?? true;
$allowStepClick = $allowStepClick ?? false;
$showStepNumbers = $showStepNumbers ?? true;
$orientation = $orientation ?? 'horizontal'; // horizontal, vertical
$animation = $animation ?? 'slide'; // slide, fade, none
@endphp

<div class="form-wizard-container {{ $orientation }}-wizard" id="{{ $id }}" data-current-step="{{ $currentStep }}">
    
    {{-- Wizard Progress Header --}}
    @if($showProgress)
    <div class="wizard-progress-container">
        <div class="wizard-steps-indicator">
            @foreach($steps as $index => $step)
            <div class="wizard-step-indicator {{ $index === $currentStep ? 'current' : '' }} {{ $index < $currentStep ? 'completed' : '' }} {{ $index > $currentStep ? 'upcoming' : '' }}" 
                 data-step="{{ $index }}">
                
                {{-- Step Number/Icon --}}
                <div class="step-indicator-circle">
                    @if($index < $currentStep)
                        <i class="fas fa-check step-check-icon"></i>
                    @elseif(isset($step['icon']) && $index !== $currentStep)
                        <i class="{{ $step['icon'] }} step-custom-icon"></i>
                    @elseif($showStepNumbers)
                        <span class="step-number">{{ $index + 1 }}</span>
                    @else
                        <i class="fas fa-circle step-dot"></i>
                    @endif
                </div>

                {{-- Step Label --}}
                <div class="step-label">
                    <div class="step-title">{{ $step['title'] }}</div>
                    @if(isset($step['description']))
                    <div class="step-description">{{ $step['description'] }}</div>
                    @endif
                </div>

                {{-- Progress Line --}}
                @if($index < count($steps) - 1)
                <div class="step-progress-line {{ $index < $currentStep ? 'completed' : '' }}">
                    <div class="progress-line-fill"></div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Overall Progress Bar --}}
        <div class="wizard-overall-progress">
            <div class="progress wizard-progress-bar">
                <div class="progress-bar bg-primary" 
                     role="progressbar"
                     style="width: {{ (($currentStep + 1) / count($steps)) * 100 }}%"
                     aria-valuenow="{{ $currentStep + 1 }}" 
                     aria-valuemin="0" 
                     aria-valuemax="{{ count($steps) }}">
                </div>
            </div>
            <div class="progress-text">
                <small class="text-muted">
                    Step {{ $currentStep + 1 }} of {{ count($steps) }}
                    ({{ round((($currentStep + 1) / count($steps)) * 100) }}% complete)
                </small>
            </div>
        </div>
    </div>
    @endif

    {{-- Wizard Content Container --}}
    <div class="wizard-content-container">
        @foreach($steps as $index => $step)
        <div class="wizard-step-content {{ $index === $currentStep ? 'active' : '' }}" 
             id="{{ $id }}-step-{{ $index }}"
             data-step="{{ $index }}"
             role="tabpanel"
             aria-labelledby="{{ $id }}-step-{{ $index }}-tab">
            
            <div class="step-content-wrapper">
                {{-- Step Header --}}
                <div class="step-header">
                    <div class="step-header-main">
                        @if(isset($step['icon']))
                        <div class="step-icon-large">
                            <i class="{{ $step['icon'] }}"></i>
                        </div>
                        @endif
                        
                        <div class="step-header-text">
                            <h4 class="step-main-title">{{ $step['title'] }}</h4>
                            @if(isset($step['description']))
                            <p class="step-main-description">{{ $step['description'] }}</p>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Step Status --}}
                    <div class="step-status">
                        @if($index < $currentStep)
                        <span class="badge bg-success">
                            <i class="fas fa-check me-1"></i>Completed
                        </span>
                        @elseif($index === $currentStep)
                        <span class="badge bg-primary">
                            <i class="fas fa-edit me-1"></i>Current
                        </span>
                        @else
                        <span class="badge bg-secondary">
                            <i class="fas fa-clock me-1"></i>Pending
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Step Content --}}
                <div class="step-content-body">
                    {{-- Validation Summary --}}
                    <div class="step-validation-summary d-none">
                        <div class="alert alert-danger">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>
                                    <strong>Please fix the following errors before continuing:</strong>
                                    <ul class="validation-errors-list mb-0 mt-2"></ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Content --}}
                    <div class="step-dynamic-content">
                        @if(isset($step['view']))
                            @include($step['view'], $step['data'] ?? [])
                        @elseif(isset($step['content']))
                            @if(is_string($step['content']))
                                @include($step['content'])
                            @else
                                {!! $step['content'] !!}
                            @endif
                        @else
                            {{-- Default Content Placeholder --}}
                            <div class="step-placeholder">
                                <div class="text-center p-5">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ $step['title'] }}</h5>
                                    <p class="text-muted">Add your step content here</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Step Navigation --}}
                <div class="step-navigation">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Previous Button --}}
                        <div class="nav-previous">
                            @if($index > 0)
                            <button type="button" 
                                    class="btn btn-outline-secondary wizard-prev-btn"
                                    data-target-step="{{ $index - 1 }}">
                                <i class="fas fa-chevron-left me-2"></i>Previous
                            </button>
                            @endif
                        </div>

                        {{-- Step Info --}}
                        <div class="nav-info d-none d-md-block">
                            <div class="text-center">
                                <div class="step-dots">
                                    @foreach($steps as $dotIndex => $dotStep)
                                    <span class="step-dot {{ $dotIndex === $currentStep ? 'active' : '' }} {{ $dotIndex < $currentStep ? 'completed' : '' }}"
                                          data-step="{{ $dotIndex }}"></span>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    {{ $step['title'] }}
                                </small>
                            </div>
                        </div>

                        {{-- Next/Finish Button --}}
                        <div class="nav-next">
                            @if($index < count($steps) - 1)
                            <button type="button" 
                                    class="btn btn-primary wizard-next-btn"
                                    data-target-step="{{ $index + 1 }}"
                                    data-validate="true">
                                Next<i class="fas fa-chevron-right ms-2"></i>
                            </button>
                            @else
                            <button type="button" class="btn btn-success wizard-finish-btn">
                                <i class="fas fa-check me-2"></i>Complete Wizard
                            </button>
                            @endif
                        </div>
                    </div>

                    {{-- Mobile Navigation --}}
                    <div class="mobile-step-nav d-md-none mt-3">
                        <div class="btn-group w-100" role="group">
                            @if($index > 0)
                            <button type="button" class="btn btn-outline-secondary wizard-prev-btn-mobile">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            @endif
                            
                            <button type="button" class="btn btn-outline-primary step-info-mobile flex-fill">
                                Step {{ $index + 1 }} of {{ count($steps) }}
                            </button>
                            
                            @if($index < count($steps) - 1)
                            <button type="button" class="btn btn-primary wizard-next-btn-mobile">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            @else
                            <button type="button" class="btn btn-success wizard-finish-btn-mobile">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Loading Overlay --}}
    <div class="wizard-loading-overlay d-none">
        <div class="loading-content">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted">Processing step...</p>
        </div>
    </div>
</div>

{{-- Enhanced CSS Styles --}}
<style>
.form-wizard-container {
    --wizard-primary: #0d6efd;
    --wizard-secondary: #6c757d;
    --wizard-success: #198754;
    --wizard-danger: #dc3545;
    --wizard-warning: #ffc107;
    --wizard-light: #f8f9fa;
    --wizard-dark: #212529;
    --wizard-border: #dee2e6;
    --wizard-radius: 0.75rem;
    --wizard-shadow: 0 4px 12px rgba(0,0,0,0.1);
    --wizard-shadow-lg: 0 8px 25px rgba(0,0,0,0.15);
    --wizard-transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    
    background: white;
    border-radius: var(--wizard-radius);
    box-shadow: var(--wizard-shadow);
    overflow: hidden;
}

/* Progress Container */
.wizard-progress-container {
    background: linear-gradient(135deg, var(--wizard-light) 0%, #e9ecef 100%);
    padding: 2rem;
    border-bottom: 1px solid var(--wizard-border);
}

/* Steps Indicator */
.wizard-steps-indicator {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    position: relative;
}

.wizard-step-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
    max-width: 200px;
}

/* Step Circle */
.step-indicator-circle {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
    position: relative;
    z-index: 2;
    transition: var(--wizard-transition);
    border: 3px solid var(--wizard-border);
    background: white;
    color: var(--wizard-secondary);
}

.wizard-step-indicator.current .step-indicator-circle {
    background: var(--wizard-primary);
    border-color: var(--wizard-primary);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
}

.wizard-step-indicator.completed .step-indicator-circle {
    background: var(--wizard-success);
    border-color: var(--wizard-success);
    color: white;
}

.wizard-step-indicator.upcoming .step-indicator-circle {
    background: white;
    border-color: var(--wizard-border);
    color: var(--wizard-secondary);
}

/* Step Icons/Numbers */
.step-number {
    font-weight: 700;
    font-size: 1.1rem;
}

.step-check-icon,
.step-custom-icon {
    font-size: 1.2rem;
}

.step-dot {
    font-size: 0.5rem;
}

/* Step Labels */
.step-label {
    text-align: center;
    max-width: 120px;
}

.step-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--wizard-dark);
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.step-description {
    font-size: 0.75rem;
    color: var(--wizard-secondary);
    line-height: 1.3;
}

.wizard-step-indicator.current .step-title {
    color: var(--wizard-primary);
    font-weight: 700;
}

.wizard-step-indicator.completed .step-title {
    color: var(--wizard-success);
}

/* Progress Lines */
.step-progress-line {
    position: absolute;
    top: 1.5rem;
    left: calc(50% + 1.5rem);
    right: calc(-50% + 1.5rem);
    height: 3px;
    background: var(--wizard-border);
    z-index: 1;
    border-radius: 1.5px;
}

.step-progress-line .progress-line-fill {
    height: 100%;
    background: var(--wizard-success);
    width: 0%;
    border-radius: 1.5px;
    transition: width 0.6s ease;
}

.step-progress-line.completed .progress-line-fill {
    width: 100%;
}

/* Overall Progress */
.wizard-overall-progress {
    margin-bottom: 0;
}

.wizard-progress-bar {
    height: 8px;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 4px;
    margin-bottom: 0.75rem;
}

.wizard-progress-bar .progress-bar {
    border-radius: 4px;
    transition: width 0.6s ease;
}

.progress-text {
    text-align: center;
}

/* Step Content */
.wizard-content-container {
    position: relative;
    min-height: 500px;
}

.wizard-step-content {
    display: none;
    opacity: 0;
    transform: translateX(20px);
    transition: var(--wizard-transition);
}

.wizard-step-content.active {
    display: block;
    opacity: 1;
    transform: translateX(0);
}

.step-content-wrapper {
    padding: 2.5rem;
}

/* Step Header */
.step-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--wizard-border);
}

.step-header-main {
    display: flex;
    align-items: center;
    flex: 1;
}

.step-icon-large {
    width: 4rem;
    height: 4rem;
    border-radius: 1rem;
    background: linear-gradient(135deg, var(--wizard-primary), #0b5ed7);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.5rem;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.step-header-text {
    flex: 1;
}

.step-main-title {
    color: var(--wizard-dark);
    font-weight: 700;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.step-main-description {
    color: var(--wizard-secondary);
    font-size: 1.1rem;
    line-height: 1.4;
    margin: 0;
}

.step-status .badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    font-weight: 600;
}

/* Step Content Body */
.step-content-body {
    margin-bottom: 2rem;
}

.step-placeholder {
    background: linear-gradient(135deg, var(--wizard-light) 0%, #e9ecef 100%);
    border: 2px dashed var(--wizard-border);
    border-radius: var(--wizard-radius);
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Step Navigation */
.step-navigation {
    background: var(--wizard-light);
    margin: 2rem -2.5rem -2.5rem;
    padding: 1.5rem 2.5rem;
    border-top: 1px solid var(--wizard-border);
}

.nav-info .step-dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.nav-info .step-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--wizard-border);
    transition: var(--wizard-transition);
    cursor: pointer;
}

.nav-info .step-dot.active {
    background: var(--wizard-primary);
    transform: scale(1.3);
}

.nav-info .step-dot.completed {
    background: var(--wizard-success);
}

/* Navigation Buttons */
.wizard-prev-btn,
.wizard-next-btn,
.wizard-finish-btn {
    padding: 0.875rem 2rem;
    font-weight: 600;
    border-radius: calc(var(--wizard-radius) * 0.8);
    transition: var(--wizard-transition);
}

.wizard-prev-btn:hover,
.wizard-next-btn:hover,
.wizard-finish-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--wizard-shadow);
}

.wizard-next-btn:hover {
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
}

.wizard-finish-btn:hover {
    box-shadow: 0 4px 15px rgba(25, 135, 84, 0.4);
}

/* Mobile Navigation */
.mobile-step-nav .btn-group .btn {
    border-radius: 0;
    font-weight: 500;
}

.mobile-step-nav .btn-group .btn:first-child {
    border-radius: calc(var(--wizard-radius) * 0.6) 0 0 calc(var(--wizard-radius) * 0.6);
}

.mobile-step-nav .btn-group .btn:last-child {
    border-radius: 0 calc(var(--wizard-radius) * 0.6) calc(var(--wizard-radius) * 0.6) 0;
}

/* Vertical Wizard Layout */
.vertical-wizard {
    display: flex;
}

.vertical-wizard .wizard-progress-container {
    width: 300px;
    border-right: 1px solid var(--wizard-border);
    border-bottom: none;
}

.vertical-wizard .wizard-steps-indicator {
    flex-direction: column;
    align-items: stretch;
}

.vertical-wizard .wizard-step-indicator {
    flex-direction: row;
    margin-bottom: 2rem;
    max-width: none;
}

.vertical-wizard .step-label {
    text-align: left;
    max-width: none;
    margin-left: 1rem;
}

.vertical-wizard .step-progress-line {
    position: absolute;
    top: calc(50% + 1.5rem);
    bottom: calc(-50% - 1.5rem);
    left: 1.5rem;
    right: auto;
    width: 3px;
    height: auto;
}

.vertical-wizard .wizard-content-container {
    flex: 1;
}

/* Loading Overlay */
.wizard-loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(2px);
}

.loading-content {
    text-align: center;
    padding: 2rem;
}

/* Animations */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.wizard-step-content.slide-in-right {
    animation: slideInRight 0.4s ease;
}

.wizard-step-content.slide-in-left {
    animation: slideInLeft 0.4s ease;
}

.wizard-step-content.fade-in {
    animation: fadeIn 0.3s ease;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .wizard-progress-container {
        padding: 1.5rem;
    }
    
    .wizard-steps-indicator {
        overflow-x: auto;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    
    .wizard-step-indicator {
        min-width: 100px;
        margin-right: 1rem;
    }
    
    .step-indicator-circle {
        width: 2.5rem;
        height: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    .step-title {
        font-size: 0.8rem;
    }
    
    .step-description {
        font-size: 0.7rem;
    }
    
    .step-content-wrapper {
        padding: 1.5rem;
    }
    
    .step-header {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .step-header-main {
        margin-bottom: 1rem;
    }
    
    .step-icon-large {
        width: 3rem;
        height: 3rem;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    
    .step-main-title {
        font-size: 1.5rem;
    }
    
    .step-main-description {
        font-size: 1rem;
    }
    
    .step-navigation {
        margin: 1.5rem -1.5rem -1.5rem;
        padding: 1rem 1.5rem;
    }
    
    .nav-info {
        display: none !important;
    }
    
    .wizard-prev-btn,
    .wizard-next-btn,
    .wizard-finish-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
    }
    
    /* Vertical wizard becomes horizontal on mobile */
    .vertical-wizard {
        flex-direction: column;
    }
    
    .vertical-wizard .wizard-progress-container {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid var(--wizard-border);
    }
    
    .vertical-wizard .wizard-steps-indicator {
        flex-direction: row;
        overflow-x: auto;
    }
    
    .vertical-wizard .wizard-step-indicator {
        flex-direction: column;
        min-width: 100px;
    }
    
    .vertical-wizard .step-label {
        text-align: center;
        margin-left: 0;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .form-wizard-container {
        --wizard-light: #343a40;
        --wizard-dark: #ffffff;
        --wizard-border: #495057;
        background: #2b3035;
    }
    
    .step-placeholder {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        color: #ffffff;
    }
    
    .step-navigation {
        background: #1e2124;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .wizard-step-indicator.current .step-indicator-circle {
        border-width: 4px;
    }
    
    .step-progress-line {
        height: 4px;
    }
    
    .nav-info .step-dot {
        width: 10px;
        height: 10px;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .form-wizard-container * {
        transition: none !important;
        animation: none !important;
    }
}
</style>

{{-- Enhanced JavaScript Functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wizard = document.getElementById('{{ $id }}');
    if (!wizard) return;

    const steps = {{ count($steps) }};
    let currentStep = {{ $currentStep }};
    const allowStepClick = {{ $allowStepClick ? 'true' : 'false' }};
    const animation = '{{ $animation }}';
    
    const stepContents = wizard.querySelectorAll('.wizard-step-content');
    const stepIndicators = wizard.querySelectorAll('.wizard-step-indicator');
    const progressBar = wizard.querySelector('.progress-bar');
    const nextBtns = wizard.querySelectorAll('.wizard-next-btn, .wizard-next-btn-mobile');
    const prevBtns = wizard.querySelectorAll('.wizard-prev-btn, .wizard-prev-btn-mobile');
    const finishBtns = wizard.querySelectorAll('.wizard-finish-btn, .wizard-finish-btn-mobile');
    const stepDots = wizard.querySelectorAll('.nav-info .step-dot');

    // Initialize wizard
    function initializeWizard() {
        updateWizardState();
        attachEventListeners();
        
        // Custom initialization event
        wizard.dispatchEvent(new CustomEvent('wizardInitialized', {
            detail: { 
                currentStep, 
                totalSteps: steps,
                wizardElement: wizard
            }
        }));
    }

    // Attach event listeners
    function attachEventListeners() {
        // Next buttons
        nextBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const targetStep = parseInt(btn.dataset.targetStep);
                const shouldValidate = btn.dataset.validate === 'true';
                
                if (shouldValidate && !validateCurrentStep()) {
                    return;
                }
                
                goToStep(targetStep);
            });
        });

        // Previous buttons
        prevBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const targetStep = parseInt(btn.dataset.targetStep || (currentStep - 1));
                goToStep(targetStep);
            });
        });

        // Finish buttons
        finishBtns.forEach(btn => {
            btn.addEventListener('click', handleWizardCompletion);
        });

        // Step indicators (if clicking allowed)
        if (allowStepClick) {
            stepIndicators.forEach((indicator, index) => {
                indicator.style.cursor = 'pointer';
                indicator.addEventListener('click', () => {
                    if (index <= currentStep || validateCurrentStep()) {
                        goToStep(index);
                    }
                });
            });
        }

        // Step dots navigation
        stepDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                if (index <= currentStep || validateCurrentStep()) {
                    goToStep(index);
                }
            });
        });

        // Form validation on input
        wizard.addEventListener('input', debounce(validateCurrentStep, 300));
        wizard.addEventListener('change', validateCurrentStep);

        // Keyboard navigation
        wizard.addEventListener('keydown', handleKeyboardNavigation);
    }

    // Navigate to specific step
    function goToStep(stepIndex) {
        if (stepIndex < 0 || stepIndex >= steps || stepIndex === currentStep) {
            return;
        }

        const previousStep = currentStep;
        currentStep = stepIndex;

        // Show loading if needed
        showLoading();

        // Custom event before step change
        const beforeChangeEvent = new CustomEvent('beforeStepChange', {
            detail: {
                previousStep,
                currentStep,
                direction: stepIndex > previousStep ? 'forward' : 'backward'
            },
            cancelable: true
        });

        if (!wizard.dispatchEvent(beforeChangeEvent)) {
            currentStep = previousStep; // Revert if cancelled
            hideLoading();
            return;
        }

        // Update wizard state with animation
        setTimeout(() => {
            updateWizardState();
            applyStepAnimation(stepIndex > previousStep ? 'forward' : 'backward');
            hideLoading();

            // Custom event after step change
            wizard.dispatchEvent(new CustomEvent('stepChanged', {
                detail: {
                    previousStep,
                    currentStep,
                    stepElement: stepContents[currentStep],
                    stepData: getStepData(currentStep)
                }
            }));

            // Focus management for accessibility
            const currentStepContent = stepContents[currentStep];
            const firstFocusable = currentStepContent.querySelector('input, select, textarea, button');
            if (firstFocusable) {
                firstFocusable.focus();
            }
        }, 100);
    }

    // Update wizard visual state
    function updateWizardState() {
        // Update step content visibility
        stepContents.forEach((content, index) => {
            content.classList.toggle('active', index === currentStep);
        });

        // Update step indicators
        stepIndicators.forEach((indicator, index) => {
            indicator.classList.remove('current', 'completed', 'upcoming');
            
            if (index === currentStep) {
                indicator.classList.add('current');
            } else if (index < currentStep) {
                indicator.classList.add('completed');
                
                // Update progress lines
                const progressLine = indicator.querySelector('.step-progress-line');
                if (progressLine) {
                    progressLine.classList.add('completed');
                }
            } else {
                indicator.classList.add('upcoming');
            }
        });

        // Update progress bar
        if (progressBar) {
            const progress = ((currentStep + 1) / steps) * 100;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', currentStep + 1);
            
            // Update progress text
            const progressText = wizard.querySelector('.progress-text small');
            if (progressText) {
                progressText.innerHTML = `Step ${currentStep + 1} of ${steps} (${Math.round(progress)}% complete)`;
            }
        }

        // Update step dots
        stepDots.forEach((dot, index) => {
            dot.classList.remove('active', 'completed');
            if (index === currentStep) {
                dot.classList.add('active');
            } else if (index < currentStep) {
                dot.classList.add('completed');
            }
        });

        // Update wizard container data attribute
        wizard.dataset.currentStep = currentStep;
    }

    // Apply step transition animation
    function applyStepAnimation(direction) {
        const currentStepElement = stepContents[currentStep];
        
        if (animation === 'slide') {
            const animationClass = direction === 'forward' ? 'slide-in-right' : 'slide-in-left';
            currentStepElement.classList.add(animationClass);
            
            setTimeout(() => {
                currentStepElement.classList.remove(animationClass);
            }, 400);
        } else if (animation === 'fade') {
            currentStepElement.classList.add('fade-in');
            
            setTimeout(() => {
                currentStepElement.classList.remove('fade-in');
            }, 300);
        }
    }

    // Validate current step
    function validateCurrentStep() {
        const currentStepElement = stepContents[currentStep];
        const validationSummary = currentStepElement.querySelector('.step-validation-summary');
        const errorsList = currentStepElement.querySelector('.validation-errors-list');
        
        // Get all form fields in current step
        const formFields = currentStepElement.querySelectorAll('input, select, textarea');
        const errors = [];
        let isValid = true;

        formFields.forEach(field => {
            // Clear previous validation
            field.classList.remove('is-invalid');
            
            // Required field validation
            if (field.hasAttribute('required') && !field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                errors.push(`${getFieldLabel(field)} is required`);
            }
            
            // Email validation
            if (field.type === 'email' && field.value && !isValidEmail(field.value)) {
                isValid = false;
                field.classList.add('is-invalid');
                errors.push(`${getFieldLabel(field)} must be a valid email address`);
            }
            
            // Custom validation
            const customValidator = field.dataset.validator;
            if (customValidator && window[customValidator]) {
                const result = window[customValidator](field.value, field);
                if (result !== true) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    errors.push(result || `${getFieldLabel(field)} is invalid`);
                }
            }
        });

        // Update validation summary
        if (validationSummary && errorsList) {
            if (!isValid) {
                errorsList.innerHTML = errors.map(error => `<li>${error}</li>`).join('');
                validationSummary.classList.remove('d-none');
            } else {
                validationSummary.classList.add('d-none');
            }
        }

        return isValid;
    }

    // Handle wizard completion
    function handleWizardCompletion() {
        if (!validateCurrentStep()) {
            return;
        }

        showLoading();

        // Custom completion event
        const completionEvent = new CustomEvent('wizardCompleted', {
            detail: {
                stepData: getAllStepData(),
                formData: getFormData(),
                wizardElement: wizard
            },
            cancelable: true
        });

        if (wizard.dispatchEvent(completionEvent)) {
            // Default completion behavior
            setTimeout(() => {
                hideLoading();
                showCompletionMessage();
            }, 1000);
        } else {
            hideLoading();
        }
    }

    // Utility functions
    function getFieldLabel(field) {
        const label = field.closest('.form-group, .mb-3')?.querySelector('label');
        return label?.textContent?.replace('*', '').trim() || field.name || 'Field';
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function getStepData(stepIndex) {
        const stepElement = stepContents[stepIndex];
        const formData = new FormData();
        const fields = stepElement.querySelectorAll('input, select, textarea');
        
        fields.forEach(field => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                if (field.checked) {
                    formData.append(field.name, field.value);
                }
            } else {
                formData.append(field.name, field.value);
            }
        });
        
        return Object.fromEntries(formData.entries());
    }

    function getAllStepData() {
        const allData = {};
        for (let i = 0; i < steps; i++) {
            allData[`step_${i}`] = getStepData(i);
        }
        return allData;
    }

    function getFormData() {
        const form = wizard.closest('form');
        return form ? new FormData(form) : new FormData();
    }

    function showLoading() {
        const loadingOverlay = wizard.querySelector('.wizard-loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.classList.remove('d-none');
        }
    }

    function hideLoading() {
        const loadingOverlay = wizard.querySelector('.wizard-loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.classList.add('d-none');
        }
    }

    function showCompletionMessage() {
        // You can customize this completion message
        const completionHtml = `
            <div class="completion-message text-center p-5">
                <div class="completion-icon mb-4">
                    <i class="fas fa-check-circle fa-4x text-success"></i>
                </div>
                <h3 class="text-success mb-3">Wizard Completed Successfully!</h3>
                <p class="text-muted mb-4">All steps have been completed and your information has been processed.</p>
                <button type="button" class="btn btn-primary restart-wizard-btn">
                    <i class="fas fa-redo me-2"></i>Start Over
                </button>
            </div>
        `;
        
        wizard.querySelector('.wizard-content-container').innerHTML = completionHtml;
        
        // Add restart functionality
        wizard.querySelector('.restart-wizard-btn')?.addEventListener('click', () => {
            location.reload(); // Simple restart - you can customize this
        });
    }

    function handleKeyboardNavigation(e) {
        if (e.target.closest('.wizard-step-content')) {
            switch(e.key) {
                case 'ArrowRight':
                    if (e.ctrlKey && currentStep < steps - 1) {
                        e.preventDefault();
                        if (validateCurrentStep()) {
                            goToStep(currentStep + 1);
                        }
                    }
                    break;
                case 'ArrowLeft':
                    if (e.ctrlKey && currentStep > 0) {
                        e.preventDefault();
                        goToStep(currentStep - 1);
                    }
                    break;
            }
        }
    }

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
    window.formWizard = window.formWizard || {};
    window.formWizard['{{ $id }}'] = {
        goToStep,
        getCurrentStep: () => currentStep,
        getTotalSteps: () => steps,
        validateCurrentStep,
        getStepData: (index) => getStepData(index || currentStep),
        getAllStepData,
        complete: handleWizardCompletion,
        restart: () => goToStep(0)
    };

    // Initialize wizard
    initializeWizard();
});
</script>
