<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-themes">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<div class="panel-body">
				<div class="row wrap-none wrap-left">
					<?php if ($themes) { ?>
						<?php foreach ($themes as $theme) { ?>
							<div class="col-xs-12 col-sm-6 wrap-none wrap-right wrap-bottom">
								<div class="panel panel-default panel-theme">
									<?php if ($theme['active'] === '1') { ?>
										<span class="label label-warning label-active text-sm" title="<?php echo lang('text_is_default'); ?>"></span>
									<?php } ?>
									<div class="panel-body">
										<div class="row">
											<div class="theme-img col-xs-12 col-sm-4 wrap-none hidden-xs">
												<img class="img-responsive" alt="" src="<?php echo $theme['screenshot']; ?>" style="width:100%!important;height:100%!important" />
												<a class="btn btn-default preview-thumb" title="<?php echo lang('text_preview'); ?>" data-img-src="<?php echo $theme['screenshot']; ?>" title="Default"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;
											</div>
											<div class="col-xs-12 col-sm-8 description">
												<h4><?php echo $theme['title']; ?></h4>
												<p><?php echo $theme['description']; ?></p>
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
													<?php if ($theme['active'] === '1') { ?>
														<a class="btn btn-warning disabled"><i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo lang('text_is_default'); ?></a>&nbsp;&nbsp;
													<?php } else {?>
														<a class="btn btn-warning" href="<?php echo $theme['activate']; ?>"><i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo lang('text_set_default'); ?></a>&nbsp;&nbsp;
													<?php } ?>
													<?php if (!empty($theme['child'])) { ?>
														<a class="btn btn-info" href="<?php echo $theme['copy']; ?>" title="<?php echo lang('text_copy_theme'); ?>"><i class="fa fa-files-o"></i></a>&nbsp;&nbsp;
													<?php } ?>
													<a class="btn btn-danger delete" title="<?php echo lang('text_delete'); ?>" href="<?php echo $theme['delete']; ?>"><i class="fa fa-trash-o"></i></a>
												</div>
                                                <?php if (!empty($theme['parent_title'])) { ?>
													<p class="small text-muted"><?php echo sprintf(lang('text_is_child_theme'), $theme['parent_title']); ?></p>
                                                <?php } ?>
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
	$('a.delete').click(function(){
		if (!confirm('<?php echo lang('alert_warning_confirm'); ?>')) {
			return false;
		}
	});

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