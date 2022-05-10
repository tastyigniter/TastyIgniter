/*
 * The progress indicator.
 *
 * data-progress-indicator="Message" - displays a progress indicator with a supplied message, the element
 * must be wrapped in a `<div class="progress-indicator-container"></div>` container.
 *
 * JavaScript API:
 *
 * $('#buttons').progressIndicator({ text: 'Saving...', opaque: true }) - display the indicator in a solid (opaque) state
 * $('#buttons').progressIndicator({ centered: true }) - display the indicator aligned in the center horizontally
 * $('#buttons').progressIndicator({ size: small }) - display the indicator in small size
 * $('#buttons').progressIndicator({ text: 'Saving...' }) - display the indicator in a transparent state
 * $('#buttons').progressIndicator('hide') - hide the indicator
 */
+function ($) {
    "use strict"

    var ProgressIndicator = function (element, options) {
        this.$el = $(element)

        this.options = options || {}
        this.counter = 0
        this.show()
    }

    ProgressIndicator.prototype.hide = function() {
        this.counter--

        if (this.counter <= 0) {
            $('div.progress-indicator', this.$el).remove()
            this.$el.removeClass('in-progress')
        }
    }

    ProgressIndicator.prototype.show = function(options) {
        if (options)
            this.options = options

        this.hide()

        var indicator = $('<div class="progress-indicator"></div>')
        indicator.append($('<span class="ti-loading spinner-border"></span>'))
        indicator.append($('<div></div>').text(this.options.text))
        if (this.options.opaque !== undefined) {
            indicator.addClass('is-opaque')
        }
        if (this.options.centered !== undefined) {
            indicator.addClass('indicator-center')
        }
        if (this.options.size === 'small') {
            indicator.addClass('size-small')
        }

        this.$el.prepend(indicator)
        this.$el.addClass('in-progress')

        this.counter++
    }

    ProgressIndicator.prototype.destroy = function() {
        this.$el.removeData('ti.progressIndicator')
        this.$el = null
    }

    ProgressIndicator.DEFAULTS = {
        text: ''
    }

    // PROGRESS INDICATOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.progressIndicator

    $.fn.progressIndicator = function (option) {
        var args = arguments;

        return this.each(function () {
            var $this = $(this)
            var data  = $this.data('ti.progressIndicator')
            var options = $.extend({}, ProgressIndicator.DEFAULTS, typeof option == 'object' && option)

            if (!data) {
                if (typeof option == 'string')
                    return;

                $this.data('ti.progressIndicator',  new ProgressIndicator(this, options))
            } else {
                if (typeof option !== 'string')
                    data.show(options);
                else {
                    var methodArgs = [];
                    for (var i=1; i<args.length; i++)
                        methodArgs.push(args[i])

                    data[option].apply(data, methodArgs)
                }
            }
        })
    }

    $.fn.progressIndicator.Constructor = ProgressIndicator

    // PROGRESS INDICATOR NO CONFLICT
    // =================

    $.fn.progressIndicator.noConflict = function () {
        $.fn.progressIndicator = old
        return this
    }

    // PROGRESS INDICATOR DATA-API
    // ==============

    $(document)
        .on('ajaxPromise', '[data-progress-indicator]', function() {
            var
                $indicatorContainer = $(this).closest('.progress-indicator-container'),
                progressText = $(this).data('progress-indicator'),
                options = {
                    opaque: $(this).data('progress-indicator-opaque'),
                    centered: $(this).data('progress-indicator-centered'),
                    size: $(this).data('progress-indicator-size')
                }

            if (progressText)
                options.text = progressText

            $indicatorContainer.progressIndicator(options)
        })
        .on('ajaxFail ajaxDone', '[data-progress-indicator]', function() {
            $(this).closest('.progress-indicator-container').progressIndicator('hide')
        })
}(window.jQuery);
