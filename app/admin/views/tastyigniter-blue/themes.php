<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-themes">
			<div class="panel-body">
				<div class="row wrap-none wrap-left">
					<?php if ($themes) { ?>
						<?php foreach ($themes as $theme) { ?>
							<div class="col-xs-12 col-sm-6 wrap-none wrap-right wrap-bottom">
								<div class="panel panel-default panel-theme">
									<div class="theme-label">
										<?php if ($theme['activated']) { ?>
											<span class="activated" title="<?php echo lang('text_is_default'); ?>"></span>
										<?php } ?>

										<?php if ($theme['is_child']) { ?>
											<span class="child-theme" title="<?php echo lang('text_is_child'); ?>"></span>
										<?php } ?>
									</div>
									<div class="panel-body">
										<div class="media">
											<a class="media-left preview-thumb" data-img-src="<?php echo $theme['screenshot']; ?>">
												<img class="img-rounded" alt="" src="<?php echo $theme['screenshot']; ?>" style="width:150px!important;height:214px!important" />
												<i class="fa fa-eye" title="<?php echo lang('text_preview'); ?>"></i>
											</a>
											<div class="media-body">
												<h4 class="media-heading"><?php echo $theme['name']; ?></h4>
												<p class="description text-muted"><?php echo $theme['description']; ?></p>
												<div class="row metas">
													<div class="pull-left wrap-vertical text-muted text-sm">
														<b><?php echo lang('text_author'); ?>:</b><br />
														<?php echo $theme['author']; ?>
													</div>
													<div class="pull-left wrap-vertical text-muted text-sm text-left">
														<b><?php echo lang('text_version'); ?>:</b><br />
														<?php echo $theme['version']; ?>
													</div>
												</div>
												<div class="buttons action">
													<a class="btn btn-edit" title="<?php echo lang('text_customize'); ?>" href="<?php echo $theme['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
													<?php if ($theme['activated']) { ?>
														<a class="btn btn-warning disabled"><i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo lang('text_is_default'); ?></a>&nbsp;&nbsp;
													<?php } else {?>
														<a class="btn btn-warning" href="<?php echo $theme['activate']; ?>"><i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo lang('text_set_default'); ?></a>&nbsp;&nbsp;
													<?php } ?>
													<?php if (empty($theme['is_child'])) { ?>
														<a class="btn btn-info" href="<?php echo $theme['copy']; ?>" title="<?php echo lang('text_copy_theme'); ?>"><i class="fa fa-files-o"></i></a>&nbsp;&nbsp;
													<?php } ?>
													<a class="btn btn-danger delete" title="<?php echo lang('text_delete'); ?>" href="<?php echo $theme['delete']; ?>"><i class="fa fa-trash-o"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
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