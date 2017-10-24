var Installer = {

    currentStep: null,

    options: {
        page: "#page",
        form: "#setup-form",
        currentStepSelector: "#current-step",
        submitButton: "button[type=\"submit\"]",
        progressBox: "#progress-box",
        flashMessageSelector: "#flash-message"
    },

    Steps: {
        requirement: {handler: "onCheckRequirements"},
        database: {handler: "onCheckDatabase"},
        install: {
            steps: {
                download: {
                    msg: "Downloading foundation framework...",
                    error: "Downloading failed. See installation log."
                },
                extract: {msg: "Extracting foundation framework...", error: "Extracting failed. See installation log."},
                install: {
                    msg: "Installing foundation framework (this might take a while)... <i class=\"fa fa-smile-o\"></i>",
                    error: "Installing failed. See installation log."
                }
            }
        },
        proceed: {proceedUrl: '/admin/settings', frontUrl: '/'},

        settings: {handler: "onValidateSettings"},

        success: {}
    },

    init: function () {
        Installer.$page = $(Installer.options.page)
        Installer.$progressBox = $(Installer.options.progressBox)
        Installer.currentStep = $(Installer.options.currentStepSelector).val()

        // render
        Installer.renderView(Installer.currentStep)
        Installer.updateWizard(Installer.currentStep)

        $(document).ready(function () {
            Installer.$form = $(Installer.options.form)

            Installer.$submitBtn = $(Installer.options.submitButton)
            Installer.$form.submit(Installer.submitForm)

            if (Installer.currentStep === 'requirement')
                Installer.checkRequirements()
        })
    },

    submitForm: function (e) {
        e.preventDefault()
        if (!Installer.$submitBtn.hasClass('disabled')) {
            Installer.currentStep = $(Installer.options.currentStepSelector).val()
            Installer.processForm()
        }
    },

    disableSubmitButton: function (disabled) {
        Installer.$submitBtn.prop("disabled", disabled)
        if (disabled) {
            Installer.$submitBtn.addClass("disabled")
        } else {
            Installer.$submitBtn.removeClass("disabled")
        }
    },

    getHandler: function (currentStep) {
        var step = Installer.Steps[currentStep]

        return step.handler
    },

    processForm: function () {
        if (Installer.$form.length) {
            var progressMessage = Installer.getAlert(Installer.currentStep),
                requestHandler = Installer.getHandler(Installer.currentStep)

            Installer.sendRequest(requestHandler, {}, progressMessage).done(function (json) {
                Installer.processResponse(json)
            })
        }
    },

    sendRequest: function (handler, data, message) {
        data.handler = handler
        var postData = (typeof Installer.$form !== "undefined")
            ? Installer.$form.serialize() + (typeof data === "undefined" ? ""
                : "&" + $.param(data)) : []

        Installer.disableSubmitButton(true)

        return $.ajax({
            async: true,
            type: "POST",
            cache: true,
            data: postData,
            beforeSend: Installer.showProgress("right", message)
        }).done(function () {
            Installer.disableSubmitButton(false)
            Installer.refreshProgress("right")
        }).fail(function (xhr) {
            Installer.hideProgress()
            Installer.disableSubmitButton(false)
            Installer.flashMessage("danger", xhr.responseText)
        })
    },

    refreshProgress: function (direction, message) {
        var $progressBar = Installer.$progressBox.find(".progress-bar"),
            $message = Installer.$progressBox.find(".message")

        if (message)
            $message.text(message)

        switch (direction) {
            case "right":
                $progressBar.attr("aria-valuenow", "100%").width("101%").delay(500)
                break
            case "left":
                $progressBar.css("left", "0").delay(200)
                break
            case "success":
            case "danger":
                var width = direction === 'success' ? "101%" : "10%"
                $progressBar.attr("aria-valuenow", width).width(width).delay(500)
                $progressBar.addClass('progress-bar-' + direction)
                $message.addClass('text-' + direction)
                break
            case "down":
                $progressBar.height("101%").delay(200).fadeOut(400)
                Installer.$progressBox.fadeOut()
                break
            case "up":
                $progressBar.css("top", "0").delay(200).fadeOut(400)
                Installer.$progressBox.fadeOut()
                break
        }
    },

    showProgress: function (direction, message) {
        var $progressBar = $(".progress-bar", Installer.$progressBox),
            progressMessage = Installer.$progressBox.find(".message")

        // if (message)
        //     progressMessage.text(message)
        // Installer.flashMessage(message)

        // if (!Installer.$progressBox.hasClass("waiting")) {
        // $progressBar.fadeIn()
        Installer.$progressBox.addClass("waiting")
        $progressBar.removeClass('progress-bar-danger')
        progressMessage.removeClass('text-danger')

        switch (direction) {
            case "right":
                var progressCount = (50 + Math.random() * 30) + "%"
                $progressBar.attr("aria-valuenow", progressCount).width(progressCount)
                break
            case "left":
                $progressBar.addClass("left").animate({
                    right: 0,
                    left: 100 - (50 + Math.random() * 30) + "%"
                }, 200)
                break
            case "down":
                $progressBar.addClass("down").animate({
                    left: 0,
                    height: (50 + Math.random() * 30) + "%"
                }, 200)
                break
            case "up":
                $progressBar.addClass("up").animate({
                    left: 0,
                    top: 100 - (50 + Math.random() * 30) + "%"
                }, 200)
                break
        }
        // }
    },

    hideProgress: function () {
        Installer.$progressBox.removeClass("waiting")
    },

    getAlert: function (step) {
        if (Installer.Steps.hasOwnProperty(step))
            return Installer.Steps[step].msg
    },

    checkRetry: function () {
        Installer.checkRequirements()
    },

    updateWizard: function (step) {
        var steps = [
            "requirement",
            "database",
            "settings",
            "install",
            "proceed"
        ]

        $(Installer.options.currentStepSelector).val(step)

        for (var index in steps) {
            Installer.$page.find('[data-wizard="' + steps[index] + '"]').addClass('complete')

            if (steps[index] === step) {
                break
            }
        }
    },

    checkRequirements: function () {
        var $requirementList = $('.list-requirement').empty(),
            $checkMessage = $(Installer.options.progressBox).find('.message'),
            $checkResult = $('#check-result').empty(),
            alertTemplate = $('[data-view="check_alert"]').clone().html(),
            requestChain = [],
            failCodes = [],
            failMessages = [],
            success = true

        $.each(Installer.$page.find('[data-requirement]'), function (index, requirement) {

            var $requirement = $(requirement),
                data = $requirement.data(),
                timeout = 1500

            requestChain.push(function () {
                var deferred = $.Deferred(),
                    itemName = $('<strong />').text(data.label),
                    itemIcon = $('<i />').addClass('fa fa-circle pull-right'),
                    item = $('<div />').addClass('list-group-item animated pulse').append(itemName).append(itemIcon)

                $requirementList.append(item)

                Installer.sendRequest('onCheckRequirement', {
                    code: data.code
                }).always(function () {
                    Installer.refreshProgress("left", "Checking system requirements [" + data.code + "]...")
                }).done(function (json) {
                    setTimeout(function () {
                        if (json.result) {
                            item.addClass('done')
                            itemIcon.attr('title', 'Success!')
                            deferred.resolve()
                        }
                        else {
                            success = false
                            failCodes.push(data.code)
                            failMessages.push(data.hint)
                            item.addClass('failed')
                            itemIcon.attr('title', data.hint)
                            deferred.resolve()
                        }
                        deferred.resolve()
                    }, timeout)
                }).fail(function () {
                    setTimeout(function () {
                        success = false
                        failCodes.push(data.code)
                        failMessages.push(data.hint)
                        item.addClass('failed')
                        itemIcon.attr('title', data.hint)
                        deferred.resolve()
                    }, timeout)
                })

                return deferred
            })
        })

        $.waterfall.apply(this, requestChain).always(function () {
        }).done(function (arr) {
            $checkMessage.text()
            Installer.hideProgress()
            if (!success) {
                $checkResult.append(Mustache.render(alertTemplate, {
                    code: failCodes.join(', '),
                    message: failMessages.join('<br> ')
                }))
                $checkResult.show().addClass('animated fadeInDown')
            } else {
                Installer.renderView('database')
                Installer.updateWizard('database')
                Installer.$form.append('<input type="hidden" name="requirement" value="success">')
            }
        })
    },

    installFoundation: function () {
        Installer.$form.append('<input type="hidden" name="db" value="success">')

        var success = true,
            requestChain = [],
            failMessages = [],
            proceedUrl = null,
            $checkMessage = $(Installer.options.progressBox).find('.message')

        $checkMessage.text('Installing application...')

        $.each(Installer.Steps.install.steps, function (index, step) {
            var timeout = 500

            requestChain.push(function () {
                var deferred = $.Deferred()

                Installer.sendRequest('onInstallDependencies', {
                    step: index,
                    disableLog: true
                }, step.msg).done(function (json) {
                    setTimeout(function () {
                        if (json.result) {
                            if (index === "install") proceedUrl = json.result
                            deferred.resolve()
                        }
                        else {
                            success = false
                            failMessages.push(step.error)
                            deferred.resolve()
                        }
                        deferred.resolve()
                    }, timeout)
                }).fail(function () {
                    setTimeout(function () {
                        success = false
                        deferred.resolve()
                    }, timeout)
                })

                return deferred
            })
        })

        $.waterfall.apply(this, requestChain).always(function () {
        }).done(function () {
            if (!success) {
                Installer.refreshProgress("danger", failMessages.join('<br> '))
            } else {
                Installer.$page.find('[data-wizard="database"]').addClass('complete')
                Installer.hideProgress()
                Installer.renderView('proceed', {proceedUrl: proceedUrl, frontUrl: '/'})
            }
        })
    },

    renderView: function (name, data) {
        var pageData = Installer.Steps[name],
            view = pageData.view

        if (!pageData)
            pageData = {}

        if (pageData.title) {
            Installer.$page.find("[data-html=\"title\"]").html(pageData.title)
        }

        if (pageData.subTitle) {
            Installer.$page.find("[data-html=\"subTitle\"]").html(pageData.subTitle)
        }

        if (name) {
            var viewHtml = Mustache.render($(view).html(), $.extend(pageData, data, {}))
            Installer.$page.find('[data-html="content"]').html(viewHtml)
        }
    },

    flashMessage: function (type, message) {
        if (!message)
            return

        var $flashMessage = $(Installer.options.flashMessageSelector),
            $alert = $('<div />', {
                class: 'animated bounceIn alert alert-' + type
            })

        $flashMessage.addClass('show')
        $alert.append('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>')
        $alert.append(message)
        $flashMessage.append($alert)

        if (type !== 'danger')
            $alert.delay(5000).fadeOut(400, function () {
                $(this).remove()
            })
    },

    processResponse: function (json) {
        var flashMessage = json.flash,
            nextStep = json.step

        if (flashMessage) {
            Installer.hideProgress()
            Installer.flashMessage(flashMessage.type, flashMessage.message)
        }

        switch (nextStep) {
            case 'database':
                Installer.hideProgress()
                Installer.renderView(nextStep)
                break
            case 'settings':
                Installer.hideProgress()
                Installer.renderView(nextStep)
                Installer.updateWizard(nextStep)
                break
            case 'install':
                Installer.hideProgress()
                Installer.renderView(nextStep)
                Installer.updateWizard(nextStep)
                setTimeout(Installer.installFoundation(), 500)
                break
            case 'proceed':
                Installer.hideProgress()
                Installer.renderView(nextStep)
                break
        }
    },

    TEMPLATES: {
        progressBar: [
            '<div id="progressBar"><div class="progress-box">',
            '<p class="message"></p><div class="progress">',
            '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>',
            '</div></div></div>'
        ].join('')
    }
}
