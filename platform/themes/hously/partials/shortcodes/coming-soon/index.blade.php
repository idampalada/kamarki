@php($backgroundImage = $shortcode->background_image ?? theme_option('default_page_cover_image'))

<section class="relative flex items-center justify-center overflow-hidden md:h-screen py-36 zoom-image">
    <div class="absolute inset-0 bg-center bg-cover bg-no-repeat image-wrap z-1" style="background-image: url('{{ RvMedia::getImageUrl($backgroundImage) }}')"></div>
    @if ($shortcode->enable_snow_effect)
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow">
            <canvas class="particles-js-canvas-el" width="2010" height="1612" style="width: 100%; height: 100%;"></canvas>
        </div>
    @endif
    <div class="relative container-fluid z-3">
        <div class="grid grid-cols-1">
            <div class="flex flex-col justify-center min-h-screen px-4 py-10 md:px-10">
                <div class="text-center">
                    <a href="{{ route('public.index') }}">
                        <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" class="mx-auto" alt="{{ theme_option('site_title') }}">
                    </a>
                </div>
                <div class="my-auto text-center title-heading">
                    <h1 class="mt-3 mb-6 text-3xl font-bold text-white md:text-5xl">{!! BaseHelper::clean($shortcode->title) !!}</h1>
                    <p class="max-w-xl mx-auto text-lg text-white/70">{!! BaseHelper::clean($shortcode->subtitle) !!}</p>
                    <div id="countdown">
                        <input type="hidden" class="time-end" value="{{ $shortcode->time }}">
                        <ul class="inline-block m-6 mt-8 text-center text-white list-none count-down">
                            <li id="days" class="inline-block m-2 count-number"></li>
                            <li id="hours" class="inline-block m-2 count-number"></li>
                            <li id="mins" class="inline-block m-2 count-number"></li>
                            <li id="secs" class="inline-block m-2 count-number"></li>
                            <li id="end" class="h1"></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center">
                    <p class="mb-0 text-slate-400">{!! BaseHelper::clean(theme_option('copyright')) !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>
