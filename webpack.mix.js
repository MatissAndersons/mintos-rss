let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'dist/');
mix.less('resources/less/app.less', 'dist/');
mix.copy('resources/images/', 'public/images/');
