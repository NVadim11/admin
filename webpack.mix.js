let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.styles([
    'public/admin/global/plugins/bootstrap/css/bootstrap.min.css',
    'public/admin/global/plugins/uniform/css/uniform.default.css',
    'public/admin/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    'public/admin/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
    'public/admin/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
    'public/admin/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
    'public/admin/global/plugins/bootstrap-select/bootstrap-select.min.css',
    'public/admin/global/plugins/jquery-multi-select/css/multi-select.css',
    'public/admin/pages/css/tasks.css',
    'public/admin/global/css/components-rounded.css',
    'public/admin/global/css/plugins.css',
    'public/admin/css/layout.css',
    'public/admin/css/themes/light.css',
    'public/admin/css/sweet-alert.css',
    'public/admin/css/custom.css'
], 'public/admin/css/all.css').options({
    processCssUrls: false
});

mix.scripts([
    'public/admin/global/plugins/respond.min.js',
    'public/admin/global/plugins/excanvas.min.js',
    'public/admin/global/plugins/jquery.min.js',
    'public/admin/global/plugins/jquery-migrate.min.js',
    'public/admin/global/plugins/jquery-ui/jquery-ui.min.js',
    'public/admin/global/plugins/bootstrap/js/bootstrap.min.js',
    'public/admin/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
    'public/admin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
    'public/admin/global/plugins/jquery.blockui.min.js',
    'public/admin/global/plugins/jquery.cokie.min.js',
    'public/admin/global/plugins/uniform/jquery.uniform.min.js',
    'public/admin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
    'public/admin/global/plugins/fuelux/js/spinner.min.js',
    'public/admin/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
    'public/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
    'public/admin/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
    'public/admin/global/plugins/bootstrap-select/bootstrap-select.min.js',
    'public/admin/global/plugins/jquery-multi-select/js/jquery.multi-select.js',
    'public/admin/global/plugins/jquery-idle-timeout/jquery.idletimeout.js',
    'public/admin/global/plugins/jquery-idle-timeout/jquery.idletimer.js',
    'public/admin/global/scripts/metronic.js',
    'public/admin/js/layout.js',
    'public/admin/pages/scripts/components-pickers.js',
    'public/admin/js/sweet-alert.min.js',
    'public/admin/js/snap.svg-min.js',
    'public/admin/js/svgicons.js',
    'public/admin/js/custom.js'
], 'public/admin/js/all.js');