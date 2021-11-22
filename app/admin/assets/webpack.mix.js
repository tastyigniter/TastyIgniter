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
    '../../../public/assets/fonts/FontAwesome'
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
// .copy(
//     'node_modules/animate.css/animate.min.css',
//     '../../admin/assets/scss/vendor/_animate.scss'
// )

//
//  Build Admin SCSS
//
mix.sass('scss/admin.scss', 'css')

//
//  Combine Admin Vendor JS
//
mix.js('js/src/app.js', 'js/admin.js')
