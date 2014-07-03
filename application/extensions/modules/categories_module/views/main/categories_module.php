<div id="category-box" class="module-box">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $text_heading; ?></h3>
		</div>
		<div class="list-group list-group-responsive">
			<?php foreach ($categories as $category) { ?>
			<?php if ($category_id == $category['category_id']) { ?>
				<a href="<?php echo site_url('main/menus'); ?>" class="list-group-item active"><?php echo $category['category_name']; ?> <!--<span class="badge"><?php echo $text_clear; ?></span>--></a>
			<?php } else { ?>
				<a href="<?php echo $category['href']; ?>" class="list-group-item"><?php echo $category['category_name']; ?></a>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>
