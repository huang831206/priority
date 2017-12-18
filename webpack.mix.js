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

mix.webpackConfig({
	resolve: {
		alias: {
			jquery: "jquery/src/jquery",
			handlebars: 'handlebars/dist/handlebars.min.js'
		}
	}
});

mix.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/test.js', 'public/js')
	// .js('resources/assets/js/Priority.js', 'public/js')
	.scripts(['resources/assets/js/Priority.js'], 'public/js/Priority.js')
    .extract([
		'handlebars',
        'underscore',
        'jquery',
        'axios',
        'vue',
        './resources/assets/semantic/dist/semantic'])
   .sass('resources/assets/sass/app.scss', 'public/css');
