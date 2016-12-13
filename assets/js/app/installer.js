var Installer = {

    currentStep: null,
    installProgress: 5,

    installSteps: {
        downloadComposer: {msg: 'Downloading composer...', completed: false},
        extractComposer: {msg: 'Extracting composer...', completed: false},
        installComposer: {msg: 'Installing composer dependencies (this might take a while) ... <i class="fa fa-smile-o"></i>', completed: false},
        getExtensionMeta: {msg: 'Fetching extension meta information...', completed: false},
        downloadExtension: {msg: 'Downloading %s extension...', completed: false},
        extractExtension: {msg: 'Extracting %s extension...', completed: false},
        installExtension: {msg: 'Installing %s extension...', completed: false},
        finish: {msg: 'Completing installation...', completed: false},
    },

    options: {
        listSelector: '#extensions-list',
        checkboxSelector: '#extensions-list .extension',
        completeForm: '#completeForm',
        submitButton: '#btn-continue',
    },
    dataCache: {
        completedSteps: [],
        metas: [],
        extensions: [] // extensions to install
    },

    init: function () {
        this.form = $('#completeForm');
        this.list = $('#extensions-list');
        this.checkbox = $('#extensions-list .extension');
        this.submitBtn = $('#btn-continue');
        this.currentStep = this.form.find('input[name="install_step"]').val();

        this.form.submit(this.submitForm);
    },

    submitForm: function (e) {
        e.preventDefault();
        Installer.disableSubmitButton(true);
        Installer.processForm();
    },

    watchCheckboxes: function () {
        var checkBoxes = $(Installer.checkbox);

        if (!checkBoxes.length) Installer.disableSubmitButton(false);
        checkBoxes.change(function () {
            var disabled = checkBoxes.filter(':not(:checked)').length >= 1;
            Installer.disableSubmitButton(disabled);
        });

        checkBoxes.trigger('change');
    },

    disableSubmitButton: function (disabled) {
        var submitButton = $(Installer.submitBtn);
        submitButton.prop('disabled', disabled);
        if (disabled) {
            submitButton.addClass('disabled');
        } else {
            submitButton.removeClass('disabled');
        }
    },

    refreshProgress: function (message, type) {
        var progressBox = $('.progress-box'),
            progressCount = Installer.installProgress,
            progressBar = progressBox.find('.progress-bar'),
            progressMessage = progressBox.find('.message');

        progressMessage.html(message);
        progressBar.attr('aria-valuenow', progressCount).width(progressCount + '%');

        if (type != null) {
            progressBar.addClass('progress-bar-' + type);
            progressMessage.addClass('text-' + type);
        }

        progressBox.fadeIn();
    },

    processForm: function () {
        var completeForm = Installer.form;
        completeForm.fadeOut();
        if (completeForm.length) {
            var progressMessage = Installer.getAlert(Installer.currentStep);
            var jqXhr = Installer.sendRequest('install', {}, progressMessage);
            Installer.processResponse(jqXhr, 0);
        }
    },

    processRequest: function (iterate) {
        var currStep = Installer.currentStep;
        if (iterate) {
            var startIndex = 0;
            Installer.sendMetaRequest(startIndex);
        } else {
            var progressMessage = Installer.getAlert(currStep);
            Installer.form.find('input[name=install_step]').val(currStep);
            var jqXhr = Installer.sendRequest('install', {}, progressMessage);
            Installer.processResponse(jqXhr, 0);
        }
    },

    sendMetaRequest: function (startIndex) {
        var currStep = Installer.currentStep;
        if (startIndex < Installer.dataCache.metas.length) {
            var extensionMeta = Installer.dataCache.metas[startIndex];
            if (extensionMeta.hasOwnProperty('hash')) {
                var progressMessage = Installer.getAlert(currStep);
                var replaceStr = extensionMeta.name.toLowerCase() + ' extension';
                Installer.form.find('input[name=install_step]').val(currStep);
                var jqXhr = Installer.sendRequest('install', extensionMeta, progressMessage.replace('%s', replaceStr));
                Installer.processResponse(jqXhr, startIndex);
            }
        }
    },

    sendRequest: function (method, data, message) {
        console.log('sendRequest:'+ message);
        return $.ajax({
            type: 'POST',
            url: js_site_url(method),
            data: Installer.form.serialize() + (typeof data == 'undefined' ? '' : '&'+$.param(data)),
            beforeSend: message ? Installer.refreshProgress(message) : null,
            dataType: 'json'
        })
    },

    proceed: function () {
        Installer.currentStep = Installer.nextStep();
        if (!Installer.installSteps[Installer.currentStep].completed) {
            Installer.installSteps[Installer.currentStep].completed = true;
            switch (Installer.currentStep) {
                case 'downloadExtension':
                case 'extractExtension':
                case 'installExtension':
                    Installer.processRequest(true);
                    break;
                case 'downloadComposer':
                case 'extractComposer':
                case 'installComposer':
                case 'getExtensionMeta':
                case 'finish':
                    Installer.processRequest(false);
                    break;
            }
        }
    },

    getAlert: function (step) {
        if (Installer.installSteps.hasOwnProperty(step))
            return Installer.installSteps[step].msg;
    },

    nextStep: function () {
        switch (Installer.currentStep) {
            case 'getExtensionMeta':
                return 'downloadExtension';
            case 'downloadComposer':
                return 'extractComposer';
            case 'extractComposer':
                return 'installComposer';
            case 'installComposer':
                return 'getExtensionMeta';
            case 'downloadExtension':
                return 'extractExtension';
            case 'extractExtension':
                return 'installExtension';
            case 'installExtension':
                return 'finish';
        }
    },

    fetchExtensions: function (extensions) {
        var jqXhr = Installer.sendRequest('fetch', extensions);
        jqXhr.done(function (json) {
            if (json['error']) {
                var obj = $('.loading-box');
                obj.find('.fa').removeClass('fa-spin')
                obj.find('p').addClass('text-danger').html(json['error'])
            }

            if (json['results']) {
                Installer.buildExtensionsList(json['results']);
            }

            Installer.watchCheckboxes();
        });

        jqXhr.fail(function (xhr) {
            console.log(xhr)
            Installer.refreshProgress(xhr.responseText, 'danger');
        });
    },

    processResponse: function(jqXhr, index) {
        var currStep = Installer.currentStep;
        var progressCounter = (100/Object.keys(Installer.installSteps).length).toFixed(0);
        var progress = (parseInt(Installer.installProgress) + parseInt(progressCounter));

        jqXhr.done(function (json) {
            if (json['error']) Installer.refreshProgress(json['error'], 'danger');
            if (json['results']) {
                switch (currStep) {
                    case 'getExtensionMeta':
                        if (json['results'].extensions) {
                            for (var extCode in json['results'].extensions)
                                if (json['results'].extensions.hasOwnProperty(extCode))
                                    Installer.dataCache.metas.push(json['results'].extensions[extCode]);
                            Installer.installProgress = progress;
                            Installer.proceed();
                        } else if (json['results'].hasOwnProperty('core')) {
                            Installer.currentStep = 'installExtension';
                            Installer.proceed();
                        }
                        break;
                    case 'downloadComposer':
                    case 'extractComposer':
                    case 'installComposer':
                        Installer.installProgress = progress;
                        Installer.proceed();
                        break;
                    case 'downloadExtension':
                    case 'extractExtension':
                    case 'installExtension':
                        if (index != null) {
                            var tempIndex = index + 1;
                            var progressCount = (progressCounter / Object.keys(Installer.dataCache.metas).length).toFixed(2);
                            if (tempIndex < Installer.dataCache.metas.length) {
                                Installer.installProgress = parseInt(progressCount) + parseInt(Installer.installProgress);
                                Installer.sendMetaRequest(tempIndex);
                            } else {
                                Installer.installProgress = progress;
                                Installer.proceed();
                            }
                        }
                        break;
                    case 'finish':
                        Installer.installProgress = 100;
                        Installer.refreshProgress(json['results'], 'success');
                        if (json['redirect']) setTimeout(function() {
                            window.location.href = json['redirect'];
                        }, 3000);
                        break;
                }
            }
        }).fail(function (xhr) {
            console.log(xhr);
            Installer.refreshProgress(xhr.responseText, 'danger');
        });
    },

    buildExtensionsList: function (results) {
        var extList = $(Installer.list);
        var html = '<div class="select-box"><div class="row">';
        for (var key in results) {
            var extension = results[key];

            html += '<div class="col-xs-12 col-sm-6">';
            html += '   <div class="panel panel-default">';
            html += '       <div class="panel-heading">';
            if (typeof installedExtensions != 'undefined' && installedExtensions.hasOwnProperty(extension.code)) {
                html += '<div class="pull-right">';
                html += '   <span class="small text-muted">Downloaded</span>';
                html += '</div>';
            } else {
                Installer.dataCache.extensions.push(extension);
                html += '           <div class="checkbox checkbox-primary pull-right">';
                html += '               <input type="checkbox" class="styled extension" id="checkbox-' + extension.code + '" value="' + extension.version + '" name="install_extensions[' + extension.code + ']" checked/>';
                html += '               <label for="checkbox-all"></label>';
                html += '           </div>';
            }
            html += '           <h4 class="panel-title">' + extension.name + '</h4>';
            html += '       </div>';
            html += '       <div class="panel-body small text-muted">' + extension.description.truncate(84) + '</div>';
            html += '   </div>';
            html += '</div>';
        }

        html += '</div></div>';

        $('.loading-box').fadeOut();
        extList.html(html);
        extList.fadeIn();
    }
};

String.prototype.truncate = String.prototype.truncate || function (n) {
        return (this.length > n) ? this.substr(0, n - 1) + '&hellip;' : this;
    };