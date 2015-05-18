<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Theme List</h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($themes) { ?>
							<?php foreach ($themes as $theme) { ?>
							<tr>
								<td><a class="preview-thumb" title="Click to enlarge." href="<?php echo $theme['preview']; ?>">
									<img class="img-responsive img-thumbnail" alt="" src="<?php echo $theme['thumbnail']; ?>" style="height:150px !important" /></td>
								<td><?php echo $theme['title']; ?><br />
									<i><?php echo $theme['description']; ?></i><br />
                                    <span class="text-mute text-sm"><b>Location:</b> <?php echo $theme['location']; ?></span>
								</td>
								<td class="text-center">
									<?php if ($theme['active'] === '1') { ?>
										<a class="btn btn-edit" title="Customize" href="<?php echo $theme['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
										<a class="btn btn-warning" disabled="disabled" title="Default"><i class="fa fa-star"></i></a>&nbsp;&nbsp;
										<a class="btn btn-info preview-thumb" title="Preview" href="<?php echo $theme['preview']; ?>" title="Default"><i class="fa fa-eye"></i></a>
									<?php } else {?>
										<a class="btn btn-edit" title="Customize" href="<?php echo $theme['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
										<a class="btn btn-warning" title="Set Default" href="<?php echo $theme['activate']; ?>"><i class="fa fa-star"></i></a>&nbsp;&nbsp;
										<a class="btn btn-info preview-thumb" title="Preview" href="<?php echo $theme['preview']; ?>" title="Default"><i class="fa fa-eye"></i></a>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="3"><?php echo $text_empty; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo root_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.preview-thumb').fancybox();
});
</script>
<?php echo get_footer(); ?>