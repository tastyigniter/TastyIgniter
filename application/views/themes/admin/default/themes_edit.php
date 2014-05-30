<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#editor">Editor</a></li>
			</ul>
		</div>

		<div id="editor" class="wrap_content theme-editor" style="display:block;">
			<p><?php echo $text_file_heading; ?></p>
			<div class="theme-tree-holder">
				<?php echo $theme_files; ?>
			</div>
			
			<div class="editor">
				<?php echo $file_content; ?>
			</div>
		</div>
	</form>
	</div>
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

});

$(document).delegate('#editor', 'keydown', function(e) {
  var keyCode = e.keyCode || e.which;

  if (keyCode == 9) {
    e.preventDefault();
    var start = $(this).get(0).selectionStart;
    var end = $(this).get(0).selectionEnd;

    // set textarea value to: text before caret + tab + text after caret
    $(this).val($(this).val().substring(0, start)
                + "\t"
                + $(this).val().substring(end));

    // put caret at right position again
    $(this).get(0).selectionStart =
    $(this).get(0).selectionEnd = start + 1;
  }
});

$('#tabs a').tabs();
//--></script>