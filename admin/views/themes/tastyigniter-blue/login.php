<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="col-md-4 center-block float-none">
			<div class="panel panel-primary panel-login">
				<!--<div class="panel-heading">
                    <a class="login-logo" href="<?php echo site_url('dashboard'); ?>"><span class="navbar-logo"></span><?php echo $site_name; ?></a>
				</div>-->
				<div class="panel-body">
					<div id="notification">
						<?php echo $this->alert->display(); ?>
					</div>

					<form role="form" id="edit-form" class="form-vertical" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
						<div class="form-group">
							<label for="input-user" class="control-label">Username</label>
							<div class="">
                                <div class="input-group">
                                    <input name="user" type="text" id="input-user" class="form-control" /></td>
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                </div>
								<?php echo form_error('user', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-password" class="control-label">Password</label>
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
								<a href="<?php echo $reset_url; ?>">Forgot your password?</a>
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-login">Login</button>
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