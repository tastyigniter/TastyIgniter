<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="notification" class="row">
	<?php echo $this->alert->display(); ?>
	<?php if (!empty($local_alert)) { ?>
		<div class="alert alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<div class="wrap-all  bg-danger"><?php echo $local_alert; ?></div>
		</div>
	<?php } ?>
</div>

<?php if ($local_location) { ?>
<div class="row margin-top">
	<ul class="nav nav-tabs menus-tabs text-sm" role="tablist">
		<li><a href="<?php echo site_url('menus'); ?>">Menu</a></li>
		<li><a href="<?php echo site_url('local'); ?>">Info</a></li>
		<li class="active"><a href="<?php echo site_url('local/reviews'); ?>">Reviews</a></li>
	</ul>
</div>

<div class="row">
	<?php echo get_partial('content_left'); ?><?php echo get_partial('content_right'); ?>

	<div class="col-md-8">
		<div class="row wrap-all" style="display: block;">
			<div class="page-header">
				<h4><?php echo $text_review; ?></h4>
			</div>

			<div class="row wrap-all">
				<?php if ($reviews) { ?>
					<?php $review_row = 1; ?>
					<?php foreach ($reviews as $review) { ?>
						<blockquote>
							<ul class="list-inline text-sm">
								<li><b>Quality:</b><br />
									<div class="rating rating-star" data-score="<?php echo $review['quality']; ?>" data-readonly="true"></div>
								</li>
								<li><b>Delivery:</b><br />
									<div class="rating rating-star" data-score="<?php echo $review['delivery']; ?>" data-readonly="true"></div>
								</li>
								<li><b>Service:</b><br />
									<div class="rating rating-star" data-score="<?php echo $review['service']; ?>" data-readonly="true"></div>
								</li>
							</ul>
							<p class="text-sm"><?php echo $review['text']; ?></p>
							<footer>
								<?php echo $review['author']; ?><?php echo $text_from; ?>
								<cite title="Source Title"><?php echo $review['city']; ?></cite><?php echo $text_on; ?>
								<?php echo $review['date']; ?>
							</footer>
						</blockquote>
					<?php } ?>
				<?php } else { ?>
					<p><?php echo $text_empty; ?></p>
				<?php } ?>

				<div class="wrap-horizontal">
					<div class="pagination-bar text-right clearfix">
						<div class="links"><?php echo $pagination['links']; ?></div>
						<div class="info"><?php echo $pagination['info']; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php echo get_footer(); ?>