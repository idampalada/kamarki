@php
    $navStyle = Theme::get('navStyle');
    $navClass = $navStyle === 'light' ? ' nav-light' : null;

    $logoLight = theme_option('logo');
    $logoDark = theme_option('logo_dark');
    $defaultLogo = theme_option('logo');
    $siteName = theme_option('site_title');
@endphp

<nav id="topnav" class="defaultscroll is-sticky">
    <div class="container">
        <a class="logo" href="{{ route('public.index') }}" title="{{ $siteName }}">
            @switch($navStyle)
                @case('light')
                    <span class="inline-block dark:hidden">
                        @if($logoLight || $logoDark)
                            <img src="{{ RvMedia::getImageUrl($logoDark) }}" class="l-dark" height="28" alt="{{ $siteName }}">
                            <img src="{{ RvMedia::getImageUrl($logoLight) }}" class="l-light" height="28" alt="{{ $siteName }}">
                        @else
                            <img src="{{ RvMedia::getImageUrl($defaultLogo) }}" height="28" alt="{{ $siteName }}">
                        @endif
                    </span>
                    @if($logoLight)
                        <img src="{{ RvMedia::getImageUrl($logoLight) }}" height="28" class="hidden dark:inline-block" alt="{{ $siteName }}">
                    @else
                        <img src="{{ RvMedia::getImageUrl($defaultLogo) }}" height="28" alt="{{ $siteName }}">
                    @endif
                    @break
                @default
                    @if($logoLight || $logoDark)
                        <img src="{{ RvMedia::getImageUrl($logoDark) }}" height="28" class="inline-block dark:hidden" alt="{{ $siteName }}">
                        <img src="{{ RvMedia::getImageUrl($logoLight) }}" height="28" class="hidden dark:inline-block" alt="{{ $siteName }}">
                    @else
                        <img src="{{ RvMedia::getImageUrl($defaultLogo) }}" height="28" alt="{{ $siteName }}">
                    @endif
                    @break
            @endswitch
        </a>

        <div class="menu-extras">
            <div class="menu-item">
                <button type="button" class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
         <ul class="p-0 space-x-5 m-0 buy-button" >
            <li class="inline mb-0" style="margin-left:20px;">
                <a href="https://wa.me/+6281211772089"  target="_blank"><i class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary border-primary dark:border-primary mdi mdi-whatsapp" style="font-size:24px"></i>
           </a>
            </li>

        </ul>
        
        
        <!--@if(is_plugin_active('real-estate'))-->
        <!--    <ul class="p-0 space-x-4 m-0 list-none buy-button">-->
        <!--        {!! Theme::partial('language-switcher.language-switcher') !!}-->
        <!--        @if(RealEstateHelper::isLoginEnabled())-->
        <!--            <li class="inline mb-0">-->
        <!--                <a href="{{ route('public.account.login') }}" class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary border-primary dark:border-primary" aria-label="{{ __('Sign in') }}">-->
        <!--                    <i data-feather="user" class="h-4 w-4 stroke-[3]"></i>-->
        <!--                </a>-->
        <!--            </li>-->
        <!--            <li class="hidden mb-0 sm:inline ps-1">-->
        <!--                <a href="{{ route('public.account.properties.index') }}" class="text-white rounded-full btn bg-primary hover:bg-secondary border-primary dark:border-primary" aria-label="{{ __('Add your listing') }}">-->
        <!--                    {{ __('Add your listing') }}-->
        <!--                </a>-->
        <!--            </li>-->
        <!--        @endif-->
        <!--    </ul>-->
        <!--@endif-->

        <div id="navigation">
            {!!
                Menu::renderMenuLocation('main-menu', [
                    'options' => ['class' => 'navigation-menu justify-end' . $navClass],
                    'view' => 'main-menu',
                ])
            !!}
            <ul class="navigation-menu">
                {!! Theme::partial('language-switcher.language-switcher-mobile') !!}
            </ul>
        </div>
    </div>
</nav>
