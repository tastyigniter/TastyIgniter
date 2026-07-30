$(function () {
    var $el = $('[data-control="cookie-banner"]'),
        $btn = $el.find('#eu-cookie-action'),
        options = $.extend({}, $el.data()),
        cookieName = 'complianceCookie',
        cookieValue = 'on',
        cookieDuration = 30

    if ($el.length) {
        if (options.active === 1) {
            if (checkCookie(cookieName) !== cookieValue) {
                $el.fadeIn()
            }
        } else {
            eraseCookie('complianceCookie');
        }
    }

    $btn.on('click', function (event) {
        createCookie(cookieName, cookieValue, cookieDuration);
        $el.fadeOut()
    })

    function createCookie(name, value, days) {
        var expires = ''

        if (days) {
            var date = new Date()
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
            expires = '; expires=' + date.toGMTString()
        }

        document.cookie = name + "=" + value + expires + "; path=/"
    }

    function checkCookie(name) {
        var nameEQ = name + "=",
            ca = document.cookie.split(';')

        for (var i = 0; i < ca.length; i++) {
            var c = ca[i]
            while (c.charAt(0) === ' ') c = c.substring(1, c.length)
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length)
        }

        return null
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }
})