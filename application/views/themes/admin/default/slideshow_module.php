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
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a class="active" rel="#general">General</a></li>
				<li><a rel="#images">Images</a></li>
				<li><a rel="#layouts">Layouts</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tbody> 
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><span class="red">*</span><b>Dimension:</b><br />
						<font size="1">(H x W)</font></td>
						<td><input type="text" name="dimension_h" value="<?php echo $dimension_h; ?>" class="mini" size="5" /> x 
							<input type="text" name="dimension_w" value="<?php echo $dimension_w; ?>" class="mini" size="5" /></td>
					</tr>
					<tr>
						<td><span class="red">*</span><b>Effect</b></td>
						<td><select name="effect">
						<?php foreach ($effects as $key => $value) { ?>
						<?php if ($value === $effect) { ?>
							<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Transition Speed:</b><br />
						<font size="1">(Slide transition speed)</font></td>
						<td><input type="text" name="speed" value="<?php echo set_value('speed', $speed); ?>" size="5" class="textfield" /></td>
					</tr>
				</tbody> 
			</table>
		</div>

		<div id="images" class="wrap_content" style="display:none;">
			<ul class="sorted_image">
				<?php $image_row = 0; ?>
				<?php foreach ($images as $image) { ?>
				<li id="image-row<?php echo $image_row; ?>">
					<div class="imagebox">
						<div class="preview"><img src="<?php echo $image['preview']; ?>" class="thumb" id="thumb<?php echo $image_row; ?>"></div>
						<div class="select">
							<input type="hidden" name="images[<?php echo $image_row; ?>]" value="<?php echo $image['input']; ?>" id="field<?php echo $image_row; ?>" />
							<center class="name"><?php echo $image['name']; ?></center>
							<a class="button select-image" onclick="imageUpload('field<?php echo $image_row; ?>');">Select</a>
							<a class="button remove-image"  onclick="$(this).parent().parent().parent().remove();">Remove</a>
						</div>
					</div>
				</li>
				<?php $image_row++; ?>
				<?php } ?>  
				<li id="add-image">
					<a class="add-image" onclick="addImage();"><i class="icon icon-add"></i></a>
				</li>		 
			</ul>
		</div>

		<div id="layouts" class="wrap_content" style="display:none;">
			<table class="list sorted_table">
				<thead> 
					<tr>
						<th class="action action-one"></th>
						<th>Layout</th>
						<th>Position</th>
						<th>Priority</th>
						<th>Status</th>
					</tr>
				</thead> 
				<tbody> 
					<?php $table_row = 0; ?>
					<?php foreach ($modules as $module) { ?>
					<tr id="module-row<?php echo $table_row; ?>">
						<td class="action action-one"><a onclick="$(this).parent().parent().remove();"><i class="icon icon-delete"></i></a></td>
						<td><select name="modules[<?php echo $table_row; ?>][layout_id]">
						<?php foreach ($layouts as $layout) { ?>
						<?php if ($layout['layout_id'] === $module['layout_id']) { ?>
							<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
						<td><select name="modules[<?php echo $table_row; ?>][position]">
							<?php if ($module['position'] === 'top') { ?>
								<option value="top" selected="selected">Top</option>
							<?php } else { ?>  
								<option value="top" selected="selected">Top</option>
							<?php } ?>  
						</select></td>
						<td><input type="text" name="modules[<?php echo $table_row; ?>][priority]" value="<?php echo $module['priority']; ?>" size="5" /></td>
						<td class="center"><select name="modules[<?php echo $table_row; ?>][status]">
							<option value="0" >Disabled</option>
						<?php if ($module['status'] === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
						<?php } else { ?>  
							<option value="1" >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
					<?php $table_row++; ?>
					<?php } ?>  
				</tbody> 
				<tfoot> 
					<tr id="tfoot">
						<td class="action action-one"><i class="icon icon-add" onclick="addModule();"></i></td>
						<td colspan="4"></td>
					</tr>		 
				</tfoot> 
			</table>
		</div>

	</form>
	</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url('admin/image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('#container').prepend('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="980" height="550" frameborder="0"></iframe></div>');
	
	$('.select-image').fancybox({	
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('admin/image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb" />');
					}
				});
			}
		}
	});
};
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {	
	html  = '<li id="image-row' + image_row + '">';
	html += '	<div class="imagebox"><div class="preview">';
	html += '		<img src="<?php echo $no_photo; ?>" class="thumb" id="thumb' + image_row + '" />';
	html += '	</div>';
	html += '	<div class="select">';
	html += '		<input type="hidden" name="images[' + image_row + ']" value="data/no_photo.png" id="field' + image_row + '" />';
	html += '		<center class="name">no_photo.png</center>';
	html += '		<a class="button select-image" onclick="imageUpload(\'field' + image_row + '\');">Select</a>';
	html += '		<a class="button remove-image" onclick="$(this).parent().parent().parent().remove();">Remove</a>';
	html += '	</div>';
	html += '</li>';
	
	$('.sorted_image #add-image').before(html);
	
	image_row++;
}
//--></script>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addModule() {	
	html  = '<tr id="module-row' + table_row + '">';
	html += '	<td class="action action-one"><a onclick="$(this).parent().parent().remove();"><i class="icon icon-delete"></i></a></td>';
    html += '<td><select name="modules[' + table_row + '][layout_id]">';
		<?php foreach ($layouts as $layout) { ?>
			html += '<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
		<?php } ?>  
    html += '</select></td>';
    html += '<td><select name="modules[' + table_row + '][position]">';    
		html += '<option value="right">Right</option>';
		html += '<option value="left">Left</option>';
		html += '<option value="top">Top</option>';
    html += '</select></td>';    
	html += '	<td><input type="text" name="modules[' + table_row + '][priority]" value="" size="5" /></td>';
	html += '   <td class="center"><select name="modules[' + table_row + '][status]">';
    html += '      <option value="1">Enabled</option>';
    html += '      <option value="0">Disabled</option>';
    html += '   </select></td>';
	html += '</tr>';
	
	$('.sorted_table tbody').append(html);
	
	table_row++;
}

$('#tabs a').tabs();

//--></script> 