{{-- <ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
        <li @if ($row->css_class || $row->active) class="@if ($row->css_class) {{ $row->css_class }} @endif @if ($row->active) current @endif" @endif>
            <a href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif title="{{ $row->title }}">
                @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif <span>{!! BaseHelper::clean($row->title) !!}</span>
            </a>
            @if ($row->has_child)
                {!! Menu::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child
                ]) !!}
            @endif
        </li>
    @endforeach
</ul> --}}

@php
    $menu_nodes = Menu::generateMenu([
        'menu' => 'main-menu',
        'view' => 'main-menu'
    ])->getData()['menu_nodes'];
@endphp
<ul class="{{ 'navigation-menu justify-end' . $navClass }}">
    @foreach ($menu_nodes as $key => $row)
        <li @if ($row->css_class || $row->active) class="@if ($row->css_class) {{ $row->css_class }} @endif @if ($row->active) current @endif" @endif>
            <a href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif title="{{ $row->title }}">
                @if ($row->icon_font) <i class="{{ trim($row->icon_font) }}"></i> @endif <span>{!! BaseHelper::clean($row->title) !!}</span>
            </a>
            @if ($row->has_child)
                {!! Menu::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child
                ]) !!}
            @endif
        </li>
    @endforeach

    @if (auth('account')->check())
        <li class="">
            <a href="{{ route('dashboard') }}" class="sub-menu-item">
                Dashboard
            </a>
        </li>
        <li class="">
            <a href="{{ route('logout') }}" class="sub-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        <li class="">
            <a href="#" class="sub-menu-item">
                {{ auth('account')->user()->name }}
            </a>
        </li>
    @else
        <li class="">
            <a href="{{ route('login') }}" class="sub-menu-item">
                Login
            </a>
        </li>
        <li class="">
            <a href="{{ route('register') }}" class="sub-menu-item">
                Signup
            </a>
        </li>
    @endif
</ul>
