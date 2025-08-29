@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet/leaflet.css');
    Theme::asset()->usePath()->add('style', 'css/style.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet/leaflet.js');
    Theme::asset()->container('footer')->usePath()->add('leaflet-markercluster', 'plugins/leaflet/leaflet.markercluster-src.js');

    $layouts = [
        'grid' => [
            'name' => __('Grid'),
            'icon' => 'mdi mdi-view-grid-outline',
        ],
        'list' => [
            'name' => __('List'),
            'icon' => 'mdi mdi-view-list-outline',
        ],
        'map' => [
            'name' => __('Map'),
            'icon' => 'mdi mdi-map-marker',
        ],
    ];

    $currentLayout = BaseHelper::stringify(request()->query('layout')) ?? (theme_option('projects_list_layout') ?: 'grid');

    if (! in_array($currentLayout, array_keys($layouts))) {
        $currentLayout = 'grid';
    }
@endphp

<div class="container mt-16 item-search">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <button class="block px-3 py-2 text-white transition-all bg-primary md:hidden rounded-xl hover:bg-secondary" id="open-filter">
                <i class="mdi mdi-filter"></i>
                <span class="hidden md:block">{{ __('Filter') }}</span>
            </button>
            {{-- @foreach($layouts as $key => $layout)
                <button @disabled($currentLayout === $key) @class(['hidden md:flex items-center pt-1 px-2 rounded-md text-white leading-none hover:bg-secondary cursor-pointer toggle-layout', 'bg-secondary' => $currentLayout === $key, 'bg-slate-500' => $currentLayout !== $key]) data-type="{{ $key }}" title="{{ $layout['name'] }}">
                    <i class="{{ $layout['icon'] }} text-2xl"></i>
                </button>
            @endforeach --}}
            @foreach($layouts as $key => $layout)
                <button
                    @disabled($currentLayout === $key)
                    @class(['hidden md:flex items-center pt-1 px-2 rounded-md text-white leading-none cursor-pointer toggle-layout',
                            'bg-secondary' => $currentLayout === $key,
                            'bg-slate-500' => $currentLayout !== $key])
                    data-type="{{ $key }}"
                    title="{{ $layout['name'] }}"
                    style="background-color: {{ $currentLayout === $key ? '#00adee' : '#00adee' }} !important;"
                >
                    <i class="{{ $layout['icon'] }} text-2xl"></i>
                </button>
            @endforeach

            <style>
                button[data-type="{{ $key }}"]:hover {
                    background-color: #0070a6 !important; /* Change to your desired hover color */
                }

                button[data-type="{{ $key }}"]:active {
                    background-color: #004d73 !important; /* Change to your desired active color */
                }
            </style>
        </div>
        {!! Theme::partial('filters.sort-order', ['perPages' => RealEstateHelper::getProjectsPerPageList()]) !!}
    </div>
</div>

<section class="relative">
    <div class="container">
        <div id="items-map" @class(['hidden' => (! request()->input('layout') == 'map') || ! $showMap])>
            {!! Theme::partial("real-estate.projects.items-map", compact('projects')) !!}
        </div>
        <div id="items-list" data-box-type="project" @class(['hidden' => request()->input('layout') == 'map']) data-layout="{{ theme_option('projects_list_layout') }}" style="max-height: none; max-width: none">
            {!! Theme::partial("real-estate.projects.items-$currentLayout", compact('projects')) !!}
        </div>
    </div>
</section>

<div class="hidden overflow-hidden duration-500 ease-in-out bg-white shadow group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700" id="project-grid-skeleton">
    <div class="relative">
        <div class="flex items-center justify-center w-full bg-gray-300 rounded h-60 dark:bg-gray-700">
            <i class="text-gray-200 text-8xl mdi mdi-image-filter-hdr"></i>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="space-y-4">
            <div class="h-2 rounded bg-slate-200"></div>
            <div class="w-3/5 h-2 rounded bg-slate-200"></div>
        </div>
    </div>
</div>

<div class="hidden w-full mx-auto overflow-hidden duration-500 ease-in-out bg-white shadow group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 lg:max-w-2xl" id="project-list-skeleton">
    <div class="md:flex">
        <div class="flex items-center justify-center bg-gray-300 rounded-l h-36 dark:bg-gray-700">
            <i class="px-12 text-gray-200 text-8xl mdi mdi-image-filter-hdr"></i>
        </div>
        <div class="w-full p-6">
            <div class="pb-6 space-y-4">
                <div class="hidden md:flex items-center -ms-0.5 mb-2">
                    <i class="me-1 text-sm mdi mdi-tag-outline text-slate-200"></i>
                    <div class="w-1/4 h-2 rounded bg-slate-200"></div>
                </div>
                <div class="h-2 rounded bg-slate-200"></div>
                <div class="w-3/5 h-2 rounded bg-slate-200"></div>
            </div>
        </div>
    </div>
</div>
