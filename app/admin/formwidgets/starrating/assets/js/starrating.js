/*
 * Star rating class
 */
+function ($) {
    "use strict";

    if ($.ti === undefined) $.ti = {}

    if ($.ti.starRating === undefined)
        $.ti.starRating = {}

    var StarRating = function (element, options) {
        this.$el = $(element)

        this.options = options

        this.init()
    }

    StarRating.prototype.constructor = StarRating

    StarRating.prototype.init = function () {
        this.$ratingElement = this.$el.find('.rating')

        this.$ratingElement.raty(this.options)
    }

    // MEDIA MANAGER PLUGIN DEFINITION
    // ============================

    StarRating.DEFAULTS = {
        score: null,
        scoreName: null,
        readOnly: false,
        hints: [],
        starOff: 'fa fa-star-o',
        starOn: 'fa fa-star',
        cancel: false,
        half: false,
        starType: 'i'
    }

    var old = $.fn.starRating

    $.fn.starRating = function (option) {
        var args = Array.prototype.slice.call(arguments, 1),
            result = undefined

        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.starRating')
            var options = $.extend({}, StarRating.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.starRating', (data = new StarRating(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.starRating.Constructor = StarRating

    // MEDIA MANAGER NO CONFLICT
    // =================

    $.fn.starRating.noConflict = function () {
        $.fn.starRating = old
        return this
    }

    // MEDIA MANAGER DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="star-rating"]').starRating()
    })

}(window.jQuery);
