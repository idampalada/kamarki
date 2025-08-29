<ul {!! $options !!}>
    @foreach($menu_nodes->loadMissing('metadata') as $key => $row)
        <li @class(['has-submenu parent-menu-item' => $row->has_child, 'active' => $row->active])>
            <a href="{{ url($row->url) }}" target="{{ $row->target }}" class="sub-menu-item">
                @if ($iconImage = $row->getMetadata('icon_image', true))
                    <img src="{{ RvMedia::getImageUrl($iconImage) }}" class="w-3 h-3 inline-block align-top mt-[5px]" />
                @elseif ($row->icon_font)
                    <i class="{{ trim($row->icon_font) }}"></i>
                @endif
                {{ $row->title }}
            </a>
            @if ($row->has_child)
                <span class="me-4 menu-arrow lg:me-0"></span>
                {!!
                    Menu::generateMenu([
                        'menu' => $menu,
                        'view'  => 'main-menu',
                        'options' => ['class' => 'submenu'],
                        'menu_nodes' => $row->child,
                    ])
                !!}
            @endif
        </li>
    @endforeach
</ul>
