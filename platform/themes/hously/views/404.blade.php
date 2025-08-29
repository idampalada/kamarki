@php
    SeoHelper::setTitle(__('404 - Not found'));
    Theme::fireEventGlobalAssets();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="light scroll-smooth" dir="{{ BaseHelper::siteLanguageDirection() === 'rtl' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! Theme::header() !!}
</head>
<body class="dark:bg-slate-900">
    {!! apply_filters(THEME_FRONT_BODY, null) !!}

    <section class="relative bg-primary/5">
        <div class="relative container-fluid">
            <div class="grid grid-cols-1">
                <div class="flex flex-col justify-center min-h-screen px-4 py-10 md:px-10">
                    <div class="text-center">
                        <a href="{{ route('public.index') }}">
                            <img src="{{ RvMedia::getImageUrl(theme_option('favicon')) }}" style="max-height: 64px" class="mx-auto" alt="{{ theme_option('site_title') }}">
                        </a>
                    </div>
                    <div class="my-auto text-center title-heading">
                        <img src="{{ theme_option('404_page_image') ? RvMedia::getImageUrl(theme_option('404_page_image')) : asset('themes/hously/images/error.png') }}" class="mx-auto" alt="{{ theme_option('site_title') }}">
                        <h1 class="mt-3 mb-6 text-3xl font-bold md:text-4xl">{{ __('Page Not Found?') }}</h1>
                        <p class="text-slate-400">
                            {{ __('Whoops, this is embarrassing.') }}
                            <br>
                            {{ __("Looks like the page you were looking for wasn't found.") }}
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('public.index') }}" class="text-white rounded-md btn bg-primary hover:bg-secondary border-primary hover:border-secondary">
                                {{ __('Back to Home') }}
                            </a>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="mb-0 text-slate-400">{!! BaseHelper::clean(theme_option('copyright')) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="fixed z-10 bottom-3 end-3">
        <a href="{{ route('public.index') }}" class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary">
            <i class="mdi mdi-arrow-left"></i>
        </a>
    </div>
</body>
</html>
