@if(Admin::user()->visible(\Illuminate\Support\Arr::get($item, 'roles', [])) && Admin::user()->can(\Illuminate\Support\Arr::get($item, 'permission')))
    @if(!isset($item['children']))
        <li class="nav-item">
            @if(url()->isValidUrl($item['uri']))
                <a href="{{ $item['uri'] }}" target="_blank" class="nav-link">
            @else
                <a href="{{ admin_url($item['uri']) }}" class="nav-link">
            @endif
                <i class="nav-icon fas {{ $item['icon'] }}"></i>
                <p>
                    @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                        {{ __($titleTranslation) }}
                    @else
                        {{ admin_trans($item['title']) }}
                    @endif
                </p>
            </a>
        </li>
    @else
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas {{ $item['icon'] }}"></i>
                <p>
                    @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                        {{ __($titleTranslation) }}
                    @else
                        {{ admin_trans($item['title']) }}
                    @endif
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach($item['children'] as $item)
                    @include('admin::partials.menu', $item)
                @endforeach
            </ul>
        </li>
    @endif
@endif