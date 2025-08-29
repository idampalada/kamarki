const mix = require('laravel-mix');
const tailwindcss = require("tailwindcss");
const path = require('path');

const directory = path.basename(path.resolve(__dirname));
const source = 'platform/themes/' + directory;
const dist = 'public/themes/' + directory;

mix
    .sass(source + '/assets/sass/icons.scss', dist + '/css')
    .sass(source + '/assets/sass/style.scss', dist + '/css', {}, [
        tailwindcss(source + '/tailwind.config.js')
    ])
    .js(source + '/assets/js/app.js', dist + '/js')
    .js(source + '/assets/js/wishlist.js', dist + '/js')
    .js(source + '/assets/js/filter.js', dist + '/js')
    .js(source + '/assets/js/icons-field.js', dist + '/js')
    .js(source + '/assets/js/review.js', dist + '/js')
    .js(source + '/assets/js/script.js', dist + '/js')

if (mix.inProduction()) {
    mix
        .copy(dist + '/css/icons.css', source + '/public/css')
        .copy(dist + '/css/style.css', source + '/public/css')
        .copy(dist + '/js/app.js', source + '/public/js')
        .copy(dist + '/js/wishlist.js', source + '/public/js')
        .copy(dist + '/js/filter.js', source + '/public/js')
        .copy(dist + '/js/icons-field.js', source + '/public/js')
        .copy(dist + '/js/review.js', source + '/public/js')
        .copy(dist + '/js/script.js', source + '/public/js');
}
