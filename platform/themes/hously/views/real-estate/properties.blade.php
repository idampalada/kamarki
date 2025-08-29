{!! do_shortcode('[hero-banner style="default" title="' . __('Properties') . '" subtitle="' . __('Each place is a good choice, it will help you make the right decision, do not miss the opportunity to discover our wonderful properties.') . '" enabled_search_box="1" search_type="properties"][/hero-banner]') !!}

@php
    Theme::set('navStyle', 'light');
@endphp

{!! Theme::partial('shortcodes.properties-list.index', ['properties' => $properties, 'ajaxUrl' => $ajaxUrl ?? null, 'actionUrl' => $actionUrl ?? null]) !!}
