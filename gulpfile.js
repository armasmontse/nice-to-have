const elixir = require('laravel-elixir');
require('dotenv').config()
require('laravel-elixir-browserify-official');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

 elixir.config.css.autoprefix = {
     enabled: true, //default, this is only here so you know how to disable
     options: {
         cascade: true,
         browsers: ['last 5 versions', '> 5%']
     }
 };



elixir(mix => {
    mix
    	.browserify(['micorriza-admin.js'], 'public/js/admin-functions.js')
    	.browserify(['micorriza.js'], 'public/js/functions.js')
    	.sass(['admin.scss'], 'public/css/admin.css')
    	.sass(['mazorca.scss'], 'public/css/mazorca.css')
       	.browserSync({proxy: process.env.URL_SITE});
});
