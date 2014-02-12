<div id="cart-box">
	<h3><?php echo $text_your_order; ?></h3>
	<div id="cart-alert"><?php echo $cart_alert; ?></div>

	<div id="cart-info">
	<?php if ($cart_items) {?>
    <div>
    <table width="100%" height="auto" class="list">
        <tr>
			<th class="menu_name"><?php echo $column_menu; ?></th>
			<th><?php echo $column_price; ?></th>
			<th><?php echo $column_qty; ?></th>
			<th><?php echo $column_total; ?></th>
        </tr>
    </table>
    </div>
    
    <div class="cart-info">
    <table width="100%" height="auto" class="list">
		<?php foreach ($cart_items as $cart_item) { ?>
		<tr id="<?php echo $cart_item['key']; ?>">
			<td class="food_name"><?php echo $cart_item['name']; ?><br />
			<?php if ($this->cart->has_options($cart_item['key']) == TRUE) { ?>
				<?php foreach ($this->cart->product_options($cart_item['key']) as $option_name => $option_value) { ?>
				<div><font size="1"><strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?> </font></div>
			<?php } ?>
			<?php } ?>
			</td>
			<td><?php echo $cart_item['price']; ?></td>
			<td><select name="quantity[<?php echo $cart_item['key']; ?>]" onChange="updateCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['key']; ?>');">
				<?php foreach ($quantities as $key => $value) { ?>
				<?php if ($value === $cart_item['qty']) { ?>
					<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
				<?php } else { ?>
					<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php } ?>
				<?php } ?>
			</select></td>
			<td><?php echo $cart_item['sub_total']; ?></td>
		</tr>
		<?php } ?>
    </table>
    </div>
   
    <div class="cart-coupon">
    <p style="text-align:center;"><b><?php echo $text_apply_coupon; ?></b></p>
    <table width="100%" height="auto" class="list">
		<tr>
			<td class="right"><input type="text" name="coupon" value="<?php echo $coupon_code; ?>" size="" /></td>
			<td><a class="button" onclick="applyCoupon();"><?php echo $button_coupon; ?></a></td>
		</tr>
    </table>
    </div>

    <div class="cart-total">
    <table width="100%" height="auto" class="list">
		<?php if (!empty($sub_total)) { ?>
		<tr>
			<td class="right"><b><?php echo $text_sub_total; ?>:</b> <?php echo $sub_total; ?></td>
		</tr>
		<?php } ?>
		<?php if (!empty($coupon)) { ?>
		<tr>
			<td class="right"><img onclick="clearCoupon();" src="<?php echo base_url('assets/img/delete.png'); ?>" />
			<b><?php echo $text_coupon; ?>:</b> -<?php echo $coupon; ?></td>
		</tr>
		<?php } ?>
		<?php if (!empty($delivery)) { ?>
		<tr>
			<td class="right"><b><?php echo $text_delivery; ?>:</b> <?php echo $delivery; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td class="right"><b><?php echo $text_order_total; ?>:</b> <?php echo $order_total; ?></td>
		</tr>
	</table>
    </div>
	<?php } else { ?>
		<p><?php echo $text_no_cart_items; ?></p>
	<?php } ?>
    </div>
</div>