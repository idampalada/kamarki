<div class="relative px-6 py-10 overflow-hidden bg-white shadow-lg -top-40 dark:bg-slate-900 lg:px-8 rounded-xl dark:shadow-gray-700">
    <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-[30px]">
        <div class="text-center md:text-start z-1">
            <h3 class="text-2xl font-medium leading-normal text-black md:text-3xl md:leading-normal dark:text-white">{!! $config['title'] ? BaseHelper::clean($config['title']) : __('Subscribe to Newsletter.') !!}</h3>
            <p class="max-w-xl mx-auto text-slate-400">{!! $config['subtitle'] ? BaseHelper::clean($config['subtitle']) : __('Subscribe to get latest updates and information.') !!}</p>
        </div>

        <div class="subcribe-form z-1">
            <form action="{{ route('public.newsletter.subscribe') }}" method="post" class="relative max-w-lg form-newsletter subscribe-form newsletter-form md:ms-auto">
                @csrf
                <input type="text" id="subcribe" name="email" class="bg-white rounded-full shadow input-newsletter dark:bg-slate-900 dark:shadow-gray-700" placeholder="{{ __('Enter your email:') }}">
                <button type="submit" class="text-white rounded-full bg-primary btn hover:bg-secondary"  style="background-color: #00adee !important;">{{ __('Subscribe') }}</button>
            </form>
        </div>
    </div>

    <div class="absolute -top-5 -start-5">
        <div class="mdi mdi-email-outline lg:text-[150px] text-7xl text-black/5 dark:text-white/5 ltr:-rotate-45 rtl:rotate-45"></div>
    </div>

    <div class="absolute -bottom-5 -end-5">
        <div class="mdi mdi-pencil-outline lg:text-[150px] text-7xl text-black/5 dark:text-white/5 rtl:-rotate-90"></div>
    </div>
</div>
