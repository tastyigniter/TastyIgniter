<div class="row-fluid">
    <div class="col-md-4 center-block float-none">
        <div class="panel panel-default panel-login">
            <div class="thumbnail">
                <img src="<?= image_url('tastyigniter-logo.png'); ?>" width="250px">
            </div>
            <div class="panel-body">
                <h5><?= lang('admin::login.text_reset_password_title'); ?></h5>
                <?= form_open(current_url(),
                    [
                        'id'   => 'edit-form',
                        'role' => 'form',
                        'method' => 'POST'
                    ]
                ); ?>

                <?php if (empty($resetCode)) { ?>
                    <div class="form-group">
                        <label for="input-user"
                               class="control-label"><?= lang('admin::login.label_username'); ?></label>
                        <div class="">
                            <input name="username" type="text" id="input-user" class="form-control"/>
                            <?= form_error('username', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                <?php }
                else { ?>
                    <div class="form-group">
                        <input type="password"
                               id="password"
                               class="form-control input-lg"
                               name="password"
                               placeholder="<?= lang('admin::login.label_password'); ?>">
                        <?= form_error('password', '<span class="text-danger">', '</span>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="password"
                               id="password-confirm"
                               class="form-control input-lg"
                               name="password_confirm"
                               placeholder="<?= lang('admin::login.label_password_confirm'); ?>">
                        <?= form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <div class="pull-left">
                        <a class="btn btn-default"
                           href="<?= admin_url('login'); ?>"><?= lang('admin::login.text_back_to_login'); ?></a>
                    </div>
                    <button type="submit"
                            class="btn btn-success pull-right"><?= lang('admin::login.button_reset_password'); ?></button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
