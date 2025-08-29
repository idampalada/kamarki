@if (is_plugin_active('language'))
    @php
        $supportedLocales = Language::getSupportedLocales();
    @endphp
    @if ($supportedLocales && count($supportedLocales) > 1)
        @php
            $languageDisplay = setting('language_display', 'all');
        @endphp
        <li class="inline-block pe-2 wrapper-dropdown-language-switcher h-16 ps-5 hidden lg:inline-block">
            <div class="relative">
                @if (setting('language_switcher_display', 'dropdown') == 'dropdown')
                    <button type="button" class="flex items-center w-full px-2 py-2 font-medium text-gray-700 rounded-md language-switcher-nav-light dark:text-white hover:text-primary" id="button-language-switcher" aria-expanded="true" aria-haspopup="true">
                        @if (($languageDisplay == 'all' || $languageDisplay == 'flag'))
                            <span>
                                {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                            </span>
                        @endif
                        @if (($languageDisplay == 'all' || $languageDisplay == 'name'))
                            <span class="leading-none mt-[2px] ms-2">
                                {{ Language::getCurrentLocaleName() }}
                            </span>
                        @endif
                        <i class="mt-1 ms-2 font-weight-[700] leading-none mdi mdi-chevron-down"></i>
                    </button>
                    <div class="absolute end-0 z-10 w-40 mt-2 transition duration-100 ease-out origin-top-right transform scale-95 bg-white rounded-md shadow-md opacity-0 dropdown-language-switcher dark:shadow-slate-800 focus:outline-none dark:bg-slate-900" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            @foreach ($supportedLocales as $localeCode => $properties)
                                @if ($localeCode != Language::getCurrentLocale())
                                    <a href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}" class="flex items-center gap-2 px-4 py-2 leading-none text-gray-700 dark:text-white hover:text-primary" role="menuitem" tabindex="-1" id="menu-item-0">
                                        @if (($languageDisplay === 'all' || $languageDisplay === 'flag'))
                                            {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                                        @endif
                                        <span class="mt-1 leading-none">{{ $properties['lang_name'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    @foreach ($supportedLocales as $localeCode => $properties)
                        @if ($localeCode != Language::getCurrentLocale())
                            <a href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}" class="w-full px-2 py-2 font-medium text-gray-700 rounded-md">
                                @if (($languageDisplay == 'all' || $languageDisplay == 'flag'))
                                    <span class="inline-block">{!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}</span>
                                @endif
                                @if (($languageDisplay == 'all' || $languageDisplay == 'name'))
                                    <span class="inline-block">{{ $properties['lang_name'] }}</span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                @endif
            </div>
        </li>
    @endif
@endif
