{{-- Enhanced floating label select field --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'has-validation' !!}">
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        
        <input type="hidden" name="{{$name}}"/>
        
        <div class="form-floating">
            <select class="form-select {{$class}} {!! !$errors->has($errorKey) ? '' : 'is-invalid' !!}" 
                    name="{{$name}}" 
                    id="{{$id}}"
                    aria-label="{{$label}}"
                    {!! $attributes !!}>
                @if($groups)
                    @foreach($groups as $group)
                        <optgroup label="{{ $group['label'] }}">
                            @foreach($group['options'] as $select => $option)
                                <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                @else
                    <option value="" disabled {{ old($column, $value) == '' ? 'selected' : '' }}>Choose {{$label}}</option>
                    @foreach($options as $select => $option)
                        <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
                    @endforeach
                @endif
            </select>
            
            <label for="{{$id}}" class="form-label">{{$label}}</label>
        </div>

        @include('admin::form.help-block')
    </div>
</div>

<style>
/* Enhanced floating label select styles */
.form-floating > .form-select {
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
    line-height: 1.25;
    transition: all 0.3s ease-in-out;
}

.form-floating > .form-select ~ label {
    opacity: 0.65;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    color: var(--bs-primary);
}

.form-floating > .form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    animation: selectFocus 0.3s ease-in-out;
}

@keyframes selectFocus {
    0% {
        border-color: var(--bs-border-color);
        box-shadow: none;
    }
    100% {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }
}

/* Success state for select */
.form-floating > .form-select.is-valid {
    border-color: var(--bs-success);
    animation: selectSuccess 0.6s ease-in-out;
}

@keyframes selectSuccess {
    0% { box-shadow: 0 0 0 0 rgba(var(--bs-success-rgb), 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(var(--bs-success-rgb), 0); }
    100% { box-shadow: 0 0 0 0 rgba(var(--bs-success-rgb), 0); }
}

/* Error state for select */
.form-floating > .form-select.is-invalid {
    border-color: var(--bs-danger);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-danger-rgb), 0.25);
}

/* Custom select arrow enhancement */
.form-floating > .form-select {
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

.form-floating > .form-select:focus {
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%230d6efd' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
}

/* Dark mode support for select */
@media (prefers-color-scheme: dark) {
    .form-floating > .form-select {
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23adb5bd' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
    }
}
</style>
