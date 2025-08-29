<div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-[30px]">
        @if ($shortcode->phone)
            <div class="px-6 text-center">
                <div class="relative -m-3 overflow-hidden text-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-32 h-32 mx-auto feather feather-hexagon fill-primary/5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    <div class="absolute start-0 end-0 flex items-center justify-center mx-auto text-4xl align-middle transition-all duration-500 ease-in-out top-2/4 -translate-y-2/4 text-primary rounded-xl">
                        <i class="mdi mdi-phone-outline"></i>
                    </div>
                </div>

                <div class="content mt-7">
                    <h5 class="text-xl font-medium title h5">{{ __('Phone') }}</h5>
                    <p class="mt-3 text-slate-400">{!! BaseHelper::clean($shortcode->phone_description) !!}</p>

                    <div class="mt-5">
                        <a href="tel:{!! BaseHelper::clean($shortcode->phone) !!}" dir="ltr" class="transition duration-500 btn btn-link text-primary hover:text-primary after:bg-primary" style="color: #00adee !important">{!! BaseHelper::clean($shortcode->phone) !!}</a>
                    </div>
                </div>
            </div>
        @endif

        @if ($shortcode->email)
            <div class="px-6 text-center">
                <div class="relative -m-3 overflow-hidden text-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-32 h-32 mx-auto feather feather-hexagon fill-primary/5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    <div class="absolute start-0 end-0 flex items-center justify-center mx-auto text-4xl align-middle transition-all duration-500 ease-in-out top-2/4 -translate-y-2/4 text-primary rounded-xl">
                        <i class="mdi mdi-email-outline"></i>
                    </div>
                </div>

                <div class="content mt-7">
                    <h5 class="text-xl font-medium title h5">{{ __('Email') }}</h5>
                    <p class="mt-3 text-slate-400">{!! BaseHelper::clean($shortcode->email_description) !!}</p>

                    <div class="mt-5">
                        <a href="mailto:{!! BaseHelper::clean($shortcode->email) !!}" class="transition duration-500 btn btn-link text-primary hover:text-primary after:bg-primary" style="color: #00adee !important">{!! BaseHelper::clean($shortcode->email) !!}</a>
                    </div>
                </div>
            </div>
        @endif

        @if ($shortcode->address)
            <div class="px-6 text-center">
                <div class="relative -m-3 overflow-hidden text-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-32 h-32 mx-auto feather feather-hexagon fill-primary/5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    <div class="absolute start-0 end-0 flex items-center justify-center mx-auto text-4xl align-middle transition-all duration-500 ease-in-out top-2/4 -translate-y-2/4 text-primary rounded-xl">
                        <i class="mdi mdi-map-marker-outline"></i>
                    </div>
                </div>

                <div class="content mt-7">
                    <h5 class="text-xl font-medium title h5">{{ __('Location') }}</h5>
                    <p class="mt-3 text-slate-400">{!! BaseHelper::clean($shortcode->address_description) !!}</p>

                    <div class="mt-5">
                        <a href="https://www.googlemap.com?q={{ $shortcode->address }}" class="transition duration-500 video-play-icon read-more lightbox btn btn-link text-primary hover:text-primary after:bg-primary" style="color: #00adee !important">{{ __('View on Google map') }}</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
