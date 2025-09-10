@if(Admin::user()->visible(\Illuminate\Support\Arr::get($item, 'roles', [])) && Admin::user()->can(\Illuminate\Support\Arr::get($item, 'permission')))
    @if(!isset($item['children']))
        <li class="nav-item">
            @if(url()->isValidUrl($item['uri']))
                <a href="{{ $item['uri'] }}" target="_blank" class="nav-link {{ admin_url($item['uri']) == request()->url() ? 'active' : '' }}">
            @else
                <a href="{{ admin_url($item['uri']) }}" class="nav-link {{ admin_url($item['uri']) == request()->url() ? 'active' : '' }}" data-pjax>
            @endif
                <i class="nav-icon fas fa-{{ str_replace('fa-', '', $item['icon'] ?? 'circle') }}"></i>
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
            <a href="#" class="nav-link" data-widget="treeview">
                <i class="nav-icon fas fa-{{ str_replace('fa-', '', $item['icon'] ?? 'folder') }}"></i>
                <p>
                    @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                        {{ __($titleTranslation) }}
                    @else
                        {{ admin_trans($item['title']) }}
                    @endif
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach($item['children'] as $subItem)
                    @if(Admin::user()->visible(\Illuminate\Support\Arr::get($subItem, 'roles', [])) && Admin::user()->can(\Illuminate\Support\Arr::get($subItem, 'permission')))
                        <li class="nav-item">
                            @if(url()->isValidUrl($subItem['uri']))
                                <a href="{{ $subItem['uri'] }}" target="_blank" class="nav-link {{ admin_url($subItem['uri']) == request()->url() ? 'active' : '' }}">
                            @else
                                <a href="{{ admin_url($subItem['uri']) }}" class="nav-link {{ admin_url($subItem['uri']) == request()->url() ? 'active' : '' }}" data-pjax>
                            @endif
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @if (Lang::has($subTitleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($subItem['title'])))))
                                        {{ __($subTitleTranslation) }}
                                    @else
                                        {{ admin_trans($subItem['title']) }}
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
    @endif
@endif