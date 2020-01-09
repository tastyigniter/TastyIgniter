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
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    'ui/fonts/FontAwesome'
).copy(
    'node_modules/animate.css/animate.min.css',
    'ui/scss/vendor/animate.scss'
).copy(
    'node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
    '../../admin/formwidgets/colorpicker/assets/vendor/colorpicker/css/bootstrap-colorpicker.min.css'
).copy(
    'node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    '../../admin/formwidgets/colorpicker/assets/vendor/colorpicker/js/bootstrap-colorpicker.min.js'
);

//
//  Build UI SCSS
//
// mix.sass('ui/scss/flame.scss', 'ui')

//
//  Combine UI JS
//
// mix.scripts(
//     [
//         'node_modules/jquery/dist/jquery.min.js',
//         'node_modules/popper.js/dist/umd/popper.min.js',
//         'node_modules/bootstrap/dist/js/bootstrap.min.js',
//         'node_modules/sweetalert/dist/sweetalert.min.js',
//         'ui/js/vendor/waterfall.min.js',
//         'ui/js/vendor/transition.js',
//         'ui/js/app.js',
//         'ui/js/loader.bar.js',
//         'ui/js/loader.progress.js',
//         'ui/js/flashmessage.js',
//         'ui/js/toggler.js',
//         'ui/js/trigger.js',
//     ],
//     'ui/flame.js'
// )

//
//  Build Admin SCSS
//
// mix.sass('../../admin/assets/scss/admin.scss', '../../../admin/assets/css')

//
//  Combine Admin Vendor JS
//
// mix.scripts(
//     [
//         'node_modules/js-cookie/src/js.cookie.js',
//         'node_modules/select2/dist/js/select2.min.js',
//         'node_modules/metismenu/dist/metisMenu.min.js',
//         '../../admin/assets/js/src/app.js',
//     ],
//     '../../admin/assets/js/admin.js'
// )
