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
    'ui/fonts/FontAwesome'
);

//
//  Build UI SCSS
//
mix.sass('ui/scss/flame.scss', 'ui')

//
//  Combine UI JS
//
mix.scripts(
    [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/popper.js/dist/umd/popper.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/sweetalert/dist/sweetalert.min.js',
        'ui/js/vendor/waterfall.min.js',
        'ui/js/vendor/transition.js',
        'ui/js/app.js',
        'ui/js/flashmessage.js',
        'ui/js/toggler.js',
        'ui/js/trigger.js',
    ],
    'ui/flame.js'
)

//
//  Build Admin SCSS
//
mix.sass('../../admin/assets/scss/admin.scss', '../../../admin/assets/css')

//
//  Combine Admin Vendor JS
//
mix.scripts(
    [
        'node_modules/js-cookie/src/js.cookie.js',
        'node_modules/select2/dist/js/select2.min.js',
        'node_modules/metismenu/dist/metisMenu.min.js',
        '../../admin/assets/js/src/app.js',
    ],
    '../../admin/assets/js/admin.js'
)
