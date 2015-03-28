<div class="module-box">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $text_heading; ?></h3>
		</div>
		<div class="list-group list-group-responsive">
			<a href="<?php echo site_url('account'); ?>" class="list-group-item <?php echo ($page === 'account') ? 'active' : ''; ?>"><span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_account; ?></a>
			<a href="<?php echo site_url('details'); ?>" class="list-group-item <?php echo ($page === 'details') ? 'active' : ''; ?>"><span class="fa fa-edit"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_edit_details; ?></a>
			<a href="<?php echo site_url('address'); ?>" class="list-group-item <?php echo ($page === 'address') ? 'active' : ''; ?>"><span class="fa fa-book"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_address; ?></a>
			<a href="<?php echo site_url('orders'); ?>" class="list-group-item <?php echo ($page === 'orders') ? 'active' : ''; ?>"><span class="fa fa-list-alt"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_orders; ?></a>

			<?php if ($this->config->item('reservation_mode') === '1') { ?>
				<a href="<?php echo site_url('reservations'); ?>" class="list-group-item <?php echo ($page === 'reservations') ? 'active' : ''; ?>"><span class="fa fa-calendar"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_reservations; ?></a>
			<?php } ?>

			<a href="<?php echo site_url('reviews'); ?>" class="list-group-item <?php echo ($page === 'reviews') ? 'active' : ''; ?>"><span class="fa fa-star"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_reviews; ?></a>
			<a href="<?php echo site_url('inbox'); ?>" class="list-group-item <?php echo ($page === 'inbox') ? 'active' : ''; ?>"><span class="fa fa-inbox"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_inbox; ?></a>
			<a href="<?php echo site_url('logout'); ?>" class="list-group-item  list-group-item-danger" ><span class="fa fa-ban"></span>&nbsp;&nbsp;&nbsp;<?php echo $text_logout; ?></a>
		</div>
	</div>
</div>
