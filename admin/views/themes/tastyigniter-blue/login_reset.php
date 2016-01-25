<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="col-md-4 center-block float-none">
			<div class="panel panel-default panel-login">
				<div class="thumbnail">
					<img src="<?php echo base_url('views/themes/tastyigniter-blue/images/tastyigniter-logo.png'); ?>" width="64px">
				</div>
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo lang('text_reset_password_title'); ?></h3>
				</div>
				<div class="panel-body">
					<div id="notification">
						<?php echo $this->alert->display(); ?>
					</div>

					<form role="form" id="edit-form" class="form-vertical" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
						<div class="form-group">
							<label for="input-user" class="control-label"><?php echo lang('label_username_email'); ?></label>
							<div class="">
								<input name="user_email" type="text" id="input-user" class="form-control" /></td>
								<?php echo form_error('user_email', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="pull-left">
								<a class="btn btn-default" href="<?php echo $login_url; ?>"><?php echo lang('text_back_to_login'); ?></a>
							</div>
							<button type="submit" class="btn btn-success pull-right"><?php echo lang('button_reset_password'); ?></button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('body').addClass('body-login');
});
//--></script>
<?php echo get_footer(); ?>