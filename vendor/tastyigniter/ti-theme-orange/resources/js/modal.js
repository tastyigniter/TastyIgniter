+function ($) {
    "use strict";

    if ($.fn.orangeModal === undefined)
        $.fn.orangeModal = {}

    var OrangeModal = function (element, options) {
        this.$el = $(element)
        this.options = options || {}

        this.init()
    }

    OrangeModal.prototype.init = function () {
        $(document).on('click', this.options.toggleSelector, $.proxy(this.show, this));

        this.$el.on('hide.bs.modal', $.proxy(this.onModalHidden, this))
        this.$el.on('shown.bs.modal', $.proxy(this.onModalShown, this))

        Livewire.on('hideModal', () => {
            let modal = bootstrap.Modal.getOrCreateInstance(this.$el.get(0));
            modal.hide()
        })
    }

    OrangeModal.prototype.show = function (event) {
        var $button = $(event.currentTarget);

        this.options.component = $button.data('component');
        this.options.params = $button.data('arguments');

        let modal = bootstrap.Modal.getOrCreateInstance(this.$el.get(0));
        modal.show();
    }

    OrangeModal.prototype.onModalHidden = function (event) {
        Livewire.dispatch('resetModal')
    }

    OrangeModal.prototype.onModalShown = function (event) {
        Livewire.dispatch('showModal', {
            component: this.options.component,
            arguments: this.options.params,
        })
    }

    OrangeModal.DEFAULTS = {
        toggleSelector: '[data-toggle="orange-modal"]',
    }

    var old = $.fn.orangeModal

    $.fn.orangeModal = function (option) {
        var args = arguments

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.orangeModal')
            var options = $.extend({}, OrangeModal.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.orangeModal', (data = new OrangeModal(this, options)))
            if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.orangeModal.Constructor = OrangeModal

    $.fn.orangeModal.noConflict = function () {
        $.fn.booking = old
        return this
    };

    ['livewire:initialized', 'livewire:navigated'].forEach(function (eventName) {
        document.addEventListener(eventName, () => {
            $('#orange-modal').orangeModal()
        }, {once: true});
    });
}(window.jQuery);
