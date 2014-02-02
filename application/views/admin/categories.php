<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD NEW CATEGORY</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="category_name" value="<?php echo set_value('category_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Description:</b></td>
			<td><textarea name="category_description" rows="7" cols="50"><?php echo set_value('category_description'); ?></textarea></td>
		</tr>
	</table>
	</form>
	</div>

	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>Description</th>
			<th class="right">Action</th>			
		</tr>
		<?php if ($categories) { ?>
		<?php foreach ($categories as $category) { ?>
		<tr>
			<td class="delete"><input type="checkbox" name="delete[]" value="<?php echo $category['category_id']; ?>" /></td>  
			<td><?php echo $category['category_name']; ?></td>
			<td><?php echo $category['category_description']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $category['edit']; ?>"></a></td>
		</tr>

		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8">There are no categories added to your database.</td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
