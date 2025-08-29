@if(is_plugin_active('language'))
    @php
        $supportedLocales = Language::getSupportedLocales();
        $languageDisplay = setting('language_display', 'all');
    @endphp
    @if ($supportedLocales && count($supportedLocales) > 1)
        <li class="has-submenu parent-menu-item lg:hidden">
            <a href="#" class="cursor-pointer" target="_self">
                @if (($languageDisplay == 'all' || $languageDisplay == 'flag'))
                    <span class="inline-block">
                        {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                    </span>
                @endif
                <span class="inline-block">
                    {{ Language::getCurrentLocaleName() }}
                </span>
            </a>
            <span class="me-4 menu-arrow lg:me-0 top-[18px]"></span>
            <ul class="submenu">
                @foreach ($supportedLocales as $localeCode => $properties)
                    @if ($localeCode != Language::getCurrentLocale())
                        <li>
                            <a href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}" target="_self" class="sub-menu-item">
                                @if (($languageDisplay == 'all' || $languageDisplay == 'flag'))
                                    <span class="inline-block">{!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}</span>
                                @endif
                                <span class="inline-block">{{ $properties['lang_name'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
    @endif
@endif
