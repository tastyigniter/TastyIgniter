<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<div class="panel-body">
				<?php if ($themes) { ?>
				<div class="row">
					<?php foreach ($themes as $theme) { ?>
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img class="img-responsive" alt="" src="<?php echo $theme['screenshot']; ?>" style="width:100%!important;height:320px!important" />
								<div class="caption">
									<h4><?php echo $theme['title']; ?><span class="badge text-sm pull-right"><?php if ($theme['active'] === '1') echo lang('text_is_default'); ?></span></h4>
									<p><?php echo $theme['description']; ?></p>
									<div class="buttons">
										<?php if ($theme['active'] === '1') { ?>
											<a class="btn btn-edit" title="<?php echo lang('text_customize'); ?>" href="<?php echo $theme['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
											<a class="btn btn-warning" disabled="disabled" title="<?php echo lang('text_is_default'); ?>"><i class="fa fa-star"></i></a>&nbsp;&nbsp;
											<a class="btn btn-info preview-thumb" title="<?php echo lang('text_preview'); ?>" data-img-src="<?php echo $theme['screenshot']; ?>" title="Default"><i class="fa fa-eye"></i></a>
										<?php } else {?>
											<a class="btn btn-edit" title="<?php echo lang('text_customize'); ?>" href="<?php echo $theme['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
											<a class="btn btn-warning" title="<?php echo lang('text_set_default'); ?>" href="<?php echo $theme['activate']; ?>"><i class="fa fa-star"></i></a>&nbsp;&nbsp;
											<a class="btn btn-info preview-thumb" title="<?php echo lang('text_preview'); ?>" data-img-src="<?php echo $theme['screenshot']; ?>" title="Default"><i class="fa fa-eye"></i></a>
										<?php } ?>
									</div>
									<div class="row">
										<div class="col-xs-6 text-muted text-sm">
											<b><?php echo lang('text_location'); ?>:</b><br />
											<?php echo $theme['location']; ?>
										</div>
										<div class="col-xs-6 text-muted text-sm">
											<b><?php echo lang('text_version'); ?>:</b><br />
											<?php echo $theme['version']; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php } else {?>
					<?php echo lang('text_empty'); ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click', '.preview-thumb', function() {
		$('#preview-theme').remove();

		$('body').append('<div id="preview-theme" class="modal" tabindex="-1" data-parent="note-editor" role="dialog" aria-hidden="true">'
			+ '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">'
			+ '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
			+ '<h4 class="modal-title">Preview Theme</h4>'
			+ '</div><div class="modal-body wrap-none">'
			+ '<img src="'+ $(this).attr('data-img-src') +'" width="100%" />'
			+ '</div></div></div></div>');

		$('#preview-theme').modal('show');

	});
});
</script>
<?php echo get_footer(); ?>