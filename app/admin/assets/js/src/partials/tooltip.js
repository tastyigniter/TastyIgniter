+function ($) {

    page.initTooltip = function () {
        $('a[title], span[title], button[title]', document).tooltip({placement: 'bottom'});
    }

}(jQuery);
