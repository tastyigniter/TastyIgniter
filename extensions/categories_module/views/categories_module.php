<div id="category-box" class="module-box">
	<div class="panel panel-default">
		<ul class="list-group list-group-responsive">
			<?php if (!empty($menu_total) AND $menu_total > 500) { ?>
				<li class="list-group-item"><a href="<?php echo site_url('menus'); ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo lang('text_show_all'); ?></a></li>

				<?php foreach ($categories as $category) { ?>
                    <li class="list-group-item <?php if ($category['category_id'] === $category_id) echo 'active'; ?>">
                        <a href="<?php echo $category['href']; ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['category_name']; ?></a>
                    </li>
				<?php } ?>
			<?php } else { ?>
				<li class="list-group-item filter" data-filter="all"><a><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo lang('text_show_all'); ?></a></li>
				<?php foreach ($categories as $category) { ?>
					<li class="list-group-item filter" data-filter=".<?php echo strtolower(str_replace(' ', '-', $category['category_name'])); ?>">
                        <a><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['category_name']; ?></a>

    			        <?php if (!empty($category['children'])) { ?>
                            <ul class="list-group list-group-responsive">
                                <?php foreach ($category['children'] as $child) { ?>
                                    <li class="list-group-item filter" data-filter=".<?php echo strtolower(str_replace(' ', '-', $child['category_name'])); ?>">
                                        <a><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $child['category_name']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
</div>