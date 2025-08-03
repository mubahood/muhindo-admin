{{-- UPDATED FOR BOOTSTRAP 5 - Priority 2.2 Component Migration --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'is-invalid' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="input-group">

            @if ($prepend)
            <span class="input-group-text">{!! $prepend !!}</span>
            @endif

            <input {!! $attributes !!} />

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
