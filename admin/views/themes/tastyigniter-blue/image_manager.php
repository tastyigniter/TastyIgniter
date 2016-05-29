<?php if ($popup !== 'iframe') { ?>
    <?php echo get_header(); ?>
    <div class="row content">
        <div class="col-md-12">
            <div id="image-manager" style="padding: 3px 0px 0px 0px;">
                <iframe src="<?php echo site_url('image_manager?popup=iframe'); ?>" width="100%" height="550" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    <?php echo get_footer(); ?>
<?php } else { ?>
    <?php echo $this->template->getDocType() ?>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <?php echo $this->template->getMetas() ?>
        <title><?php echo $title ?></title>
        <?php echo $this->template->getStyleTags() ?>
        <?php echo $this->template->getScriptTags() ?>
        <script type="text/javascript">
            var js_site_url = function (str) {
                var strTmp = "<?php echo site_url('" + str + "'); ?>";
                return strTmp;
            };

            var js_base_url = function (str) {
                var strTmp = "<?php echo base_url('" + str + "'); ?>";
                return strTmp;
            };

            var allowed_ext = new Array('<?php echo implode("','", $allowed_ext); ?>');
            var maxSizeUpload = <?php echo round($max_size_upload / 1024, 2); ?>;
        </script>
    </head>
    <body>
    <div class="notification alert alert-info" style="display:none;"><span></span></div>
    <input type="hidden" id="current_url" value="<?php echo $current_url; ?>"/>
    <input type="hidden" id="new_gallery" value="New Folder"/>
    <input type="hidden" id="total_files" value="<?php echo $total_files; ?>"/>
    <input type="hidden" id="total_selected" value=""/>
    <input type="hidden" id="field_id" value="<?php echo $field_id; ?>"/>
    <input type="hidden" id="sub_folder" value="<?php echo $sub_folder; ?>"/>
    <input type="hidden" id="current_folder" value="<?php echo $current_folder; ?>"/>
    <input type="hidden" id="sort_order" value="<?php echo $sort_order; ?>"/>
    <div id="folders_list" style="display:none;">
        <select class="form-control">
            <?php foreach ($folders_list as $key => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select>
        <span class="help-block small"><?php echo lang('help_existing_files'); ?></span>
    </div>

    <nav class="navbar navbar-default navbar-menu" role="navigation">
        <div class="container-fluid navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="btn-toolbar" role="toolbar">
                    <div class="col-xs-12 col-sm-2 wrap-none">
                        <div class="btn-group">
                            <a class="btn btn-default navbar-btn btn-back <?php echo $back; ?>" title="Back" href="<?php echo $back_url; ?>"><i class="fa fa-arrow-left"></i></a>
                            <a id="refresh" title="Refresh" class="btn btn-default navbar-btn btn-refresh" href="<?php echo $refresh_url; ?>"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 wrap-none">
                        <div class="btn-group">
                            <?php if ($uploads) { ?>
                                <button type="button" class="btn btn-default navbar-btn btn-upload"><i class="fa fa-upload"></i>&nbsp;&nbsp;
                                    <small><?php echo lang('button_upload'); ?></small>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-1 wrap-none">
                        <div class="btn-group">
                            <a class="btn btn-default navbar-btn btn-options" title="<?php echo lang('button_option'); ?>" href="<?php echo site_url('settings#image-manager'); ?>" target="_parent"><i class="fa fa-gear"></i></a>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-1 wrap-none">
                        <div class="btn-group">
                            <div class="dropdown">
                                <a class="btn btn-default navbar-btn btn-sort dropdown-toggle" data-toggle="dropdown" title="Sort">
                                    <?php if ($sort_order === 'ascending') { ?>
                                        <i class="fa fa-sort-amount-asc"></i> <i class="caret"></i>
                                    <?php } else { ?>
                                        <i class="fa fa-sort-amount-desc"></i> <i class="caret"></i>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu dropdown-sorter" role="menu">
                                    <li><span><strong><?php echo lang('text_sort_by'); ?>:</strong></span></li>
                                    <li class="divider"></li>
                                    <li>
                                        <a class="sorter" data-sort="name"><?php echo ($sort_by === 'name') ? $sort_icon : ''; ?><?php echo lang('label_name'); ?></a>
                                    </li>
                                    <li>
                                        <a class="sorter" data-sort="date"><?php echo ($sort_by === 'date') ? $sort_icon : ''; ?><?php echo lang('label_date'); ?></a>
                                    </li>
                                    <li>
                                        <a class="sorter" data-sort="size"><?php echo ($sort_by === 'size') ? $sort_icon : ''; ?><?php echo lang('label_size'); ?></a>
                                    </li>
                                    <li>
                                        <a class="sorter" data-sort="extension"><?php echo ($sort_by === 'extension') ? $sort_icon : ''; ?><?php echo lang('label_type'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-4 wrap-none">
                        <div class="btn-group btn-block">
                            <div class="navbar-form input-group">
                                <span id="btn-clear" class="input-group-addon" title="<?php echo lang('text_clear'); ?>"><i id="filter-clear" class="fa fa-times"></i></span>
                                <input type="text" name="filter_search" id="filter-search" class="form-control" value="<?php echo $filter; ?>" placeholder="<?php echo lang('text_filter_search'); ?>"/>
                                <span id="btn-search" class="input-group-addon" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ol class="breadcrumb">
                <li id="folderPopover">
                    <button type="button" class="btn btn-folders" data-container="body" data-placement="bottom" data-toggle="popover">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                </li>
                <?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
                    <?php if ($key == count($breadcrumbs) - 1) { ?>
                        <li class="active"><?php echo $breadcrumb['name']; ?></li>
                    <?php } else { ?>
                        <li><a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['name']; ?></a></li>
                    <?php } ?>
                <?php } ?>
                <li>
                    <?php if ($new_folder) { ?>
                        <a class="btn btn-new-folder" title="<?php echo lang('text_new_folder'); ?>" href="#"><i class="fa fa-folder"></i></a>&nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <?php if ($rename) { ?>
                        <a class="btn btn-rename" title="<?php echo lang('text_rename_folder'); ?>" data-name="<?php echo $current_folder; ?>" data-path="<?php echo $parent_folder; ?>" href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <?php if ($delete) { ?>
                        <a class="btn btn-delete" title="<?php echo lang('text_delete_folder'); ?>" data-name="<?php echo $current_folder; ?>" data-path="<?php echo $parent_folder; ?>" href="#"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                </li>
            </ol>
        </div>
    </nav>

    <div class="media-content container-fluid">
        <div class="row-fluid">
            <div id="notification"></div>

            <?php if ($uploads) { ?>
                <div class="uploader-box">
                    <div class="tabbable upload-tabbable"> <!-- Only required for left/right tabs -->
                        <form role="form" method="POST" enctype="multipart/form-data" id="my-awesome-dropzone" class="dropzone">
                            <input type="hidden" name="sub_folder" value="<?php echo $sub_folder; ?>"/>
                            <div class="fallback">
                                <?php echo lang('button_upload'); ?>:<br/>
                                <input name="file" type="file"/>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <div class="grid-box">
                <?php if (empty($total_files)) { ?>
                    <p class="alert"><?php echo $files_empty; ?></p>
                <?php } else { ?>
                    <div id="selectable" class="col-xs-9 wrap-none">
                        <div class="media-preview row"></div>
                        <div class="media-list row">
                            <?php foreach ($files as $file) { ?>
                                <div class="thumbnail-each col-xs-6 col-sm-4 <?php echo $file['html_class']; ?>">
                                    <figure class="thumbnail" data-type="<?php echo $file['type']; ?>" data-name="<?php echo $file['name']; ?>" data-path="<?php echo $file['path']; ?>">
                                        <a class="link" title="<?php echo $file['size']; ?>">
                                            <div class="img-container">
                                                <?php if ($file['thumb_type'] === 'thumb') { ?>
                                                    <img alt="<?php echo $file['name']; ?>" class="img-responsive thumb" src="<?php echo $file['thumb_url']; ?>"/>
                                                <?php } else if ($file['thumb_type'] === 'icon') { ?>
                                                    <span class=""><?php echo $file['ext']; ?></span>
                                                    <i class="fa fa-file icon"></i>
                                                <?php } ?>
                                            </div>
                                            <figcaption class="caption">
                                                <h4 class="ellipsis">
                                                    <span class=""><?php echo $file['human_name']; ?></span>
                                                </h4>
                                            </figcaption>
                                        </a>
                                        <div class="info">
                                            <div class="btn-group">
                                                <?php if ($file['type'] === 'img') { ?>
                                                    <button type="button" class="btn btn-default btn-preview" title="<?php echo lang('button_preview'); ?>" data-url="<?php echo $file['img_url']; ?>"><i class="fa fa-eye"></i></button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default btn-preview" title="<?php echo lang('button_preview'); ?>" disabled="disabled" data-url="<?php echo $file['img_url']; ?>"><i class="fa fa-eye"></i></button>
                                                <?php } ?>
                                                <?php if ($rename) { ?>
                                                    <button type="button" class="btn btn-default btn-rename" title="<?php echo lang('button_rename'); ?>" data-name="<?php echo $file['name']; ?>" data-path="<?php echo $sub_folder; ?>"><i class="fa fa-pencil"></i></button>
                                                <?php } ?>
                                                <?php if ($move) { ?>
                                                    <button type="button" class="btn btn-default btn-move" title="<?php echo lang('button_move'); ?>"><i class="fa fa-folder-open"></i></button>
                                                <?php } ?>
                                                <?php if ($copy) { ?>
                                                    <button type="button" class="btn btn-default btn-copy" title="<?php echo lang('button_copy'); ?>"><i class="fa fa-clipboard"></i></button>
                                                <?php } ?>
                                                <?php if ($delete) { ?>
                                                    <button type="button" class="btn btn-default btn-delete" title="<?php echo lang('button_delete'); ?>"><i class="fa fa-trash"></i></button>
                                                <?php } ?>
                                            </div>
                                            <ul class="get_info">
                                                <li class="file-name">
                                                    <span>Name :</span><?php echo $file['name']; ?>
                                                </li>
                                                <li class="file-size">
                                                    <span><?php echo lang('label_size'); ?> :</span> <?php echo $file['size']; ?>
                                                </li>
                                                <li class="file-path">
                                                    <span><?php echo lang('label_path'); ?> :</span> <?php echo '/' . $sub_folder; ?>
                                                </li>
                                                <?php if ($file['type'] === 'img') { ?>
                                                    <li class="file-url"><span><?php echo lang('label_url'); ?> :</span>
                                                        <input type="text" class="form-control url-control" readonly="readonly" value="<?php echo $file['img_url']; ?>"/>
                                                    </li>
                                                    <li class="img-dimension">
                                                        <span><?php echo lang('label_dimension'); ?> :</span> <?php echo $file['img_dimension']; ?>
                                                    </li>
                                                <?php } ?>
                                                <li class="file-date">
                                                    <span><?php echo lang('label_modified_date'); ?> :</span> <?php echo $file['date']; ?>
                                                </li>
                                                <li class="file-extension">
                                                    <span><?php echo lang('label_extension'); ?> :</span><em class="text-uppercase"><?php echo $file['ext']; ?></em>
                                                </li>
                                                <li class="file-permission">
                                                    <span><?php echo lang('label_permission'); ?> :</span>
                                                    <?php if ($file['perms'] === '04' OR $file['perms'] === '05') { ?>
                                                        <?php echo lang('text_read_only'); ?>
                                                    <?php } else if ($file['perms'] === '06' OR $file['perms'] === '07') { ?>
                                                        <?php echo lang('text_read_write'); ?>
                                                    <?php } else { ?>
                                                        <?php echo lang('text_no_access'); ?>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </figure>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="media-sidebar col-xs-3">
                        <div id="media-details"></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-statusbar navbar-fixed-bottom" role="navigation">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <p class="navbar-text">
                        <span class="total-selected">0</span><span class="total-selected-text"> of </span><?php echo sprintf(lang('text_footer_note'), $total_files, $folder_size); ?>
                    </p>
                </div>
                <div class="col-sm-4 text-right">
                    <?php if ($field_id) { ?>
                        <a class="btn btn-primary btn-choose disabled"><?php echo lang('text_choose'); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <div id="previewBox" style="display:none;"></div>
    <script type="text/javascript"><!--
        $(document).ready(function () {
            $('a, button, span').tooltip({container: 'body', placement: 'bottom'});

            var folder_tree = '<?php echo $folder_tree; ?>';
            $('#folderPopover .btn-folders').popover({
                container: '#folderPopover',
                html: true,
                title: 'Folders',
                content: '<span class="help-block">Double click to go</span>' + folder_tree
            });

            $('#folderPopover').on('shown.bs.popover', function () {
                $('.metisFolder').metisMenu({
                    toggle: false,
                    doubleTapToGo: true
                });
            });

            $('.media-list').on('click', function () {
                $('#folderPopover .btn-folders').popover('hide');
            });

            var mediaList = $('.media-list');
            mediaList.selectonic({
                listClass: 'selectable',
                selectedClass: 'selected',
                focusClass: 'focused',
                disabledClass: 'disabled',
                keyboard: true,
                select: function (event, ui) {
                    $('#media-details').html($(ui.target).find('.info').html());
                    $('.btn-copy, .btn-move, .btn-choose').removeClass('disabled');
                },
                unselect: function (event, ui) {
                    $('#media-details').html('');
                },
                unselectAll: function (event, ui) {
                    $('#media-details').html('');
                    $('.btn-copy, .btn-move, .btn-choose').addClass('disabled');
                },
                stop: function () {
                    var totalSelected = mediaList.selectonic('getSelected').length;
                    $('.total-selected').html(totalSelected);
                }
            });

            if ($(".selected-on-open")[0]) {
                mediaList.selectonic('select', $(".selected-on-open"));
                mediaList.selectonic('focus', $(".selected-on-open"));
                mediaList.selectonic('scroll');
            }

            $('#btn-search').on('click', function () {
                if ($('#filter-search').val().length > 1) {
                    var input = fixFilename($('#filter-search').val());
                    window.location.href = $('#refresh').attr('href') + '&filter=' + input;
                }
            });

            $('#filter-search').keypress(function (e) {
                if (e.which == 13) {
                    if ($('#filter-search').val().length > 1) {
                        var input = fixFilename($('#filter-search').val());
                        window.location.href = $('#refresh').attr('href') + '&filter=' + input;
                    }
                }
            });

            $('#btn-clear').on('click', function () {
                window.location.href = $('#refresh').attr('href');
            });

            $('.media-list .file').on('dblclick', '.link', function () {
                chooseSelected($(this).parent());
            });

            $(document).on('click', '.btn-choose', function () {
                var selected = mediaList.selectonic('getSelected');
                if (selected.length == 1) {
                    chooseSelected($(selected).find('figure'));
                }
            });
        });

        //upload open
        $(document).on('click', '.btn-upload', function () {
            if ($(this).hasClass('active')) {
                $('.uploader-box').slideUp();
                $('.btn-upload').removeClass('active');
                window.location.href = $('#refresh').attr('href') + '&' + new Date().getTime();
            } else {
                $('.uploader-box').slideDown();
                $('.btn-upload').addClass('active');
                $('.btn-toolbar .btn:not(.btn-upload)').addClass('disabled');
            }
        });

        //sort by
        $(document).on('click', '.sorter', function () {
            var _this = $(this);
            $('.dropdown-toggle').trigger('click');
            var sortOrder = $('#sort_order').val();

            if (sortOrder == 'ascending') {
                sortOrder = 'descending';
            } else {
                sortOrder = 'ascending';
            }

            window.location.href = $('#refresh').attr('href') + "&sort_by=" + _this.attr('data-sort') + "&sort_order=" + sortOrder;
        });

        //new folder
        $(document).on('click', '.btn-new-folder', function () {
            bootbox.prompt('New Folder', function (result) {
                if (result === null) {
                    Notification.show('Action canceled');
                } else {
                    var new_name = $('.bootbox-input').val();
                    new_name = fixFilename(new_name);
                    var sub_folder = $.trim($('#sub_folder').val());
                    if (new_name != '') {
                        var data = {name: new_name, sub_folder: sub_folder};
                        modalAjax('new_folder', data);
                    } else {
                        Notification.show('Folder name can not be blank');
                    }
                }
            });
        });

        //preview
        $(document).on('click', '.btn-preview', function () {
            var image_url = decodeURIComponent($(this).attr('data-url'));
            if (image_url != '') {
                bootbox.dialog({
                    title: "Preview",
                    size: "large",
                    message: '<img src="' + image_url + '" width="100%"/>'
                });
            }
        });

        //rename
        $(document).on('click', '.btn-rename', function () {
            var file_name = $.trim($(this).attr('data-name'));
            var file_path = $.trim($(this).attr('data-path'));
            var title = 'Rename:';
            var message = '<input type="text" id="new-name" class="form-control" value="' + file_name + '" />';
            var main_callback = function () {
                var new_name = $('#new-name').val();
                new_name = fixFilename(new_name);
                if (new_name !== null && new_name != file_name) {
                    var data = {file_path: file_path, file_name: file_name, new_name: new_name};
                    modalAjax('rename', data);
                }
            };

            customModal(message, title, main_callback);
        });

        // copy
        $(document).on('click', '.btn-copy', function () {
            var copy_files = $('.media-list .selected figure').map(function () {
                return $(this).attr('data-name');
            }).get();
            if (copy_files != '') {
                var title = 'Copy selected items to:';
                var message = '<div id="folder-path">' + $('#folders_list').html() + '</div>';
                var main_callback = function () {
                    var to_folder = $('#folder-path select').val();
                    var from_folder = $.trim($('#sub_folder').val());
                    if (to_folder !== null && to_folder != from_folder) {
                        var data = {
                            from_folder: from_folder,
                            to_folder: to_folder,
                            copy_files: JSON.stringify(copy_files)
                        };
                        modalAjax('copy', data);
                    }
                };

                customModal(message, title, main_callback);
            } else {
                Notification.show('Please select the file(s) to copy');
            }
        });

        // move
        $(document).on('click', '.btn-move', function () {
            var move_files = $('.media-list .selected figure').map(function () {
                return $(this).attr('data-name');
            }).get();
            if (move_files != '') {
                var title = 'Move selected items to:';
                var message = '<div id="folder-path">' + $('#folders_list').html() + '</div>';
                var main_callback = function () {
                    var from_folder = $.trim($('#sub_folder').val());
                    var to_folder = $('#folder-path select').val();
                    if (to_folder !== null && to_folder != from_folder) {
                        var data = {
                            from_folder: from_folder,
                            to_folder: to_folder,
                            move_files: JSON.stringify(move_files)
                        };
                        modalAjax('move', data);
                    }
                };

                customModal(message, title, main_callback);
            } else {
                Notification.show('Please select the file(s) to move');
            }
        });

        //delete
        $(document).on('click', '.btn-delete', function () {
            var sub_folder = $.trim($('#sub_folder').val());
            var file_path = $.trim($(this).attr('data-path'));
            var file_name = $.trim($(this).attr('data-name'));
            var delete_files = $('.media-list .selected figure').map(function () {
                return $(this).attr('data-name');
            }).get();

            if (delete_files == '' && file_name != '' && file_path != '/') {
                bootbox.confirm('Are you sure you want to delete the opened folder and its contents?', function (result) {
                    if (result === false) {
                        Notification.show('Action canceled');
                    } else {
                        var data = {file_path: file_path, file_name: file_name};
                        modalAjax('delete', data);
                    }
                });
            } else if (delete_files != '') {
                bootbox.confirm('Are you sure you want to delete the selected file (s)?', function (result) {
                    if (result === false) {
                        Notification.show('Action canceled');
                    } else {
                        var data = {file_path: sub_folder, file_names: JSON.stringify(delete_files)};
                        modalAjax('delete', data);
                    }
                });
            } else {
                Notification.show('Please select the file(s) to delete');
            }
        });

        // choose
        function chooseSelected(figure) {
            var field = parent.$('#' + $('#field_id').val());
            var file_path = 'data/' + figure.attr('data-path');

            if ($('#field_id').attr('value').length) {
                var file_name = figure.attr('data-name');
                var thumb_name = field.parent().parent().find('.name');

                field.attr('value', file_path);
                thumb_name.html(file_name);
                parent.$('#media-manager').modal('hide');
            }

            if (parent.$('#media-manager.modal[data-parent="note-editor"]').is(':visible')) {
                // Get the current selection
                var range = parent.window.getSelection().getRangeAt(0);
                var node = range.startContainer;
                var startOffset = range.startOffset;  // where the range starts
                var endOffset = range.endOffset;      // where the range ends

                $.ajax({
                    url: js_site_url('image_manager/resize?image=' + encodeURIComponent(file_path)),
                    dataType: 'json',
                    success: function (url) {
                        // Create a new range from the orginal selection
                        var range = document.createRange();
                        range.setStart(node, startOffset);
                        range.setEnd(node, endOffset);

                        var img = document.createElement('img');
                        img.src = url;

                        range.insertNode(img);

                        parent.$('#media-manager').modal('hide');
                    }
                });
            }
        }

        function customModal(message, title, main_callback) {
            bootbox.dialog({
                message: message,
                title: title,
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: "btn-default",
                        callback: function () {
                            Notification.show('Action canceled');
                        }
                    },
                    main: {
                        label: "OK",
                        className: "btn-primary",
                        callback: main_callback
                    }
                }
            });
        }

        function modalAjax(action, data) {
            var redirect = '';

            if (action === 'new_folder') {
                redirect = data.sub_folder + data.name + '/';
            } else if (action === 'create_gallery') {
                redirect = 'gallery/' + data.name + '/';
            } else if (action === 'delete') {
                redirect = data.file_path;
            } else if (action === 'rename') {
                redirect = data.file_path + data.new_name;
            } else if (action === 'copy' || action === 'move') {
                redirect = data.to_folder;
            }

            $.ajax({
                type: 'POST',
                url: js_site_url('image_manager/' + action),
                data: data,
                dataType: 'json',
                success: function (json) {
                    showSuccess(json, redirect)
                }
            });
        }

        function showSuccess(json, redirect) {
            $('.error, .success').remove();

            var refresh_url = $('#refresh').attr('href');
            var cpos = refresh_url.indexOf("&sub_folder=") + "&sub_folder=".length,
                spos = refresh_url.indexOf("/&");
            if (typeof redirect != 'undefined' && redirect != '' && cpos > -1 && spos > cpos)
                var refreshUrl = refresh_url.substr(0, cpos) + redirect + refresh_url.substr(spos + 1);

            if (typeof refreshUrl == 'undefined') refreshUrl = refresh_url;

            var message = '';
            if (json['alert']) {
                message = json['alert'];
            }

            if (json['success']) {
                message = json['success'];
            }

            if (message != '') {
                Notification.show(message);
                setTimeout(function () {
                    window.location.href = refreshUrl;
                }, 2000);
            }
        }

        function fixFilename(stri) {
            if (stri != null) {
                stri = stri.replace('"', '');
                stri = stri.replace("'", '');
                stri = stri.replace("/", '');
                stri = stri.replace("\\", '');
                stri = stri.replace(/<\/?[^>]+(>|$)/g, "");
                return $.trim(stri);
            }

            return null;
        }
        //--></script>

    <script type="text/javascript"><!--
        //dropzone config
        window.Dropzone.options.myAwesomeDropzone = {
            dictInvalidFileType: 'File extension is not allowed.',
            dictFileTooBig: 'The uploaded file exceeds the max size allowed.',
            paramName: 'file', // The name that will be used to transfer the file
            maxFilesize: maxSizeUpload, // MB
            addRemoveLinks: false,
            url: js_site_url('image_manager/upload'),
            init: function () {
                this.on("addedfile", function (file) {
                    var removeButton = Dropzone.createElement("<a class='dz-remove'>Delete file</a>");
                    var _this = this;

                    removeButton.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var sub_folder = $.trim($('#sub_folder').val());
                        var delete_file = file.name;
                        if (delete_file != '') {
                            $.ajax({
                                type: 'POST',
                                url: js_site_url('image_manager/delete'),
                                data: {file_path: sub_folder, file_name: delete_file},
                                dataType: 'json',
                                success: function (json) {
                                    showSuccess(json);
                                    _this.removeFile(file);
                                }
                            });
                        }
                    });

                    file.previewElement.appendChild(removeButton);
                });
            },
            accept: function (file, done) {
                var extension = file.name.split('.').pop();
                extension = extension.toLowerCase();

                if ($.inArray(extension, allowed_ext) == -1) {
                    done('File extension is not allowed.');
                } else {
                    done();
                }
            }
        };

        //--></script>
    <script type="text/javascript"><!--
        var Notification = (function () {
            "use strict";

            var elem,
                hideHandler,
                that = {};

            that.init = function (options) {
                elem = $(options.selector);
            };

            that.show = function (text) {
                clearTimeout(hideHandler);

                elem.find("span").html(text);
                elem.delay(200).fadeIn().delay(4000).fadeOut();
            };

            return that;
        }());

        //--></script>

    <script>
        $(function () {
            Notification.init({
                "selector": ".notification"
            });
        });
    </script>
    </body>
    </html>
<?php } ?>
