const mix = require("laravel-mix");

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

mix.js("resources/front/js/app.js", "public/front_resources/js")
    .js("resources/admin/js/app.js", "public/admin_resources/js")
    .sass("resources/front/sass/app.scss", "public/front_resources/css")
    .sass("resources/admin/sass/app.scss", "public/admin_resources/css")
    .sourceMaps();
