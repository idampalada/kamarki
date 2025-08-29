<?php

return [
    'events' => [

        'beforeRenderTheme' => function (Botble\Theme\Theme $theme) {
            $version = time();

            $theme->asset()->usePath()->add('tobii', 'plugins/tobii/css/tobii.min.css');
            $theme->asset()->usePath()->add('choices.js', 'plugins/choices.js/css/choices.min.css');
            $theme->asset()->usePath()->add('icons', 'css/icons.css');
            $theme->asset()->usePath()->add('style', 'css/style.css', version: $version);

            $theme->asset()->container('footer')->usePath()->add('jquery', 'plugins/jquery/jquery.min.js');
            $theme->asset()->container('footer')->usePath()->add('tobii', 'plugins/tobii/js/tobii.min.js');
            $theme->asset()->container('footer')->usePath()->add('choices.js', 'plugins/choices.js/js/choices.min.js');
            $theme->asset()->container('footer')->usePath()->add('feather-icons', 'plugins/feather-icons/feather.min.js');
            $theme->asset()->container('footer')->usePath()->add('app', 'js/app.js', ['tiny-slider-js'], version: $version);
            $theme->asset()->container('footer')->usePath()->add('script', 'js/script.js', ['easy_background'], version: $version);

            if (function_exists('shortcode')) {
                $theme->composer(['page', 'post', 'real-estate.project', 'real-estate.property'], function (\Botble\Shortcode\View\View $view) {
                    $view->withShortcodes();
                });
            }
        },

    ],

];
