/* ========================================================================
 * TastyIgniter: updates.js v2.2.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */

+function ($) {
    "use strict";

    // UPDATES CLASS DEFINITION
    // =========================

    var Updates = function () {
        var self = this;
        this.items = [];
        this.updateSteps = [];

        $(document).ready(function () {
            self.bindSearch($('#marketplace-search .search'));
        });
    }

    Updates.prototype.executeSteps = function (steps) {

        this.showProgressBar();

        this.updateSteps = steps;
        this.runStep(0);
    }

    Updates.prototype.completeStep = function () {
        this.setProgressBar('Done.', 'success', true)

        setTimeout(function () {
            window.location.reload(true);
        }, 500);
    }

    Updates.prototype.runStep = function (stepIndex) {
        var self = this;

        if (typeof self.updateSteps[stepIndex] == 'undefined') return;

        var step = self.updateSteps[stepIndex];

        var oldStepIndex = stepIndex - 1;
        self.switchModal(step.code, oldStepIndex)

        self.setProgressBar(step.label)

        $.request('updates/process', {
            data: step
        }).done(function (json) {
            var data = $.parseJSON(json);

            if (data['redirect']) {
                self.setProgressBar('Redirecting to setup page')
                setTimeout(function () { window.location.href = data['redirect'] }, 500);
            } else {

                if (step.process == 'completeUpdate' || step.process == 'completeInstall')
                    self.removeFromItems(step.code)

                if (stepIndex < self.updateSteps.length) {
                    stepIndex++
                    self.runStep(stepIndex)
                }

                if (stepIndex == self.updateSteps.length - 1)
                    self.completeStep()
            }

        }).fail(function (xhr) {
            self.setProgressBar(xhr.responseText, 'danger')
        })
    }

    Updates.prototype.submitForm = function () {
        var self = this,
            items = self.items

        if (items.length == 0) return;

        $.request('updates/apply', {
            data: {code: items},
            success: function (json) {
                var data = $.parseJSON(json);
                if (data['response']['steps'])
                    self.executeSteps(data['response']['steps']);
            },
            error: function (xhr) {
                TI.helpers.addAlert(xhr.responseText, 'danger');
                $('#item-modal').modal('hide')
            }
        })
    }

    Updates.prototype.findItem = function (itemCode, apply) {
        var items = apply ? this.items : updatesItems;

        for (var i in items) {
            var context = items[i]
            if (!context.hasOwnProperty('code')) continue;

            if (context.code == itemCode)
                return context;
        }

        return null;
    }

    Updates.prototype.removeFromItems = function (itemCode) {
        var items = this.items;

        $.each(items, function (i) {
            if (items[i].code == itemCode) {
                items.splice(i, 1);
                return false;
            }
        });
    }

    Updates.prototype.loadModalBody = function (modal, context) {
        var bodyHtml = Updates.TEMPLATES.modalBody,
            requireHtml = Updates.TEMPLATES.modalRequire;

        context.submit = context.installed ? 'Already Added' : 'Add ' + context.type;

        $(modal).find('.panel .item-details').html(Mustache.render(bodyHtml, context));
        if (context.require) {
            context.require.map(function (require) {
                return $.extend(require, {installed: ($.inArray(require.code, installedItems) > -1)})
            })

            $(modal).find('.panel-body').after(Mustache.render(requireHtml, context));
        }
    }

    Updates.prototype.openModal = function (itemToOpen) {

        var self = this,
            modal = '#item-modal',
            modalHtml = Updates.TEMPLATES.modal,
            footerHtml = Updates.TEMPLATES.modalFooter;

        if (self.items.length < 1) return

        var item = itemToOpen ? itemToOpen : self.items[0],
            context = $.ti.updates.findItem(item.code)

        $('body').append(modalHtml);
        $(modal).find('.modal-title').html(item.title);

        if (context != null && self.items[0].code != 'tastyigniter') {
            self.loadModalBody(modal, context)
            $(modal).find('.panel-footer').html(Mustache.render(footerHtml, context));
        }

        $(modal).modal({backdrop: 'static', keyboard: false, show: true})
        $(modal).on('hidden.bs.modal', function () {
            self.clearModal(modal, context)
        });
    }

    Updates.prototype.switchModal = function (code, oldStepIndex) {
        var self = this

        if (typeof self.updateSteps[oldStepIndex] == 'undefined') return

        var oldStep = self.updateSteps[oldStepIndex];

        if (oldStep.length == 0 || oldStep.code == code) return

        var pcontext = self.findItem(code, true),
            context = self.findItem(code)

        if (pcontext.length == 0 || context.length == 0) return

        var modal = '#item-modal';
        $(modal).find('.modal-title').html(pcontext.title);
        self.loadModalBody(modal, context)
    }

    Updates.prototype.clearModal = function (modal, context) {
        var self = this

        $(modal).remove();

        if (context == null) return;

        self.removeFromItems(context.code)

        if (context.require) {
            context.require.map(function (require) {
                self.removeFromItems(require.code)
                return false;
            })
        }
    }

    Updates.prototype.showProgressBar = function () {
        var $modal = $('#item-modal'),
            $footer = $modal.find('.panel-footer')

        $footer.html(Updates.TEMPLATES.progressBar)
    }

    Updates.prototype.setProgressBar = function (message, type, complete) {
        var progressBox = $('#progressBar'),
            progressBar = progressBox.find('.progress-bar'),
            progressMessage = progressBox.find('.message'),
            progressCount = complete ? 100 : parseInt(progressBar.attr('aria-valuenow')) + parseInt((100 / Object.keys(this.updateSteps).length).toFixed(0)),
            modalCloseButton = progressBox.parents('.modal').find('[data-dismiss="modal"]');

        progressMessage.html(message);
        progressBar.attr('aria-valuenow', progressCount).width(progressCount + '%');

        if (type != null) {
            progressBar.addClass('progress-bar-' + type);
            progressMessage.addClass('text-' + type);
        }

        if (complete)
            progressBar.removeClass('active')

        if (type == 'danger' || (progressCount < 1 || progressCount >= 100))
            modalCloseButton.removeClass('hide').attr('disabled', false)
        else
            modalCloseButton.addClass('hide').attr('disabled', true)

        progressBox.fadeIn();
    }

    Updates.prototype.bindSearch = function (field) {
        var self = this,
            $field = $(field),
            $container = $field.closest('#marketplace-search'),
            searchType = $field.data('searchType');

        if ($field.length == 0) return;

        var template = Updates.TEMPLATES.suggestion;

        Mustache.parse(template)
        var suggestionTemplate = function (context) {
            return Mustache.render(template, context);
        }

        var engine = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            name: 'items',
            method: 'POST',
            limit: 15,
            remote: {
                url: js_site_url('updates/search?filter[type]=' + searchType + '&filter[search]=%QUERY'),
                wildcard: '%QUERY',
                transform: function (response) {
                    return (response['response'] && response['response'].hasOwnProperty('data')) ? response['response'].data : [];
                }
            },
        });

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
                    'unable to find any ' + searchType + ' that match the current query',
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
            self.items.push({
                title: 'Add ' + context.name,
                code: context.code,
                type: context.type,
                ver: context.version,
                action: 'install'
            })

            self.openModal();
        });
    };

    // Move to script tags instead
    Updates.TEMPLATES = {
        suggestion: [
            '<div class="item-details">',
            '<div class="item-thumb text-muted">',
            '{{#thumb}}',
            '<img src="{{thumb}}" class="img-rounded" alt="No Image" style="width: 48px; height: 48px;" />',
            '{{/thumb}}{{^thumb}}',
            '<i class="fa {{icon}} fa-2x"></i>',
            '{{/thumb}}',
            '</div>',
            '<div class="item-name">{{name}}</div>',
            '<div class="item-description small text-muted text-overflow">{{{description}}}</div>',
            '</div>'
        ].join(''),

        modal: [
            '<div id="item-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">',
            '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">',
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
            '<h4 class="modal-title"></h4>',
            '</div><div class="modal-body wrap-none">',
            '<div class="panel panel-default"><div class="item-details"></div>',
            '<div class="panel-footer border-top">',
            '</div></div></div></div></div></div>',
        ].join(''),

        modalBody: [
            '<div class="panel-body"><div class="media"><a class="media-left">',
            '{{#thumb}}',
            '<img src="{{thumb}}" class="img-rounded" alt="No Image" style="width: 68px; height: 68px;">',
            '{{/thumb}}{{^thumb}}',
            '<i class="fa {{icon}} fa-4x text-muted"></i>',
            '{{/thumb}}',
            '</a><div class="media-body">',
            '<p>{{{description}}}</p><span class="small"><span class="text-muted">Version:</span> <strong>{{version}}</strong>, ',
            '<span class="text-muted">Author:</span> <strong>{{author}}</strong></span>',
            '</div></div></div>',
        ].join(''),

        modalRequire: [
            '<ul class="list-group">',
            '<li class="list-group-item list-group-item-warning"><strong>Requires:</strong></li>',
            '{{#require}}',
            '<li class="list-group-item"><div class="media"> ',
            '<div class="media-left media-middle" style="padding-right:20px"><i class="fa {{icon}} text-muted"></i></div>',
            '<div class="media-body media-middle"><span>{{name}}</span></div>',
            '<div class="media-right">',
            '{{#installed}}',
            '<button class="btn btn-default btn-require pull-right" title="Added" disabled><i class="fa fa-cloud-download text-success"></i></button>',
            '{{/installed}}{{^installed}}',
            '<button class="btn btn-default btn-require pull-right" data-title="Add {{name}}" data-require-code="{{code}}" data-version="{{version}}" data-type="{{type}}"><i class="fa fa-cloud-download text-success"></i></button>',
            '{{/installed}}',
            '</div></li>',
            '{{/require}}',
            '</ul>',
        ].join(''),

        modalFooter: [
            '<div class="text-right">',
            '<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>',
            '&nbsp;&nbsp;&nbsp;&nbsp;',
            '{{#installed}}',
            '<button type="submit" class="btn btn-success" disabled><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;{{submit}}</button>',
            '{{/installed}}{{^installed}}',
            '<button type="submit" class="btn btn-success btn-install">',
            '<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;{{submit}}</button>',
            '{{/installed}}',
            '</div>',
        ].join(''),

        progressBar: [
            '<div id="progressBar"><div class="progress-box">',
            '<p class="message"></p><div class="progress">',
            '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>',
            '</div></div></div>',
        ].join(''),
    }

    // UPDATES PLUGIN DEFINITION
    // ==========================

    if ($.ti === undefined) $.ti = {}

    $.ti.updates = new Updates

    $(document).on('click', '#item-modal button[type="submit"]', function () {
        var $button = $(this);

        $button.attr('disable', true).addClass('disabled')

        $.ti.updates.submitForm()
    });

    $(document).on('click', 'button[data-require-code]', function () {
        var $button = $(this);

        if ($button.data('requireCode') == null) return;

        $button.attr('disable', true).addClass('disabled')

        $.ti.updates.items.push({
            title: $button.data('title'),
            code: $button.data('requireCode'),
            type: $button.data('requireType'),
            ver: $button.data('requireVersion'),
            action: 'install'
        })
    })

    $(document).on('click', 'button[data-install-code]', function () {
        var $button = $(this),
            installCode = $button.data('installCode'),
            context = $.ti.updates.findItem(installCode)

        if (context == null) return;

        var installItem = {
            title: $button.data('title'),
            code: $button.data('installCode'),
            type: $button.data('installType'),
            ver: $button.data('installVersion'),
            action: 'install'
        }

        $.ti.updates.items.push(installItem)

        $.ti.updates.openModal(installItem);
        // setTimeout($.ti.updates.submitForm(), 100)
    })

    $(document).on('click', '#applyUpdates', function () {
        var $checkboxes = $('input[data-update-code]:checked')

        $checkboxes.each(function () {
            var checked = this.checked,
                $checkbox = $(this)

            console.log($checkbox);
            if (!checked) return false;

            $.ti.updates.items.push({
                title: $checkbox.data('title'),
                code: $checkbox.data('updateCode'),
                type: $checkbox.data('updateType'),
                ver: $checkbox.data('updateVersion'),
                action: 'update'
            })
        })

        $.ti.updates.openModal();
        setTimeout($.ti.updates.submitForm(), 100)
        console.log($.ti.updates.items);
    })

}(jQuery);