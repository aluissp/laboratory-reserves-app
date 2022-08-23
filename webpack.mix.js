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

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/admin/majors.js", "public/js/admin")
    .js("resources/js/admin/labs.js", "public/js/admin")
    .js("resources/js/admin/users.js", "public/js/admin")
    .js("resources/js/calendar/main.js", "public/js/calendar")
    .sass("resources/sass/app.scss", "public/css")
    .css("resources/css/app.css", "public/css")
    .sourceMaps();
