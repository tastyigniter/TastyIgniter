<?php echo get_header(); ?>
    <div class="row content">
        <div class="col-md-12">
            <div class="col-md-4 center-block float-none">
                <div class="panel panel-default panel-login">
                    <div class="thumbnail">
                        <img src="<?php echo image_url('tastyigniter-logo.png'); ?>" width="250px">
                    </div>
                    <div class="panel-body">
                        <h3><?php echo lang('text_reset_password_title'); ?></h3>
                        <div id="notification">
                            <?php echo $this->alert->display(); ?>
                        </div>

                        <form role="form" id="edit-form" class="form-vertical" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                            <?php if (empty($reset_code)) { ?>
                                <div class="form-group">
                                    <label for="input-user" class="control-label"><?php echo lang('label_username'); ?></label>
                                    <div class="">
                                        <input name="username" type="text" id="input-user" class="form-control"/></td>
                                        <?php echo form_error('username', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <input type="password" id="password" class="form-control input-lg" name="password" placeholder="<?php echo lang('label_password'); ?>">
                                    <?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password-confirm" class="form-control input-lg" name="password_confirm" placeholder="<?php echo lang('label_password_confirm'); ?>">
                                    <?php echo form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            <?php } ?>
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
        $(document).ready(function () {
            $('body').addClass('body-login');
        });
        //--></script>
<?php echo get_footer(); ?>