const mix = require('laravel-mix');
const src = 'resources';
const dist = 'public';

mix.setPublicPath('./public');

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
//  Build Admin SCSS
//
mix.sass(`${src}/scss/app.scss`, `${dist}/css`).options({
    processCssUrls: false,
})

mix.sass(`${src}/scss/static.scss`, `${dist}/css`)

//
//  Build Admin JS
//
mix.js(`${src}/js/app.js`, `${dist}/js`);

mix.combine([
    'node_modules/animate.css/animate.compat.css',
    'node_modules/choices.js/public/assets/styles/choices.min.css',
    'node_modules/bootstrap-table/dist/bootstrap-table.min.css',
    'node_modules/codemirror/lib/codemirror.css',
    'node_modules/codemirror/theme/material.css',
    'node_modules/daterangepicker/daterangepicker.css',
    'node_modules/dropzone/dist/dropzone.css',
    'node_modules/easymde/dist/easymde.min.css',
    'node_modules/fullcalendar/main.min.css',
    'node_modules/summernote/dist/summernote-bs5.min.css',
    `${src}/js/vendor/timesheet/timesheet.css`,
], `${dist}/css/vendor.css`)

mix.combine([
    'node_modules/bootstrap-table/dist/bootstrap-table.min.js',
    'node_modules/choices.js/public/assets/scripts/choices.min.js',
    'node_modules/inputmask/dist/jquery.inputmask.min.js',
    'node_modules/mustache/mustache.min.js',
    `${src}/js/vendor/selectonic/selectonic.min.js`,
    `${src}/js/vendor/waterfall.min.js`,
    'node_modules/sortablejs/Sortable.js',
], `${dist}/js/vendor.js`)

mix.combine([
    'node_modules/chart.js/dist/chart.min.js',
    'node_modules/chartjs-adapter-moment/dist/chartjs-adapter-moment.min.js',
], `${dist}/js/vendor.chart.js`)

mix.combine([
    'node_modules/daterangepicker/daterangepicker.js',
    'node_modules/fullcalendar/main.min.js',
    `${src}/js/vendor/timesheet/timesheet.js`,
], `${dist}/js/vendor.datetime.js`)

mix.combine([
    'node_modules/codemirror/lib/codemirror.js',
    'node_modules/codemirror/mode/clike/clike.js',
    'node_modules/codemirror/mode/css/css.js',
    'node_modules/codemirror/mode/htmlembedded/htmlembedded.js',
    'node_modules/codemirror/mode/htmlmixed/htmlmixed.js',
    'node_modules/codemirror/mode/javascript/javascript.js',
    'node_modules/codemirror/mode/php/php.js',
    'node_modules/codemirror/mode/xml/xml.js',
    'node_modules/summernote/dist/summernote-bs5.min.js',
    'node_modules/easymde/dist/easymde.min.js',
], `${dist}/js/vendor.editor.js`)

// We only want to copy these files when building for production
if (!mix.inProduction()) return

//
// Copy fonts from node_modules
//
mix.copyDirectory(
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    `${dist}/fonts/FontAwesome`
).copyDirectory(
    'node_modules/summernote/dist/font',
    `${dist}/fonts/summernote`
).copyDirectory(
    'node_modules/summernote/dist/lang',
    `${dist}/js/locales/summernote`
).copy(
    'node_modules/fullcalendar/locales-all.min.js',
    `${dist}/js/locales/fullcalendar/locales-all.min.js`
);
