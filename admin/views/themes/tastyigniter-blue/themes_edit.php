<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#customize" data-toggle="tab">Customize</a></li>
				<li><a href="#edit-source" data-toggle="tab">Edit Source</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="customize" class="tab-pane theme-sections clearfix active">
				    <?php if ($sections) { ?>
						<div class="col-sm-2 wrap-none">
							<ul class="nav nav-tabs nav-stacked" role="tablist">
								<?php $section_row = 1; ?>
				    			<?php foreach ($sections as $key => $section) { ?>
									<?php if ($section_row === 1) { ?>
										<li class="active"><a href="#section-<?php echo $key; ?>" data-toggle="tab"><?php echo $section['title']; ?></a></li>
				    				<?php } else { ?>
										<li><a href="#section-<?php echo $key; ?>" data-toggle="tab"><?php echo $section['title']; ?></a></li>
				    				<?php } ?>
				    				<?php $section_row++; ?>
				    			<?php } ?>
				    		</ul>
						</div>
						<div class="col-sm-10 wrap-veritcal">
							<div class="tab-content">
								<?php $section_row = 1; ?>
				    			<?php foreach ($sections as $key => $section) { ?>
									<div id="section-<?php echo $key; ?>" class="tab-pane <?php echo ($section_row === 1) ? 'active' : ''; ?>">
				    					<h4 class="section-heading"><?php echo $section['title']; ?></h4>
				    					<p><?php echo $section['desc']; ?></p><br />
				    					<?php foreach ($section['fields'] as $field) { ?>
					    					<div class="form-group">
												<label class="col-sm-3 control-label" for="input-<?php echo $field['id']; ?>"><?php echo $field['label']; ?>
													<?php if (isset($field['desc'])) { ?>
														<span class="help-block"><?php echo $field['desc']; ?></span>
													<?php } ?>
												</label>
												<div class="col-sm-6">
													<?php echo $field['control']; ?>
													<?php if (isset($field['name']) AND is_string($field['name'])) { ?>
														<?php echo isset($error_fields[$field['name']]) ? $error_fields[$field['name']] : ''; ?>
													<?php } else if (is_array($field['name'])) { ?>
														<?php foreach ($field['name'] as $field_name) { ?>
															<?php echo isset($error_fields[$field_name]) ? $error_fields[$field_name] : ''; ?>
														<?php } ?>
													<?php } ?>
												</div>
											</div>
					    				<?php } ?>
				    					<?php if (isset($section['table'])) { ?>
				    						<?php echo $section['table']; ?>
					    				<?php } ?>
				    				</div>
				    				<?php $section_row++; ?>
				    			<?php } ?>
							</div>
						</div>
				    <?php } ?>
				</div>

				<div id="edit-source" class="tab-pane row theme-editor">
					<?php if (!empty($file['heading'])){ ?>
						<h4 class="text-info editor-text"><?php echo $file['heading']; ?></h4>
					<?php } ?>

					<div class="">
						<div class="col-sm-9 wrap-none wrap-left">
							<!--<a class="theme-tree-toggle"><i class="fa fa-angle-double-left"></i></a>-->
							<div class="theme-editor-holder">
								<?php if (!empty($file['type']) AND $file['type'] === 'file') { ?>
									<textarea name="editor_area" id="editor-area" class="form-control" rows="28"><?php echo $file['content']; ?></textarea>
								<?php } else if (!empty($file['type']) AND $file['type'] === 'img') { ?>
									<img class="center-block wrap-horizontal" alt="<?php echo $file['name']; ?>" src="<?php echo $file['content']; ?>" />
								<?php } else { ?>
									<div class="jumbotron">
										<h4>Select a File!</h4>
										<p>You can select from a number of options to alter the look of your theme. The Theme Editor supports Source files, image files and font files.</p>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-sm-3 wrap-none wrap-right">
							<div class="metisHolder">
								<?php echo $theme_files; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/colorpicker/css/bootstrap-colorpicker.min.css"); ?>">
<script src="<?php echo root_url("assets/js/colorpicker/js/bootstrap-colorpicker.min.js"); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/codemirror/codemirror.css"); ?>">
<script src="<?php echo root_url("assets/js/codemirror/codemirror.js"); ?>"></script>
<script src="<?php echo root_url("assets/js/codemirror/xml/xml.js"); ?>"></script>
<script src="<?php echo root_url("assets/js/codemirror/css/css.js"); ?>"></script>
<script src="<?php echo root_url("assets/js/codemirror/javascript/javascript.js"); ?>"></script>
<script src="<?php echo root_url("assets/js/codemirror/php/php.js"); ?>"></script>
<script src="<?php echo root_url("assets/js/codemirror/htmlmixed/htmlmixed.js"); ?>"></script>
<script type="text/javascript"><!--
if ($('#editor-area').val()) {
	var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor-area'), {
    	lineNumbers: true,
    	mode: "<?php echo $mode; ?>"
  	});
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php if (!empty($file)) { ?>
		$('#nav-tabs a[href="#edit-source"]').tab('show');
	<?php } else { ?>
		$('#nav-tabs a[href="#customize"]').tab('show');
	<?php } ?>

	$('.ti-color-picker').colorpicker();
	//$('.theme-tree-holder ul').find('ul').hide();

	// Expand/collapse on click
	$('.directory a').click( function() {
		$(this).parent().find("ul:first").slideToggle('medium');
		if ($(this).parent().attr('class') == 'directory') {
			return false;
		}
	});

	$('.metisFolder').metisMenu({
		toggle: false
	});

	/*$('.theme-tree-toggle').click(function() {
		var theme_holder = $('.theme-tree-holder').parent();
		var theme_editor = $('.theme-editor-holder').parent();

		theme_holder.toggle('slide', function() {
			if (theme_holder.is(':visible')) {
				$('#editor').removeClass('theme-editor-wide');
				theme_editor.removeClass('col-sm-12').addClass('col-sm-9');
				theme_editor.removeClass('wrap-vertical').addClass('wrap-none');
				$('.theme-tree-toggle .fa').removeClass('fa-angle-double-right').addClass('fa-angle-double-left');
			} else {
				$('#editor').addClass('theme-editor-wide');
				theme_editor.removeClass('col-sm-9').addClass('col-sm-12');
				theme_editor.removeClass('wrap-none').addClass('wrap-vertical');
				$('.theme-tree-toggle .fa').removeClass('fa-angle-double-left').addClass('fa-angle-double-right');
			}
		});

	});*/
});
//--></script>
<script src="<?php echo root_url("assets/js/jquery-sortable.js"); ?>"></script>
<script type="text/javascript"><!--
$(function  () {
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="4"></td></tr>',
		handle: '.handle'
	})
})
//--></script>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo root_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();

	var iframe_url = js_site_url('image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('body').append('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="980" height="550" frameborder="0"></iframe></div>');

	$.fancybox({
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')) + '&width=28&height=28',
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb img-responsive" id="' + field + '-thumb" width="28" />');
					}
				});
			}
		}
	});
};
//--></script>

<?php echo $footer; ?>