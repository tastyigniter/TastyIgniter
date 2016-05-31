<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<?php if (!empty($upgrade_url)) { ?>
			<div id="updateIframe"><?php echo $upgrade_url; ?></div>
		<?php } else { ?>
			<?php if (!empty($updates['last_version_check'])) { ?>
				<p class="text-muted"><?php echo sprintf(lang('text_last_checked'), time_elapsed($updates['last_version_check'], array('m', 'w', 'd', 'h', 'i', 's'))); ?></p>
			<?php } ?>
			<div class="panel panel-default panel-table">
				<div class="panel-heading hide">
					<h3 class="panel-title"><i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_tab_title_core'); ?></h3>
				</div>
				<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
					<div class="panel-body">
						<?php if (!empty($updates['core'])) { ?>
							<div class="alert alert-warning"><?php echo lang('alert_updates_warning'); ?></div>
							<div class="alert alert-info"><?php echo lang('alert_modification_warning'); ?></div>
							<h4><?php echo lang('text_core_update_available'); ?></h4>
							<p><?php echo sprintf(lang('help_core_update'), $updates['core']['version_name']); ?></p>
							<p><?php echo lang('text_maintenance_mode'); ?></p>
						<?php } else { ?>
							<h4><?php echo lang('text_core_updated'); ?></h4>
						<?php } ?>
					</div>
					<?php if (!empty($updates['core'])) { ?>
						<div class="panel-footer">
							<input name="version" value="<?php echo $updates['core']['stable_tag']; ?>" type="hidden">
							<button class="btn btn-primary" type="submit" name="update" value="core"><?php echo lang('button_update_now'); ?></button>
						</div>
					<?php } ?>
				</form>
			</div>
		<?php } ?>
	</div>
</div>
<?php if (!empty($upgrade_url)) { ?>
	<script type="text/javascript"><!--
		$(document).ready(function() {
			var iframe_url = $('#updateIframe').html();
			$('#updateIframe').html('<iframe src="' + iframe_url + '" frameborder="0" style="width: 100%; height: 100%; min-height: 450px;"></iframe>');
		});
	//--></script>
<?php } ?>
<?php echo get_footer(); ?>