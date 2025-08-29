@php
    Theme::set('navStyle', 'light');
    $avatar = $account->avatar->url ? RvMedia::getImageUrl($account->avatar->url, 'thumb') : $account->avatar_url;
@endphp

{!! Theme::partial('breadcrumb') !!}

<div class="container z-10 -mt-12 lg:-mt-16">
    <div class="block bg-white rounded-lg shadow-2xl md:flex dark:bg-slate-900">
        <div class="flex-[1] md:me-2 p-4">
            <img src="{{ $avatar }}" alt="{{ $account->name }}" class="w-full rounded-lg">
        </div>
        <div class="py-4 px-6 w-full flex-[3]">
            <h2 class="text-2xl font-semibold">{{ $account->name }}</h2>
            <hr class="my-4">
            <p>{!! BaseHelper::clean($account->description) !!}</p>
            <ul class="mt-5 space-y-2">
                <li>
                    <i class="me-1 text-xl mdi mdi-home-outline"></i>
                    <span>
                        @php($propertiesCount = $account->properties->count())
                        @if($propertiesCount === 1)
                            {{ __(':count property', ['count' => number_format($propertiesCount)]) }}
                        @else
                            {{ __(':count properties', ['count' => number_format($propertiesCount)]) }}
                        @endif
                    </span>
                </li>
                @if($account->email)
                    <li class="hover:text-primary">
                        <i class="me-1 mdi mdi-email-outline"></i>
                        @if(setting('real_estate_hide_agency_email', 0))
                            <span>{{ Str::mask($account->email, '*', 4, -4) }}</span>
                        @else
                            <a href="mailto:{{ $account->email }}">{{ $account->email }}</a>
                        @endif
                    </li>
                @endif
                @if($account->phone)
                    <li class="hover:text-primary">
                        <i class="me-1 mdi mdi-phone-outline"></i>
                        @if(setting('real_estate_hide_agency_phone', 0))
                            <span>{{ Str::mask($account->phone, '*', 3, -3) }}</span>
                        @else
                            <a href="tel:{{ $account->phone }}" dir="ltr">{{ $account->phone }}</a>
                        @endif
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="pt-10">
        @if ($properties->count())
            <div class="mx-3 mt-10 mb-5">
                <h5 class="pb-3 text-xl font-bold border-b border-gray-300">{{ __('Properties by this agent') }}</h5>
                {!! Theme::partial('real-estate.properties.items', ['properties' => $properties]) !!}
            </div>
        @endif
    </div>
</div>
