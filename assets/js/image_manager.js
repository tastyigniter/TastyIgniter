$(document).ready(function(){
    
	//$("body").queryLoader2({ 'backgroundColor':'none','minimumTime':100,'percentage':true});

	$.contextMenu({
		selector:'figure.selected:not(.back), figure.selected:not(.back)',
		trigger: 'right',
		autoHide: false,
		zIndex: 9999,
		build: function($trigger) {
			var figure = $trigger;
			//figure.addClass('selected');
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
					case 'rename':
						var f_name = $.trim(figure.attr('data-name'));
						prependModal();
						$('#modalBox').modal({
							overlayClose: true, position: [65], opacity: 70,
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

			options.items.duplicate = {name: 'Duplicate', icon: 'duplicate', disabled: false};
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

	$('.grid').on('contextmenu', function(e) {
		if (!$(e.target).is("figure")) {
			e.preventDefault();
		}
	});	
    
    //upload
    $('.upload-btn').on('click', function() {
	    $('.uploader-box').slideDown(500);
    });
    
    //upload close
    $('.close-uploader').on('click',function() {
	    $('.uploader-box').slideUp(500, function() {
	    	window.location.href = $('#refresh').attr('href') + '&' + new Date().getTime();
	    });
    });
    
    //dropdown
	$('.dropdown-toggle').on('click', function() {
		if ($('.dropdown-menu').is(':visible')) {
			$('.dropdown-menu').fadeOut();
			$('.dropdown-toggle').removeClass('open');
		} else {
			$('.dropdown-menu').fadeIn();
			$('.dropdown-toggle').addClass('open');
		}
	});	

    //new folder
    $('.new-folder').on('click', function() {
		prependModal();
		$('#modalBox').modal({
			overlayClose: true, position: [65], opacity: 70,
			onOpen:  function(dialog) { openModal(dialog) },
			onShow:  function(dialog) {
				var modal = this;
				modalNewFolder(modal, dialog);
			},
			onClose: function(dialog) { closeModal(dialog) }
		});
    });

	// move
    $('.move').on('click', function() {
		var move_files = $('ul.grid figure.selected').map(function(){return $(this).attr('data-name');}).get();
		if (move_files != '') {
			prependModal();
			$('#modalBox').modal({
				overlayClose: true, position: [65], opacity: 70,
				onOpen: function(dialog) { openModal(dialog) },
				onShow:  function(dialog) {
					var modal = this;
					modalMove(modal, dialog, move_files);
				},
				onClose: function(dialog) { closeModal(dialog) }
			});
		} else {
			confirm('Please select the files to move', '', true);
		}
	});
	
	$('ul.grid .directory .link').on('click', function(e) {
		e.preventDefault();
	});

	$('ul.grid .directory .link').on('dblclick', function(e) {
		window.location.replace($(this).attr('href'));
	});

	$('ul.grid .file .link').on('dblclick', function() {
		var field = parent.$('#' + $('#field_id').val());
		var figure = $(this).parent();
		var file_path = figure.find('#file-path').val()
		var file_name = figure.attr('data-name');
		var file_src = figure.find('.img-container img').attr('src');
		var thumb = field.parent().parent().find('.thumb');
		var thumb_name = field.parent().parent().find('.name');
		
		field.attr('value', file_path + file_name);
		thumb.attr('src', file_src);
		thumb_name.html(file_name);

		if(typeof parent.$.fancybox == 'function') {
			parent.$.fancybox.close();
			parent.$('#image-manager').empty();
		}
	});

	$('ul.grid .link').on('click', function(e) {
		var _this = $(this);
	  	
	  	if (e.ctrlKey || e.metaKey) {
			if (_this.parent().hasClass('selected')) {
				_this.removeClass('selected');
			}
	  	} else {
			$('ul.grid figure').removeClass('selected');
		}

		_this.parent().addClass('selected');
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

function modalMove(modal, dialog, move_files) {
	$('.title', dialog.data[0]).html('Move selected items to:');
	$('.form-content', dialog.data[0]).html('<select id="folder-path" class="form-input" tabindex="1001">' + $('#move_folders').html() + '</select>');
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
		$('.error, .success, .form-cancel').fadeIn('slow', function() {
			setTimeout(function() { 
				$.modal.close();
				window.location.href = refresh_url;
			}, 1000);
		});				
	}
}

function executeAction(action, data_path, new_name, old_name) {
    if (new_name !== null) {
		var refresh_url = $('#refresh').attr('href');
		new_name = fixFilename(new_name);
		//old_name = fixFilename(old_name);
		
		$.ajax({
			type: 'POST',
			url: js_site_url + 'admin/image_manager/' + action,
			data: {data_path: data_path, old_name: old_name, name: new_name},
			dataType: 'json',
			success: function(json) {
				$('.error, .success').remove();

				if (json['alert']) {
					$('.form-content').html(json['alert']);
					$('.form-footer .form-ok').remove();
					$('.form-footer .form-cancel').html('Close');

					$('.error, .success, .form-cancel').fadeIn('slow', function() {
						setTimeout(function() { 
							$.modal.close();
							//window.location.href = refresh_url;
						}, 1000);
					});				
				}
			}
		});
    }
}