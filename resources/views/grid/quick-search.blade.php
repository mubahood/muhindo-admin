<form action="{!! $action !!}" pjax-container class="grid-search-form">
    <div class="input-group input-group-sm grid-search-container">
        <input type="text" name="{{ $key }}" class="form-control grid-quick-search" value="{{ $value }}" placeholder="{{ $placeholder }}">
        <button type="submit" class="btn btn-admin-search">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>