<?php echo get_header(); ?>
<div id="notification" class="row">
	<?php echo $this->alert->display(); ?>
</div>
<?php echo get_partial('content_top'); ?>
<div class="row">
	<div class="home-fixed text-center">
		<div id="local-alert"><?php echo $local_alert; ?></div>
		<div id="search-location">
			<form id="location-form" method="POST" action="<?php echo $local_action; ?>" role="form">
				<div class="form-group">
					<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
					<div class="col-sm-4 center-block">
						<div class="input-group postcode-group">
							<input type="text" id="postcode" class="form-control text-center postcode-control" name="postcode" value="<?php echo $postcode; ?>">
							<a id="search" class="input-group-addon btn btn-success" onclick="$('form').submit();"><?php echo $text_find; ?></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>