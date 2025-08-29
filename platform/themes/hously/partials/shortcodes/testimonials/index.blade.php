<div class="container mt-16 lg:mt-24">
    <div class="grid grid-cols-1 pb-8 text-center">
        <h3 class="mb-4 text-2xl font-semibold leading-normal md:text-3xl md:leading-normal">
            {!! BaseHelper::clean($shortcode->title) !!}
        </h3>
        <p class="max-w-xl mx-auto text-slate-400">{!! BaseHelper::clean($shortcode->subtitle) !!}</p>
    </div>

    @switch($shortcode->style)
        @case('style-2')
            <div class="relative flex justify-center">
                <div class="relative w-full">
                    <div class="tiny-three-item">
                        @foreach($testimonials as $testimonial)
                            <div class="tiny-slide">
                                <div class="mx-3 text-center">
                                    <p class="text-lg italic text-slate-400"> " {{ $testimonial->content }} " </p>

                                    <div class="mt-5 text-center">
                                        <ul class="mb-2 text-xl font-medium list-none text-amber-400">
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                        </ul>

                                        <img src="{{ RvMedia::getImageUrl($testimonial->image) }}" class="mx-auto rounded-full shadow-md h-14 w-14 dark:shadow-gray-700" alt="{{ $testimonial->name }}">
                                        <span class="block mt-2 fw-semibold">{{ $testimonial->name }}</span>
                                        <span class="text-sm text-slate-400">{{ $testimonial->company }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @break
        @default
            <div class="relative flex justify-center mt-16">
                <div class="relative w-full lg:w-1/3 md:w-1/2">
                    <div class="absolute -top-20 md:-start-24 -start-0">
                        <i class="mdi mdi-format-quote-open text-9xl opacity-5"></i>
                    </div>
                    <div class="absolute bottom-28 md:-end-24 -end-0">
                        <i class="mdi mdi-format-quote-close text-9xl opacity-5"></i>
                    </div>

                    <div class="tiny-single-item">
                        @foreach($testimonials as $testimonial)
                            <div class="tiny-slide">
                                <div class="text-center">
                                    <p class="text-xl italic text-slate-400"> " {{ $testimonial->content }} " </p>

                                    <div class="mt-5 text-center">
                                        <img src="{{ RvMedia::getImageUrl($testimonial->image) }}" class="mx-auto rounded-full shadow-md h-14 w-14 dark:shadow-gray-700" alt="{{ $testimonial->name }}">
                                        <span class="block mt-2 fw-semibold">{{ $testimonial->name }}</span>
                                        <span class="text-sm text-slate-400">{{ $testimonial->company }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @break
    @endswitch
</div>
