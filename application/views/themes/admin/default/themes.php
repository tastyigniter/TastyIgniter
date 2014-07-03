<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"></th>
						<th></th>
						<th>Name</th>
						<th class="text-right">Location</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($themes) { ?>
					<?php foreach ($themes as $theme) { ?>
					<tr>
						<td class="action">
							<a class="btn btn-edit" title="Edit" href="<?php echo $theme['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
							<?php if ($theme['default'] === '1') { ?>
								<a class="btn btn-favorite" title="Default"><i class="fa fa-star"></i></a>
							<?php } else {?>
								<a class="btn btn-favorite-o" title="Set Default" href="<?php echo $theme['default']; ?>"><i class="fa fa-star-o"></i></a>
							<?php } ?>
						</td>
						<td><a class="preview-thumb" title="Click to enlarge." href="<?php echo $theme['preview']; ?>">
							<img class="img-responsive img-thumbnail" alt="" src="<?php echo $theme['thumbnail']; ?>" style="height:150px !important" /></td>
						<td><?php echo $theme['name']; ?></td>
						<td class="text-right"><?php echo $theme['location']; ?></td>
					</tr>
					<?php } ?>
					<?php } else {?>
					<tr>
						<td colspan="3"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo base_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.preview-thumb').fancybox();
});
</script>
<?php echo $footer; ?>