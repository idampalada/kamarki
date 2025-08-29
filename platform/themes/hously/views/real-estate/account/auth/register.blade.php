@php
    Theme::asset()->container('footer')->usePath()->add('feather-icons', 'plugins/feather-icons/feather.min.js');
    Theme::asset()->container('footer')->usePath()->add('particles.js', 'plugins/particles.js/particles.js');
    Theme::asset()->container('footer')->add('js-validation', 'vendor/core/core/js-validation/js/js-validation.js');

    $logo = theme_option('logo_authentication_page') ? theme_option('logo_authentication_page') : theme_option('favicon');

    add_filter(THEME_FRONT_FOOTER, function () {
        return JsValidator::formRequest(\Botble\RealEstate\Http\Requests\RegisterRequest::class);
    });
@endphp

<section class="relative flex items-center py-36 zoom-image">
    @include(Theme::getThemeNamespace('views.real-estate.account.auth.partials.background'))

    @if (theme_option('authentication_enable_snowfall_effect'))
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"><canvas class="w-full h-full particles-js-canvas-el" width="2010" height="1612"></canvas></div>
    @endif
    <div class="container z-3">
        <div class="flex justify-center mt-10">
            <div class="login-form max-w-[500px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                <a href="{{ route('public.index') }}"><img src="https://kamarki.com/storage/general/logo-dark.png" width="64" height="64" class="mx-auto" alt="{{ theme_option('site_title') }}"></a>
                {{-- <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl($logo) }}" width="64" height="64" class="mx-auto" alt="{{ theme_option('site_title') }}"></a> --}}

                {{-- <a class="logo" href="https://kamarki.com" title="Hously">
                    <img src="https://kamarki.com/storage/general/logo-dark.png" height="28" class="inline-block dark:hidden" alt="Hously">
<img src="https://kamarki.com/storage/general/logo-light.png" height="28" class="hidden dark:inline-block" alt="Hously">
            </a> --}}
                <h5 class="my-2 text-xl font-semibold">{{ __('Register') }}</h5>
                <form class="text-start" action="{{ route('public.account.register') }}" method="post">
                    @csrf
                    <div class="grid grid-cols-1">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="mb-4">
                                <label class="font-medium" for="first_name">{{ __('First name:') }}</label>
                                <input id="first_name" name="first_name" type="text" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('first_name')]) placeholder="{{ __('First name') }}">
                                @error('first_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="font-medium" for="last_name">{{ __('Last name:') }}</label>
                                <input id="last_name" name="last_name" type="text" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('last_name')]) placeholder="{{ __('Last name') }}">
                                @error('last_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="mb-4">
                                <label class="font-medium" for="username">{{ __('Username:') }}</label>
                                <input id="username" name="username" type="text" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('username')]) placeholder="{{ __('Username') }}">
                                @error('username')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="font-medium" for="email">{{ __('Email:') }}</label>
                                <input id="email" name="email" type="email" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('email')]) placeholder="{{ __('Email') }}">
                                @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="font-medium" for="phone">{{ __('Phone:') }}</label>
                            <input id="phone" name="phone" type="text" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('phone')]) placeholder="{{ __('Phone') }}">
                            @error('phone')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="mb-4">
                                <label class="font-medium" for="password">{{ __('Password:') }}</label>
                                <input id="password" name="password" type="password" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('password')]) placeholder="{{ __('Password') }}">
                                @error('password')
                                <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="mb-2 form-group">
                                <label class="font-medium" for="password-confirm">{{ __('Password confirmation:') }}</label>
                                <input id="password-confirm" type="password" class="mt-1 form-control form-input"
                                       name="password_confirmation" required
                                       placeholder="{{ __('Password confirmation') }}">
                            </div>
                        </div>

                        <div class="mt-2 mb-4">
                            <button type="submit" class="w-full text-white rounded-md btn bg-primary hover:bg-secondary" style="background-color: #00adee !important;">{{ __('Register') }}</button>
                        </div>

                        <div class="text-center">
                            <span class="text-slate-400 me-2">{{ __('Already have an account?') }}</span> <a href="{{ route('public.account.login') }}" class="font-bold text-black dark:text-white">{{ __('Login') }}</a>
                        </div>
                    </div>
                </form>
                {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\RealEstate\Models\Account::class) !!}
            </div>
        </div>
    </div>
</section>
