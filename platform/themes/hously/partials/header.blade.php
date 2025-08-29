<!DOCTYPE html>
@php
    $themeMode = $_COOKIE['theme'] ?? null;

    if (! in_array($themeMode, ['light', 'dark'])) {
        $themeMode = theme_option('default_theme_mode', 'system');
    }
@endphp
<html lang="{{ app()->getLocale() }}" @class(['scroll-smooth', $themeMode]) dir="{{ BaseHelper::siteLanguageDirection() === 'rtl' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('primary_font', 'League Spartan')) . ':wght@300;400;500;600;700&display=swap') !!}

        <style>
            :root {
                --primary-color: {{ implode(' ', BaseHelper::hexToRgb(theme_option('primary_color', '#16a34a'))) }};
                --secondary-color: {{ theme_option('secondary_color', '#15803D') }};
                --primary-font: '{{ theme_option('primary_font', 'League Spartan') }}', sans-serif;
                --primary-color-rgb: {{ BaseHelper::hexToRgba(theme_option('primary_color', '#16a34a'), 0.8) }};
            }
        </style>

        <script>
            window.defaultThemeMode = @json(theme_option('default_theme_mode', 'system'));
        </script>

        {!! Theme::header() !!}
    </head>

    <body class="dark:bg-slate-900">
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <div id="alert-container"></div>

        @if (empty($withoutNavbar))
            {!! Theme::partial('topnav') !!}
        @endif
