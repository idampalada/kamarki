@foreach($menu_nodes->loadMissing('metadata') as $item)
    <li class="my-2.5">
        <a href="{{ url($item->url) }}" class="duration-500 ease-in-out text-slate-300 hover:text-slate-400">
            <i class="{{ $item->icon_font ?? 'mdi mdi-chevron-right' }} me-1"></i>
            {{ $item->title }}
        </a>
    </li>
@endforeach
