<div class="content">
	<div class="account_summary">
  	<table align="left">
  		<tr>
		<td><h4><?php echo $text_my_details; ?></h4></td>
  		<td align="right"><a class="" href="<?php echo site_url('account/details'); ?>"><?php echo $text_edit; ?></a></td>
  		</tr>
  		<?php if ($customer_info) { ?>
  		<tr>
  			<td><b><?php echo $entry_first_name; ?></b></td>
  			<td><?php echo $customer_info['first_name']; ?></td>
  		</tr>
  		<tr>
  			<td><b><?php echo $entry_last_name; ?></b></td>
  			<td><?php echo $customer_info['last_name']; ?></td>
  		</tr>
  		<tr>
  			<td><b><?php echo $entry_email; ?></b></td>
  			<td><?php echo $customer_info['email']; ?></td>
  		</tr>
  		<tr>
  			<td><b><?php echo $entry_password; ?></b></td>
  			<td><a href="<?php echo site_url('account/details'); ?>"><?php echo $text_password; ?></a></td>
  		</tr>
  		<tr>
  			<td><b><?php echo $entry_telephone; ?></b></td>
  			<td><?php echo $customer_info['telephone']; ?></td>
  		</tr>
  		<tr>
  			<td><b><?php echo $entry_s_question; ?></b></td>
  			<td><?php echo $customer_info['security_question']; ?></td>
  		</tr>
  		<tr>
  			<td><b><?php echo $entry_s_answer; ?></b></td>
  			<td><?php echo $customer_info['security_answer']; ?></td>
  		</tr>
  		<?php } ?>
  	</table>
  	
  	<table align="right">
  		<tr>
			<td><h4><?php echo $text_default_address; ?></h4></td>
  			<td align="right"><a class="" href="<?php echo site_url('account/address'); ?>"><?php echo $text_edit_add; ?></a></td>
  		</tr>
  		<?php if ($address_info) { ?>
  		<tr>
  			<td><?php echo $address_info['address_1']; ?><br /> 
  				<?php echo $address_info['address_2']; ?><br />
  				<?php echo $address_info['city']; ?><br />
  				<?php echo $address_info['postcode']; ?><br />
  				<?php echo $address_info['country']; ?>
  			</td>
  		</tr>
  		<?php } else { ?>
  		<tr>
  			<td colspan="2"><?php echo $text_no_default_add; ?></td>
  		</tr>
  		<?php } ?>
  	</table> 
	</div>
	
	<div class="account_summary">  	
  	<table align="left">
  		<tr>
			<td><h4><?php echo $text_cart; ?></h4></td>
  			<td align="right"><a class="button" href="<?php echo site_url('checkout'); ?>"><?php echo $text_checkout; ?></a></td>
  		</tr>
  		<?php if ($cart_items != '0') { ?>
  		<tr>
  			<td><b><?php echo $text_cart_items; ?> <?php echo $cart_items; ?></b></td>
  			<td><b><?php echo $text_cart_total; ?> <?php echo $cart_total; ?></b></td>
  		</tr>
  		<?php } else { ?>
  		<tr>
  			<td colspan="2"><?php echo $text_no_cart_items; ?></td>
  		</tr>
  		<?php } ?>
  	</table>

  	<table align="right">
  		<tr>
			<td><h4><?php echo $text_orders; ?></h4></td>
			<td></td>
  			<td align="right"><a class="" href="<?php echo site_url('orders'); ?>"><?php echo $text_view; ?></a></td>
  		</tr>
  		<tr>
  			<th><b><?php echo $column_order_date; ?></b></th>
  			<th><b><?php echo $column_order_id; ?></b></th>
  			<th><b><?php echo $column_order_status; ?></b></th>
  		</tr>
  		<tr>
  		</tr>
  	</table>
	</div>
	
	<div class="account_summary">  	
  	<table align="left">
  		<tr>
			<td><h4><?php echo $text_reservations; ?></h4></td>
			<td></td>
  			<td align="right"><a class="" href="<?php echo site_url('reservations'); ?>"><?php echo $text_view; ?></a></td>
  		</tr>
  		<tr>
  			<th><b><?php echo $column_resrv_date; ?></b></th>
  			<th><b><?php echo $column_resrv_id; ?></b></th>
  			<th><b><?php echo $column_resrv_status; ?></b></th>
  		</tr>
  		<tr>
  		</tr>
  	</table>

  	<table align="right">
  		<tr>
			<td><h4><?php echo $text_inbox; ?></h4></td>
			<td></td>
  			<td align="right"><a class="" href="<?php echo site_url('inbox'); ?>"><?php echo $text_view; ?></a></td>
  		</tr>
  		<tr>
  			<th><b><?php echo $column_inbox_date; ?></b></th>
  			<th><b><?php echo $column_subject; ?></b></th>
  			<th><b><?php echo $column_action; ?></b></th>
  		</tr>
  		<tr>
  		</tr>
  	</table>
	</div>
</div>
