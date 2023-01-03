/*
 * Media manager control class
 */
+function ($) {
    "use strict";

    if ($.ti === undefined) $.ti = {}

    if ($.ti.mediaManager === undefined)
        $.ti.mediaManager = {}

    var MediaManager = function (element, options) {
        this.$el = $(element)
        this.$form = this.$el.closest('form')

        this.options = options

        this.$mediaListElement = null
        this.dialogElement = null
        this.dropzone = null

        this.init()
    }

    MediaManager.prototype.constructor = MediaManager

    MediaManager.prototype.dispose = function () {
        this.unregisterHandlers()
        this.clearSelectTimer()
        this.destroySelectonic()
        this.clearSearchTrackInputTimer()
        this.destroyUploader()

        this.$el = null
        this.$form = null
        this.$mediaListElement = null
        this.navigationAjax = null
        this.$folderTreeElement = null;
    }

    MediaManager.prototype.init = function () {
        this.$mediaListElement = this.$el.find('[data-control="media-list"]')

        this.registerHandlers()

        this.initScroll()
        this.initUploader()
        this.initSelectonic()
        this.initFolderTree()
    }

    MediaManager.prototype.registerHandlers = function () {
        this.$el.on('dblclick', '[data-control="media-list"]', $.proxy(this.onChoose, this))
        this.$el.on('click', '[data-control="media-choose"]', $.proxy(this.onChoose, this))
        this.$el.on('click', '[data-media-control]', $.proxy(this.onControlClick, this))

        this.$el.on('click', '[data-media-sort]', $.proxy(this.onSortingChanged, this))
        this.$el.on('click', '[data-media-filter]', $.proxy(this.onFilterChanged, this))
        this.$el.on('keyup', '[data-media-control="search"]', $.proxy(this.onSearchChanged, this))

        $(window).bind("load resize", $.proxy(this.initScroll, this));
    }

    MediaManager.prototype.unregisterHandlers = function () {

    }

    MediaManager.prototype.initScroll = function () {
        if (!this.$el)
            return;

        var windowHeight = window.innerHeight,
            listTopOffset = this.$el.find('[data-control="media-list"]').get(0).offsetTop,
            statusbarHeight = this.$el.find('[data-control="media-statusbar"]').outerHeight() || 0,
            modalHeaderHeight = this.$el.closest('.modal').find('.modal-header').outerHeight() || 0

        var listHeight = Math.max(0, windowHeight-listTopOffset-parseInt(modalHeaderHeight)-parseInt(statusbarHeight))

        if (listHeight < 1)
            return

        $('.media-list-container', this.$mediaListElement)
            .css('height', listHeight)
            .css('overflow-y', 'scroll')
    }

    //
    // Selecting

    MediaManager.prototype.clearSelectTimer = function () {
        if (this.selectTimer === null)
            return

        clearTimeout(this.selectTimer)
        this.selectTimer = null
    }

    MediaManager.prototype.initSelectonic = function () {
        var self = this

        if (!this.$mediaListElement)
            return

        var selectonicOptions = {
            multi: self.options.selectMode == 'multi',
            listClass: 'selectable',
            selectedClass: 'selected',
            focusClass: 'focused',
            disabledClass: 'disabled',
            keyboard: true,
            select: function (event, ui) {
                self.toggleSelection(event, ui)
            },
            unselect: function (event, ui) {
                self.toggleSelection(event, ui)
            },
            unselectAll: function (event, ui) {
                self.toggleSelection(event, ui)
            },
            stop: function (event, ui) {
                if (ui.target)
                    self.updateStatusBar()
            },
        }

        this.$mediaListElement.find('.media-list').selectonic(selectonicOptions)
    }

    MediaManager.prototype.scrollToTop = function () {
        this.$mediaListElement.animate({scrollTop: 0}, "fast");
    }

    MediaManager.prototype.selectMarkedItem = function () {
        if (!this.$mediaListElement)
            return;

        this.selectItem('[data-media-item-marked]')
    }

    MediaManager.prototype.selectFirstItem = function () {
        if (!this.$mediaListElement)
            return;

        this.selectItem('[data-media-item]:eq(0)')
    }

    MediaManager.prototype.selectItem = function (selector) {
        var $mediaList = $('.media-list', this.$mediaListElement),
            $itemElement = $(selector, $mediaList).closest('.media-item'),
            indexPosition = $mediaList.children().index($itemElement)

        if (!$itemElement.length || indexPosition < 0)
            return;

        $mediaList.selectonic('unselect')
            .selectonic('select', indexPosition)
            .selectonic('focus', indexPosition)

        var currentScroll = $itemElement.scrollTop()
        $mediaList.animate({
            scrollTop: currentScroll+$itemElement.position().top-30
        }, 0)
    }

    MediaManager.prototype.getSelectedItems = function () {
        return this.$mediaListElement.find('.media-list').selectonic('getSelected')
    }

    MediaManager.prototype.toggleSelection = function (event, selection) {
        if (!selection.items)
            return;

        var items = this.getSelectedItems()

        if (this.isPreviewSidebarVisible()) {
            this.selectTimer = setTimeout($.proxy(this.updateSidebar(items)), 100)
        }
    }

    MediaManager.prototype.cancelSelection = function () {
        if (!this.$mediaListElement)
            return

        this.$mediaListElement.find('.media-list').selectonic('unselect')
    }

    MediaManager.prototype.destroySelectonic = function () {
        if (!this.$mediaListElement)
            return

        this.$mediaListElement.find('.media-list').selectonic('destroy')
    }

    //
    // Navigation

    MediaManager.prototype.goToFolder = function (path, resetSearch) {
        var data = {
            path: path,
            resetSearch: resetSearch !== undefined ? 1 : 0
        }

        this.execNavigationRequest('onGoToFolder', data)
    }

    MediaManager.prototype.afterNavigate = function () {
        this.initScroll()
        this.initUploader()
        this.initSelectonic()
        this.initFolderTree()
        this.selectFirstItem()
        this.scrollToTop()
    }

    MediaManager.prototype.refresh = function () {
        var data = {
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        this.execNavigationRequest('onGoToFolder', data)
    }

    MediaManager.prototype.execNavigationRequest = function (handler, data, element) {
        if (element === undefined)
            element = this.$form

        if (this.navigationAjax !== null) {
            try {
                this.navigationAjax.abort()
            } catch (e) {
            }
            this.releaseNavigationAjax()
        }

        $.ti.loadingIndicator.show()
        this.navigationAjax = element.request(this.options.alias+'::'+handler, {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
            .always($.proxy(this.releaseNavigationAjax, this))
    }

    MediaManager.prototype.releaseNavigationAjax = function () {
        this.navigationAjax = null
    }

    //
    // Sidebar

    MediaManager.prototype.isPreviewSidebarVisible = function () {
        return !this.$el.find('[data-media-preview-container]').hasClass('hide')
    }

    MediaManager.prototype.updateSidebar = function (items) {
        var container = this.$el[0],
            previewContainer = container.querySelector('[data-media-preview-container]'),
            template, previewTemplate

        // Single selection
        if (items.length == 1) {
            var item = items[0].querySelector('[data-media-item]'),
                previewSelector = '[data-media-file-selection-template]',
                itemFileType = item.getAttribute('data-media-item-file-type')

            if (itemFileType === 'video')
                previewSelector = '[data-media-video-selection-template]'

            if (itemFileType === 'audio')
                previewSelector = '[data-media-audio-selection-template]'

            if (itemFileType === 'image')
                previewSelector = '[data-media-image-selection-template]'

            previewTemplate = container.querySelector(previewSelector).innerHTML
                .replace('{fileType}', itemFileType)
                .replace('{src}', item.getAttribute('data-media-item-url'))
                .replace('{url}', item.getAttribute('data-media-item-url'))

            template = container.querySelector('[data-media-single-selection-template]').innerHTML
            previewContainer.innerHTML = template
                .replace('{name}', item.getAttribute('data-media-item-name'))
                .replace('{size}', item.getAttribute('data-media-item-size'))
                .replace('{dimension}', item.getAttribute('data-media-item-dimension'))
                .replace('{src}', item.getAttribute('data-media-item-url'))
                .replace('{url}', item.getAttribute('data-media-item-url'))
                .replace('{path}', item.getAttribute('data-media-item-path'))
                .replace('{modified}', item.getAttribute('data-media-item-modified'))
                .replace('<div data-media-preview-placeholder></div>', previewTemplate)
        }
        // No selection
        else if (items.length == 0) {
            template = container.querySelector('[data-media-no-selection-template]').innerHTML
            previewContainer.innerHTML = template
        }
        // Multiple selection
        else {
            template = container.querySelector('[data-media-multi-selection-template]').innerHTML
            previewContainer.innerHTML = template
        }
    }

    MediaManager.prototype.updateStatusBar = function () {
        if (!this.$mediaListElement)
            return

        var totalSelected = this.getSelectedItems().length;
        $('[data-media-total-size]').html(totalSelected);
    }

    //
    // Uploader

    MediaManager.prototype.initUploader = function () {
        var $uploader = $('[data-control="media-upload"]', this.$mediaListElement)
        if (!$uploader.length || this.dropzone)
            return

        var dropzoneOptions = {
            url: this.options.url,
            headers: {},
            paramName: 'file_data',
            addRemoveLinks: true,
            maxFilesize: this.options.maxUploadSize, // MB
            clickable: this.$el.find('[data-media-control="upload"]').get(0),
            dictInvalidFileType: this.options.extensionNotAllowed,
            dictFileTooBig: 'The uploaded file exceeds the max size allowed.',
            accept: $.proxy(this.checkUploadAllowedType, this),
        }

        if (this.options.uniqueId) {
            dropzoneOptions.headers['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content')
            dropzoneOptions.headers['X-IGNITER-FILEUPLOAD'] = this.options.uniqueId
        }

        Dropzone.autoDiscover = false
        this.dropzone = new Dropzone($uploader.get(0), dropzoneOptions);
        this.dropzone.on('addedfile', $.proxy(this.uploadFileAdded, this))
        this.dropzone.on('error', $.proxy(this.uploadError, this))
        this.dropzone.on('sending', $.proxy(this.uploadSending, this))
        this.dropzone.on('queuecomplete', $.proxy(this.uploadQueueComplete, this))
    }

    MediaManager.prototype.showUploadZone = function () {
        this.$el.find('[data-control="media-upload"]').slideDown();
    }

    MediaManager.prototype.hideUploadZone = function () {
        this.$el.find('[data-control="media-upload"]').slideUp();
    }

    MediaManager.prototype.checkUploadAllowedType = function (file, done) {
        var fileExt = file.name.split('.').pop().toLowerCase();

        done($.inArray(fileExt, this.options.allowedExtensions) == -1 ? this.options.extensionNotAllowed : null);
    }

    MediaManager.prototype.destroyUploader = function () {
        if (!this.dropzone)
            return

        this.dropzone.destroy()
        this.dropzone = null
    }

    MediaManager.prototype.uploadFileAdded = function () {
        this.showUploadZone()
    }

    MediaManager.prototype.uploadSending = function (file, xhr, formData) {
        formData.append('path', this.$el.find('[data-media-type="current-folder"]').val())
    }

    MediaManager.prototype.uploadError = function (file, message, xhr) {
        $.ti.flashMessage({class: 'danger', text: message});
    }

    MediaManager.prototype.uploadQueueComplete = function () {
        var status = false;

        $.each(this.dropzone.getAcceptedFiles(), function () {
            if (this.status === 'success')
                status = true
        })

        if (status) this.refresh()
    }

    //
    // Dialog

    MediaManager.prototype.showDialog = function (options) {

        Swal.fire($.extend({}, MediaManager.DIALOG_DEFAULTS, options));

        // $(this.dialogElement).one('shown.bs.modal', function () {
        //     $(this).find('input, select').focus()
        // })
    }

    //
    // Folder Tree

    MediaManager.prototype.initFolderTree = function () {
        this.$folderTreeElement = this.$el.find('[data-control="folder-tree"]')
        var $folderTreeDropdown = this.$el.find('[data-control="folder-tree-dropdown"]'),
            $folderTree = this.$folderTreeElement.find('.folder-tree')

        $folderTreeDropdown.find('[data-bs-toggle="dropdown"]').dropdown('hide')

        var treeOptions = {
            data: $folderTree[0].getAttribute('data-tree-data'),
            expandIcon: 'fa fa-plus',
            collapseIcon: 'fa fa-minus',
            nodeIcon: 'fa fa-folder',
            selectedIcon: 'fa folder-open',
        }

        $folderTree.treeview(treeOptions)
        $folderTree.on('nodeSelected', $.proxy(this.onTreeNodeSelected, this))

        $folderTreeDropdown.on('show.bs.dropdown', $.proxy(this.onShowFolderTree, this));
        $folderTreeDropdown.on('hide.bs.dropdown', $.proxy(this.onHideFolderTree, this));
    }

    //
    // File and folder operations

    MediaManager.prototype.createFolder = function (event) {
        this.showDialog({
            input: 'text',
            title: $(event.currentTarget).data('swal-title'),
            preConfirm: $.proxy(this.onCreateFolderSubmit, this)
        })
    }

    MediaManager.prototype.renameFolder = function (event) {
        if (this.$el.find('[data-media-type="current-folder"]').val() === '/') {
            $.ti.flashMessage({text: this.options.renameDisabled, class: 'warning'});
            return;
        }

        this.showDialog({
            input: 'text',
            title: $(event.currentTarget).data('swal-title'),
            preConfirm: $.proxy(this.onRenameFolderSubmit, this)
        })
    }

    MediaManager.prototype.deleteFolder = function (event) {
        if (this.$el.find('[data-media-type="current-folder"]').val() === '/') {
            $.ti.flashMessage({text: this.options.deleteDisabled, class: 'warning'});
            return;
        }

        this.showDialog({
            text: $(event.currentTarget).data('swal-confirm'),
            icon: 'warning',
            customClass: {
                confirmButton: "btn-danger",
            },
            preConfirm: $.proxy(this.onDeleteFolderSubmit, this)
        })
    }

    MediaManager.prototype.renameItem = function (event) {
        var items = this.getSelectedItems()
        if (items.length > 1) {
            $.ti.flashMessage({text: this.options.selectSingleImage, class: 'danger'});
            return
        }

        this.showDialog({
            input: 'text',
            title: $(event.currentTarget).data('swal-title'),
            preConfirm: $.proxy(this.onRenameFileSubmit, this)
        })
    }

    MediaManager.prototype.moveItems = function (event) {
        var items = this.getSelectedItems()
        if (!items.length) {
            $.ti.flashMessage({text: this.options.moveEmpty, class: 'danger'});
            return
        }

        this.showDialog({
            input: 'select',
            inputOptions: JSON.parse(this.$folderTreeElement.find('.folder-tree')[0].getAttribute('data-folders')),
            title: $(event.currentTarget).data('swal-title'),
            preConfirm: $.proxy(this.onMoveFilesSubmit, this)
        })
    }

    MediaManager.prototype.copyItems = function (event) {
        var items = this.getSelectedItems()
        if (!items.length) {
            $.ti.flashMessage({text: this.options.copyEmpty, class: 'danger'});
            return
        }

        this.showDialog({
            input: 'select',
            inputOptions: JSON.parse(this.$folderTreeElement.find('.folder-tree')[0].getAttribute('data-folders')),
            title: $(event.currentTarget).data('swal-title'),
            preConfirm: $.proxy(this.onCopyFilesSubmit, this)
        })
    }

    MediaManager.prototype.deleteItems = function (event) {
        var items = this.getSelectedItems()
        if (!items.length) {
            $.ti.flashMessage({text: this.options.deleteEmpty, class: 'danger'});
            return
        }

        this.showDialog({
            text: $(event.currentTarget).data('swal-confirm'),
            icon: 'warning',
            customClass: {
                confirmButton: "btn-danger",
            },
            preConfirm: $.proxy(this.onDeleteFilesSubmit, this)
        })
    }

    MediaManager.prototype.clearSearchTrackInputTimer = function () {
        if (this.searchTrackInputTimer === null)
            return

        clearTimeout(this.searchTrackInputTimer)
        this.searchTrackInputTimer = null
    }

    // EVENT HANDLERS
    // ============================

    MediaManager.prototype.onDialogApply = function () {
        $(this).find('form').trigger('submit.dialog')
    }

    MediaManager.prototype.onShowFolderTree = function (event) {
        var $el = $(event.currentTarget);
        $el.find('.list-group').addClass('list-group-flush')
    }

    MediaManager.prototype.onHideFolderTree = function (event) {
        if (event.clickEvent !== undefined) {
            var $el = $(event.clickEvent.target);
            if ($el.hasClass("list-group-item") || $el.parents(".list-group-item").length) {
                return false;
            }
        }
    }

    MediaManager.prototype.onTreeNodeSelected = function (event, data) {
        if (data.path)
            this.goToFolder(data.path);
    }

    MediaManager.prototype.onChoose = function (event) {
        this.$el.trigger('insert.media.ti.mediamanager')
    }

    MediaManager.prototype.onControlClick = function (event) {
        var control = $(event.currentTarget).data('media-control')

        switch (control) {
            case 'refresh':
                this.refresh()
                break;
            case 'cancel-selection':
                this.cancelSelection()
                break;
            case 'close-uploader':
                this.hideUploadZone()
                break;
            case 'new-folder':
                this.createFolder(event)
                break;
            case 'rename-folder':
                this.renameFolder(event)
                break;
            case 'delete-folder':
                this.deleteFolder(event)
                break;
            case 'rename-item':
                this.renameItem(event)
                break;
            case 'move-item':
                this.moveItems(event)
                break;
            case 'copy-item':
                this.copyItems(event)
                break;
            case 'delete-item':
                this.deleteItems(event)
                break;
        }
    }

    MediaManager.prototype.onSortingChanged = function (event) {
        var data = {
            sortBy: $(event.target).data('mediaSort'),
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        this.execNavigationRequest('onSetSorting', data)
    }

    MediaManager.prototype.onFilterChanged = function (event) {
        this.execNavigationRequest('onSetFilter', {
            filterBy: $(event.target).data('mediaFilter')
        })
    }

    MediaManager.prototype.onSearchChanged = function (event) {
        var self = this,
            data = {
                search: event.currentTarget.value,
            }

        self.clearSearchTrackInputTimer()

        self.searchTrackInputTimer = window.setTimeout(function () {
            self.execNavigationRequest('onSearch', data)
        }, 500)
    }

    MediaManager.prototype.onCreateFolderSubmit = function (name) {
        var data = {
            name: name,
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onCreateFolder', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    MediaManager.prototype.onRenameFolderSubmit = function (name) {
        var data = {
            name: name,
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onRenameFolder', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    MediaManager.prototype.onDeleteFolderSubmit = function (event) {
        var data = {
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onDeleteFolder', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    MediaManager.prototype.onRenameFileSubmit = function (name) {
        var items = this.getSelectedItems(),
            item = items[0].querySelector('[data-media-item]')

        var data = {
            file: item.getAttribute('data-media-item-name'),
            name: name,
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onRenameFile', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    MediaManager.prototype.onMoveFilesSubmit = function (selected) {
        var items = this.getSelectedItems(),
            files = []

        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i].querySelector('[data-media-item]')
            files.push({
                'path': item.getAttribute('data-media-item-name'),
                'type': item.getAttribute('data-media-item-type')
            })
        }

        var data = {
            files: files,
            destination: selected,
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onMoveFiles', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    MediaManager.prototype.onCopyFilesSubmit = function (selected) {
        var items = this.getSelectedItems(),
            files = []

        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i].querySelector('[data-media-item]')
            files.push({
                'path': item.getAttribute('data-media-item-name'),
                'type': item.getAttribute('data-media-item-type')
            })
        }

        var data = {
            files: files,
            destination: selected,
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onCopyFiles', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    MediaManager.prototype.onDeleteFilesSubmit = function (event) {
        var items = this.getSelectedItems(),
            files = []

        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i].querySelector('[data-media-item]')
            files.push({
                'path': item.getAttribute('data-media-item-name'),
                'type': item.getAttribute('data-media-item-type')
            })
        }

        var data = {
            files: files,
            path: this.$el.find('[data-media-type="current-folder"]').val()
        }

        $.ti.loadingIndicator.show()
        return this.$form.request(this.options.alias+'::onDeleteFiles', {
            data: data
        }).always(function () {
            $.ti.loadingIndicator.hide()
        }).done($.proxy(this.afterNavigate, this))
    }

    // MEDIA MANAGER PLUGIN DEFINITION
    // ============================

    MediaManager.DIALOG_DEFAULTS = {
        title: '',
        confirmButtonText: 'Apply',
        cancelButtonText: 'Cancel',
        showCancelButton: true,
        showLoaderOnConfirm: true,
        customClass: {
            confirmButton: "btn-primary",
            cancelButton: "btn-default",
        },
    }

    MediaManager.DEFAULTS = {
        url: window.location,
        alias: '',
        selectMode: 'multi',
        chooseButton: false,
        chooseButtonText: 'Choose',
        uniqueId: null,
        maxUploadSize: 0,
        allowedExtensions: [],
        renameDisabled: 'Folder can not be renamed.',
        moveDisabled: 'Folder can not be moved.',
        deleteDisabled: 'Folder can not be deleted.',
        deleteConfirm: 'Delete the selected folder/file(s)?',
        moveEmpty: 'Please select files to move.',
        copyEmpty: 'Please select files to copy.',
        deleteEmpty: 'Please select files to delete.',
        selectSingleImage: 'Please select a single image.',
        selectionNotImage: 'The selected item is not an image.',
        extensionNotAllowed: 'File extension is not allowed.',
    }

    var old = $.fn.mediaManager

    $.fn.mediaManager = function (option) {
        var args = Array.prototype.slice.call(arguments, 1),
            result = undefined

        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.mediaManager')
            var options = $.extend({}, MediaManager.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.mediaManager', (data = new MediaManager(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.mediaManager.Constructor = MediaManager

    // MEDIA MANAGER NO CONFLICT
    // =================

    $.fn.mediaManager.noConflict = function () {
        $.fn.mediaManager = old
        return this
    }

    // MEDIA MANAGER DATA-API
    // ===============

    Dropzone.autoDiscover = false;

    $(document).render(function () {
        $('div[data-control=media-manager]').mediaManager()
    })
}(window.jQuery);
