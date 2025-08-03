{{-- UPDATED FOR BOOTSTRAP 5 - Priority 2.2 Component Migration --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($column) ?: 'is-invalid' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}" id="{{$id}}">

        @if($canCheckAll)
            <div class="form-check">
                <input class="form-check-input {{ $checkAllClass }}" type="checkbox" id="{{$id}}_all">
                <label class="form-check-label" for="{{$id}}_all">
                    {{ __('admin.all') }}
                </label>
            </div>
            <hr style="margin-top: 10px;margin-bottom: 0;">
        @endif

        @include('admin::form.error')

        @if($groups)

        @foreach($groups as $group => $options)

            <p style="{{ $canCheckAll ? 'margin: 15px 0 0 0;' : 'margin: 7px 0 0 0;' }}padding-bottom: 5px;border-bottom: 1px solid #eee;display: inline-block;">{{ $group }}</p>

            @foreach($options as $option => $label)

            <div class="form-check">
                <input class="form-check-input {{$class}}" type="checkbox" name="{{$name}}[]" value="{{$option}}" id="{{$id}}_{{$option}}" {{ false !== array_search($option, array_filter(old($column, $value ?? []))) || ($value === null && in_array($option, $checked)) ?'checked':'' }} {!! $attributes !!} />
                <label class="form-check-label" for="{{$id}}_{{$option}}">
                    {{$label}}
                </label>
            </div>

            @endforeach

        @endforeach

        @else

        @foreach($options as $option => $label)

            @if($inline)
                <div class="form-check form-check-inline">
                    <input class="form-check-input {{$class}}" type="checkbox" name="{{$name}}[]" value="{{$option}}" id="{{$id}}_{{$option}}" {{ false !== array_search($option, array_filter(old($column, $value ?? []))) || ($value === null && in_array($option, $checked)) ?'checked':'' }} {!! $attributes !!} />
                    <label class="form-check-label" for="{{$id}}_{{$option}}">
                        {{$label}}
                    </label>
                </div>
            @else
                <div class="form-check">
                    <input class="form-check-input {{$class}}" type="checkbox" name="{{$name}}[]" value="{{$option}}" id="{{$id}}_{{$option}}" {{ false !== array_search($option, array_filter(old($column, $value ?? []))) || ($value === null && in_array($option, $checked)) ?'checked':'' }} {!! $attributes !!} />
                    <label class="form-check-label" for="{{$id}}_{{$option}}">
                        {{$label}}
                    </label>
                </div>
            @endif

        @endforeach

        @endif

        <input type="hidden" name="{{$name}}[]">

        @include('admin::form.help-block')

    </div>
</div>
