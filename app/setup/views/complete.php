<div id="completeBox">

	<form id="completeForm" method="POST" role="form">
		<input type="hidden" name="install_step" value="<?php echo $install_step ?>">
		<div class="form-group">
			<label for=""><?php echo lang('label_site_key'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a class="small" href="http://docs.tastyigniter.io/tutorial/site"><?php echo lang('text_whats_this'); ?></a>
				<span class="help-block"><?php echo lang('help_site_key'); ?></span>
			</label>
			<input type="text" class="form-control" name="site_key" value="<?php echo $site_key; ?>" placeholder="Enter your Site Key... (Optional)">
		</div>

		<div class="form-group extensions">

			<div class="links pull-right" style="display: none;">
				<div class="btn-group btn-group-xs" data-toggle="buttons">
				   <label class="btn btn-default"><input type="radio" onclick="$('input[name*=\'install_extensions\']').prop('checked', this.checked)">Select All</label>
				   <label class="btn btn-default"><input type="radio" onclick="$('input[name*=\'install_extensions\']').prop('checked', this.checked)">Un-select All</label>
				</div>
			</div>

			<label for=""><?php echo lang('label_extensions'); ?>
				<span class="help-block"><?php echo lang('help_extensions'); ?></span>
			</label>

			<div class="loading-box text-center">
				<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
				<p class="text-muted"><?php echo lang('text_fetch_extensions'); ?></p>
			</div>

			<div id="extensions-list" style="display: none;"></div>
		</div>

		<div class="buttons text-right">
			<button id="btn-skip" class="btn btn-default" onclick="skipInstall(); return false;"><?php echo lang('button_skip'); ?></button>
            &nbsp;&nbsp;
			<button id="btn-continue" type="submit" class="btn btn-success disabled"><?php echo lang('button_continue'); ?></button>
		</div>
	</form>

	<div class="progress-box" style="display: none;">
		<p class="message"></p>
		<div class="progress">
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		</div>
	</div>
</div>
<script><!--
	var installedExtensions = JSON.parse('<?php echo json_encode($installed_extensions); ?>');

	console.log(installedExtensions);

    function skipInstall() {
        var installStep = '<?php echo $install_skip; ?>';

        $('#completeForm').append('<input type="hidden" name="install_skip" value="1" />');
        $('input[name="install_step"]').val(installStep);
        Installer.currentStep = installStep;
        $('#completeForm').submit();
    }

//--></script>