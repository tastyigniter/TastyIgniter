<div id="page-box" class="module-box">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $heading; ?></h3>
		</div>
		<div class="list-group list-group-responsive">
			<?php foreach ($pages as $page) { ?>
				<?php if ($page_id == $page['page_id']) { ?>
					<a class="list-group-item active" href="<?php echo $page['href']; ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $page['name']; ?></a>
				<?php } else { ?>
					<a class="list-group-item" href="<?php echo $page['href']; ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $page['name']; ?></a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>