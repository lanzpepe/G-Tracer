const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/popper/dist/popper.min.js',
    'node_modules/moment/min/moment.min.js',
    'node_modules/blueimp-load-image/js/load-image.all.min.js',
    'node_modules/chart.js/dist/Chart.min.js'
], 'public/js/app.js')
