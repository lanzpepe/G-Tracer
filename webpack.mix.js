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

mix.styles([
    'node_modules/jquery-ui-dist/jquery-ui.min.css',
    'node_modules/datatables.net-se/css/dataTables.semanticui.min.css'
], 'public/css/all.css')

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/popper/dist/popper.min.js',
    'node_modules/datatables.net/js/jquery.dataTables.min.js',
    'node_modules/datatables.net-se/js/dataTables.semanticui.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/jquery-ui-dist/jquery-ui.min.js',
    'node_modules/moment/min/moment.min.js',
    'node_modules/blueimp-load-image/js/load-image.all.min.js',
    'node_modules/chart.js/dist/Chart.min.js'
], 'public/js/app.js')
