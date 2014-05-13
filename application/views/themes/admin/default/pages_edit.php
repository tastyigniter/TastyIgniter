<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">General</a></li>
				<li><a rel="#content-f">Content</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Title:</b></td>
						<td><input type="text" name="title" value="<?php echo set_value('title', $page_title); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Heading:</b></td>
						<td><input type="text" name="heading" value="<?php echo set_value('heading', $page_heading); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Meta Description:</b></td>
						<td><textarea name="meta_description" rows="5" cols="45"><?php echo set_value('meta_description', $meta_description); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Meta Keywords:</b></td>
						<td><textarea name="meta_keywords" rows="5" cols="45"><?php echo set_value('meta_keywords', $meta_keywords); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Layout:</b></td>
						<td><select name="layout_id">
							<option value="0">None</option>
							<?php foreach ($layouts as $layout) { ?>
							<?php if ($layout['layout_id'] === $layout_id) { ?>
								<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
							<?php } else { ?>  
								<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
							<?php } ?>  
							<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Language:</b></td>
						<td><select name="language_id">
							<?php foreach ($languages as $language) { ?>
							<?php if ($language['language_id'] === $language_id) { ?>
								<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
							<?php } else { ?>  
								<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
							<?php } ?>  
							<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="status">
							<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
						<?php if ($status === '1') { ?>
							<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="content-f" class="wrap_content" style="display:none;">
			<table class="">
				<tbody>
					<tr>
						<td><textarea name="content" id="page-content" style="height:300px;width:1010px;"><?php echo set_value('content', $content); ?></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>
<script src="<?php echo base_url("assets/js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript"><!--
window.onload = function() {
    CKEDITOR.replace('page-content', {
    	width: '1010'
	});
};
$('#tabs a').tabs();
//--></script>