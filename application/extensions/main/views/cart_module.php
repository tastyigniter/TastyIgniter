<div class="img_inner">
<div id="cart-box">
	<h3><?php echo $text_your_order; ?></h3>
	<div id="cart-alert"><?php echo $cart_alert; ?></div>

	<div id="cart-info">
	<?php if ($cart_items) {?>
    <div style="display:none;">
    <table width="100%" height="auto" class="list">
        <tr>
			<th></th>
			<th width="55%" class="left"><?php echo $column_menu; ?></th>
			<!--<th><?php echo $column_price; ?></th>-->
			<th><?php echo $column_total; ?></th>
			<th></th>
        </tr>
    </table>
    </div>
    
    <div class="cart-info">
    <table width="100%" height="auto" class="list">
		<?php foreach ($cart_items as $cart_item) { ?>
		<tr id="<?php echo $cart_item['rowid']; ?>">
			<td width="1"><?php echo $cart_item['qty']; ?>x<br />
			<td width="55%" class="left"><?php echo $cart_item['name']; ?><br />
			<?php if (!empty($cart_item['options'])) { ?>
				<div><font size="1">+ <?php echo $cart_item['options']['name']; ?> : <?php echo $cart_item['options']['price']; ?></font></div>
			<?php } ?>
			</td>
			<!--<td><?php echo $cart_item['price']; ?></td>-->
			<td><?php echo $cart_item['sub_total']; ?></td>
			<td><img class="delete_cart" alt="Remove" src="<?php echo base_url('assets/img/delete-menu.png'); ?>" onClick="updateCart('<?php echo $cart_item['menu_id']; ?>', '<?php echo $cart_item['rowid']; ?>', '0');"/></td>
		</tr>
		<?php } ?>
    </table>
    </div>
   
    <div class="cart-coupon">
    <table width="100%" height="auto" class="list">
		<tr>
			<td class="right"><input type="text" name="coupon" value="<?php echo $coupon_code; ?>" placeholder="<?php echo $text_apply_coupon; ?>" /></td>
			<td><a class="button2" onclick="applyCoupon();"><?php echo $button_coupon; ?></a></td>
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
			<td class="right"><img onclick="clearCoupon();" src="<?php echo base_url('assets/img/delete.svg'); ?>" />
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
</div>