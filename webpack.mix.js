const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css');

/* front-end */
mix.scripts(['resources/assets/site/js/scroll.js'], 'public/js/scroll.js')
	.scripts(['resources/assets/site/js/s.js'], 'public/js/s.js')
	.scripts(['resources/assets/site/js/b.js'], 'public/js/b.js')
	.scripts(['resources/assets/site/js/bp.js'], 'public/js/bp.js')
	.sass('resources/assets/site/sass/min.scss', 'public/css')
	.sass('resources/assets/site/sass/starability.css', 'public/css');

mix.version();
