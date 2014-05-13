<div class="content">
<div class="img_inner">
	<table width="80%" class="order_confirmation">
	<tr>
    	<td><?php echo $message; ?></td>
    </tr>
    <tr>
        <td><br /><h4><?php echo $text_order_details; ?></h4></td>
    </tr>
    <tr>
        <td><?php echo $order_details; ?></td>
    </tr>
   	<tr>
        <td><br /><h4><?php echo $text_order_items; ?></h4></td>
   	</tr>
	<?php if ($menus) { ?>
   	<tr>
   		<td>
			<table>
			<?php foreach ($menus as $menu) { ?>
			<tr>
			 	<td>x <?php echo $menu['quantity']; ?></td>
				<td><?php echo $menu['name']; ?><br />
					<?php if (!empty($menu['order_option_id'])) { ?>
						<div><font size="1">+ <?php echo $menu['option_name']; ?>: <?php echo $menu['option_price']; ?> </font></div>
					<?php } ?></td>
				<td><?php echo $menu['price']; ?></td>
			 </tr>		
			<?php } ?>
			<tr>
				<td colspan="3"><?php echo $order_total; ?></td>
			</tr>
			</table
   		</td>
   	</tr>
	<?php } ?>
	<?php if ($delivery_address) { ?>
   	<tr>
        <td><br /><h4><?php echo $text_delivery_address; ?></h4></td>
   	</tr>
   	<tr>
   		<td><address><?php echo $delivery_address; ?></address></td>
   	</tr>
	<?php } ?>
   	<tr>
        <td><br /><h4><?php echo $text_local; ?></h4></td>
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
</div>