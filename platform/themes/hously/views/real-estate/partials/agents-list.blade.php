<div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
    @foreach($accounts as $account)
        <div class="overflow-hidden duration-500 ease-in-out bg-white shadow property-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700">
            <div class="relative overflow-hidden">
                <a href="{{ $account->url }}">
                    <img src="{{ RvMedia::getImageUrl($account->avatar_url, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $account->name }}" class="transition-all duration-500 hover:scale-110 w-full">
                </a>
            </div>

            <div class="p-6">
                <div class="flex items-center justify-between">
                    <a href="{{ $account->url }}" class="text-lg font-medium uppercase duration-500 ease-in-out hover:text-primary" title="{{ $account->name }}">
                        {!! BaseHelper::clean($account->name) !!}
                    </a>
                    @if($account->email && ! setting('real_estate_hide_agency_email', 0))
                        <a href="mailto:{{ $account->email }}" class="bg-primary text-white px-2.5 py-1.5 rounded-full hover:bg-secondary transition-all" title="{{ $account->name }}">
                            <i class="mdi mdi-email-outline"></i>
                        </a>
                    @endif
                </div>
                <ul class="list-none ps-0 border-t dark:border-t-slate-600 mt-5 pt-5 mb-0 space-y-3">
                    <li>
                        <i class="mdi mdi-home-outline me-1 text-xl"></i>
                        <span>
                            @if($account->properties_count === 1)
                                {{ __(':count property', ['count' => number_format($account->properties_count)]) }}
                            @else
                                {{ __(':count properties', ['count' => number_format($account->properties_count)]) }}
                            @endif
                        </span>
                    </li>
                    @if($account->email && ! setting('real_estate_hide_agency_email', 0))
                        <li class="hover:text-primary">
                            <i class="mdi mdi-email-outline me-1"></i>
                            <a href="mailto:{{ $account->email }}">{{ $account->email }}</a>
                        </li>
                    @endif
                    @if($account->phone && ! setting('real_estate_hide_agency_phone', 0))
                        <li class="hover:text-primary">
                            <i class="mdi mdi-phone-outline me-1"></i>
                            <a href="tel:{{ $account->phone }}" dir="ltr">{{ $account->phone }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endforeach
</div>
