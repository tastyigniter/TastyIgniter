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
    '../../system/assets/ui/fonts/FontAwesome'
)
.copy(
    'node_modules/animate.css/animate.min.css',
    '../../admin/assets/scss/vendor/_animate.scss'
)
.copy(
    'node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
    '../formwidgets/colorpicker/assets/vendor/colorpicker/css/bootstrap-colorpicker.min.css'
)
.copy(
    'node_modules/sortablejs/Sortable.min.js',
    '../formwidgets/repeater/assets/vendor/sortablejs/Sortable.min.js'
)
.copy(
    'node_modules/jquery-sortablejs/jquery-sortable.js',
    '../formwidgets/repeater/assets/vendor/sortablejs/jquery-sortable.js'
)
.copy(
    'node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    '../formwidgets/colorpicker/assets/vendor/colorpicker/js/bootstrap-colorpicker.min.js'
)
.copy(
    'node_modules/metismenu/dist/metisMenu.min.js.map',
    'js/metisMenu.min.js.map'
);

//
//  Build Admin SCSS
//
// mix.sass('scss/admin.scss', 'css')

//
//  Combine UI JS
//
// mix.scripts(
//     [
//         'node_modules/jquery/dist/jquery.min.js',
//         'node_modules/popper.js/dist/umd/popper.min.js',
//         'node_modules/bootstrap/dist/js/bootstrap.min.js',
//         'node_modules/sweetalert/dist/sweetalert.min.js',
//         '../../system/assets/ui/js/vendor/waterfall.min.js',
//         '../../system/assets/ui/js/vendor/transition.js',
//         '../../system/assets/ui/js/app.js',
//         '../../system/assets/ui/js/loader.bar.js',
//         '../../system/assets/ui/js/loader.progress.js',
//         '../../system/assets/ui/js/flashmessage.js',
//         '../../system/assets/ui/js/toggler.js',
//         '../../system/assets/ui/js/trigger.js',
//     ],
//     '../../system/assets/ui/flame.js'
// )

//
//  Combine Admin Vendor JS
//
// mix.scripts(
//     [
//         '../../system/assets/ui/flame.js',
//         'node_modules/js-cookie/src/js.cookie.js',
//         'node_modules/select2/dist/js/select2.min.js',
//         'node_modules/metismenu/dist/metisMenu.min.js',
//         'js/src/app.js',
//     ],
//     'js/admin.js'
// )