<section class="relative w-full">
    <div class="relative mt-8 container-fluid">
        <div id="map"
             aria-label="{{ __('Add to wishlist') }}" data-type="{{ BaseHelper::stringify(request()->input('type')) }}"
             data-url="{{ route('public.ajax.projects.map') }}{{ isset($city) && $city ? '?city_id=' . $city->id : '' }}"
             data-center="{{ json_encode(RealEstateHelper::getMapCenterLatLng()) }}"
             style="height: 500px">
        </div>
    </div>
</section>

<script id="traffic-popup-map-template" type="text/x-custom-template">
    {!! Theme::partial('real-estate.properties.map') !!}
</script>
