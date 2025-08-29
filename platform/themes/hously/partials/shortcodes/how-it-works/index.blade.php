<div class="container mt-16 lg:mt-24">
    <div class="grid grid-cols-1 pb-8 text-center">
        <h3 class="mb-4 text-2xl font-semibold leading-normal md:text-3xl md:leading-normal">{!! BaseHelper::clean($shortcode->title) !!}</h3>
        <p class="max-w-xl mx-auto text-slate-400">{!! BaseHelper::clean($shortcode->subtitle) !!}</p>
    </div>

    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]">
        @foreach(range(1, 3) as $i)
            <div class="relative overflow-hidden text-center transition-all duration-500 ease-in-out bg-white group lg:px-10 rounded-xl dark:bg-slate-900">
                <div class="relative -m-3 overflow-hidden text-transparent">
                    <i data-feather="hexagon" class="w-32 h-32 mx-auto fill-primary/5"></i>
                    <div class="absolute start-0 end-0 flex items-center justify-center mx-auto text-4xl align-middle transition-all duration-500 ease-in-out top-2/4 -translate-y-2/4 text-primary rounded-xl">
                        <i class="{{ $shortcode->{'icon_' . $i} }}"></i>
                    </div>
                </div>
                <div class="mt-6">
                    @if($title = $shortcode->{'title_' . $i})
                        <h3 class="text-xl font-medium">{!! BaseHelper::clean($title) !!}</h3>
                    @endif
                    @if($description = $shortcode->{'description_' . $i})
                        <p class="mt-3 text-slate-400">{!! BaseHelper::clean($description) !!}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
