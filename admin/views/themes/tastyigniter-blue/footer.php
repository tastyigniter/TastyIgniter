</div>
<div id="footer" class="<?php echo ($this->user->islogged()) ? '' : 'wrap-none'; ?>">
	<div class="row navbar-footer">
		<div class="col-sm-12 version">
			<p class="text-version"><?php echo sprintf(lang('text_copyright'), config_item('ti_version')); ?></p>
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

    if (window.location.search.indexOf('filter_', 1) != -1) {
        $('.btn-filter').trigger('click');
    }

    $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
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