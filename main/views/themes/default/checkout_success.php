<?php echo get_header(); ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row content wrap-all">
	<div class="row wrap-vertical">
		<div class="wrap-vertical wrap-bottom">
			<?php echo $message; ?>
		</div>

		<div class="wrap-vertical wrap-bottom">
			<h4><?php echo $text_order_details; ?></h4>
			<?php echo $order_details; ?>
		</div>

		<?php if ($menus) { ?>
		<div class="wrap-vertical">
			<h4><?php echo $text_order_items; ?></h4>
			<div class="table-responsive">
				<table class="table">
					<?php foreach ($menus as $menu) { ?>
					<tr>
						<td>x <?php echo $menu['quantity']; ?></td>
						<td><?php echo $menu['name']; ?><br />
							<?php if (!empty($menu['options'])) { ?>
								<div><font size="1">+ <?php echo $menu['options']; ?></font></div>
							<?php } ?></td>
						<td><?php echo $menu['subtotal']; ?></td>
					 </tr>
					<?php } ?>
					<tr>
						<td colspan="3"><?php echo $order_total; ?></td>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>

		<?php if ($delivery_address) { ?>
		<div class="wrap-vertical wrap-bottom">
			<h4><?php echo $text_delivery_address; ?></h4>
			<address><?php echo $delivery_address; ?></address>
		</div>
		<?php } ?>

		<div class="wrap-vertical wrap-bottom">
			<h4><?php echo $text_local; ?></h4>
			<strong><?php echo $location_name; ?></strong><br />
			<address><?php echo $location_address; ?></address>
		</div>

		<div class="wrap-vertical wrap-bottom">
			<?php echo $text_thank_you; ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>