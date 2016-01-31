<form accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>" />
	<input type="hidden" name="licence_agreed" value="1" />
	<div class="terms"><?php echo lang('text_license_terms'); ?></div>
	<div class="buttons">
		<p class="text-right"><?php echo lang('text_license_agreed'); ?></p>
		<div class="pull-right">
			<button type="submit" class="btn btn-success"><?php echo lang('button_continue'); ?></button>
		</div>
	</div>
</form>