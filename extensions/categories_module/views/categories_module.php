<div id="category-box" class="module-box">
	<div class="panel panel-default">
		<div class="list-group list-group-responsive">
			<?php if (!empty($menu_total) AND $menu_total > 500) { ?>
				<a href="<?php echo site_url('menus'); ?>" class="list-group-item"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo lang('text_show_all'); ?></a>

				<?php foreach ($categories as $category) { ?>
					<?php if ($category['category_id'] === $category_id) { ?>
						<a href="<?php echo site_url('menus'); ?>" class="list-group-item active"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['category_name']; ?></a>
					<?php } else { ?>
						<a href="<?php echo $category['href']; ?>" class="list-group-item"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['category_name']; ?></a>
					<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<a class="list-group-item filter" data-filter="all"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo lang('text_show_all'); ?></a>
				<?php foreach ($categories as $category) { ?>
					<a class="list-group-item filter" data-filter=".<?php echo strtolower(str_replace(' ', '-', $category['category_name'])); ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['category_name']; ?></a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>