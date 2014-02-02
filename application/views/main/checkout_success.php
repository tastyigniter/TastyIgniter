<div class="content">
<table width="80%" class="order_confirmation">
	<tr>
    	<td><?php echo $message; ?></td>
    </tr>
    <tr>
        <td><h4><?php echo $text_order_details; ?></h4></td>
    </tr>
    <tr>
        <td><?php echo $order_details; ?></td>
    </tr>
   	<tr>
        <td><h4><?php echo $text_order_items; ?></h4></td>
   	</tr>
	<?php if ($menus) { ?>
   	<tr>
   		<td>
			<table>
			<?php foreach ($menus as $menu) { ?>
			<tr>
				<td><?php echo $menu['name']; ?><br />
				<?php if (!empty($menu['options'])) { ?>
					<?php foreach ($menu['options'] as $option_name => $option_value) { ?>
						<div><font size="1"><strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?> </font></div>
					<?php } ?>
				<?php } ?></td>
			 	<td>x <?php echo $menu['quantity']; ?></td>
			 </tr>		
			<?php } ?>
			</table
   		</td>
   	</tr>
	<?php } ?>
   	<tr>
   		<td><?php echo $order_total; ?></td>
   	</tr>
	<?php if ($delivery_address) { ?>
   	<tr>
        <td><h4><?php echo $text_delivery_address; ?></h4></td>
   	</tr>
   	<tr>
   		<td><address><?php echo $delivery_address['address_1']; ?>, <?php echo $delivery_address['address_2']; ?>, <?php echo $delivery_address['city']; ?>, <?php echo $delivery_address['postcode']; ?>, <?php echo $delivery_address['country_name']; ?></address></td>
   	</tr>
	<?php } ?>
   	<tr>
        <td><h4><?php echo $text_local; ?></h4></td>
   	</tr>
   	<tr>
    	<td><font size="4"><?php echo $location_name; ?></font><br />
    	<?php echo $location_address; ?></td>
   	</tr>
	<tr>
		<td><br /><br /><?php echo $text_thank_you; ?></td>
	</tr>
</table>
</div>