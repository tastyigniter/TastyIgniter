<?php
		$locations = array();
?>
</div>
<div id="footer" class="<?php echo ($this->user->islogged()) ? '' : 'wrap-none'; ?>">
	<div class="row navbar-footer">
		<div class="col-sm-8 version">
			<p class="text-version"><?php echo sprintf(lang('text_copyright'), config_item('ti_version')); ?></p>
		</div>
		<?php if ($locations) { ?>
			<div class="col-sm-3 navbar-locations">
				<form role="form" class="navbar-form navbar-left" role="form">
					<div class="form-group">
						<select name="location" class="form-control">
						<?php foreach ($locations as $location) { ?>
							<?php if ($this->user->getLocationId() === $location['location_id']) { ?>
								<option value="<?php echo $location['location_id']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
							<?php } ?>
						<?php } ?>
						</select>
					</div>
				</form>
			</div>
		<?php } ?>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
        //$('.' + active_menu).parents('.collapse').addClass('in');
		$('#side-menu .' + active_menu).addClass('active');
        $('#side-menu .' + active_menu).parents('.collapse').parent().addClass('active');
        $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
        $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
    }

    if (window.location.hash) {
        var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
		$('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
        $('#nav-tabs a[href="#'+hash+'"]').tab('show');
    }

    if (window.location.search.indexOf('filter_', 1) != -1) {
        $('.btn-filter').trigger('click');
    }

    $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');

    /*if ($('.form-group .text-danger').length > 0) {
        $('.form-group .text-danger').parents('.form-group').addClass('has-error');
    }*/
});

function confirmDelete(form = 'list-form') {
	if ($('input[name="delete[]"]:checked').length && confirm('<?php echo lang('alert_warning_confirm'); ?>')) {
		$('#'+form).submit();
	} else {
		return false;
	}
}

function saveClose() {
	$('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
	$('#edit-form').submit();
}
</script>
</body>
</html>