@php
    $navStyle = Theme::get('navStyle');
    $navClass = $navStyle === 'light' ? ' nav-light' : null;

    $logoLight = theme_option('logo');
    $logoDark = theme_option('logo_dark');
    $defaultLogo = theme_option('logo');
    $siteName = theme_option('site_title');
@endphp
<style>
    .notification-badge {
        position: absolute;
        top: -9px;
        right: 5px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 3px 6px;
        font-size: 10px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        right: 75px;
        top: 65px;
        /* Adjust this value to position the dropdown correctly */
    }

    .inline.mb-0.relative:hover .dropdown-content {
        display: block;
    }

    a.btn:hover {
        background-color: #00adee;
        border-color: #00adee;
    }
</style>
<nav id="topnav" class="defaultscroll is-sticky">
    <div class="container">
        <a class="logo" href="{{ route('public.index') }}" title="{{ $siteName }}">
            @switch($navStyle)
                @case('light')
                    <span class="inline-block dark:hidden">
                        @if ($logoLight || $logoDark)
                            <img src="{{ RvMedia::getImageUrl($logoDark) }}" class="l-dark" height="28"
                                alt="{{ $siteName }}">
                            <img src="{{ RvMedia::getImageUrl($logoLight) }}" class="l-light" height="28"
                                alt="{{ $siteName }}">
                        @else
                            <img src="{{ RvMedia::getImageUrl($defaultLogo) }}" height="28" alt="{{ $siteName }}">
                        @endif
                    </span>
                    @if ($logoLight)
                        <img src="{{ RvMedia::getImageUrl($logoLight) }}" height="28" class="hidden dark:inline-block"
                            alt="{{ $siteName }}">
                    @else
                        <img src="{{ RvMedia::getImageUrl($defaultLogo) }}" height="28" alt="{{ $siteName }}">
                    @endif
                @break

                @default
                    @if ($logoLight || $logoDark)
                        <img src="{{ RvMedia::getImageUrl($logoDark) }}" height="28" class="inline-block dark:hidden"
                            alt="{{ $siteName }}">
                        <img src="{{ RvMedia::getImageUrl($logoLight) }}" height="28" class="hidden dark:inline-block"
                            alt="{{ $siteName }}">
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

        {{-- Link to profile --}}
        @if (auth('account')->check())
            <ul class="p-0 space-x-5 m-0 buy-button text-black">
                <li class="inline mb-0 dropdown">
                    <div class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary border-primary dark:border-primary"
                        aria-label="{{ __('Sign in') }}">
                        <i data-feather="user" class="h-4 w-4 stroke-[3]"></i>
                        <div class="notification-badge"></div>
                    </div>
                    <div class="dropdown-content py-4 px-0 rounded-md">
                        <div class="px-4">
                            <p class="leading-none">Signed in as:</p>
                            <p class=""><b>{{ auth('account')->user()->name }}</b></p>
                        </div>
                        <hr class="block border-t-0 bg-neutral-100 h-1 my-2" />
                        <!-- Add more dropdown items here if needed -->
                        {{-- <a href="{{ route('public.account.dashboard') }}" class="block px-4 py-2">Profile</a> --}}
                        <div class="block pt-2 px-4 pb-0">
                            <a class="no-underline black-50 inline-block w-full"
                                href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                title="{{ trans('plugins/real-estate::dashboard.header_logout_link') }}">
                                <i class="fas fa-sign-out-alt mr1"></i><span>{{ trans('plugins/real-estate::dashboard.header_logout_link') }}</span>
                            </a>

                            <form id="logout-form" action="{{ route('public.account.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        @else
            <ul class="p-0 space-x-5 m-0 buy-button">
                <li class="hidden mb-0 sm:inline ps-1">
                    <a href="{{ route('public.account.login') }}" class="text-white rounded-full btn"
                        style="background-color: #00adee; border-color: #00adee;" aria-label="{{ __('Sign in') }}">
                        Log In
                    </a>
                </li>

            </ul>
        @endif

        <div id="navigation">
            {!! Menu::renderMenuLocation('main-menu', [
                'options' => ['class' => 'navigation-menu justify-end'],
                'view' => 'main-menu',
            ]) !!}
            <ul class="navigation-menu">
                {!! Theme::partial('language-switcher.language-switcher-mobile') !!}
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('click', function(event) {
        var dropdown = document.querySelector('.dropdown-content');
        if (event.target.closest('.dropdown')) {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    });
</script>
