@php
    Theme::asset()->container('footer')->usePath()->add('feather-icons', 'plugins/feather-icons/feather.min.js');
    Theme::asset()->container('footer')->usePath()->add('particles.js', 'plugins/particles.js/particles.js');
    Theme::asset()->container('footer')->add('js-validation', 'vendor/core/core/js-validation/js/js-validation.js');

    $logo = theme_option('logo_authentication_page') ? theme_option('logo_authentication_page') : theme_option('favicon');

    add_filter(THEME_FRONT_FOOTER, function () {
        return JsValidator::formRequest(\Botble\RealEstate\Http\Requests\LoginRequest::class);
    });
@endphp

<section class="relative flex items-center overflow-hidden md:h-screen py-36 zoom-image">
    @include(Theme::getThemeNamespace('views.real-estate.account.auth.partials.background'))

    @if (theme_option('authentication_enable_snowfall_effect'))
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"><canvas class="w-full h-full particles-js-canvas-el" width="2010" height="1612"></canvas></div>
    @endif
    <div class="container z-3">
        <div class="flex justify-center">
            <div class="login-form max-w-[400px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                {{-- <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl($logo) }}" class="mx-auto" width="64" height="64" alt="{{ theme_option('site_title') }}"></a> --}}
                <a href="{{ route('public.index') }}"><img src="https://kamarki.com/storage/general/logo-dark.png" class="mx-auto" width="64" height="64" alt="{{ theme_option('site_title') }}"></a>

                <h5 class="my-6 text-xl font-semibold">{{ __('Login') }}</h5>
                <form class="text-start" action="{{ route('public.account.login') }}" method="post">
                    @csrf
                    <div class="grid grid-cols-1">
                        <div class="mb-4">
                            <label class="font-medium" for="email">{{ __('Email Address:') }}</label>
                            <input id="email" name="email" type="email" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('email')]) placeholder="{{ __('name@example.com') }}">
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="font-medium" for="password">{{ __('Password:') }}</label>
                            <input id="password" name="password" type="password" @class(['form-control form-input dark:bg-slate-800 mt-1', 'is-invalid' => $errors->has('password')]) placeholder="{{ __('Password') }}">
                            @error('password')
                            <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="flex justify-between mb-4">
                            <div class="flex items-center mb-0 form-checkbox">
                                <input class="me-2 border border-inherit w-[16px] h-[16px] mb-[3px]" type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}" id="RememberMe">
                                <label class="text-slate-400" for="RememberMe">{{ __('Remember me?') }}</label>
                            </div>
                            <p class="mb-0 text-slate-400"><a href="{{ route('public.account.password.request') }}" class="text-slate-400">{{ __('Forgot password?') }}</a></p>
                        </div>

                        <div class="mb-4">
                            {{-- <button type="submit" class="w-full text-white rounded-md btn bg-primary hover:bg-secondary">{{ __('Login') }}</button> --}}
                            <button type="submit" class="w-full text-white rounded-md btn bg-primary hover:bg-secondary" style="background-color: #00adee !important;">Login</button>
                        </div>

                        @if(RealEstateHelper::isRegisterEnabled())
                            <div class="text-center">
                                <span class="text-slate-400 me-2">{{ __("Don't have an account?") }}</span>
                                <a href="{{ route('public.account.register') }}" class="font-bold text-black dark:text-white">{{ __('Register') }}</a>
                            </div>
                        @endif
                    </div>
                </form>

                {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\RealEstate\Models\Account::class) !!}
            </div>
        </div>
    </div>
</section>
