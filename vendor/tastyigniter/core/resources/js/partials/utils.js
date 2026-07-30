+function ($) {
    "use strict";

    $("#navSidebar").on('show.bs.collapse', function () {
        $('.sidebar').addClass('show')
    }).on('hide.bs.collapse', function () {
        $('.sidebar').removeClass('show')
    })

    $(document).render(function () {
        $('a[title], span[title], button[title]', document).not('[data-bs-toggle=dropdown]').tooltip({placement: 'bottom'});
        $('.alert', document).alert();
    });

    // Multiple Modal Fix
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length + 1)
        $(this).css('z-index', zIndex)
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 2).addClass('modal-stack')
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack')
        }, 0)
    })

    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open')
    })

    // Varying modal content
    $(document).on('show.bs.modal', '.modal', function (event) {
        var $modal = $(this),
            $button = $(event.relatedTarget)

        if (!$button.length)
            return

        $.each($button.get(0).attributes, function (index, attribute) {
            if (/^data-modal-/.test(attribute.name)) {
                var attrName = attribute.name.substr(11),
                    attrValue = attribute.value

                $modal.find('[data-modal-html="' + attrName + '"]').html(attrValue)
                $modal.find('[data-modal-text="' + attrName + '"]').text(attrValue)
                $modal.find('[data-modal-input="' + attrName + '"]').val(attrValue)
            }
        });
    })

    /*
     * Ensure the CSRF token is added to all AJAX requests.
     */
    $.ajaxPrefilter(function (options) {
        var token = $('meta[name="csrf-token"]').attr('content')

        if (token) {
            if (!options.headers) options.headers = {}
            options.headers['X-CSRF-TOKEN'] = token
        }
    })
}(window.jQuery);

/*
 * Asset Manager
 *
 * Usage: assetManager.load({ css:[], js:[], img:[] }, onLoadedCallback)
 */

AssetManager = function () {

    var o = {

        load: function (collection, callback) {
            console.log(collection)
            var jsList = (collection.js) ? collection.js : [],
                cssList = (collection.css) ? collection.css : [],
                imgList = (collection.img) ? collection.img : []

            jsList = $.grep(jsList, function (item) {
                return $('head script[src="' + item + '"]').length == 0
            })

            cssList = $.grep(cssList, function (item) {
                return $('head link[href="' + item + '"]').length == 0
            })

            var cssCounter = 0,
                jsLoaded = false,
                imgLoaded = false

            if (jsList.length === 0 && cssList.length === 0 && imgList.length === 0) {
                callback && callback()
                return
            }

            o.loadJavaScript(jsList, function () {
                jsLoaded = true
                checkLoaded()
            })

            $.each(cssList, function (index, source) {
                o.loadStyleSheet(source, function () {
                    cssCounter++
                    checkLoaded()
                })
            })

            o.loadImage(imgList, function () {
                imgLoaded = true
                checkLoaded()
            })

            function checkLoaded() {
                if (!imgLoaded)
                    return false

                if (!jsLoaded)
                    return false

                if (cssCounter < cssList.length)
                    return false

                callback && callback()
            }
        },

        /*
         * Loads StyleSheet files
         */
        loadStyleSheet: function (source, callback) {
            var cssElement = document.createElement('link')

            cssElement.setAttribute('rel', 'stylesheet')
            cssElement.setAttribute('type', 'text/css')
            cssElement.setAttribute('href', source)
            cssElement.addEventListener('load', callback, false)

            if (typeof cssElement != 'undefined') {
                document.getElementsByTagName('head')[0].appendChild(cssElement)
            }

            return cssElement
        },

        /*
         * Loads JavaScript files in sequence
         */
        loadJavaScript: function (sources, callback) {
            if (sources.length <= 0)
                return callback()

            var source = sources.shift(),
                jsElement = document.createElement('script');

            jsElement.setAttribute('type', 'text/javascript')
            jsElement.setAttribute('src', source)
            jsElement.addEventListener('load', function () {
                o.loadJavaScript(sources, callback)
            }, false)

            if (typeof jsElement != 'undefined') {
                document.getElementsByTagName('head')[0].appendChild(jsElement)
            }
        },

        /*
         * Loads Image files
         */
        loadImage: function (sources, callback) {
            if (sources.length <= 0)
                return callback()

            var loaded = 0
            $.each(sources, function (index, source) {
                var img = new Image()
                img.onload = function () {
                    if (++loaded == sources.length && callback)
                        callback()
                }
                img.src = source
            })
        }

    };

    return o;
};

assetManager = new AssetManager();
