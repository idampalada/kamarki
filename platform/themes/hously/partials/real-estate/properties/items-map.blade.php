<section class="relative w-full">
    <div class="relative mt-8 container-fluid">
        <div
            id="map"
            data-url="{{ route('public.ajax.properties.map') }}"
            data-center="{{ json_encode(RealEstateHelper::getMapCenterLatLng()) }}"
            style="height: 500px"
        ></div>
    </div>
</section>

<script id="traffic-popup-map-template" type="text/x-custom-template">
    {!! Theme::partial('real-estate.properties.map') !!}
</script>
