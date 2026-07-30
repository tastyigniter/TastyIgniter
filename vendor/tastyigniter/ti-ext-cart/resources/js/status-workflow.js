/*
 * Status workflow plugin
 *
 * Data attributes:
 * - data-control="status-workflow" - enables the plugin on an element
 */

+function ($) {
    "use strict";

    // FIELD STATUSWORKFLOW CLASS DEFINITION
    // ============================

    var StatusWorkflow = function (element, options) {
        this.options = options
        this.$el = $(element)
        this.$modalTemplate = $('[data-status-workflow-modal-template]', this.$el)
        this.workflowQueue = []
        this.activeStatus = null

        // Init
        this.init()
        this.initChannel()
    }

    StatusWorkflow.DEFAULTS = {
        actionUrl: undefined,
        modalSelector: undefined,
        locations: undefined,
    }

    StatusWorkflow.prototype.init = function () {
    }

    StatusWorkflow.prototype.initChannel = function () {
        if (typeof Broadcast === 'undefined') {
            console.warn('Broadcast is not defined, ensure Broadcast Events extension is set up correctly.')
            return
        }

        this.options.locations.forEach((id) => {
            Broadcast.channel('igniter.order-placed.'+id)
                .listen('.cart.order-placed', $.proxy(this.toggleModal, this));
        });
    }

    StatusWorkflow.prototype.toggleModal = function (order) {
        this.workflowQueue[order.id] = order

        if (this.$modalTemplate.length === 0) {
            console.warn('Order status workflow modal template not found.')
            return
        }

        if (this.activeOrder) {
            // Modal is already open, do not show it again
            return
        }

        var modalSelector = this.options.modalSelector.replace('{id}', order.id)
        if ($(modalSelector).length > 0) {
            // Modal already exists, dont show it
            return
        }

        var modalHtml = this.$modalTemplate.html().replace(/\{\w+\}/g, key => {
            key = key.slice(1, -1).trim();
            return order[key] || key;
        })

        this.$el.after(modalHtml)

        var $modal = $(modalSelector)
        $modal.on('click', '[data-status-workflow-control]', $.proxy(this.onControlClick, this))
            .on('hidden.bs.modal', $.proxy(this.onModalHidden, this))
            .on('shown.bs.modal', $.proxy(this.onModalShown, this));

        $modal.modal({backdrop: 'static', keyboard: false})
        $modal.modal('show')

        this.activeOrder = order
        delete this.workflowQueue[order.id]
    }

    StatusWorkflow.prototype.onModalHidden = function (event) {
        var $modal = $(event.currentTarget)
        $modal.remove()

        this.activeOrder = null

        // Trigger next order in the queue if available
        if (Object.keys(this.workflowQueue).length > 0) {
            var nextOrderId = Object.keys(this.workflowQueue)[0]
            this.toggleModal(this.workflowQueue[nextOrderId])
        }
    }

    StatusWorkflow.prototype.onModalShown = function (event) {

    }

    StatusWorkflow.prototype.processAction = function ($modalEl, action, data) {
        if (!this.activeOrder) {
            console.warn('No active order to process action on.')
            return
        }

        if (!this.options.actionUrl) {
            console.warn('Action URL is not defined in options.')
            return
        }

        var actionUrl = this.options.actionUrl
            .replace('{action}', action)
            .replace('{id}', this.activeOrder.id);

        $.ajax(actionUrl, {
            data: data,
            type: 'POST',
            success: (data, textStatus, jqXHR) => {
                $.ti.flashMessage({class: 'success', text: data.message});
                $modalEl.modal('hide')
            },
            error: (jqXHR, textStatus, errorThrown) => {
                if (jqXHR.responseJSON?.message) {
                    $.ti.flashMessage({class: 'danger', text: jqXHR.responseJSON?.message});
                } else if (jqXHR.responseJSON?.X_IGNITER_FLASH_MESSAGES) {
                    $.each(jqXHR.responseJSON?.X_IGNITER_FLASH_MESSAGES, function (index, message) {
                        $.ti.flashMessage({class: 'danger', text: message.text});
                    })
                } else {
                    $.ti.flashMessage({class: 'danger', text: 'An error occurred while processing the action.'});
                }
            }
        }).always(() => {
            $modalEl.find('.modal-footer button').prop('disabled', false);
        })
    }

    StatusWorkflow.prototype.onControlClick = function (event) {
        var $button = $(event.currentTarget),
            $modal = $button.closest('.modal');

        $modal.find('.modal-footer button').prop('disabled', true);

        switch ($button.data('status-workflow-control')) {
            case 'accept':
                this.processAction($modal, 'accept', {})
                break;
            case 'delay':
                this.processAction($modal, 'accept', {
                    minutes: $button.data('delay-minutes')
                })
                break;
            case 'reject':
                this.processAction($modal, 'reject', {
                    reasonCode: $button.data('reason-code')
                })
                break;
        }
    }

    // FIELD STATUSWORKFLOW PLUGIN DEFINITION
    // ============================

    var old = $.fn.statusWorkflow

    $.fn.statusWorkflow = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.statusWorkflow')
            var options = $.extend({}, StatusWorkflow.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.statusWorkflow', (data = new StatusWorkflow(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.statusWorkflow.Constructor = StatusWorkflow

    // FIELD STATUSWORKFLOW NO CONFLICT
    // =================

    $.fn.statusWorkflow.noConflict = function () {
        $.fn.statusWorkflow = old
        return this
    }

    // FIELD STATUSWORKFLOW DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="status-workflow"]', document).statusWorkflow()
    });

}(window.jQuery);
