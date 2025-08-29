@php
    Theme::asset()->container('footer')->usePath()->add('filter', 'js/filter.js');
    Theme::asset()->container('footer')->usePath()->add('wishlist', 'js/wishlist.js');
    Theme::set('navStyle', 'dark');

    $showMap = false;
    $backgroundImage = theme_option('categories_background_image') ?? theme_option('default_page_cover_image');
    $layouts = [
        'grid' => [
            'name' => __('Grid'),
            'icon' => 'mdi mdi-view-grid-outline',
        ],
        'list' => [
            'name' => __('List'),
            'icon' => 'mdi mdi-view-list-outline',
        ],
    ];

    $currentLayout = BaseHelper::stringify(request()->query('layout')) ?? (theme_option('properties_list_layout') ?: 'grid');

    if (! in_array($currentLayout, array_keys($layouts))) {
        $currentLayout = 'grid';
    }

    $properties
        ->loadCount('reviews', fn ($query) => $query->where('status', \Botble\RealEstate\Enums\ReviewStatusEnum::APPROVED))
        ->loadAvg('reviews', 'star');
@endphp

<div class="relative mt-36 w-full h-[300px] bg-center bg-no-repeat" style="background-image: url('{{ RvMedia::getImageUrl($backgroundImage) }}')">
    <div class="absolute inset-0 bg-slate-900/70 "></div>
    <div class="container">
        <div class="grid grid-cols-1 pt-16 mt-10 text-center">
            <h3 class="text-3xl font-medium leading-normal text-white md:text-4xl md:leading-normal">
                {{ $category->name }}
            </h3>
            <p class="max-w-3xl mx-auto mt-5 text-xl text-white/70">{!! BaseHelper::clean($category->description) !!}</p>
        </div>
    </div>
</div>

<div>
    <div class="item-search">
        <form action="{{ url()->current() }}" class="search-filter" data-ajax-url="{{ route('public.properties') }}">
            <input type="hidden" name="category_id" value="{{ $category->id }}">
        </form>
    </div>

    {!! Theme::partial('shortcodes.properties-list.index', compact('properties', 'currentLayout', 'showMap')) !!}
</div>
