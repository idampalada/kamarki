@if (is_plugin_active('real-estate'))
    @php
        $currencies = get_all_currencies();
    @endphp

    @if ($currencies->count() > 1)
        <li class="relative inline-block currency-switcher text-start">
            <div>
                <button id="button-currency-switcher" type="button" class="inline-flex justify-center w-full px-2 py-2 text-sm font-medium text-gray-300 rounded-md shadow-sm btn btn-icon btn-sm hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-100" aria-expanded="true" aria-haspopup="true">
                    {{ get_application_currency()->title }}
                    <i class="ms-1 leading-none mdi mdi-chevron-down"></i>
                </button>
            </div>
            <div class="dropdown-currency-switcher overflow-hidden transform opacity-0 scale-95 hidden transition ease-out duration-100 absolute end-0 bottom-[45px] z-10 mt-2 min-w-[84px] origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-slate-900">
                <div>
                    @foreach($currencies as $currency)
                        <a href="{{ route('public.change-currency', $currency->title) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-200 item-currency dark:text-white dark:hover:bg-slate-600">{{ $currency->title }}</a>
                    @endforeach
                </div>
            </div>
        </li>
    @endif
@endif
