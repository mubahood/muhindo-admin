{{-- UPDATED FOR BOOTSTRAP 5 - Priority 2.2 Component Migration --}}
@if($help)
<div class="form-text text-muted">
    <i class="fa {{ \Illuminate\Support\Arr::get($help, 'icon') }}"></i>&nbsp;{!! \Illuminate\Support\Arr::get($help, 'text') !!}
</div>
@endif