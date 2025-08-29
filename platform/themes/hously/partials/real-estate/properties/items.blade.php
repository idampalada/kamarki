@php
    Theme::asset()->container('footer')->usePath()->add('wishlist', 'js/wishlist.js');

    $currentLayout = $currentLayout ?? (BaseHelper::stringify(request()->query('layout')) ?? (theme_option('properties_list_layout') ?: 'grid'));

    if (! in_array($currentLayout, ['grid', 'list'])) {
        $currentLayout = 'grid';
    }
@endphp

{!! Theme::partial("real-estate.properties.items-$currentLayout", compact('properties')) !!}

@if ($properties instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $properties->links(Theme::getThemeNamespace('partials.pagination')) }}
@endif
