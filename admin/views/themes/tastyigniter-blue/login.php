<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="col-md-4 center-block float-none">
			<div class="panel panel-default panel-login">
				<div class="thumbnail">
					<img src="<?php echo base_url('views/themes/tastyigniter-blue/images/tastyigniter-logo.png'); ?>" width="64px">
				</div>
				<div class="panel-body">
					<div id="notification">
						<?php echo $this->alert->display(); ?>
					</div>

					<form role="form" id="edit-form" class="form-vertical" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
						<div class="form-group">
							<label for="input-user" class="control-label"><?php echo lang('label_username'); ?></label>
							<div class="">
                                <div class="input-group">
                                    <input name="user" type="text" id="input-user" class="form-control" /></td>
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                </div>
								<?php echo form_error('user', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-password" class="control-label"><?php echo lang('label_password'); ?></label>
							<div class="">
                                <div class="input-group">
                                    <input name="password" type="password" id="input-password" class="form-control" /></td>
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                </div>
								<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="">
								<a href="<?php echo $reset_url; ?>"><?php echo lang('text_forgot_password'); ?></a>
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-login"><?php echo lang('button_login'); ?></button>
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