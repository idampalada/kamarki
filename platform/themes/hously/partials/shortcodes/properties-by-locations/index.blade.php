<section class="relative pt-28 lg:pt-32">
    <div class="container">
        <h4 class="mb-2 text-3xl font-medium text-center">{!! BaseHelper::clean(str_replace($title_highlight_text = $shortcode->title_highlight_text, "<span class='font-italic'>$title_highlight_text</span>", $shortcode->title)) !!}</h4>
        @if ($subtitle = $shortcode->subtitle)
            <p class="py-2 text-center text-gray-500">{!! BaseHelper::clean($subtitle) !!}</p>
        @endif
        <div class="relative flex justify-center mt-7">
            <div class="relative w-full">
                <div class="tns-controls" id="customize-controls" tabindex="0">
                    <button type="button" data-controls="next" tabindex="-1" aria-controls="tns1" aria-label="{{ __('Prev') }}">
                        <i class="mdi mdi-chevron-left align-top inline-block mt-0.5"></i>
                    </button>
                    <button type="button" data-controls="prev" tabindex="-1" aria-controls="tns1" aria-label="{{ __('Next') }}">
                        <i class="mdi mdi-chevron-right align-top inline-block mt-0.5"></i>
                    </button>
                </div>
                <div class="tiny-properties-location-slide-four">
                    @foreach($cities as $city)
                        <div class="tiny-slider">
                            <div class="overflow-hidden duration-500 ease-in-out bg-white shadow location-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700">
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('public.properties-by-city', $city->slug) }}">
                                        <img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}">
                                        <div class="absolute inset-0 bg-slate-900 bg-opacity-40"></div>
                                        <div class="absolute -translate-x-1/2 top-2/3 start-1/2 -translate-y-2/3">
                                            <p class="text-xl font-bold text-white">{{ $city->name }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
