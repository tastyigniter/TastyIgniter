<div id="content">
	<h2 align="center">UPDATE FOOD INFO (<?php echo $food_name; ?>)</h2>
	<hr>

	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" enctype="multipart/form-data">
	<table width="330" align="center">
	<tr>
		<td><b>Food Name:</b></td>
    	<td><input type="text" name="food_name" value="<?php echo set_value('food_name'), $food_name; ?>" id="name" class="textfield" /></td>
		<td></td>
    </tr>
    <tr>
    	<td><b>Food Price:</b></td>
	    <td><input type="text" name="food_price" value="<?php echo set_value('food_price'), $food_price; ?>" id="price" size="5" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
    	<td><b>Food Options: (multi-select)</b></td>
    	<td><select id="food-option" name="food_options[]" multiple="multiple" size="5" style="width:200px;">
		<?php foreach ($food_options as $food_option) { ?>
		<?php if (in_array($food_option['option_id'], $has_option_id)) { ?>
    		<option value="<?php echo $food_option['option_id']; ?>" selected="selected" /><?php echo $food_option['option_name']; ?> / <?php echo $food_option['option_price']; ?> </option>
		<?php } else { ?>
    		<option value="<?php echo $food_option['option_id']; ?>" /><?php echo $food_option['option_name']; ?> / <?php echo $food_option['option_price']; ?> </option>
		<?php } ?>
		<?php } ?>
		</select></td>
	</tr>
	<tr>
    	<td><b>Food Category:</b></td>
    	<td><select name="food_category" id="category">
    		<option value=""> - please select - </option>
		<?php foreach ($categories as $category) { ?>
		<?php if ($food_category == $category['category_id']) { ?>
    		<option value="<?php echo $category['category_id']; ?>" selected="selected">- <?php echo $category['category_name']; ?> - </option>
		<?php } else { ?>
    		<option value="<?php echo $category['category_id']; ?>">- <?php echo $category['category_name']; ?> - </option>
		<?php } ?>
		<?php } ?>
		</select></td>
		<td></td>
	</tr>
	<tr>
    	<td><b>Food Photo:</b></td>
    	<td><input type="file" name="food_photo" value="" id="photo"/><br />
    	<font size="1" color="red">(select a file to update food photo, otherwise don't update)</font></td>
		<td></td>
    </tr>
    <tr>
    	<td><b>Delete:</b></td>
    	<td><input type="checkbox" name="delete" value="1" /></td>
		<td></td>
    </tr>
    <tr>
    	<td><b>Action:</b></td>
    	<td><input type="submit" name="submit" value="Update" /></td>
		<td></td>
    </tr>
	</table>

</div>