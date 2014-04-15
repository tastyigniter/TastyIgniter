<div class="box">
	<div id="update-box" class="content">
	<h2>SEND MESSAGE</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table class="form">
		<tr>
			<td><b>From:</b></td>
			<td><select name="sender">
				<?php foreach ($locations as $location) { ?>
				<?php if ($location['location_id'] === $default_location_id) { ?>
					<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('sender', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
				<?php } else { ?>  
					<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('sender', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
				<?php } ?>  
				<?php } ?>  
			</select></td>
		</tr>
		<tr>
			<td><b>To:</b></td>
			<td><select name="receiver">
				<option value="customers">All Customers</option>
				<option value="staffs">All Staffs</option>
			</select></td>
		</tr>
		<tr>
			<td width="15%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="<?php echo set_value('subject'); ?>" class="textfield" size="40" /></td>
		</tr>
		<tr>
			<td><b>Text:</b></td>
			<td><textarea name="body" style="height:300px;width:800px;"><?php echo set_value('body'); ?></textarea></td>
		</tr>
  	</table>
	</form>

	</div>
</div>
<script src="<?php echo base_url("assets/js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript"><!--
window.onload = function() {
    CKEDITOR.replace('body');
    CKEDITOR.config.width = 800;
    CKEDITOR.config.height = 300;
    CKEDITOR.config.toolbar = [
		{ name: 'document', items: [ 'Source' ] },
		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'insert', items : [ 'Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];
};
//--></script>
