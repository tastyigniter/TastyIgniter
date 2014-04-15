<div class="img_inner">
	<h3><?php echo $text_heading; ?></h3>
	<ul id="sub_nav">
	<?php foreach ($categories as $category) { ?>
	<?php if ($category_id == $category['category_id']) { ?>
		<li><a href="<?php echo site_url('menus'); ?>" class="active"><?php echo $category['category_name']; ?>  <small>[<?php echo $text_clear; ?>]</small></a></li>
	<?php } else { ?>
		<li><a href="<?php echo $category['href']; ?>"><?php echo $category['category_name']; ?></a></li>
	<?php } ?>
	<?php } ?>
	</ul>
</div>
