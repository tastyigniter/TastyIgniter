<div class="content">
<div id="write-review">
<div class="box-close"><a title="" onclick="closeReviewBox();" class="close-button">X</a></div>
	<div id="review-notification"></div>
	<?php if (isset($error)) { ?>
		<p class="error"><?php echo $error; ?></p>
	<?php } else { ?>
	<table cellpadding="2" border="0" width="100%" align="center" id="review-form">
    	<tr>
        	<td colspan="2" align="center"><h2><?php echo $text_write_review; ?></h2></td>
        </tr>
  		<tr>
    		<td align="right"><label for="menu_name"><?php echo $entry_menu_name; ?></label></td>
    		<td><b><?php echo $menu_name; ?></b><input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" /></td>
		</tr>
  		<tr>
    		<td align="right"><label for="customer_name"><?php echo $entry_customer_name; ?></label></td>
    		<td><b><?php echo $customer_name; ?></b><input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /></td>
		</tr>
  		<tr>
    		<td align="right"><label for="rating_id"><?php echo $entry_rating; ?></label></td>
    		<td><select name="rating_id">
			<?php foreach ($ratings as $key => $value) { ?>
    			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
			<?php }?>
    		</select></td>
		</tr>
  		<tr>
    		<td align="right"><label for="review_text"><?php echo $entry_rating_text; ?></label></td>
    		<td><textarea name="review_text" style="width:250px;height:100px"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><button class="cart" onclick="addReview('#review-form')"><?php echo $button_add_review; ?></button></td>
		</tr>
	</table>
	<?php } ?>
</div>
</div>
<script type="text/javascript">
</script> 