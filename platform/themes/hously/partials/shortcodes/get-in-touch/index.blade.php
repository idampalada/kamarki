<div class="container mt-16 lg:mt-24">
    <div class="grid grid-cols-1 text-center">
        <h3 class="mb-6 text-2xl font-medium leading-normal text-black md:text-3xl md:leading-normal dark:text-white">
            {!! BaseHelper::clean($shortcode->title) !!}
        </h3>

        @if($subtitle = $shortcode->subtitle)
            <p class="max-w-xl mx-auto text-slate-400">{!! BaseHelper::clean($subtitle) !!}</p>
        @endif

        @if($buttonLabel = $shortcode->button_label)
            <div class="mt-6">
                <a href="{{ $shortcode->button_url }}" class="text-white rounded-md bg-primary btn hover:bg-secondary">
                    <i class="align-middle mdi mdi-phone me-2"></i> {{ $buttonLabel }}
                </a>
            </div>
        @endif
    </div>
</div>
