<div class="container py-16 lg:py-24">
    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-x-[30px] gap-y-[50px]">
        @foreach(range(1, 6) as $i)
            <div class="relative overflow-hidden text-center transition-all duration-500 ease-in-out bg-white group md:text-left lg:px-10 rounded-xl dark:bg-slate-900">
                <div class="relative -m-3 overflow-hidden text-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-32 h-32 text-center feather feather-hexagon fill-primary/5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    <div class="absolute top-[50%] md:start-[45px] start-1/2 -translate-x-[50%] -translate-y-[50%] text-primary rounded-xl transition-all duration-500 ease-in-out text-4xl flex align-middle justify-center items-center">
                        <i class="{{ $shortcode->{'icon_' .$i} }}"></i>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{!! BaseHelper::clean($shortcode->{'url_' . $i}) !!}" class="text-xl font-medium hover:text-primary">{!! BaseHelper::clean($shortcode->{'title_' . $i}) !!}</a>
                    <p class="mt-3 text-slate-400">{!! BaseHelper::clean($shortcode->{'description_' .$i}) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
