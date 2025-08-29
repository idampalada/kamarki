<div class="lg:col-span-3 md:col-span-4">
    <div class="tracking-[1px] text-gray-100 font-semibold">{{ Arr::get($config, 'name') }}</div>
    @if($address = Arr::get($config, 'address'))
        <div class="flex mt-6">
            <i data-feather="map-pin" class="w-5 h-5 text-primary me-2"></i>
            <div>
                <span class="block mb-2 text-gray-300">{{ $address }}</span>
                <a href="https://maps.google.com/maps?q={{ addslashes($address) }}%20&t=&z=13&ie=UTF8&iwloc=&output=embed" data-type="iframe" data-group="contact-information" class="duration-500 ease-in-out text-primary hover:text-secondary lightbox">
                    {{ __('View on Google map') }}
                </a>
            </div>
        </div>
    @endif

    @if($email = Arr::get($config, 'email'))
        <div class="flex mt-6">
            <i data-feather="mail" class="w-5 h-5 text-primary me-2"></i>
            <div>
                <a href="mailto:{{ $email }}" class="duration-500 ease-in-out text-slate-300 hover:text-slate-400">{{ $email }}</a>
            </div>
        </div>
    @endif

    @if($phone = Arr::get($config, 'phone'))
        <div class="flex mt-6">
            <i data-feather="phone" class="w-5 h-5 text-primary me-2"></i>
            <div>
                <a href="tel:{{ $phone }}" dir="ltr" class="duration-500 ease-in-out text-slate-300 hover:text-slate-400">{{ $phone }}</a>
            </div>
        </div>
    @endif
</div>
