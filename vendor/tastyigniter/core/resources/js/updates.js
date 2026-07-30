/* ========================================================================
 * TastyIgniter: updates.js v2.2.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */

+function ($) {
    "use strict"

    // UPDATES CLASS DEFINITION
    // =========================

    var Updates = function (element, options) {
        this.options = options
        this.$container = $(element)
        this.$itemModal = null

        this.init()
    }

    Updates.DEFAULTS = {
        carteModal: '#carte-modal',
        itemModal: '#item-modal',
        searchContainer: '#marketplace-search',
        searchInput: '#marketplace-search .search',
        updateSteps: [],
        itemInModal: null,
        itemsToApply: [],
        installedItems: []
    }

    Updates.prototype.init = function () {
        this.bindSearch(this.options.searchInput)

        $(document).on('click', '#update-carte', $.proxy(this.onUpdateCarteClick, this))

        $(document).on('click', '[data-control="apply-updates"]', $.proxy(this.onApplyUpdateClick, this))

        $(document).on('click', '[data-control="apply-install"]', $.proxy(this.onApplyInstallClick, this))
    }

    Updates.prototype.openModal = function (itemToOpen, context) {

        this.$itemModal = $(Updates.TEMPLATES.modal)

        if (!itemToOpen || !context) return

        this.$container.after(this.$itemModal)
        this.$itemModal.find('.modal-title').html(itemToOpen.title)

        this.options.itemInModal = $.extend({}, context, itemToOpen)
        this.loadModal()

        var modal = new bootstrap.Modal(this.$itemModal, {backdrop: 'static', keyboard: false})

        modal.show()
        this.$itemModal.on('hidden.bs.modal', $.proxy(this.clearModal, this))
    }

    Updates.prototype.loadModal = function () {
        if (!this.options.itemInModal) return

        var context = this.options.itemInModal,
            bodyHtml = Mustache.render(Updates.TEMPLATES.modalBody, context),
            footerHtml = Mustache.render(Updates.TEMPLATES.modalFooter, context)

        this.$itemModal.find('.item-details').html(bodyHtml)
        this.$itemModal.find('.modal-footer').html(footerHtml)
    }

    Updates.prototype.clearModal = function (event) {
        var $modal = $(event.currentTarget)

        this.$itemModal = null
        this.options.itemInModal = null
        $modal.remove()
    }

    Updates.prototype.showProgressBar = function () {
        if (!this.$itemModal) {
            this.$itemModal = $(Updates.TEMPLATES.modal)
            this.$container.after(this.$itemModal)
            var modal = new bootstrap.Modal(this.$itemModal, {backdrop: 'static', keyboard: false})

            modal.show()
            this.$itemModal.on('hidden.bs.modal', $.proxy(this.clearModal, this))
        }

        var $modalContent = this.$itemModal.find('.modal-content')

        $('> div', $modalContent).slideUp()
        $('.modal-header', this.$itemModal).slideUp()
        $modalContent.html(Updates.TEMPLATES.progressBar)
    }

    Updates.prototype.setProgressBar = function (message, context) {
        var $container = $('#progressBar'),
            $message = $container.find('.message'),
            $spinner = $container.find('.spinner'),
            $icon = $container.find('.icon')

        if (message) {
            if (context === 'danger') {
                message = '<span class="text-danger">'+message+'</span>';
            }

            $message.append(message+'<br>')
        }

        if (context) {
            $icon.addClass('fas fa-3x text-'+context+' fa-circle-'+(context == 'danger' ? 'exclamation' : 'check'))
            $spinner.remove()

            if (context === 'danger') {
                this.$itemModal.find('.modal-content').append([
                    '<div class="modal-footer">',
                    '<button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal" aria-hidden="true">Close</button>',
                    '</div>'
                ].join(''))
            }
        }
    }

    Updates.prototype.handleInstallOrUpdateResponse = function (json) {
        var self = this
        self.setProgressBar(json.message, json.success ? 'success' : 'danger')

        if (json.redirect) {
            setTimeout(function () {
                self.$itemModal.find('.modal-content').append([
                    '<div class="modal-footer">',
                    '<a class="btn btn-secondary btn-block" href="'+json.redirect+'">Close</a>',
                    '</div>'
                ].join(''))
            });
        }
    }

    Updates.prototype.onUpdateCarteClick = function (event) {
        var $button = $(event.currentTarget),
            $icon = $button.find('.fa'),
            $form = $button.closest('#carte-form'),
            $modal = $button.closest('#carte-modal')

        if ($button.hasClass('disabled')) return

        $button.attr('disable', true).addClass('disabled')
        $icon.removeClass('fa-arrow-right').addClass('fa-spinner fa-spin')

        $form.request('onApplyCarte').always(function () {
            $button.attr('disable', false).removeClass('disabled')
            $icon.removeClass('fa-spinner fa-spin').addClass('fa-arrow-right')
        }).fail(function (xhr) {
            $modal.modal('hide')
        })
    }

    Updates.prototype.onApplyInstallClick = function (event) {
        var self = this,
            $button = $(event.target),
            $modal = $button.closest('.modal')

        if ($button.hasClass('disabled')) return

        $button.attr('disable', true).addClass('disabled')

        this.showProgressBar()
        $.request('onApplyItems', {
            data: {
                item: {
                    code: this.options.itemInModal.code,
                    name: this.options.itemInModal.name,
                    type: this.options.itemInModal.type,
                    version: this.options.itemInModal.version,
                    package: this.options.itemInModal.package,
                    action: this.options.itemInModal.action
                }
            }
        }).always(function () {
            $button.attr('disable', false).removeClass('disabled')
        }).fail(function (xhr) {
            $modal.modal('hide')
        }).done(function (json) {
            self.handleInstallOrUpdateResponse(json)
        })

        this.options.itemsToApply = []
    }

    Updates.prototype.onApplyUpdateClick = function (event) {
        var self = this,
            $button = $(event.currentTarget)

        if ($button.hasClass('disabled')) return

        $button.attr('disable', true).addClass('disabled')

        this.showProgressBar()
        $.request('onApplyUpdate').always(function () {
            $button.attr('disable', false).removeClass('disabled')
        }).done(function (json) {
            self.handleInstallOrUpdateResponse(json)
        })
    }

    Updates.prototype.bindSearch = function (field) {
        var self = this,
            $field = $(field),
            $container = $field.closest(this.options.searchContainer),
            searchType = $field.data('searchType'),
            searchAction = $field.data('searchAction')

        if ($field.length === 0) return

        var template = Updates.TEMPLATES.suggestion

        Mustache.parse(template)
        var suggestionTemplate = function (context) {
            return Mustache.render(template, context)
        }

        var engine = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            name: 'items',
            method: 'POST',
            limit: 15,
            remote: {
                url: searchAction+'?filter[type]='+searchType+'&filter[search]=%QUERY',
                wildcard: '%QUERY',
                transform: function (response) {
                    return (response && response.hasOwnProperty('data')) ? response.data : []
                }
            },
        })

        engine.initialize()

        $(field).typeahead({
            highlight: true
        }, {
            name: 'items',
            display: 'name',
            source: engine.ttAdapter(),
            templates: {
                notFound: [
                    '<div class="empty-message">',
                    'Unable to find any '+searchType+' that match the current query <br>',
                    '<b>If you have not already attached a carte key, please do so from the updates page</b>',
                    '</div>'
                ].join('\n'),
                suggestion: suggestionTemplate
            }
        }).on('typeahead:asyncrequest', function (object, query, data) {
            $('.fa-icon', $container).hide()
            $('.fa-icon.loading', $container).addClass('fa-pulse').show()
        }).on('typeahead:asyncreceive', function (object, query, data) {
            $('.fa-icon', $container).show()
            $('.fa-icon.loading', $container).hide()
        }).on('typeahead:select', function (object, context) {
            self.openModal({
                title: 'Add '+context.name,
                code: context.code,
                type: context.type,
                ver: context.version,
                action: 'install',
                submit: context.installed ? 'Already Added' : 'Add '+context.type
            }, context)
        })
    }

    Updates.TEMPLATES = {
        suggestion: [
            '<div class="item-details">',
            '<div class="item-thumb text-muted">',
            '{{#icon.url}}',
            '<img src="{{icon.url}}" class="img-rounded" alt="No Image" style="width: 48px; height: 48px;" />',
            '{{/icon.url}}{{^icon.url}}',
            '<span class="extension-icon rounded" style="{{icon.styles}};"><i class="{{icon.class}}"></i></span>',
            '{{/icon.url}}',
            '</div>',
            '<div class="item-name">{{name}}</div>',
            '<div class="item-description text-muted text-overflow">{{{description}}}</div>',
            '</div>'
        ].join(''),

        modal: [
            '<div id="item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">',
            '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">',
            '<h4 class="modal-title"></h4>',
            '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>',
            '</div><div class="modal-body wrap-none">',
            '<div class="item-details"></div>',
            '</div><div class="modal-footer">',
            '</div></div></div></div></div>',
        ].join(''),

        modalBody: [
            '<div class="text-center py-4 px-3"><a>',
            '{{#icon.url}}',
            '<img src="{{icon.url}}" class="img-rounded" alt="No Image" style="width: 68px; height: 68px;">',
            '{{/icon.url}}{{^icon.url}}',
            '<span class="extension-icon icon-lg rounded" style="{{icon.styles}};"><i class="{{icon.class}}"></i></span>',
            '{{/icon.url}}',
            '</a><div class="pt-4">',
            '<p>{{{description}}}</p><span class="text-muted">Version:</span> <strong>{{version}}</strong>, ',
            '<span class="text-muted">Author:</span> <strong>{{author}}</strong>',
            '</div></div>',
        ].join(''),

        modalFooter: [
            '<div class="text-right">',
            '<button type="button" class="btn btn-link text-decoration-none fw-bold" data-bs-dismiss="modal" aria-hidden="true">Close</button>',
            '&nbsp;&nbsp;&nbsp;&nbsp;',
            '{{#installed}}',
            '<button class="btn btn-primary" disabled><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;{{submit}}</button>',
            '{{/installed}}{{^installed}}',
            '<button type="submit" class="btn btn-primary" data-control="apply-install">',
            '<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;{{submit}}</button>',
            '{{/installed}}',
            '</div>',
        ].join(''),

        progressBar: [
            '<div id="progressBar" class="p-3"><div class="card-body text-center">',
            '<div class="spinner spinner-grow" role="status"><span class="visually-hidden">Loading...</span></div>',
            '<i class="icon"></i>',
            '<p class="mt-4">Please <b>do not refresh</b> or <b>close the page</b> while the update is running. <br>Interrupting the update may cause incomplete installations or system errors.</p>',
            '<pre class="message bg-black rounded text-start text-white p-3 mt-4 mb-0 text-wrap fs-5"><code>Starting...<br></code></pre></div></div></div>',
        ].join(''),
    }

    // UPDATES PLUGIN DEFINITION
    // ==========================

    if ($.ti === undefined) $.ti = {}

    $.fn.updates = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.updates')
            var options = $.extend({}, Updates.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.updates', (data = new Updates(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.updates.Constructor = Updates

    $(document).render(function () {
        $('body').updates()
    })

}(jQuery)
