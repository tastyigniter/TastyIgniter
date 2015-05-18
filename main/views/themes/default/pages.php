<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row">
	<?php echo get_partial('content_left'); ?><?php echo get_partial('content_right'); ?>

	<div class="col-md-8 wrap-all">
		<?php echo $page_content; ?>
	</div>
</div>
<?php echo get_footer(); ?>