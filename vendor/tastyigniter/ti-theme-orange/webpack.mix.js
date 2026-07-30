let mix = require('laravel-mix');
const src = 'resources/src';
const dist = 'public';

mix.setPublicPath('./public').options({
    processCssUrls: false,
})

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your TastyIgniter application. By default, we are copying all the
 | dependencies for the theme into the assets folder.
 | Compilation is done by the theme customizer in the Admin Panel.
 |
 */

// Copy fonts from node_modules
//
mix.copyDirectory(
    'node_modules/bootstrap/scss',
    `${src}/scss/vendor/bootstrap`
).copyDirectory(
    'node_modules/intl-tel-input/build/img',
    `${dist}/images/iti`
).copyDirectory(
    'node_modules/flatpickr/dist/l10n',
    `${dist}/js/locales/flatpickr`
);

mix.copy(
    'node_modules/bootstrap/dist/js/bootstrap.min.js.map',
    `${dist}/js/bootstrap.min.js.map`
).copy(
    'node_modules/jquery-raty-js/lib/jquery.raty.css',
    `${src}/scss/vendor/jquery.raty.scss`
).copy(
    'node_modules/animate.css/animate.css',
    `${src}/scss/vendor/animate.scss`
).copy(
    'node_modules/sweetalert2/dist/sweetalert2.min.css',
    `${src}/scss/vendor/sweetalert2.scss`
).copy(
    'node_modules/intl-tel-input/build/css/intlTelInput.css',
    `${src}/scss/vendor/intlTelInput.scss`
).copy(
    'node_modules/photoswipe/dist/photoswipe.css',
    `${src}/scss/vendor/photoswipe.scss`
).copy(
    'node_modules/flatpickr/dist/flatpickr.min.css',
    `${src}/scss/vendor/flatpickr.scss`
)

//  Build SCSS
//
mix.sass(`${src}/scss/app.scss`, `${dist}/css`)

//  Build JS
//
mix.js(`${src}/js/app.js`, `${dist}/js`);
