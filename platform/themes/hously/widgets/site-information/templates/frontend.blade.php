<div class="lg:col-span-4 md:col-span-12">
    @if($logo = Arr::get($config, 'logo'))
        <a href="{{ Arr::get($config, 'url') }}" class="text-[22px] focus:outline-none">
            <img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}">
        </a>
    @endif
    @if($description = Arr::get($config, 'description'))
        <p class="mt-6 text-gray-300">{!! BaseHelper::clean($description) !!}</p>
    @endif
</div>
