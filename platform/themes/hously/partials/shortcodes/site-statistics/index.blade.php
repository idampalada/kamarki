@php($backgroundImage = $shortcode->background_image ?? theme_option('default_page_cover_image'))

@switch($shortcode->style)
    @case('has-title')
        <div class="container pt-16 mt-16 lg:mt-24 lg:pt-24">
            @if ($backgroundImage)
                <div class="absolute inset-0 bg-center bg-no-repeat opacity-25 dark:opacity-50" style="background-image: url('{{ RvMedia::getImageUrl($backgroundImage) }}')"></div>
            @endif
            <div class="relative grid grid-cols-1 pb-8 text-center z-1">
                <h3 class="mb-4 text-2xl font-semibold leading-normal md:text-3xl md:leading-normal">{!! BaseHelper::clean($shortcode->title) !!}</h3>

                <p class="max-w-xl mx-auto text-slate-400">{!! BaseHelper::clean($shortcode->subtitle) !!}</p>
            </div>

            <div class="relative grid md:grid-cols-3 grid-cols-1 items-center mt-8 gap-[30px] z-1">
                @for($i = 1; $i < 4; $i++)
                    @if ($title = $shortcode->{'title_' . $i})
                        <div class="text-center counter-box">
                            <span class="mb-2 text-4xl font-semibold lg:text-5xl text-slate-400 dark:text-white"><span class="counter-value" data-target="{{ $shortcode->{'number_' . $i} }}">{{ $shortcode->{'number_' . $i} }}</span>+</span>
                            <h5 class="text-lg font-medium counter-head">{{ $title }}</h5>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
        @break
    @default
        <section class="relative py-24 mt-16 bg-fixed bg-center bg-no-repeat" @if ($backgroundImage) style="background-image: url('{{ RvMedia::getImageUrl($backgroundImage) }}')" @endif>
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="container">
                <div class="grid justify-center grid-cols-1 text-center lg:grid-cols-12 md:text-left">
                    <div class="lg:col-start-2 lg:col-span-10">
                        <div class="grid items-center grid-cols-1 md:grid-cols-3">
                            @for($i = 1; $i < 4; $i++)
                                @if ($title = $shortcode->{'title_' . $i})
                                    <div class="text-center counter-box">
                                        <span class="mb-2 text-4xl font-semibold text-white lg:text-5xl"><span class="counter-value" data-target="{{ $shortcode->{'number_' . $i} }}">{{ $shortcode->{'number_' . $i} }}</span>+</span>
                                        <h5 class="text-lg font-medium text-white counter-head">{{ $title }}</h5>
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @break
@endswitch
