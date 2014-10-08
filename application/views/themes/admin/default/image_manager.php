<?php if ($popup !== 'iframe') { ?>
	<?php echo $header; ?>
		<div class="row content">
			<div class="col-md-12">
				<div id="image-manager" style="padding: 3px 0px 0px 0px;">
					<iframe src="<?php echo site_url(ADMIN_URI.'/image_manager?popup=iframe'); ?>" width="100%" height="550" frameborder="0"></iframe>
				</div>
			</div>
		</div>
	<?php echo $footer; ?>
<?php } else { ?>
	<!DOCTYPE html>
	<html xmlns="https://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
			<meta name="robots" content="noindex,nofollow">
			<title><?php echo $title; ?></title>
			<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/images/favicon.ico'); ?>" rel="shortcut icon" />
			<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
			<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/font-awesome.css'); ?>" rel="stylesheet" type="text/css" />
			<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/dropzone.css'); ?>" type="text/css" rel="stylesheet" />
			<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/jquery.contextMenu.css'); ?>" rel="stylesheet" type="text/css" />	
			<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/image-manager.css'); ?>" rel="stylesheet" type="text/css" />
			<!--[if lt IE 8]><style>
				.img-container span, .img-container-mini span {
					display: inline-block;
					height: 100%;
				}
			</style><![endif]-->
			<script type="text/javascript" src="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/js/jquery-1.10.2.js'); ?>"></script>
			<script type="text/javascript" src="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/js/bootstrap.js'); ?>"></script>
			<script type="text/javascript" src="<?php echo base_url('assets/js/dropzone.js'); ?>"></script>
			<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.queryloader2.js'); ?>"></script>
			<!--[if lt IE 9]>
				<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
			<![endif]-->
			<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ui.position.js'); ?>"></script>
			<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.contextMenu.js'); ?>"></script>    
			<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.finderSelect.js'); ?>"></script>    
			<script type="text/javascript" src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>    
			<script type="text/javascript" src="<?php echo base_url("assets/js/tinymce/tinymce.js"); ?>"></script>
			<script type="text/javascript">
				var js_site_url = function(str) {
					var strTmp = "<?php echo site_url('" + str + "'); ?>";
					return strTmp;
				}

				var js_base_url = function(str) {
					var strTmp = "<?php echo base_url('" + str + "'); ?>";
					return strTmp;
				}
				<?php $allowed_ext = explode("|", $allowed_ext); ?>
				var allowed_ext = new Array('<?php echo implode("','", $allowed_ext); ?>');
				var maxSizeUpload = <?php echo round($max_size_upload / 1024, 2); ?>;
			</script>
		</head>
		<body>
			<div class="notification alert alert-info" style="display:none;"><span></span></div>
			<input type="hidden" id="current_url" value="<?php echo $current_url; ?>" />
			<input type="hidden" id="insert_folder_name" value="New Folder" />
			<input type="hidden" id="new_folder" value="New Folder" />
			<input type="hidden" id="total_files" value="<?php echo $total_files; ?>" />
			<input type="hidden" id="field_id" value="<?php echo $field_id; ?>" />
			<input type="hidden" id="sub_folder" value="<?php echo $sub_folder; ?>"/>
			<input type="hidden" id="sort_order" value="<?php echo $sort_order; ?>" />
			<select id="folders_list" style="display:none;">
			<?php foreach ($folders_list as $key => $value) { ?>
				<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
			<?php } ?>
			</select>
		
			<nav class="navbar navbar-default navbar-menu navbar-fixed-top" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<div class="btn-toolbar row" role="toolbar">
							<div class="btn-group pull-left col-sm-1 wrap-none">
								<a class="btn btn-default navbar-btn btn-back <?php echo $back; ?>" title="Back" href="<?php echo $back_url; ?>"><i class="fa fa-arrow-left"></i></a>
							</div>
							<div class="btn-group col-sm-4">
								<?php if ($uploads) { ?>
									<button type="button" class="btn btn-default navbar-btn btn-upload" title="Upload"><i class="fa fa-upload"></i></button> 
								<?php } ?>
								<?php if ($new_folder) { ?>
									<button type="button" class="btn btn-default navbar-btn btn-new-folder" title="New Folder"><i class="fa fa-folder"></i></button> 
								<?php } ?>
								<?php if ($move) { ?>
									<button type="button" class="btn btn-default navbar-btn btn-move" title="Move"><i class="fa fa-folder-open"></i></button> 
								<?php } ?>
								<?php if ($copy) { ?>
									<button type="button" class="btn btn-default navbar-btn btn-copy" title="Copy"><i class="fa fa-clipboard"></i></button> 
								<?php } ?>
								<a id="refresh" title="Refresh" class="btn btn-default navbar-btn btn-refresh" href="<?php echo $refresh_url; ?>"><i class="fa fa-refresh"></i></a>
							</div>
							<div class="btn-group col-sm-4 pull-right wrap-none">
								<div class="navbar-form input-group">
									<span id="btn-clear" class="input-group-addon" title="Clear"><i id="filter-clear" class="fa fa-times"></i></span>
									<input type="text" name="filter_search" id="filter-search" class="form-control" value="<?php echo $filter; ?>" placeholder="Search files and folders..." />
									<span id="btn-search" class="input-group-addon" title="Search"><i class="fa fa-search"></i></span>
								</div>
							</div>
							<div class="btn-group pull-right">
								<div class="dropdown">
									<a class="btn btn-default navbar-btn btn-sort dropdown-toggle" data-toggle="dropdown" title="Sort">
										<?php if ($sort_order === 'ascending') { ?>
											<i class="fa fa-sort-amount-asc"></i> <i class="caret"></i>
										<?php } else { ?>
											<i class="fa fa-sort-amount-desc"></i> <i class="caret"></i>
										<?php } ?>
									</a>
									<ul class="dropdown-menu dropdown-sorter" role="menu">
										<li><span><strong>Sort By:</strong></span></li>
										<li class="divider"></li>
										<li><a class="sorter" data-sort="name"><?php echo ($sort_by === 'name') ? $sort_icon:''; ?>Name</a></li>
										<li><a class="sorter" data-sort="date"><?php echo ($sort_by === 'date') ? $sort_icon:''; ?>Date</a></li>
										<li><a class="sorter" data-sort="size"><?php echo ($sort_by === 'size') ? $sort_icon:''; ?>Size</a></li>
										<li><a class="sorter" data-sort="extension"><?php echo ($sort_by === 'extension') ? $sort_icon:''; ?>Type</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>

			<div class="container-fluid">
				<div class="row-fluid">
					<ol class="breadcrumb">
						<?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
							<?php if ($key == count($breadcrumbs) - 1) { ?>
								<li class="active"><?php echo $breadcrumb['name']; ?></li>
							<?php } else { ?>
								<li><a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['name']; ?></a></li>
							<?php } ?>
						<?php } ?>
					</ol>
					<div id="notification"></div>
					<?php if ($uploads) { ?>
						<div class="uploader-box">
							<div class="tabbable upload-tabbable"> <!-- Only required for left/right tabs -->
								<form role="form" method="post" enctype="multipart/form-data" id="my-awesome-dropzone" class="dropzone">
									<input type="hidden" name="sub_folder" value="<?php echo $sub_folder; ?>"/>
									<div class="fallback">
										Upload:<br/>
										<input name="file" type="file" />
									</div>
								</form>
							</div>
						</div>	
					<?php } ?>

					<div class="grid-box">	    
					<?php if ($files_error) { ?>
						<p class="alert-danger"><?php echo $files_error; ?></p> 
					<?php } else { ?>
						<ul id="selectable" class="thumbnail-list">
							<?php foreach ($files as $file) { ?>
							<li class="<?php echo $file['html_class']; ?>">
								<figure class="thumbnail" data-name="<?php echo $file['name']; ?>" data-type="<?php echo $file['type']; ?>" data-path="<?php echo $file['data_path']; ?>">
									<a class="select-disable link" <?php echo ($file['type'] === 'dir') ? 'href="'. $file['url'] .'"' : ''; ?> title="<?php echo $file['size']; ?>">
										<div class="img-container select-disable <?php echo ($file['type'] === 'dir') ? 'directory':''; ?>">
											<?php if ($file['thumb_type'] === 'dir') { ?>
												<i class="fa fa-folder-open select-disable directory-img"></i>
											<?php } else if ($file['thumb_type'] === 'thumb') { ?>
												<img alt="<?php echo $file['name']; ?>" class="img-responsive select-disable thumb" src="<?php echo $file['thumb_url']; ?>" />
											<?php } else if ($file['thumb_type'] === 'icon') { ?>
												<span class="select-disable"><?php echo $file['ext']; ?></span>
												<i class="fa fa-file select-disable icon"></i>
											<?php } else if ($file['thumb_type'] === 'original') { ?>
												<img title="<?php echo $file['name']; ?>" class="img-responsive select-disable original" src="<?php echo $file['thumb_url']; ?>" />
											<?php } ?>
										</div>
										<figcaption class="caption">
											<h4 class="ellipsis">
												<span class="select-disable"><?php echo $file['human_name']; ?></span>
											</h4>
										</figcaption>
									</a>
									<div class="info">
										<ul class="get_info select-disable">
											<li class="file-name select-disable"><span>Name :</span> <?php echo $file['name']; ?></li>
											<li class="file-size select-disable"><span>Size :</span> <?php echo $file['size']; ?></li>
											<li class="file-path select-disable"><span>Path :</span> <?php echo $file['path']; ?></li>
											<?php if ($file['type'] === 'img') { ?>
												<li class="file-url select-disable"><span>URL :</span> <a class="preview" target="_blank" href="<?php echo $file['img_url']; ?>">Open in new window</a></li>
												<li class="img-dimension select-disable"><span>Dimension :</span> <?php echo $file['img_dimension']; ?></li>
											<?php } ?>
											<li class="file-date select-disable"><span>Modified Date :</span> <?php echo $file['date']; ?></li>
											<li class="file-extension select-disable" style="display:none"><?php echo $file['ext']; ?></li>
											<li class="file-permission select-disable"><span>Permission :</span> 
												<?php if ($file['perms'] === '04' OR $file['perms'] === '05') { ?>
													Read Only
												<?php } else if ($file['perms'] === '06' OR $file['perms'] === '07') { ?>
													Read & Write
												<?php } else { ?>
													No Access
												<?php } ?>
											</li>
										</ul>
									</div>
								</figure>
							</li>
							<?php } ?>
						</ul>
					<?php } ?>
					</div>
				</div>
			</div>

			<nav class="navbar navbar-default navbar-statusbar navbar-fixed-bottom" role="navigation">
				<div class="container">
					<p class="navbar-text"><?php echo $total_files; ?> items, <?php echo $folder_size; ?></p>
				</div>
			</nav>
		
			<div id="previewBox" style="display:none;"></div>
			<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
			<script src="<?php echo base_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
			<script type="text/javascript"><!--
			$(document).ready(function(){
				$('a, button, span').tooltip({container:'body', placement: 'bottom'});

				$('#selectable').finderSelect({children:'li:not(.back)'});
			
				$.contextMenu({
					selector:'.selected figure:not(.back)',
					trigger: 'right',
					autoHide: false,
					zIndex: 9999,
					build: function($trigger) {
						var figure = $trigger;
						//figure.parent().addClass('selected');
						var options = {
							callback: function(key, options) {
								switch (key) {
								case 'preview':
									var image_url = decodeURIComponent(figure.find('a.preview').attr('href'));
									if (image_url != '') {
										$('#previewBox').empty();
										$('#previewBox').html('<img src="'+ image_url +'" />');
										$.fancybox({	
											href:"#previewBox",
											autoScale: false,
										});
									}
									break;
								case 'copy':
									$('.btn-copy').click();
									break;
								case 'move':
									$('.btn-move').click();
									break;
								case 'rename':
									var file_name = $.trim(figure.attr('data-name'));
									var title = 'Rename:';
									var message = '<input type="text" id="new-name" class="form-control" value="' + file_name + '" />';
									var main_callback = function() {
										var sub_folder = $.trim($('#sub_folder').val());
										var new_name = $('#new-name').val();
										new_name = fixFilename(new_name);
										if (new_name !== null && new_name != file_name) {
											var data = {sub_folder: sub_folder, file_name: file_name, new_name: new_name};
											modalAjax('rename', data);
										}
									}

									customModal(message, title, main_callback);
									break;
								case 'delete':
									var sub_folder = $.trim($('#sub_folder').val());
									var delete_files = $('.thumbnail-list .selected figure').map(function(){return $(this).attr('data-name');}).get();
									if (delete_files != '') {
										bootbox.confirm('Are you sure you want to delete the file/folder and it contents?', function(result) {
											if (result === false) {
												Notification.show('Action canceled');
											} else {
												var data = {sub_folder: sub_folder, delete_files: JSON.stringify(delete_files)};
												modalAjax('delete', data);
											}
										}); 
									} else {
										Notification.show('Please select the file(s) to delete');
									}
									break;
								case 'info':
									bootbox.alert(figure.find('.info').html());
									break;
								}
							},
							items: {}
						};
					
						if (figure.attr('data-type') == 'img') {
							options.items.preview = {name: 'Preview', icon: 'eye', disabled: false};
						} else {
							options.items.preview = {name: 'Preview', icon: 'eye', disabled: true};
						}
						options.items.copy = {name: 'Copy', icon: 'clipboard', disabled: false};
						options.items.move = {name: 'Move', icon: 'folder-open', disabled: false};
						options.items.rename = {name: 'Rename', icon: 'pencil', disabled: false};
						options.items.delete = {name: 'Delete', icon: 'trash-o', disabled: false};
						options.items.sep = '----';
						options.items.info = {name: 'Get Info', icon: 'info-circle', disabled: false};

						return options;
					},
					events: {
						hide: function(opt){ 
							//$('figure').removeClass('selected');
						}
					}
				});

				$('#btn-search').on('click', function() {
					if ($('#filter-search').val().length > 1) {
						var input = fixFilename($('#filter-search').val());
						window.location.href = $('#refresh').attr('href') + '&filter=' + input;
					}
				});
	
				$('#filter-search').keypress(function(e) {
					if (e.which == 13) {
						if ($('#filter-search').val().length > 1) {
							var input = fixFilename($('#filter-search').val());
							window.location.href = $('#refresh').attr('href') + '&filter=' + input;
						}
					}
				});
	
				$('#btn-clear').on('click', function() {
					window.location.href = $('#refresh').attr('href');
				});

				$('.thumbnail-list').on('contextmenu', function(e) {
					if (!$(e.target).is("figure")) {
						e.preventDefault();
					}
				});	

				$('.thumbnail-list a:not(.link)').on('click', function(e) {
					$('#selectable li').removeClass('selected');
				});
	
				$('.thumbnail-list .directory').on('click', '.link', function(e) {
					e.preventDefault();
				});

				$('.thumbnail-list .directory').on('dblclick', '.link', function(e) {
					window.location.replace($(this).attr('href'));
				});

				$('.thumbnail-list .file').on('dblclick', '.link', function() {
					var field = parent.$('#' + $('#field_id').val());
					var figure = $(this).parent();
					var file_path = 'data/' + figure.attr('data-path');
					var file_name = figure.attr('data-name');
					var file_src = figure.find('.img-container img').attr('src');
					var thumb = field.parent().parent().find('.thumb');
					var thumb_name = field.parent().parent().find('.name');
		
					if (typeof parent.$.fancybox == 'function') {
						field.attr('value', file_path);
						thumb_name.html(file_name);

						parent.$.fancybox.close();
						parent.$('#image-manager').empty();
					}

					if (typeof top.tinymce != 'undefined') {
						$.ajax({
							url: js_site_url('admin/image_manager/resize?image=') + encodeURIComponent(file_path),
							dataType: 'json',
							success: function(url) {
								var dialogArguments = top.tinymce.activeEditor.windowManager.getParams();
								dialogArguments.updateInput(url);
								top.tinymce.activeEditor.windowManager.close();
							}
						});
					}
				});

				//upload open
				$('.btn-upload').on('click', function() {
					if ($(this).hasClass('active')) {
						$('.uploader-box').fadeOut();
						$('.grid-box').slideDown(500);
						$('.btn-upload').removeClass('active');
						window.location.href = $('#refresh').attr('href') + '&' + new Date().getTime();
					} else {
						$('.grid-box').fadeOut();
						$('.uploader-box').slideDown(500);
						$('.btn-upload').addClass('active');
					}
				});

				//sort by
				$('.sorter').on('click', function() {
					_this = $(this);
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
				$('.btn-new-folder').on('click', function() {
					bootbox.prompt('New Folder', function(result) {
						if (result === null) {
							Notification.show('Action canceled');
						} else {
							var new_name = $('.bootbox-input').val();
							new_name = fixFilename(new_name);
							var sub_folder = $.trim($('#sub_folder').val());
							if (new_name != '') {
								var data = {sub_folder: sub_folder, name: new_name};
								modalAjax('new_folder', data);
							} else {
								Notification.show('Folder name can not be blank');
							}
						}
					});
				});

				// copy
				$('.btn-copy').on('click', function() {
					var copy_files = $('.thumbnail-list .selected figure').map(function(){return $(this).attr('data-name');}).get();
					if (copy_files != '') {
						var title = 'Copy selected items to:';
						var message = '<select id="folder-path" class="form-control">' + $('#folders_list').html() + '</select><span class="help-block small">Existing file/folder will NOT be replaced</span>';
						var main_callback = function() {
							var to_folder = $('#folder-path').val();
							var from_folder = $.trim($('#sub_folder').val());
							if (to_folder !== null && to_folder != from_folder) {                                             
								var data = {from_folder: from_folder, to_folder: to_folder, copy_files: JSON.stringify(copy_files)};
								modalAjax('copy', data);
							}
						}
					
						customModal(message, title, main_callback);
					} else {
						Notification.show('Please select the file(s) to copy');
					}
				});
	
				// move
				$('.btn-move').on('click', function() {
					var move_files = $('.thumbnail-list .selected figure').map(function(){return $(this).attr('data-name');}).get();
					if (move_files != '') {
						var title = 'Move selected items to:';
						var message = '<select id="folder-path" class="form-control">' + $('#folders_list').html() + '</select><span class="help-block small">Existing file/folder will NOT be replaced</span>';
						var main_callback = function() {
							var from_folder = $.trim($('#sub_folder').val());
							var to_folder = $('#folder-path').val();
							if (to_folder !== null && to_folder != from_folder) {                                             
								var data = {from_folder: from_folder, to_folder: to_folder, move_files: JSON.stringify(move_files)};
								modalAjax('move', data);
							}
						}

						customModal(message, title, main_callback);
					} else {
						Notification.show('Please select the file(s) to move');
					}
				});

			});

			function customModal(message, title, main_callback) {
				bootbox.dialog({
					message: message,
					title: title,
					buttons: {
						cancel: {
							label: "Cancel",
							className: "btn-default",
							callback: function() {
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
				$.ajax({
					type: 'POST',
					url: js_site_url('admin/image_manager/' + action),
					data: data,
					dataType: 'json',
					success: function(json) { showSuccess(json) }
				});
			}
		
			function showSuccess(json) {
				var refresh_url = $('#refresh').attr('href');
				$('.error, .success').remove();

				if (json['alert']) {
					var message = json['alert'];
					Notification.show(message);
					setTimeout(function() { 
						window.location.href = refresh_url;
					}, 2000);
				}
			}

			function fixFilename(stri) {
				if (stri != null) {
					stri = stri.replace('"','');
					stri = stri.replace("'",'');
					stri = stri.replace("/",'');
					stri = stri.replace("\\",'');
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
				url: js_site_url('admin/image_manager/upload'),
				init: function() {
					this.on("addedfile", function(file) {
						var removeButton = Dropzone.createElement("<a class='dz-remove'>Delete file</a>");
						var _this = this;

						removeButton.addEventListener("click", function(e) {
							e.preventDefault();
							e.stopPropagation();
							var sub_folder = $.trim($('#sub_folder').val());
							var delete_file = file.name;
							if (delete_file != '') {
								$.ajax({
									type: 'POST',
									url: js_site_url('admin/image_manager/delete'),
									data: {sub_folder: sub_folder, delete_file: delete_file},
									dataType: 'json',
									success: function(json) { 
										showSuccess(json);
										_this.removeFile(file);
									}
								});
							}
						});
					
						file.previewElement.appendChild(removeButton);
					});
				},
				accept: function(file, done) {
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
			var Notification = (function() {
				"use strict";

				var elem,
					hideHandler,
					that = {};

				that.init = function(options) {
					elem = $(options.selector);
				};

				that.show = function(text) {
					clearTimeout(hideHandler);

					elem.find("span").html(text);
					elem.delay(200).fadeIn().delay(4000).fadeOut();
				};

				return that;
			}());

			//--></script>
		
			<script>
				$(function() {
					Notification.init({
						"selector": ".notification"
					});
				});
			</script>
		</body>
	</html>
<?php } ?>
