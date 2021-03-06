let mix = require('laravel-mix');

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

mix.react('resources/assets/js/employees_data-index-app.js', 'public/js').version();
mix.react('resources/assets/js/employee-index-app.js', 'public/js').version();
mix.react('resources/assets/js/department-create-app.js', 'public/js').version();
mix.react('resources/assets/js/department-index-app.js', 'public/js').version();
mix.react('resources/assets/js/event-create-app.js', 'public/js').version();
mix.react('resources/assets/js/event-index-app.js', 'public/js').version();
mix.react('resources/assets/js/position-index-app.js', 'public/js').version();

mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.js'
], 'public/js/scripts.js');

mix.sass('resources/assets/sass/app.scss', 'public/css/app.css').version();

mix.copy('resources/assets/images', 'public/images');
mix.copy('node_modules/font-awesome/fonts', 'public/fonts');

mix.browserSync('junior-php');