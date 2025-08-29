@php($style = 1)

<section class="mt-20">
    <div class="relative mt-20 container-fluid">
        <div id="map"
             data-url="{{ route('public.ajax.featured-properties-for-map') }}"
             data-center="{{ json_encode(RealEstateHelper::getMapCenterLatLng()) }}">
        </div>
    </div>
    <div class="container relative -mt-[100px] z-999">
        {!! Theme::partial('search-box', compact('categories', 'style', 'shortcode')) !!}
    </div>
</section>

<script id="traffic-popup-map-template" type="text/x-custom-template">
    {!! Theme::partial('real-estate.properties.map') !!}
</script>
