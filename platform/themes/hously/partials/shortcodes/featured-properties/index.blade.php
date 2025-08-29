<div class="container mt-16 lg:mt-24">
    <div class="grid grid-cols-1 pb-8 text-center">
        <h3 class="mb-4 text-2xl font-semibold leading-normal md:text-3xl md:leading-normal">{!! BaseHelper::clean($shortcode->title) !!}</h3>
        <p class="max-w-xl mx-auto text-slate-400">{!! BaseHelper::clean($shortcode->subtitle) !!}</p>
    </div>
    @switch($shortcode->style)
        @case('list')
            {!! Theme::partial('real-estate.properties.items-list', compact('properties')) !!}
            @break
        @default
            {!! Theme::partial('real-estate.properties.items', compact('properties')) !!}
            @break
    @endswitch
</div>
