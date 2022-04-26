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
//  Build Admin SCSS
//
mix.sass('src/scss/admin.scss', 'css')

//
//  Combine Admin UI JS
//
mix.scripts(
    [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/@popperjs/core/dist/umd/popper.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/sweetalert2/dist/sweetalert2.min.js',
        'node_modules/js-cookie/src/js.cookie.js',
        'node_modules/metismenu/dist/metisMenu.min.js',
        'src/js/vendor/waterfall.min.js',
        'src/js/request.js',
        'src/js/loader.bar.js',
        'src/js/loader.progress.js',
        'src/js/flashmessage.js',
        'src/js/toggler.js',
        'src/js/trigger.js',
        'src/js/app.js',
    ],
    'js/admin.js'
)

// We only want to copy these files when building for production
if (process.env.NODE_ENV !== 'productiion') return

//
// Copy fonts from node_modules
//
mix.copyDirectory(
    'node_modules/@fortawesome/fontawesome-free/webfonts',
    '../../admin/assets/fonts/FontAwesome'
).copy(
    'node_modules/animate.css/animate.compat.css',
    '../../admin/assets/src/scss/vendor/_animate.scss'
);

mix.copy(
    'node_modules/chart.js/dist/chart.min.js',
    '../dashboardwidgets/charts/assets/vendor/chartjs/Chart.min.js'
).copy(
    'node_modules/chartjs-adapter-moment/dist/chartjs-adapter-moment.min.js',
    '../dashboardwidgets/charts/assets/vendor/chartjs/chartjs-adapter-moment.min.js'
).copy(
    'node_modules/daterangepicker/daterangepicker.js',
    '../dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.js'
).copy(
    'node_modules/daterangepicker/daterangepicker.css',
    '../dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.css'
);

mix.copy(
    'node_modules/codemirror/lib/codemirror.css',
    '../formwidgets/codeeditor/assets/vendor/codemirror/codemirror.css'
).copy(
    'node_modules/codemirror/lib/codemirror.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/codemirror.js'
).copy(
    'node_modules/codemirror/theme/material.css',
    '../formwidgets/codeeditor/assets/vendor/codemirror/material.css'
).copy(
    'node_modules/codemirror/mode/clike/clike.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/clike/clike.js'
).copy(
    'node_modules/codemirror/mode/css/css.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/css/css.js'
).copy(
    'node_modules/codemirror/mode/htmlembedded/htmlembedded.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/htmlembedded/htmlembedded.js'
).copy(
    'node_modules/codemirror/mode/htmlmixed/htmlmixed.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/htmlmixed/htmlmixed.js'
).copy(
    'node_modules/codemirror/mode/javascript/javascript.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/javascript/javascript.js'
).copy(
    'node_modules/codemirror/mode/php/php.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/php/php.js'
).copy(
    'node_modules/codemirror/mode/xml/xml.js',
    '../formwidgets/codeeditor/assets/vendor/codemirror/xml/xml.js'
);

mix.copy(
    'node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
    '../formwidgets/colorpicker/assets/vendor/colorpicker/css/bootstrap-colorpicker.min.css'
).copy(
    'node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    '../formwidgets/colorpicker/assets/vendor/colorpicker/js/bootstrap-colorpicker.min.js'
);

mix.copy(
    'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css',
    '../formwidgets/datepicker/assets/vendor/clockpicker/bootstrap-clockpicker.min.css'
).copy(
    'node_modules/clockpicker/dist/bootstrap-clockpicker.min.js',
    '../formwidgets/datepicker/assets/vendor/clockpicker/bootstrap-clockpicker.min.js'
);

mix.copy(
    'node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css',
    '../formwidgets/datepicker/assets/vendor/datetimepicker/tempusdominus-bootstrap-4.min.css'
).copy(
    'node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js',
    '../formwidgets/datepicker/assets/vendor/datetimepicker/tempusdominus-bootstrap-4.min.js'
);

mix.copy(
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
    '../formwidgets/datepicker/assets/vendor/datepicker/bootstrap-datepicker.min.css'
).copy(
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    '../formwidgets/datepicker/assets/vendor/datepicker/bootstrap-datepicker.min.js'
).copyDirectory(
    'node_modules/bootstrap-datepicker/dist/locales',
    '../formwidgets/datepicker/assets/vendor/datepicker/locales'
);

mix.copy(
    'node_modules/easymde/dist/easymde.min.css',
    '../formwidgets/markdowneditor/assets/vendor/easymde/easymde.min.css'
).copy(
    'node_modules/easymde/dist/easymde.min.js',
    '../formwidgets/markdowneditor/assets/vendor/easymde/easymde.min.js'
);

mix.copy(
    'node_modules/sortablejs/Sortable.min.js',
    '../formwidgets/repeater/assets/vendor/sortablejs/Sortable.min.js'
).copy(
    'node_modules/jquery-sortablejs/jquery-sortable.js',
    '../formwidgets/repeater/assets/vendor/sortablejs/jquery-sortable.js'
);

mix.copy(
    'node_modules/summernote/dist/summernote-bs5.min.css',
    '../formwidgets/richeditor/assets/vendor/summernote/summernote-bs5.min.css'
).copy(
    'node_modules/summernote/dist/summernote-bs5.min.js',
    '../formwidgets/richeditor/assets/vendor/summernote/summernote-bs5.min.js'
).copy(
    'node_modules/summernote/dist/summernote-bs5.js.map',
    '../formwidgets/richeditor/assets/vendor/summernote/summernote-bs5.js.map'
).copyDirectory(
    'node_modules/summernote/dist/font',
    '../formwidgets/richeditor/assets/vendor/summernote/font'
).copyDirectory(
    'node_modules/summernote/dist/lang',
    '../formwidgets/richeditor/assets/vendor/summernote/lang'
);

mix.copy(
    'node_modules/fullcalendar/main.min.css',
    '../widgets/calendar/assets/vendor/fullcalendar/main.min.css'
).copy(
    'node_modules/fullcalendar/main.min.js',
    '../widgets/calendar/assets/vendor/fullcalendar/main.min.js'
).copy(
    'node_modules/fullcalendar/locales-all.min.js',
    '../widgets/calendar/assets/vendor/fullcalendar/locales-all.min.js'
);

mix.copy(
    'node_modules/bootstrap-multiselect/dist/css/bootstrap-multiselect.css',
    '../widgets/form/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css'
).copy(
    'node_modules/bootstrap-multiselect/dist/js/bootstrap-multiselect.js',
    '../widgets/form/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js'
);

mix.copy(
    'node_modules/inputmask/dist/jquery.inputmask.min.js',
    '../widgets/form/assets/vendor/inputmask/jquery.inputmask.min.js'
);

mix.copy(
    'node_modules/bootstrap-table/dist/bootstrap-table.min.css',
    '../widgets/table/assets/vendor/bootstrap-table/bootstrap-table.min.css'
).copy(
    'node_modules/bootstrap-table/dist/bootstrap-table.min.js',
    '../widgets/table/assets/vendor/bootstrap-table/bootstrap-table.min.js'
);

mix.copy(
    'node_modules/dropzone/dist/dropzone.css',
    '../../main/widgets/mediamanager/assets/vendor/dropzone/dropzone.min.css'
).copy(
    'node_modules/dropzone/dist/dropzone-min.js',
    '../../main/widgets/mediamanager/assets/vendor/dropzone/dropzone.min.js'
);
