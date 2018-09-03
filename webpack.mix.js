let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
        .options({
            processCssUrls: false
        })
   .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery']
    })
   .sourceMaps()
   .webpackConfig({
        devtool: 'source-map'
    });

   mix.disableNotifications();