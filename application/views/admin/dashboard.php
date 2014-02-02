<div class="box">
	<div class="two_columns">
		<div class="left border_all">
		<h2>CURRENT STATUS</h2>
		<table width="60%" align="" class="list">
			<tr>
				<td><b>Total Sales:</b></td>
				<td><?php echo $total_sales; ?></td>
			</tr>
			<tr>
				<td><b>Total Sales This Year:</b></td>
				<td><?php echo $total_sales_by_year; ?></td>
			</tr>
			<tr>
				<td><b>Total Customers:</b></td>
				<td><?php echo $total_customers; ?></td>
			</tr>
			<tr>
				<td><b>Total Orders Received:</b></td>
				<td><?php echo $total_orders_received; ?></td>
			</tr>
			<tr>
				<td><b>Total Orders Completed:</b></td>
				<td><?php echo $total_orders_completed; ?></td>
			</tr>
			<tr>
				<td><b>Total Orders Delivered:</b></td>  
				<td><?php echo $total_orders_delivered; ?></td>
			</tr>
			<tr>
				<td><b>Total Orders Picked Up:</b></td>  
				<td><?php echo $total_orders_picked; ?></td>
			</tr>
			<tr>
				<td><b>Total Table(s) Reserved:</b></td>
				<td><?php echo $total_tables_reserved; ?></td>
			</tr>
		</table>
		</div>
	
		<div class="right border_all">
			<font size="5">GRAPH COMING SOON</font>
		</div>
	</div>

    <h2>MENU REVIEWS (100%)</h2>
	<?php echo form_open(current_url()) ?>
	<table class="list">
		<tr align="center">
            <th class="select_menu"><select name="select_menu" onchange="this.form.submit();">
	  			<option value=""> - please select - </option>  	
				<?php foreach ($menus as $menu) { ?>
				<?php if ($menu_name == $menu['menu_name']) { ?>
  					<option value="<?php echo $menu['menu_id']; ?>" <?php echo set_select('menu', $menu['menu_id'], TRUE); ?> > - <?php echo $menu['menu_name']; ?> - </option>  	
				<?php } else { ?>
  					<option value="<?php echo $menu['menu_id']; ?>" <?php echo set_select('menu', $menu['menu_id']); ?> > - <?php echo $menu['menu_name']; ?> - </option>  	
				<?php } ?>
				<?php } ?>
            </select></th>
    		<th>Bad</th>
    		<th>Worse</th>
    		<th>Average</th>
    		<th>Good</th>
    		<th>Excellent</th>
    	</tr>
		<?php if ($ratings_results) { ?>
    	<tr align="center">
			<td><b><?php echo $menu_name; ?></b></td>
			<td><?php echo $ratings_results['total']['1']; ?> (<?php echo $ratings_results['percent']['1']; ?>%)</td>
			<td><?php echo $ratings_results['total']['2']; ?> (<?php echo $ratings_results['percent']['2']; ?>%)</td>
			<td><?php echo $ratings_results['total']['3']; ?> (<?php echo $ratings_results['percent']['3']; ?>%)</td>
			<td><?php echo $ratings_results['total']['4']; ?> (<?php echo $ratings_results['percent']['4']; ?>%)</td>
			<td><?php echo $ratings_results['total']['5']; ?> (<?php echo $ratings_results['percent']['5']; ?>%)</td>
    	</tr>
		<?php } else { ?>
    	<tr align="center">
			<td><b><?php echo $menu_name; ?></b></td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
    	</tr>
		<?php } ?>
    </table>
	</form>
	<br />
	<br />
	
	<h2>10 LATEST ORDERS</h2>
	<table border="0" align="center" class="list">
	<tr>
		<th>Order ID</th>
		<th>Location</th>
		<th>Customer Name</th>
		<th>Status</th>
		<th>Assigned Staff</th>
		<th>Order Time</th>
		<th class="right">Date Added</th>
		<th class="right">Date Modified</th>
		<th class="right">Action</th>
	</tr>
	<?php if ($orders) { ?>
	<?php foreach ($orders as $order) { ?>
	<tr>
		<td class="id"><?php echo $order['order_id']; ?></td>
		<td><?php echo $order['location_name']; ?></td>
		<td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
		<td><?php echo $order['order_status']; ?></td>
		<td><?php echo $order['staff_name'] ? $order['staff_name'] : 'NONE'; ?></td>
		<td><?php echo $order['order_time']; ?></td>
		<td class="right"><?php echo $order['date_added']; ?></td>
		<td class="right"><?php echo $order['date_modified']; ?></td>
		<td class="right"><a class="edit" title="Edit" href="<?php echo $order['edit']; ?>"></a></td>
	</tr>
	<?php } ?>
	<?php } else { ?>
	<tr>
		<td colspan="12" align="center"><?php echo $text_empty; ?></td>
	</tr>
	<?php } ?>
	</table>
</div>