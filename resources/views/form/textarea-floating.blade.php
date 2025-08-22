{{-- Enhanced floating label textarea field --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'has-validation' !!}">
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        
        <div class="form-floating">
            <textarea name="{{$name}}" 
                      class="form-control {{$class}} {!! !$errors->has($errorKey) ? '' : 'is-invalid' !!}" 
                      rows="{{ $rows }}" 
                      placeholder="{{$label}}" 
                      id="{{$id}}"
                      style="height: {{ $rows * 1.5 + 3 }}rem"
                      {!! $attributes !!}>{{ old($column, $value) }}</textarea>
                      
            <label for="{{$id}}" class="form-label">{{$label}}</label>
        </div>

        {!! $append !!}

        @include('admin::form.help-block')
    </div>
</div>

<style>
/* Enhanced floating label textarea styles */
.form-floating > textarea.form-control {
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
    resize: vertical;
    transition: all 0.3s ease-in-out;
}

.form-floating > textarea.form-control ~ label {
    padding-top: 1rem;
    padding-bottom: 1rem;
    height: auto;
}

.form-floating > textarea.form-control:focus ~ label,
.form-floating > textarea.form-control:not(:placeholder-shown) ~ label {
    opacity: 0.65;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    color: var(--bs-primary);
}

/* Textarea specific animations */
.form-floating > textarea.form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    animation: textareaFocus 0.3s ease-in-out;
}

@keyframes textareaFocus {
    0% {
        border-color: var(--bs-border-color);
        box-shadow: none;
    }
    100% {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }
}

/* Auto-resize functionality */
.form-floating > textarea.form-control.auto-resize {
    resize: none;
    overflow: hidden;
}
</style>

<script>
// Auto-resize functionality for textareas
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('.form-floating textarea.auto-resize');
    
    textareas.forEach(textarea => {
        const adjustHeight = () => {
            textarea.style.height = 'auto';
            textarea.style.height = Math.max(textarea.scrollHeight, 100) + 'px';
        };
        
        textarea.addEventListener('input', adjustHeight);
        textarea.addEventListener('focus', adjustHeight);
        
        // Initialize height
        adjustHeight();
    });
});
</script>
