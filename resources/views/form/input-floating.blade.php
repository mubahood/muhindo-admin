{{-- Enhanced floating label input field --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'has-validation' !!}">
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        
        <div class="form-floating {{ $prepend || $append ? 'input-group' : '' }}">
            @if ($prepend)
                <span class="input-group-text">{!! $prepend !!}</span>
            @endif

            <input {!! $attributes !!} 
                   class="form-control {!! !$errors->has($errorKey) ? '' : 'is-invalid' !!}" 
                   placeholder="{{$label}}" 
                   id="{{$id}}" />
                   
            <label for="{{$id}}" class="form-label">{{$label}}</label>

            @if ($append)
                <span class="input-group-text">{!! $append !!}</span>
            @endif

            @isset($btn)
                <div class="input-group-append">
                  {!! $btn !!}
                </div>
            @endisset
        </div>

        @include('admin::form.help-block')
    </div>
</div>

<style>
/* Enhanced floating label styles */
.form-floating {
    position: relative;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label,
.form-floating > .form-select ~ label {
    opacity: 0.65;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    color: var(--bs-primary);
}

.form-floating > .form-control {
    padding: 1rem 0.75rem;
    transition: all 0.3s ease-in-out;
}

.form-floating > .form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}

.form-floating > label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem 0.75rem;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
    color: var(--bs-gray-600);
    font-weight: 400;
}

/* Animation enhancement */
.form-floating > .form-control {
    animation: none;
}

.form-floating > .form-control:focus {
    animation: inputFocus 0.3s ease-in-out;
}

@keyframes inputFocus {
    0% {
        border-color: var(--bs-border-color);
        box-shadow: none;
    }
    100% {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }
}

/* Success state animation */
.form-floating > .form-control.is-valid {
    border-color: var(--bs-success);
    animation: successPulse 0.6s ease-in-out;
}

@keyframes successPulse {
    0% { box-shadow: 0 0 0 0 rgba(var(--bs-success-rgb), 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(var(--bs-success-rgb), 0); }
    100% { box-shadow: 0 0 0 0 rgba(var(--bs-success-rgb), 0); }
}

/* Error state enhancement */
.form-floating > .form-control.is-invalid {
    border-color: var(--bs-danger);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-danger-rgb), 0.25);
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .form-floating > label {
        color: var(--bs-gray-300);
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: var(--bs-primary);
    }
}
</style>
