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
mix.version();

mix.copy('node_modules/select2/dist/css/select2.min.css','public/css/select2.min.css')

mix.copy('node_modules/sweetalert2/dist/sweetalert2.min.css','public/css/sweetalert2.min.css')
mix.copy('node_modules/sweetalert2/dist/sweetalert2.min.js','public/js/sweetalert2.min.js')
mix.copy('node_modules/@coreui/icons/js/svgxuse.min.js','public/js/svgxuse.min.js')
mix.copy('node_modules/@coreui/icons/sprites/free.svg','public/images/sprites/free.svg')
