@php($style = $shortcode->style)

@switch($style)
    @case(1)
        <section class="relative mt-20">
            <div class="mx-2 container-fluid md:mx-4">
                <div class="relative table w-full pt-40 overflow-hidden shadow-md pb-52 rounded-2xl" id="home" data-images="{{ json_encode($images) }}">
                    <div class="absolute inset-0 bg-black/60"></div>
                    <div class="container">
                        <div class="grid grid-cols-1">
                            <div class="text-center md:text-start">
                                <h1 class="mb-6 text-4xl font-bold leading-normal text-white lg:leading-normal lg:text-5xl">
                                    {!! BaseHelper::clean(str_replace($shortcode->title_highlight, "<span class='text-primary'>$shortcode->title_highlight</span>", $shortcode->title)) !!}
                                </h1>
                                @if($subtitle = $shortcode->subtitle)
                                    <p class="max-w-xl text-xl text-white/70">{!! BaseHelper::clean($subtitle) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($shortcode->enabled_search_box)
            <div class="container relative">
                <div class="grid justify-center grid-cols-1">
                    <div class="relative -mt-32">
                        {!! Theme::partial('search-box', compact('categories', 'style', 'shortcode')) !!}
                    </div>
                </div>
            </div>
        @endif
        @break
    @case(2)
        <section class="relative table w-full overflow-hidden py-36 lg:py-44 zoom-image">
            <div class="absolute inset-0 image-wrap z-1" id="home" data-images="{{ json_encode($images) }}"></div>
            <div class="absolute inset-0 bg-black/70 z-2"></div>
            <div class="container z-3">
                <div class="grid grid-cols-1 mt-10">
                    <div class="text-center">
                        <h1 class="mb-6 text-4xl font-bold leading-normal text-white lg:leading-normal lg:text-5xl">
                            {!! BaseHelper::clean(str_replace($shortcode->title_highlight, "<span class='text-primary'>$shortcode->title_highlight</span>", $shortcode->title)) !!}
                        </h1>
                        @if($subtitle = $shortcode->subtitle)
                            <p class="max-w-xl mx-auto text-xl text-white/70">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                    </div>

                    @if($shortcode->enabled_search_box)
                        {!! Theme::partial('search-box', compact('categories', 'style', 'shortcode')) !!}
                    @endif
                </div>
            </div>
        </section>
        @break
    @case(4)
        <section class="relative flex items-center justify-center py-40 lg:h-screen bg-primary/10">
            <div class="container">
                <div class="grid md:grid-cols-2 gap-[30px] mt-10 items-center">
                    <div class="text-center md:text-start">
                        <h1 class="mb-6 text-4xl font-bold leading-normal lg:leading-normal lg:text-5xl">
                            {!! BaseHelper::clean(str_replace($shortcode->title_highlight, "<span class='text-primary'>$shortcode->title_highlight</span>", $shortcode->title)) !!}
                        </h1>
                        @if ($subtitle = $shortcode->subtitle)
                            <p class="max-w-xl text-xl text-slate-400">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif

                        <div class="relative mt-8">
                            {!! Theme::partial('search-box', compact('categories', 'style', 'shortcode')) !!}
                        </div>
                    </div>

                    <div class="relative lg:ms-10">
                        @if ($images[0])
                            <div class="p-5 bg-white rounded-t-full shadow dark:shadow-gray-700 dark:bg-slate-900">
                                <img src="{{ RvMedia::getImageUrl($images[0], false, RvMedia::getDefaultImage()) }}" class="rounded-md rounded-t-full shadow-md" alt="{{ $shortcode->title }}">
                            </div>
                        @endif
                        <div class="absolute start-0 end-0 text-center bottom-2/4 translate-y-2/4">
                            <a href="#" data-type="youtube" data-id="{{ $shortcode->youtube_video_id }}" data-group="hero-banner-youtube-video-{{ $shortcode->youtube_video_id }}" class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-md lightbox dark:shadow-gray-800 dark:bg-slate-900 text-primary">
                                <i class="inline-flex items-center justify-center text-2xl mdi mdi-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break
    @default
        @php($background = Arr::get($images, 0) ?? RvMedia::getImageUrl(theme_option('default_page_cover_image')))
        <section class="relative table w-full py-32 bg-center bg-no-repeat lg:py-36" id="home" data-images="{{ json_encode([$background]) }}">
            <div class="absolute inset-0 bg-black opacity-80"></div>
            <div class="container">
                <div class="grid grid-cols-1 mt-10 text-center">
                    <h3 class="text-3xl font-medium leading-normal text-white md:text-4xl md:leading-normal">
                        {!! BaseHelper::clean($shortcode->title) !!}
                    </h3>
                    @if($subtitle = $shortcode->subtitle)
                        <p class="max-w-3xl mx-auto mt-5 text-xl text-white/70">{!! BaseHelper::clean($subtitle) !!}</p>
                    @endif
                </div>
            </div>
        </section>

        @if($shortcode->enabled_search_box)
            @php($searchType = $shortcode->search_type)
            <div class="relative hidden md:block">
                <div class="overflow-hidden text-white shape z-1 dark:text-slate-900">
                    <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                    </svg>
                </div>
            </div>

            <div class="fixed top-0 start-0 w-10/12 h-screen transition-transform duration-300 -translate-x-full md:hidden z-999 dark:bg-gray-800" id="filter-drawer">
                <div class="absolute inset-0 w-full h-full p-4 overflow-y-auto bg-white dark:bg-slate-900">
                    <button type="button" id="close-filters" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm px-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <i class="text-xl mdi mdi-close"></i>
                    </button>
                    <div class="mt-8 mb-12 {{ $searchType === 'projects' ? 'project' : 'property' }}-search item-search">
                        {!! Theme::partial("real-estate.$searchType.search-box", ['id' => 'mobile', 'type' => 'rent', 'categories' => $categories]) !!}
                    </div>
                </div>
            </div>

            <div class="container relative hidden -mt-16 md:block z-1 item-search">
                <div class="grid grid-cols-1">
                    <div class="p-6 bg-white shadow-md dark:bg-slate-900 rounded-xl dark:shadow-gray-700">
                        {!! Theme::partial("real-estate.$searchType.search-box", ['id' => null, 'type' => 'rent', 'categories' => $categories]) !!}
                    </div>
                </div>
            </div>
        @endif
        @break
@endswitch
