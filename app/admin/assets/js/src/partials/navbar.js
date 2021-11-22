+function ($) {

    page.initNavbar = function () {
        page.navbar.metisMenu({
            toggle: true,
            collapseInClass: 'show'
        })

        $("#navSidebar").on('show.bs.collapse', function () {
            $('.sidebar').addClass('show')
        }).on('hide.bs.collapse', function () {
            $('.sidebar').removeClass('show')
        })
    }

}(jQuery);
