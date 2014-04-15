<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="robots" content="noindex,nofollow">
        <title><?php echo $title; ?></title>
		<link href="<?php echo base_url('assets/img/favicon.ico'); ?>" rel="shortcut icon" />
		<link href="<?php echo base_url('assets/js/themes/ui-lightness/jquery-ui-1.10.3.custom.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/dropzone.css'); ?>" type="text/css" rel="stylesheet" />
		<link href="<?php echo base_url('assets/css/jquery.contextMenu.css'); ?>" rel="stylesheet" type="text/css" />	
        <link href="<?php echo base_url('assets/css/image-manager.css'); ?>" rel="stylesheet" type="text/css" />
		<!--[if lt IE 8]><style>
			.img-container span, .img-container-mini span {
				display: inline-block;
				height: 100%;
			}
		</style><![endif]-->
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.9.1.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui-1.10.3.custom.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/dropzone.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.simplemodal-1.4.4.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.queryloader2.js'); ?>"></script>
		<!--[if lt IE 9]>
			<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		<![endif]-->
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ui.position.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.contextMenu.js'); ?>"></script>    
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.finderSelect.js'); ?>"></script>    
		<script type="text/javascript">
			var js_site_url = "<?php echo site_url(); ?>/";
			var js_base_url = "<?php echo base_url(); ?>";
			<?php $allowed_ext = explode("|", $allowed_ext); ?>
			var allowed_ext = new Array('<?php echo implode("','", $allowed_ext); ?>');
			var maxSizeUpload = <?php echo round($max_size_upload / 1024, 2); ?>;
		</script>
	</head>
    <body>
		<input type="hidden" id="insert_folder_name" value="New Folder" />
		<input type="hidden" id="new_folder" value="New Folder" />
		<input type="hidden" id="total_files" value="<?php echo $total_files; ?>" />
		<input type="hidden" id="field_id" value="<?php echo $field_id; ?>" />
		<input type="hidden" id="sub_folder" value="<?php echo $sub_folder; ?>"/>
		
		<div class="menu-bar">
			<div class="menu-icon">
				<?php if ($uploads) { ?>
					<button class="btn upload-btn" title="Upload">
						<i class="icon-upload"></i>
					</button> 
				<?php } ?>
				<?php if ($new_folder) { ?>
					<button class="btn new-folder" title="New Folder">
						<i class="icon-new-folder"></i>
					</button> 
				<?php } ?>
				<button class="btn move-btn" title="Move">
					<i class="icon-move"></i>
					<select id="folders_list" style="display:none;">
					<?php foreach ($folders_list as $key => $value) { ?>
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>
					</select>
				</button> 
				<button class="btn copy-btn" title="Copy">
					<i class="icon-copy"></i>
				</button> 
				<a id="refresh" title="Refresh" class="button btn refresh" href="<?php echo $refresh_url; ?>"><i class="icon-refresh"></i></a>
			</div>
			<div class="menu-search">
				<a class="dropdown-toggle sorting-btn" data-toggle="dropdown">
					<i class="icon-sort"></i> 
				</a>
				<ul class="dropdown-menu pull-left sorting">
					<li><span><strong>Sort By:</strong></span></li>
					<li><a class="sorter" href="javascript:void('')" data-sort="name">Name</a></li>
					<li><a class="sorter" href="javascript:void('')" data-sort="date">Date</a></li>
					<li><a class="sorter" href="javascript:void('')" data-sort="size">Size</a></li>
					<li><a class="sorter" href="javascript:void('')" data-sort="extension">Type</a></li>
				</ul>
				<i class="icon-search"></i>
				<input id="filter-search" type="text" name="filter_search" value="" placeholder="Search files and folders...">
				<i class="icon-close"></i>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row-fluid ff-container">
				<ul class="breadcrumb">
					<li><span class="divider">/</span></li>
					<?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
					<?php if ($key == count($breadcrumbs) - 1) { ?>
						<li class="active"><?php echo $breadcrumb['name']; ?></li>
					<?php } else { ?>
						<li><a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['name']; ?></a></li>
						<li><span class="divider"><?php echo '/'; ?></span></li>
					<?php } ?>
					<?php } ?>
				</ul>
				<?php if ($uploads) { ?>
					<div class="uploader-box">
						<div class="tabbable upload-tabbable"> <!-- Only required for left/right tabs -->
							<form method="post" enctype="multipart/form-data" id="my-awesome-dropzone" class="dropzone">
								<input type="hidden" name="sub_folder" value="<?php echo $sub_folder; ?>"/>
								<div class="fallback">
									Upload:<br/>
									<input name="file" type="file" />
								</div>
							</form>
						</div>
					</div>	
				<?php } ?>
				<?php echo $test_check; ?>
				<div class="grid-box">	    
				<?php if ( ! $files) { ?>
					<br/>
					<div class="alert"><center>There was an error. Folder can not be found.</center></div> 
				<?php } else { ?>
				<ul id="selectable" class="grid">
				<?php foreach ($files as $file) { ?>
					<li class="<?php echo $file['html_class']; ?>">
					<?php echo $file['test_check']; ?>
					<figure data-name="<?php echo $file['name']; ?>"  class="<?php echo $file['html_class']; ?>" data-type="<?php echo $file['type']; ?>" data-path="<?php echo $file['data_path']; ?>">
						<a class="select-disable <?php echo ($file['type'] === 'back') ? '' : 'link'; ?>" <?php echo ($file['type'] === 'back' OR $file['type'] === 'dir') ? 'href="'.$file['url'].'"' : ''; ?> title="<?php echo $file['size']; ?>">
							<div class="img-precontainer select-disable">
								<div class="img-container select-disable <?php echo ($file['type'] === 'dir') ? 'directory':''; ?>">
									<?php if ($file['thumb_type'] === 'back') { ?>
										<img alt="folder" class="select-disable directory-img" src="<?php echo $file['thumb_url']; ?>" />
									<?php } else if ($file['thumb_type'] === 'dir') { ?>
										<img alt="folder" class="select-disable directory-img" src="<?php echo $file['thumb_url']; ?>" />
									<?php } else if ($file['thumb_type'] === 'thumb') { ?>
										<img alt="<?php echo $file['name']; ?> thumbnails" class="select-disable thumb" src="<?php echo $file['thumb_url']; ?>" />
									<?php } else if ($file['thumb_type'] === 'icon') { ?>
										<span class="select-disable"><?php echo $file['ext']; ?></span>
										<img alt="<?php echo $file['name']; ?> thumbnails" class="select-disable icon" src="<?php echo $file['thumb_url']; ?>" />
									<?php } else if ($file['thumb_type'] === 'original') { ?>
										<img alt="<?php echo $file['name']; ?> thumbnails" class="select-disable original" src="<?php echo $file['thumb_url']; ?>" />
									<?php } ?>
								</div>
							</div>
						<?php if ($file['type'] === 'back') { ?>
							<figcaption class="box no-effect">
								<h4>Back</h4>
							</figcaption>
						</a>
						<?php } else { ?>
							<figcaption class="box">
								<h4 class="ellipsis">
									<span class="select-disable"><?php echo $file['human_name']; ?></span>
								</h4>
							</figcaption>
						</a>
						<div class="info">
							<ul class="get_info">
								<li class="file-name"><span>Name :</span> <?php echo $file['name']; ?></li>
								<li class="file-size"><span>Size :</span> <?php echo $file['size']; ?></li>
								<li class="file-path"><span>Path :</span> <?php echo $file['path']; ?><input type="hidden" id="file-path" value="<?php echo $file['path']; ?>"></li>
								<?php if ($file['type'] === 'img') { ?>
									<li class="file-url"><span>URL :</span> <a class="preview" target="_blank" href="<?php echo $file['img_url']; ?>">Open in new window</a></li>
									<li class="img-dimension"><span>Dimension :</span> <?php echo $file['img_dimension']; ?></li>
								<?php } ?>
								<li class="file-date"><span>Modified Date :</span> <?php echo $file['date']; ?></li>
								<li class='file-extension' style="display:none"><?php echo $file['ext']; ?></li>
								<li class='file-permission'><span>Permission :</span> 
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
						<?php } ?>
					</figure>
					</li>
				<?php } ?>
				</ul>
				<?php } ?>
				</div>
			</div>
		</div>
		<div class="statusbar statusbar-fixed-bottom"><center><?php echo $total_files; ?> items, <?php echo $folder_size; ?></center></div>

		<div id="modalBox" style="display:none;"></div>
		<div id="previewBox" style="display:none;"></div>
		<script type="text/javascript"><!--
		$(document).ready(function(){
			$('#selectable').finderSelect({children:'li:not(.back)'});
			//$('#selectable li').draggable();
			
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
									$('#previewBox').html('<img id="full-img" src="'+ image_url +'" class="simplemodal-close">');
									$('#previewBox').modal({
										overlayCss: {'backgroundColor': '#000'}, overlayClose: true, opacity: 65, autoResize: true,
										onClose: function(dialog) { closeModal(dialog) }
									});
								}
								break;
							case 'copy':
								$('.copy-btn').click();
								break;
							case 'move':
								$('.move-btn').click();
								break;
							case 'rename':
								var f_name = $.trim(figure.attr('data-name'));
								prependModal();
								$('#modalBox').modal({
									overlayClose: false, position: [65], opacity: 70,
									onOpen: function(dialog) { openModal(dialog) },
									onShow:  function(dialog) {
										var modal = this;
										modalRename(modal, dialog, figure, f_name);
									},
									onClose: function(dialog) { closeModal(dialog) }
								});
								break;
							case 'delete':
								var sub_folder = $('#sub_folder').val();
								var data_path = $.trim(figure.attr('data-path'));
								confirm('Are you sure you want to delete the file/folder and it contents?', function () {
									$.ajax({
										type: 'POST',
										url: js_site_url + 'admin/image_manager/delete',
										data: {data_path: data_path},
										dataType: 'json',
										success: function(json) { showSuccess(json) }
									});
								});
								break;
							case 'info':
								confirm(figure.find('.info').html(), '', true);
								break;
							}
						},
						items: {}
					};
					
					if (figure.attr('data-type') == 'img') {
						options.items.preview = {name: 'Preview', icon: 'preview', disabled: false};
					} else {
						options.items.preview = {name: 'Preview', icon: 'preview', disabled: true};
					}
					options.items.copy = {name: 'Copy', icon: 'copy', disabled: false};
					options.items.move = {name: 'Move', icon: 'move', disabled: false};
					options.items.rename = {name: 'Rename', icon: 'rename', disabled: false};
					options.items.delete = {name: 'Delete', icon: 'delete', disabled: false};
					options.items.sep = '----';
					options.items.info = {name: 'Get Info', icon: 'info', disabled: false};

					return options;
				},
				events: {
					hide: function(opt){ 
						//$('figure').removeClass('selected');
					}
				}
			});

			$('ul.grid').on('contextmenu', function(e) {
				if (!$(e.target).is("figure")) {
					e.preventDefault();
				}
			});	

			$('ul.grid a:not(.link)').on('click', function(e) {
				$('#selectable li').removeClass('selected');
			});
	
			$('ul.grid .directory').on('click', '.link', function(e) {
				e.preventDefault();
			});

			$('ul.grid .directory').on('dblclick', '.link', function(e) {
				window.location.replace($(this).attr('href'));
			});

			$('ul.grid .file').on('dblclick', '.link', function() {
				var field = parent.$('#' + $('#field_id').val());
				var figure = $(this).parent();
				var file_path = figure.find('#file-path').val()
				var file_name = figure.attr('data-name');
				var file_src = figure.find('.img-container img').attr('src');
				var thumb = field.parent().parent().find('.thumb');
				var thumb_name = field.parent().parent().find('.name');
		
				field.attr('value', file_path + file_name);
				//thumb.attr('src', file_src);
				thumb_name.html(file_name);

				if(typeof parent.$.fancybox == 'function') {
					parent.$.fancybox.close();
					parent.$('#image-manager').empty();
				}
			});

			//upload open
			$('.upload-btn').on('click', function() {
				if ($(this).hasClass('active')) {
					$('.uploader-box').fadeOut();
					$('.grid-box').slideDown(500);
					$('.upload-btn').removeClass('active');
					window.location.href = $('#refresh').attr('href') + '&' + new Date().getTime();
				} else {
					$('.grid-box').fadeOut();
					$('.uploader-box').slideDown(500);
					$('.upload-btn').addClass('active');
				}
			});
	
			//dropdown
			$('.dropdown-toggle').on('click', function() {
				if ($('.dropdown-menu').is(':visible')) {
					$('.dropdown-menu').hide();
					$('.dropdown-toggle').removeClass('open');
				} else {
					$('.dropdown-menu').show();
					$('.dropdown-toggle').addClass('open');
				}
			});	

			$('.sorter').on('click',function() {
				_this = $(this);
				window.location.href = $('#refresh').attr('href') + '&sort_by=' + _this.attr('data-sort');
			});
	
			//new folder
			$('.new-folder').on('click', function() {
				prependModal();
				$('#modalBox').modal({
					overlayClose: false, position: [65], opacity: 70,
					onOpen:  function(dialog) { openModal(dialog) },
					onShow:  function(dialog) {
						var modal = this;
						modalNewFolder(modal, dialog);
					},
					onClose: function(dialog) { closeModal(dialog) }
				});
			});

			// copy
			$('.copy-btn').on('click', function() {
				var copy_files = $('ul.grid .selected figure').map(function(){return $(this).attr('data-name');}).get();
				if (copy_files != '') {
					prependModal();
					$('#modalBox').modal({
						overlayClose: false, position: [65], opacity: 70,
						onOpen: function(dialog) { openModal(dialog) },
						onShow:  function(dialog) {
							var modal = this;
							modalCopy(modal, dialog, copy_files);
						},
						onClose: function(dialog) { closeModal(dialog) }
					});
				} else {
					confirm('Please select the file(s) to copy', '', true);
				}
			});
	
			// move
			$('.move-btn').on('click', function() {
				var move_files = $('ul.grid .selected figure').map(function(){return $(this).attr('data-name');}).get();
				if (move_files != '') {
					prependModal();
					$('#modalBox').modal({
						overlayClose: false, position: [65], opacity: 70,
						onOpen: function(dialog) { openModal(dialog) },
						onShow:  function(dialog) {
							var modal = this;
							modalMove(modal, dialog, move_files);
						},
						onClose: function(dialog) { closeModal(dialog) }
					});
				} else {
					confirm('Please select the file(s) to move', '', true);
				}
			});
		});

		//dropzone config
		window.Dropzone.options.myAwesomeDropzone = {
			dictInvalidFileType: 'File extension is not allowed.',
			dictFileTooBig: 'The uploaded file exceeds the max size allowed.',
			dictResponseError: 'SERVER ERROR',
			paramName: 'file', // The name that will be used to transfer the file
			maxFilesize: maxSizeUpload, // MB
			addRemoveLinks: true,
			//previewsContainer: '#dropzone-preview';
			url: js_site_url + 'admin/image_manager/upload',
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

		function prependModal() {
			var html = '';
			html += '<div class="form-box">';
			html += '	<div class="form-header"><h4 class="title"></h4></div>';
			html += '	<div class="form-content"></div>';
			html += '	<div class="form-footer">';
			html += '		<button type="submit" class="form-cancel form-button btn simplemodal-close" tabindex="1002">Cancel</button>';
			html += '		<button type="submit" class="form-ok form-button btn" tabindex="1003">OK</button>';
			html += '	</div>';
			html += '</div>';
			$('#modalBox').empty().prepend(html)
		}

		function openModal(dialog) {
			dialog.overlay.fadeIn(100, function () {
				dialog.container.fadeIn(100, function () {
					dialog.data.fadeIn(100, function () {
						$('.form-content #form-name', dialog.data[0]).focus();
					});
				});
			});
		}

		function closeModal(dialog) {
			dialog.data.fadeOut(100, function () {
				dialog.container.fadeOut(100, function () {
					dialog.overlay.fadeOut(100, function () {
						$.modal.close(); // must call this!
						$('#modalBox').empty();
						$('#previewBox').empty();
					});
				});
			});
		}

		function confirm(message, callback, cancel) {
			prependModal();
			$('#modalBox').modal({
				overlayClose: false, position: [65], opacity: 70,
				onShow: function(dialog) {
					var modal = this;
					$('.form-content', dialog.data[0]).append(message);
					if (cancel) {
						$('.form-footer .form-cancel').remove();
					}
					$('.form-ok', dialog.data[0]).click(function (e) {
						e.preventDefault();
						if ($.isFunction(callback)) {
							callback.apply();
						} else {
							modal.close();
						}
					});
				},
				onClose: function(dialog) { closeModal(dialog) }
			});
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

		function modalNewFolder(modal, dialog) {
			$('.title', dialog.data[0]).html('New Folder');
			$('.form-content', dialog.data[0]).html('<input type="text" id="folder-name" class="form-input" name="name" tabindex="1001" value="New Folder" />');
			$('#modalBox .form-ok').click(function(e) {
				e.preventDefault();
				var new_name = $('#folder-name').val();
				new_name = fixFilename(new_name);
				var sub_folder = $('#sub_folder').val();
				if (new_name !== null){
					$.ajax({
						type: 'POST',
						url: js_site_url + 'admin/image_manager/new_folder',
						data: {sub_folder: sub_folder, name: new_name},
						dataType: 'json',
						success: function(json) { showSuccess(json) }
					});
				}
			});
		}			

		function modalCopy(modal, dialog, copy_files) {
			$('.title', dialog.data[0]).html('Copy selected items to:');
			$('.form-content', dialog.data[0]).html('<select id="folder-path" class="form-input" tabindex="1001">' + $('#folders_list').html() + '</select><br /><font size="1">Existing file/folder will NOT be copied</font>');
			$('#modalBox .form-ok').on('click', function(e) {
				e.preventDefault();
				var from_folder = $('#sub_folder').val();
				var to_folder = $('#folder-path').val();
				if (to_folder !== null){
					if (to_folder != from_folder) {                                             
						$.ajax({
							type: 'POST',
							url: js_site_url + 'admin/image_manager/copy',
							data: {from_folder: from_folder, to_folder: to_folder, copy_files: JSON.stringify(copy_files)},
							dataType: 'json',
							success: function(json) { showSuccess(json) }
						});
					} else {
						modal.close();
					}
				}
			});
		}	

		function modalMove(modal, dialog, move_files) {
			$('.title', dialog.data[0]).html('Move selected items to:');
			$('.form-content', dialog.data[0]).html('<select id="folder-path" class="form-input" tabindex="1001">' + $('#folders_list').html() + '</select><br /><font size="1">Existing file/folder will NOT be moved</font>');
			$('#modalBox .form-ok').on('click', function(e) {
				e.preventDefault();
				var from_folder = $('#sub_folder').val();
				var to_folder = $('#folder-path').val();
				if (to_folder !== null){
					if (to_folder != from_folder) {                                             
						$.ajax({
							type: 'POST',
							url: js_site_url + 'admin/image_manager/move',
							data: {from_folder: from_folder, to_folder: to_folder, move_files: JSON.stringify(move_files)},
							dataType: 'json',
							success: function(json) { showSuccess(json) }
						});
					} else {
						modal.close();
					}
				}
			});
		}	

		function modalRename(modal, dialog, figure, f_name) {
			$('.title', dialog.data[0]).html('Rename');
			$('.form-content', dialog.data[0]).html('<input type="text" id="new-name" class="form-input" name="name" tabindex="1001" value="' + f_name + '" />');
			$('#modalBox .form-ok').on('click', function(e) {
				e.preventDefault();
				var data_path = $.trim(figure.attr('data-path'));
				var new_name = $('#new-name').val();
				new_name = fixFilename(new_name);
				if (new_name !== null){
					if (new_name != f_name) {                                             
						$.ajax({
							type: 'POST',
							url: js_site_url + 'admin/image_manager/rename',
							data: {data_path: data_path, name: new_name},
							dataType: 'json',
							success: function(json) { showSuccess(json) }
						});
					} else {
						modal.close();
					}
				}
			});
		}	

		function showSuccess(json) {
			var refresh_url = $('#refresh').attr('href');
			$('.error, .success').remove();
			if (json['alert']) {
				$('.form-content').html(json['alert']);
				$('.form-footer .form-ok').remove();
				$('.form-footer .form-cancel').html('Close');
				$('.error, .success, .form-cancel').fadeIn('slow');
				$('#modalBox .form-cancel').on('click', function(e) {
					//setTimeout(function() { 
						$.modal.close();
						window.location.href = refresh_url;
					//}, 1000);
				});				
			}
		}
		//--></script>
	</body>
</html>