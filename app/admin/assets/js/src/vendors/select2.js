require('select2');

+function ($) {
    page.initSelect2 = function () {
        $.fn.select2.defaults.set('width', null);
        $.fn.select2.defaults.set('theme', 'bootstrap');
        $.fn.select2.defaults.set('minimumResultsForSearch', 10);
        $('select.form-control', document).select2();
    }

}(jQuery);
