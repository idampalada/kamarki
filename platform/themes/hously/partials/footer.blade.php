@if (empty($withoutFooter))
    <footer class="relative mt-48 bg-slate-900 dark:bg-slate-800">
        <div class="container">
            <div class="grid grid-cols-1">
                <div class="relative py-16">
                    <div class="relative w-full">
                        {!! dynamic_sidebar('pre_footer') !!}

                        <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px] -mt-24">
                            {!! dynamic_sidebar('footer_menu') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-[30px] px-0 border-t border-gray-800 dark:border-gray-700">
            <div class="container text-center">
                <div class="grid items-center gap-6 md:grid-cols-2">
                    <div class="text-center md:text-start">
                        <p class="mb-0 text-gray-300">
                            {!! BaseHelper::clean(theme_option('copyright')) !!}
                        </p>
                    </div>

                    <ul class="p-0 m-0 space-x-1 text-center list-none md:text-end">
                        {!! Theme::partial('currency-switcher') !!}
                        @if ($socialLinks = json_decode(theme_option('social_links')))
                            @foreach ($socialLinks as $social)
                                @php($social = collect($social)->pluck('value', 'key'))
                                <li class="inline">
                                    <a href="{{ $social->get('social-url') }}" title="{{ $social->get('social-name') }}"
                                        target="_blank"
                                        class="text-gray-400 border border-gray-800 rounded-md btn btn-icon btn-sm hover:text-white dark:border-gray-700 hover:border-primary dark:hover:border-primary hover:bg-primary dark:hover:bg-primary">
                                        <i class="{{ $social->get('social-icon') }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endif

@if (theme_option('enabled_toggle_theme_mode', true))
    <div class="fixed top-1/4 z-999 -start-2">
        <span class="relative inline-block rotate-90">
            <input type="checkbox" class="absolute opacity-0 checkbox" id="chk" />
            <label
                class="flex items-center justify-between h-8 p-1 rounded-full shadow cursor-pointer label bg-slate-900 dark:bg-white dark:shadow-gray-700 w-14"
                for="chk">
                <i class="mt-1 text-lg text-yellow-500 mdi mdi-weather-sunny"></i>
                <i class="mt-1 text-lg text-yellow-500 mdi mdi-weather-night"></i>
                <span
                    class="ball bg-white dark:bg-slate-900 rounded-full absolute top-0.5 rtl:start-6 start-0.5 w-7 h-7"></span>
            </label>
        </span>
    </div>
@endif

<button type="button" onclick="topFunction()" id="back-to-top"
    class="fixed z-10 items-center justify-center hidden text-lg text-center text-white rounded-full bg-primary back-to-top bottom-5 end-5 h-9 w-9"
    aria-label="{{ __('Go to top') }}">
    <i class="mdi mdi-arrow-up"></i>
</button>

<div class="fixed top-0 start-0 hidden w-full h-full bg-opacity-50 sidebar-backdrop z-9999 bg-dark"></div>

<div class="whatsapp-button">
    <a href="https://wa.me/+6285283515660" target="_blank">
        <i class="mdi mdi-whatsapp"></i>
    </a>
</div>

<style>
    .whatsapp-button {
        position: fixed;
        bottom: 80px;
        right: 20px;
        z-index: 1000;
        width: 52px;
        height: 52px;
        background-color: #25D366;
        border-radius: 50%;
        padding: 14px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .whatsapp-button a {
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .whatsapp-button a:hover {
        background-color: #128C7E;
    }
</style>

{!! Theme::footer() !!}

@if (session()->has('status') ||
        session()->has('success_msg') ||
        session()->has('error_msg') ||
        (isset($errors) && $errors->count() > 0) ||
        isset($error_msg))
    <script type="text/javascript">
        'use strict';
        window.onload = function() {
            @if (session()->has('success_msg'))
                window.showAlert('alert-success', "{!! addslashes(session('success_msg')) !!}");
            @endif
            @if (session()->has('status'))
                window.showAlert('alert-success', "{!! addslashes(session('status')) !!}");
            @endif
            @if (session()->has('error_msg'))
                window.showAlert('alert-danger', "{!! addslashes(session('error_msg')) !!}");
            @endif
            @if (isset($error_msg))
                window.showAlert('alert-danger', "{!! addslashes($error_msg) !!}");
            @endif
            @if (isset($errors))
                @foreach ($errors->all() as $error)
                    window.showAlert('alert-danger', "{!! addslashes($error) !!}");
                @endforeach
            @endif
        };
    </script>
@endif
</body>

</html>
