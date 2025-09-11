<div class="btn-group filter-button-group" data-toggle="buttons">
    <button type="button" class="btn btn-sm btn-outline-secondary btn-admin-filter {{ $btn_class }} {{ $expand ? 'active' : '' }}" 
           title="{{ trans('admin.filter') }}" 
           data-filter-toggle="{{ $filter_id }}">
        <i class="fas fa-filter"></i><span class="filter-text d-none d-sm-inline">&nbsp;&nbsp;{{ trans('admin.filter') }}</span>
    </button>

    @if($scopes->isNotEmpty())
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
        <span class="filter-scope-label">{{ $label }}</span>
        <i class="fas fa-chevron-down ms-1"></i>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        @foreach($scopes as $scope)
            {!! $scope->render() !!}
        @endforeach
        <li role="separator" class="divider"></li>
        <li><a class="dropdown-item" href="{{ $cancel }}">{{ trans('admin.cancel') }}</a></li>
    </ul>
    @endif
</div>

<script>
$(document).ready(function() {
    var $btn = $('.{{ $btn_class }}');
    var $filter = $('#{{ $filter_id }}');

    // Remove any existing handlers to prevent conflicts
    $btn.off('click.filter-toggle');
    
    // Add the click handler with namespace
    $btn.on('click.filter-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        if ($filter.hasClass('hide') || !$filter.is(':visible')) {
            $filter.removeClass('hide').show();
            $btn.addClass('active');
        } else {
            $filter.addClass('hide').hide();
            $btn.removeClass('active');
        }
    });
});
