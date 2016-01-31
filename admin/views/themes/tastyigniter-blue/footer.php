</div>
<div id="footer" class="<?php echo ($this->user->islogged()) ? '' : 'wrap-none'; ?>">
	<div class="row navbar-footer">
		<div class="col-sm-12 text-version">
			<p class="col-xs-9 wrap-none"><?php echo lang('tastyigniter_copyright'); ?></p>
			<p class="col-xs-3 text-right wrap-none"><?php echo sprintf(lang('tastyigniter_version'), config_item('ti_version')); ?></p>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
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

    $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
});

function confirmDelete(form) {
	if ($('input[name="delete[]"]:checked').length && confirm('<?php echo lang('alert_warning_confirm'); ?>')) {
		form = (typeof form === 'undefined' || form === null) ? 'list-form' : form;
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