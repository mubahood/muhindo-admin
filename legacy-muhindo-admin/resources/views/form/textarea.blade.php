{{-- UPDATED FOR BOOTSTRAP 5 - Priority 2.2 Component Migration --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'is-invalid' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea name="{{$name}}" class="form-control {{$class}} {!! $errors->has($errorKey) ? 'is-invalid' : '' !!}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{{ old($column, $value) }}</textarea>

        {!! $append !!}

        @include('admin::form.help-block')

    </div>
</div>
