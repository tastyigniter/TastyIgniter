let mix = require('laravel-mix');

mix.setPublicPath('./').options({
    processCssUrls: false,
})

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your TastyIgniter application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//
// Copy fonts from node_modules
//
mix.copyDirectory(
    'node_modules/@fortawesome/fontawesome-free-webfonts/webfonts',
    'app/system/assets/ui/fonts/FontAwesome'
);

//
//  Build UI SCSS
//
mix.sass('app/system/assets/ui/scss/flame.scss', 'app/system/assets/ui').sourceMaps()

//
//  Combine UI JS
//
mix.scripts(
    [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/popper.js/dist/umd/popper.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/sweetalert/dist/sweetalert.min.js',
        'app/system/assets/ui/js/vendor/waterfall.min.js',
        'app/system/assets/ui/js/vendor/transition.js',
        'app/system/assets/ui/js/app.js',
        'app/system/assets/ui/js/flashmessage.js',
        'app/system/assets/ui/js/toggler.js',
        'app/system/assets/ui/js/trigger.js',
    ],
    'app/system/assets/ui/flame.js'
).sourceMaps()

//
//  Build Admin SCSS
//
mix.sass('app/admin/assets/scss/admin.scss', 'app/admin/assets/css').sourceMaps()

//
//  Combine Admin Vendor JS
//
mix.scripts(
    [
        'node_modules/js-cookie/src/js.cookie.js',
        'node_modules/select2/dist/js/select2.min.js',
        'node_modules/metismenu/dist/metisMenu.min.js',
        'app/admin/assets/js/src/app.js',
    ],
    'app/admin/assets/js/admin.js'
).sourceMaps()
