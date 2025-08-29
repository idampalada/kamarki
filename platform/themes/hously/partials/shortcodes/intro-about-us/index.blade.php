<div class="container mt-24">
    <div class="grid md:grid-cols-12 grid-cols-1 items-center gap-[30px]">
        <div class="md:col-span-5">
            <div class="relative">
                <img src="{{ RvMedia::getImageUrl($shortcode->image) ?? Theme::asset()->url('images/about.jpg') }}" class="shadow-md rounded-xl" alt="{!! BaseHelper::clean($shortcode->title) !!}">
                @if($videoId = $shortcode->youtube_video_id)
                    <div class="absolute start-0 end-0 text-center bottom-2/4 translate-y-2/4">
                        <a href="#!" data-group="intro-about-us" data-type="youtube" data-id="{!! BaseHelper::clean($videoId) !!}" class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-md lightbox dark:shadow-gyay-700 dark:bg-slate-900 text-primary" aria-label="{{ __('Play video') }}">
                            <i class="inline-flex items-center justify-center text-2xl mdi mdi-play"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="md:col-span-7">
            <div class="lg:ms-4">
                <h2 class="mb-6 text-2xl font-semibold leading-normal md:text-3xl lg:leading-normal">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                <p class="max-w-xl text-slate-400">{!! BaseHelper::clean($shortcode->description) !!}</p>

                @if ($shortcode->text_button_action)
                    <div class="mt-4">
                        <a href="{{ $shortcode->url_button_action }}" class="mt-3 text-white rounded-md btn bg-primary hover:bg-secondary">{!! BaseHelper::clean($shortcode->text_button_action) !!}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
