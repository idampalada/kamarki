
@php
    Theme::asset()->container('footer')->usePath()->add('feather-icons', 'plugins/feather-icons/feather.min.js');
    Theme::asset()->container('footer')->usePath()->add('particles.js', 'plugins/particles.js/particles.js');

    $logo = theme_option('logo_authentication_page') ? theme_option('logo_authentication_page') : theme_option('favicon');
@endphp

<section class="relative flex items-center overflow-hidden md:h-screen py-36 zoom-image">
    @include(Theme::getThemeNamespace('views.real-estate.account.auth.partials.background'))

    @if (theme_option('authentication_enable_snowfall_effect'))
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"><canvas class="w-full h-full particles-js-canvas-el" width="2010" height="1612"></canvas></div>
    @endif
    <div class="container z-3">
        <div class="flex justify-center">
            <div class="max-w-[400px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl($logo) }}" width="64" height="64" class="mx-auto" alt="{{ theme_option('site_title') }}"></a>
                <h5 class="my-6 text-xl font-semibold">{{ __('Reset Password') }}</h5>
                <div class="grid grid-cols-1">
                    <form class="text-start" method="POST" action="{{ route('public.account.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="grid grid-cols-1">
                            <div class="mb-4">
                                <label class="font-medium" for="email">{{ __('Email Address:') }}</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" @class(['form-control form-input dark:bg-slate-800 mt-3', 'is-invalid' => $errors->has('email')]) placeholder="{{ __('name@example.com') }}">
                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="font-medium" for="email">{{ __('Password:') }}</label>
                                <input id="password" name="password" type="password" @class(['form-control form-input dark:bg-slate-800 mt-3', 'is-invalid' => $errors->has('password')]) placeholder="{{ __('Password') }}">
                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4 form-group">
                                <label class="font-medium" for="email">{{ __('Password confirmation:') }}</label>
                                <input id="password-confirm" type="password" class="mt-3 form-control form-input"
                                       name="password_confirmation" required
                                       placeholder="{{ __('Password confirmation') }}">
                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="w-full text-white rounded-md btn bg-primary hover:bg-secondary">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
