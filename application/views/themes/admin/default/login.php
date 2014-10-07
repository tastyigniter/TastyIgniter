<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="col-md-4 center-block float-none">
			<div class="panel panel-primary panel-login">
				<div class="panel-heading">
					<h3 class="panel-title">Administrator Login</h3>
				</div>
				<div class="panel-body">
					<div id="notification">
						<div class="alert alert-dismissable">
							<?php if (!empty($alert)) { ?>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $alert; ?>
							<?php } ?>
							<?php if (validation_errors()) { ?>
								<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
							<?php } ?>
						</div>
					</div>

					<form role="form" id="edit-form" class="form-vertical" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
						<div class="form-group">
							<label for="input-user" class="control-label">Username</label>
							<div class="">
								<input name="user" type="text" id="input-user" class="form-control" /></td>
								<?php echo form_error('user', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="input-password" class="control-label">Password</label>
							<div class="">
								<input name="password" type="password" id="input-password" class="form-control" /></td>
								<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="pull-left">
								<a href="">Forgot your password?</a>
							</div>
							<button type="submit" class="btn btn-success pull-right">Login</button>
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
<?php echo $footer; ?>