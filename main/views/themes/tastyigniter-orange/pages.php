<?php if (empty($page_popup)) echo get_header(); ?>
<?php if (empty($page_popup)) echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="<?php echo empty($page_popup) ? 'container' : 'container-fluid'; ?>">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<?php if (!empty($page_popup)) { ?>
						<h3><?php echo $text_heading; ?></h3>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="row">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (empty($page_popup) AND partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if ((empty($page_popup) AND partial_exists('content_left')) OR (empty($page_popup) AND partial_exists('content_right'))) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<?php echo $page_content; ?>
			</div>

			<?php if (empty($page_popup)) echo get_partial('content_right'); ?>
			<?php if (empty($page_popup)) echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php if (empty($page_popup)) echo get_footer(); ?>