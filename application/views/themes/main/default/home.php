<?php echo $header; ?>
<div id="notification" class="row">
<?php if (!empty($alert)) { ?>
	<div class="alert alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
	</div><br />
<?php } ?>
</div>
<?php echo $content_top; ?>
<div class="row content">
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
<?php echo $footer; ?>