<div class="content">
	<div class="img_inner">
		<h3><?php echo $text_write_review; ?></h3>
	</div>
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<div class="img_inner">
		<?php if ($error) { ?>
			<?php echo $error; ?>
		<?php } else { ?>
		<table cellpadding="2" border="0" width="100%" align="center" class="form">
			<tr>
				<td><label for="restaurant"><?php echo $entry_restaurant; ?></label></td>
				<td><input type="hidden" name="location_id" value="<?php echo $location_id; ?>" <?php echo set_value('location_id', $location_id); ?> />
					<?php echo $restaurant_name; ?>
				</td>
			</tr>
			<tr>
				<td><label for="customer_name"><?php echo $entry_customer_name; ?></label></td>
				<td><b><?php echo $customer_name; ?></b><input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /></td>
			</tr>
			<tr>
				<td><label for="rating_id"><?php echo $entry_quality; ?></label></td>
				<td><select name="quality">
				<?php foreach ($ratings as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php echo set_select('quality', $key); ?>><?php echo $value; ?></option>
				<?php }?>
				</select><br />
    			<?php echo form_error('quality', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
				<td><label for="rating_id"><?php echo $entry_delivery; ?></label></td>
				<td><select name="delivery">
				<?php foreach ($ratings as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php echo set_select('delivery', $key); ?>><?php echo $value; ?></option>
				<?php }?>
				</select><br />
    			<?php echo form_error('delivery', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
				<td><label for="rating_id"><?php echo $entry_service; ?></label></td>
				<td><select name="service">
				<?php foreach ($ratings as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php echo set_select('service', $key); ?>><?php echo $value; ?></option>
				<?php }?>
				</select><br />
    			<?php echo form_error('service', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
				<td><label for="review_text"><?php echo $entry_review; ?></label></td>
				<td><textarea name="review_text" style="width:400px;height:200px"><?php echo set_value('review_text'); ?></textarea><br />
    			<?php echo form_error('review_text', '<span class="error">', '</span>'); ?></td>
			</tr>
		</table>
		<?php } ?>
	</div>
	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
		<div class="right"><input type="submit" name="submit" value="<?php echo $button_review; ?>" /></div>
	</div>
	</form>
</div>