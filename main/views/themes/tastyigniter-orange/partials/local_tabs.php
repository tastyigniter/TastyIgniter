<ul id="nav-tabs" class="nav nav-tabs nav-tabs-line nav-menus">
	<li class="<?php echo ($active_tab === 'menus') ? 'active':''; ?>">
		<a href="<?php echo restaurant_url('menus'); ?>"><?php echo lang('text_tab_menu'); ?></a>
	</li>
	<?php if (config_item('allow_reviews') !== '1') { ?>
		<li class="<?php echo ($active_tab === 'reviews') ? 'active':''; ?>">
			<a href="<?php echo restaurant_url('reviews'); ?>"><?php echo lang('text_tab_review'); ?></a>
		</li>
	<?php } ?>
	<li class="<?php echo ($active_tab === 'info') ? 'active':''; ?>">
		<a href="<?php echo restaurant_url('info'); ?>"><?php echo lang('text_tab_info'); ?></a>
	</li>
	<?php if (!empty($local_gallery)) { ?>
		<li class="<?php echo ($active_tab === 'gallery') ? 'active':''; ?>">
			<a href="<?php echo restaurant_url('gallery'); ?>"><?php echo lang('text_tab_gallery'); ?></a>
		</li>
	<?php } ?>
</ul>
