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
        requirement: {handler: "onCheckRequirement"},
        database: {handler: "onCheckDatabase"},
        settings: {handler: "onValidateSettings"},
        install: {
            dataCache: {},
            handler: "onInstall",
            steps: {
                download: {
                    msg: "Downloading {{name}} {{type}}...",
                    error: "Downloading {{name}} {{type}} failed. See setup log."
                },
                extract: {
                    msg: "Extracting {{name}} {{type}}...",
                    error: "Extracting {{name}} {{type}} failed. See setup log."
                },
                install: {
                    msg: "Finishing site setup...",
                    error: "Finishing site setup failed. See setup log."
                }
                // steps: {
                //     // getMeta: {msg: "Fetching extension meta information...", completed: false},
                //     download: {msg: "Downloading %s extension...", completed: false},
                //     extract: {msg: "Extracting %s extension...", completed: false},
                //     install: {msg: "Installing %s extension...", completed: false},
                //     finish: {msg: "Completing installation...", completed: false},
                // },
            }
        },
        proceed: {proceedUrl: '/admin/settings', frontUrl: '/'},
        success: {}
    },

    init: function () {
        Installer.$page = $(Installer.options.page)
        Installer.$pageContent = Installer.$page.find('[data-html="content"]')
        Installer.$progressBox = $(Installer.options.progressBox)
        Installer.currentStep = $(Installer.options.currentStepSelector).val()

        // render
        Installer.renderView(Installer.currentStep)
        Installer.updateWizard(Installer.currentStep)

        $(document).ready(function () {
            Installer.$form = $(Installer.options.form)

            Installer.$submitBtn = $(Installer.options.submitButton)
            Installer.$form.submit(Installer.submitForm)
            Installer.$page.on('click', '[data-install-control]', Installer.onControlClick)

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

    onControlClick: function (event) {
        var $button = $(event.currentTarget),
            control = $button.data('installControl')

        switch (control) {
            case 'retry-check':
                Installer.checkRetry()
                break
            case 'accept-license':
                Installer.sendRequest('onCheckLicense', {}).done(function (json) {
                    Installer.processResponse(json)
                })
                break
            case 'fetch-theme':
                Installer.fetchThemes()
                break
            case 'install-core':
            case 'install-theme':
                Installer.processInstall($button)
                break
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
            licenseTemplate = $('[data-view="license"]').html(),
            requestHandler = Installer.Steps.requirement.handler,
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

                Installer.sendRequest(requestHandler, {
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
                Installer.$form.append('<input type="hidden" name="requirement" value="complete">')
                Installer.$pageContent.append(Mustache.render(licenseTemplate))
            }
        })
    },

    installFoundation: function (steps) {
        var success = true,
            requestChain = [],
            failMessages = [],
            proceedUrl = null,
            $progressMessage = Installer.$pageContent.find('.install-progress .message')

        $progressMessage.text('Installing application...')

        $.each(steps, function (index, stepItems) {

            var step = Installer.Steps.install.steps[index]

            $.each(stepItems, function (itemIndex, item) {
                var timeout = 500

                console.log(item)
                requestChain.push(function () {
                    var postData,
                        deferred = $.Deferred(),
                        beforeSendMessage = Mustache.render(step.msg, item)

                    postData = {
                        process: item.process,
                        disableLog: true,
                        item: item
                    }

                    $progressMessage.text(beforeSendMessage)

                    Installer.sendRequest('onInstall', postData, beforeSendMessage)
                        .done(function (json) {
                            setTimeout(function () {
                                if (json.result) {
                                    if (index === "install") proceedUrl = json.result
                                    deferred.resolve()
                                }
                                else {
                                    success = false
                                    var errorMessage = Mustache.render(step.error, item)
                                    $progressMessage.text(errorMessage)
                                    failMessages.push(errorMessage)
                                    deferred.resolve()
                                }
                                deferred.resolve()
                            }, timeout)
                        })
                        .fail(function () {
                            setTimeout(function () {
                                success = false
                                deferred.resolve()
                            }, timeout)
                        })

                    return deferred
                })
            })
        })


        $.waterfall.apply(this, requestChain).always(function () {
        }).done(function () {
            if (!success) {
                Installer.refreshProgress("danger", failMessages.join('<br> '))
            } else {
                Installer.hideProgress()
                Installer.renderView('proceed', {proceedUrl: proceedUrl, frontUrl: '/'})
                Installer.updateWizard('proceed')
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
            Installer.$pageContent.html(viewHtml)
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
                Installer.updateWizard(nextStep)
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
                // setTimeout(Installer.installFoundation(), 500)
                break
        }
    },

    fetchThemes: function () {
        var $container = Installer.$pageContent.find('[data-html="install-type"]'),
            $themeView = $('[data-view="themes"]'),
            themesTemplate = $themeView.html()

        $container.html(Mustache.render(themesTemplate))
        Installer.$pageContent.find('.install-progress').removeClass('hide')

        Installer.sendRequest('onFetchItems', {})
            .done(function (json) {
                Installer.buildThemesList(json.data)
                // Installer.watchCheckboxes()
                // Installer.renderView('themes', json)
                // Installer.processResponse(json)
            })
            .fail(function () {
                $container.empty()
            })
            .always(function () {
                Installer.$pageContent.find('.install-progress').addClass('hide')
                Installer.hideProgress()
            })
    },

    buildThemesList: function (results) {
        var $themesContainer = Installer.$pageContent.find('[data-html="themes"]'),
            $themeTemplate = $('[data-view="theme"]'),
            dataCache = []

        $themesContainer.removeClass('hide')
        Installer.$pageContent.find('.install-progress').addClass('hide')

        for (var key in results) {
            var item = results[key], html

            html = Mustache.render($themeTemplate.clone().html(), item)
            $themesContainer.append(html)

            dataCache[item.code] = item
        }

        Installer.Steps.install.dataCache = dataCache
    },

    processInstall: function ($btn) {
        var _themeData,
            themeCode = $btn.data('themeCode'),
            themeData = Installer.Steps.install.dataCache[themeCode]

        _themeData = $.extend(themeData, {process: 'apply', disableLog: true})

        $btn.attr('disabled', true)

        Installer.sendRequest('onInstall', _themeData).done(function (json) {
            Installer.$pageContent.find('[data-html="themes"]').addClass('hide')
            Installer.$pageContent.find('[data-html="install-type"]').addClass('hide')
            Installer.$pageContent.find('.panel-carte').addClass('hide')
            Installer.$pageContent.find('.install-progress').removeClass('hide')
            Installer.installFoundation(json.result)
            Installer.updateWizard('install')
        }).fail(function () {
            $btn.attr('disabled', false)
        })
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
