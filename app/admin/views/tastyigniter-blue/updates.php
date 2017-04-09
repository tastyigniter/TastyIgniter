<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<?php if (!empty($updates['last_check'])) { ?>
			<p class="text-muted small"><?php echo sprintf(lang('text_last_checked'), time_elapsed($updates['last_check'], array('m', 'w', 'd', 'h', 'i', 's'))); ?></p>
		<?php } ?>
		<div class="panel panel-default">
			<?php if (!empty($updates['core'])) { ?>
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_tab_title_core'); ?></h3>
				</div>
				<?php if (empty($updates['core']['ignored'])) { ?>
					<div class="panel-body wrap-none wrap-vertical wrap-top">
						<h4 class="no-margin margin-bottom"><?php echo lang('text_core_update_available'); ?></h4>
						<p><?php echo sprintf(lang('help_core_update'), $updates['core']['version']); ?></p>
						<p><?php echo lang('text_maintenance_mode'); ?></p>
						<input type="checkbox" class="hidden" data-title="Update <?php echo $updates['core']['name'] ?>"
							   data-update-code="<?php echo $updates['core']['code'] ?>"
							   data-update-type="<?php echo $updates['core']['type'] ?>"
							   data-update-version="<?php echo $updates['core']['version'] ?>" checked />
					</div>
					<?php if (!empty($updates['core']['changelog'])) { ?>
                        <div class="panel-body changelog wrap-none wrap-vertical wrap-top border-top">
                            <p><strong>Change log:</strong></p>
                            <p><?php echo nl2br($updates['core']['changelog']); ?></p>
                        </div>
					<?php } ?>
				<?php } else { ?>
					<div class="panel-body wrap-none wrap-vertical wrap-top">
						<h4 class="text-w-400 no-margin margin-bottom"><?php echo lang('text_core_update_ignored'); ?></h4>
					</div>
				<?php } ?>

			<?php } else { ?>
				<div class="panel-body">
					<h4 class="text-w-400"><?php echo lang('text_core_updated'); ?></h4>
				</div>
			<?php } ?>
		</div>

		<?php if (isset($updates['update_count']) AND $updates['update_count'] > 0) { ?>
			<?php $button_text = !empty($updates['items']) ? $this->lang->line('text_selected') : $this->lang->line('text_now'); ?>
			<div class="page-action">
				<a id="applyUpdates" class="btn btn-primary"><?php echo sprintf(lang('button_update'), $button_text) ?></a>
				<?php if (!empty($updates['core'])) { ?>
					<a class="btn btn-warning" href="?ignore_update=<?php echo $updates['core']['version'] ?>"><?php echo lang('button_ignore_update') ?></a>
				<?php } ?>
			</div>
		<?php } ?>

		<?php if (!empty($updates['items'])) { ?>
            <hr>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title text-w-400">
						<span class="text-muted">
							<?php echo ucfirst(strtolower(lang('text_tab_title_extensions').", ".lang('text_tab_title_themes')." & ".lang('text_tab_title_translations') . " ". lang('text_title'))); ?>
						</span>
					</h4>
				</div>
				<div class="panel-body">
					<p><?php echo sprintf(lang('text_update_available'), lang('text_selected')); ?></p>
					<div id="update-items" class="items-list">
						<ul class="select-box">
						<?php foreach ($updates['items'] as $item) { ?>
							<li class="col-xs-12 col-sm-4">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa <?php echo $item['icon'] ?> fa-pull-left text-muted"></i>
										<div class="checkbox checkbox-default pull-right">
											<input type="checkbox" class="styled extension" id="checkbox-<?php echo $item['code'] ?>"
												   data-title="Update <?php echo $item['name'] ?>"
												   data-update-code="<?php echo $item['code'] ?>" data-update-type="<?php echo $item['type'] ?>"
												   data-update-version="<?php echo $item['version'] ?>" checked/>
											<label for="checkbox-all" class="text-success"></label>
										</div>
										<h4 class="panel-title"><?php echo character_limiter($item['name'], 22) ?></h4>
									</div>
									<div class="panel-body text-muted">
										<p class="small">
											<?php echo sprintf(lang('text_item_update_summary'), $installed_items[$item['code']]['ver'], $item['version']) ?><br/>
										</p>
										<ul class="list-group small">
											<?php if (isset($item['tags'])) foreach ($item['tags'] as $tag => $description) { ?>
											<li><strong><?php echo $tag; ?>:</strong> <?php echo $description ?></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							</li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript"><!--
	var updatesItems = JSON.parse('<?php echo json_encode(!empty($updates['items']) ? $updates['items'] : []); ?>');
	var installedItems = JSON.parse('<?php echo json_encode(array_keys($installed_items)); ?>');
//--></script>
<?php echo get_footer(); ?>