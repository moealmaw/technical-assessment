const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.purgeCss({
    enabled: true,
    globs: [],
    extensions: ['html', 'js', 'php', 'vue'],
});
mix.options({
    processCssUrls: false,
    purifyCss: true,
    postCss: [tailwindcss('resources/assets/js/tailwind.js')],
});
mix.version();