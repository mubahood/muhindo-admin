@extends('admin::index', ['header' => strip_tags($header)])

@section('content')
    <section class="content-header">
        <div class="content-header-container d-flex justify-content-between align-items-start flex-wrap">
            <!-- Page Title Section -->
            <div class="content-header-title">
                <h1 class="content-header-heading m-0">
                    {!! $header ?: trans('admin.title') !!}
                    @if($description ?? trans('admin.description'))
                        <small class="content-header-subtitle text-muted d-block">
                            {!! $description ?: trans('admin.description') !!}
                        </small>
                    @endif
                </h1>
            </div>

            <!-- Breadcrumb Section -->
            <div class="content-header-breadcrumb">
                @if ($breadcrumb)
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ admin_url('/') }}" class="breadcrumb-link">
                            <i class="fas fa-home"></i> {{ __('Home') }}
                        </a>
                    </li>
                    @foreach($breadcrumb as $item)
                        @if($loop->last)
                            <li class="breadcrumb-item active">
                                @if (\Illuminate\Support\Arr::has($item, 'icon'))
                                    <i class="fas fa-{{ $item['icon'] }}"></i>
                                @endif
                                {{ $item['text'] }}
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                @if (\Illuminate\Support\Arr::has($item, 'url'))
                                    <a href="{{ admin_url(\Illuminate\Support\Arr::get($item, 'url')) }}" class="breadcrumb-link">
                                        @if (\Illuminate\Support\Arr::has($item, 'icon'))
                                            <i class="fas fa-{{ $item['icon'] }}"></i>
                                        @endif
                                        {{ $item['text'] }}
                                    </a>
                                @else
                                    @if (\Illuminate\Support\Arr::has($item, 'icon'))
                                        <i class="fas fa-{{ $item['icon'] }}"></i>
                                    @endif
                                    {{ $item['text'] }}
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ol>
                @elseif(config('admin.enable_default_breadcrumb'))
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ admin_url('/') }}" class="breadcrumb-link">
                            <i class="fas fa-home"></i> {{ __('Home') }}
                        </a>
                    </li>
                    @for($i = 2; $i <= count(Request::segments()); $i++)
                        <li class="breadcrumb-item {{ $i == count(Request::segments()) ? 'active' : '' }}">
                            {{ ucfirst(Request::segment($i)) }}
                        </li>
                    @endfor
                </ol>
                @endif
            </div>
        </div>
    </section>

    <section class="content">
        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        @if($_view_)
            @include($_view_['view'], $_view_['data'])
        @else
            {!! $_content_ !!}
        @endif
    </section>
@endsection
