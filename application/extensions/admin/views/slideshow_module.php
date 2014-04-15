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
			<tr>
				<td><b>Name:</b></td>
				<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
			</tr>
			<tr>
				<td><span class="red">*</span><b>Dimension:</b><br />
				<font size="1">(H x W)</font></td>
				<td><input type="text" name="dimension_h" value="<?php echo $dimension_h; ?>" class="textfield" size="5" /> x 
					<input type="text" name="dimension_w" value="<?php echo $dimension_w; ?>" class="textfield" size="5" /></td>
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
			</table>
		</div>

		<div id="images" class="wrap_content" style="display:none;">
			<table align=""class="list">
			<?php $image_row = 0; ?>
			<?php foreach ($images as $image) { ?>
			<tr id="image-row<?php $image_row; ?>">
				<td><div class="imagebox">
					<div class="preview"><img src="<?php echo $image['preview']; ?>" class="thumb" id="thumb<?php echo $image_row; ?>"></div>
					<div class="select">
						<input type="hidden" name="images[<?php echo $image_row; ?>]" value="<?php echo $image['input']; ?>" id="field<?php echo $image_row; ?>" />
						<center class="name"><?php echo $image['name']; ?></center><br />
						<a class="button imagebox-btn" onclick="imageUpload('field<?php echo $image_row; ?>');">Select Image</a>
						<a class="button" onclick="$('#thumb<?php echo $image_row; ?>').attr('src', '<?php echo $no_photo; ?>'); $('#field<?php echo $image_row; ?>').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');">Remove Image</a>
					</div>
				</div></td>
				<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>
			</tr>
			<?php $image_row++; ?>
			<?php } ?>  
			<tr id="image-tfoot">
				<td colspan=""></td>
				<td class="right"><img src="<?php echo base_url('assets/img/add32x32.png'); ?>" onclick="addImage();" /></td>
			</tr>		 
			</table>
		</div>

		<div id="layouts" class="wrap_content" style="display:none;">
			<table align=""class="list">
			<tr>
				<th><b>Layout:</b></th>
				<th><b>Position:</b></th>
				<th><b>Priority:</b></th>
				<th><b>Status:</b></th>
				<th class="right"><b>Action:</b></th>
			</tr>
			<?php $table_row = 0; ?>
			<?php foreach ($modules as $module) { ?>
			<tr id="module-row<?php echo $table_row; ?>">
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
				<td><select name="modules[<?php echo $table_row; ?>][status]">
					<option value="0" >Disabled</option>
				<?php if ($module['status'] === '1') { ?>
					<option value="1" selected="selected">Enabled</option>
				<?php } else { ?>  
					<option value="1" >Enabled</option>
				<?php } ?>  
				</select></td>
				<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>
			</tr>
			<?php $table_row++; ?>
			<?php } ?>  
			<tr id="tfoot">
				<td colspan="4"></td>
				<td class="right"><img src="<?php echo base_url('assets/img/add32x32.png'); ?>" onclick="addModule();" /></td>
			</tr>		 
			</table>
		</div>

	</form>
	</div>
</div>
<script src="<?php echo base_url("assets/js/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url + 'admin/image_manager?popup=&field_id=' + encodeURIComponent(field);

	$('#container').prepend('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="780" height="550" frameborder="0"></iframe></div>');
	
	$('.imagebox-btn').fancybox({	
		width: 900,
		height: 600,
 		href:"#image-manager",
		autoScale: false
	});
};
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {	
	html  = '<tr id="image-row' + image_row + '">';
	html += '	<td><div class="imagebox"><div class="preview">';
	html += '		<img src="<?php echo $no_photo; ?>" class="thumb" id="thumb' + image_row + '" />';
	html += '	</div><div class="select">';
	html += '		<input type="hidden" name="images[' + image_row + ']" value="data/no_photo.png" id="field' + image_row + '" /><center class="name">no_photo.png</center><br />';
	html += '		<a class="button imagebox-btn" onclick="imageUpload(\'field' + image_row + '\');">Select Image</a>';
	html += '		<a class="button" onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_photo; ?>\'); $(\'#field' + image_row + '\').attr(\'value\', \'data/no_photo.png\'); $(this).parent().parent().find(\'center\').html(\'no_photo.png\');">Remove Image</a>';
	html += '	</div></td>';
	html += '	<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#image-tfoot').before(html);
	
	image_row++;
}
//--></script>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addModule() {	
	html  = '<tr id="module-row' + table_row + '">';
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
	html += '   <td><select name="modules[' + table_row + '][status]">';
    html += '      <option value="1">Enabled</option>';
    html += '      <option value="0">Disabled</option>';
    html += '   </select></td>';
	html += '	<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
	table_row++;
}

$('#tabs a').tabs();

//--></script> 