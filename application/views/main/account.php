<div class="content">
<div class="img_inner">
	<div class="account_summary">
  		<table align="left">
  		<tr>
			<td colspan="2"><h3><?php echo $text_my_details; ?></h3></td>
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
			<td colspan="2"><h3><?php echo $text_default_address; ?></h3></td>
  		</tr>
  		<?php if ($address_info) { ?>
  		<tr>
  			<td><?php echo $address_info; ?></td>
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
			<td colspan="3"><h3><?php echo $text_cart; ?></h3></td>
  		</tr>
  		<?php if ($cart_items != '0') { ?>
  		<tr>
  			<th><b><?php echo $column_cart_items; ?></b></th>
  			<th><b><?php echo $column_cart_total; ?></b></th>
  			<th></th>
  		</tr>
  		<tr>
  			<td><?php echo $cart_items; ?></td>
  			<td><?php echo $cart_total; ?></td>
  			<td><a class="button" href="<?php echo $button_checkout; ?>"><?php echo $text_checkout; ?></a></td>
  		</tr>
  		<?php } else { ?>
  		<tr>
  			<td colspan="3"><?php echo $text_no_cart_items; ?></td>
  		</tr>
  		<?php } ?>
  		</table>

  		<table align="right">
  		<tr>
			<td colspan="3"><h3><?php echo $text_orders; ?></h3></td>
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
			<td colspan="3"><h3><?php echo $text_reservations; ?></h3></td>
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
			<td colspan="3"><h3><?php echo $text_inbox; ?></h3></td>
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
</div>
