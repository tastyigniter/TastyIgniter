<div class="img_inner">
	<ul id="sub_nav">
		<?php if ($page === 'account') { ?>
			<li><a href="<?php echo site_url('main/account'); ?>" class="active"><?php echo $text_account; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/account'); ?>"><?php echo $text_account; ?></a></li>
		<?php } ?>

		<?php if ($page === 'details') { ?>
			<li><a href="<?php echo site_url('main/details'); ?>" class="active"><?php echo $text_edit_details; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/details'); ?>"><?php echo $text_edit_details; ?></a></li>
		<?php } ?>

		<?php if ($page === 'address') { ?>
			<li><a href="<?php echo site_url('main/address'); ?>" class="active"><?php echo $text_address; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/address'); ?>"><?php echo $text_address; ?></a></li>
		<?php } ?>

		<?php if ($page === 'orders') { ?>
			<li><a href="<?php echo site_url('main/orders'); ?>" class="active"><?php echo $text_orders; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/orders'); ?>"><?php echo $text_orders; ?></a></li>
		<?php } ?>

		<?php if ($page === 'reservations') { ?>
			<li><a href="<?php echo site_url('main/reservations'); ?>" class="active"><?php echo $text_reservations; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/reservations'); ?>"><?php echo $text_reservations; ?></a></li>
		<?php } ?>

		<?php if ($page === 'reviews') { ?>
			<li><a href="<?php echo site_url('main/reviews'); ?>" class="active"><?php echo $text_reviews; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/reviews'); ?>"><?php echo $text_reviews; ?></a></li>
		<?php } ?>

		<?php if ($page === 'inbox') { ?>
			<li><a href="<?php echo site_url('main/inbox'); ?>" class="active"><?php echo $text_inbox; ?></a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('main/inbox'); ?>"><?php echo $text_inbox; ?></a></li>
		<?php } ?>

		<li><a href="<?php echo site_url('main/logout'); ?>"><?php echo $text_logout; ?></a></li>
	</ul>
</div>
