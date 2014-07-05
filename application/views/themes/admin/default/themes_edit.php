<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#editor" data-toggle="tab">Editor</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="editor" class="tab-pane row theme-editor active">
					<?php if (!empty($file['heading'])){ ?>
						<h4 class="text-info editor-text"><?php echo $file['heading']; ?></h4>
					<?php } ?>
					
					<div class="row wrap-vertical">
						<div class="col-sm-3 wrap-none">
							<div class="theme-tree-holder wrap-vertical">
								<?php echo $theme_files; ?>
							</div>
						</div>
						<div class="col-sm-9 wrap-none">
							<a class="theme-tree-toggle"><i class="fa fa-angle-double-left"></i></a>
							<div class="theme-editor-holder">
								<?php if (!empty($file['type']) AND $file['type'] === 'file') { ?>
									<textarea name="editor_area" id="editor-area" class="form-control" rows="28"><?php echo $file['content']; ?></textarea>
								<?php } else if (!empty($file['type']) AND $file['type'] === 'img') { ?>
									<img class="center-block wrap-horizontal" alt="<?php echo $file['name']; ?>" src="<?php echo $file['content']; ?>" />
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	//$('.theme-tree-holder ul').find('ul').hide();
	
	// Expand/collapse on click
	$('.directory a').click( function() {
		$(this).parent().find("ul:first").slideToggle('medium');
		if ($(this).parent().attr('class') == 'directory') {
			return false;
		}
	});
	
	$('.theme-tree-toggle').click(function() {
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
		
	});
});
//--></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/codemirror/codemirror.css"); ?>">
<script src="<?php echo base_url("assets/js/codemirror/codemirror.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/codemirror/xml/xml.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/codemirror/css/css.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/codemirror/javascript/javascript.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/codemirror/php/php.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/codemirror/htmlmixed/htmlmixed.js"); ?>"></script>
<script type="text/javascript"><!--
if ($('#editor-area').val()) {
	var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor-area'), {
    	lineNumbers: true,
    	mode: "<?php echo $mode; ?>"
  	});
}
//--></script>
<?php echo $footer; ?>