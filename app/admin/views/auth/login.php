<div class="container-fluid">
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <?php $logo = setting('site_logo', 'tastyigniter-logo.png'); ?>
                <img alt="<?= setting('site_name'); ?>"
                     src="<?= image_url($logo) ?>"
                     height="64px" width="250px">
            </div>
            <div class="card-body">
                <?= form_open(current_url(),
                    [
                        'id'   => 'edit-form',
                        'role' => 'form',
                        'method' => 'POST'
                    ]
                ); ?>

                <div class="form-group">
                    <label for="input-user" class="control-label"><?= lang('admin::login.label_username'); ?></label>
                    <input name="user" type="text" id="input-user" class="form-control"/>
                    <?= form_error('user', '<span class="text-danger">', '</span>'); ?>
                </div>
                <div class="form-group">
                    <label for="input-password" class="control-label"><?= lang('admin::login.label_password'); ?></label>
                    <input name="password" type="password" id="input-password" class="form-control"/>
                    <?= form_error('password', '<span class="text-danger">', '</span>'); ?>
                </div>
                <div class="form-group">
                    <button
                        type="submit"
                        class="btn btn-primary btn-lg pull-right"
                    ><i class="fa fa-sign-in fa-fw"></i>&nbsp;&nbsp;&nbsp;<?= lang('admin::login.button_login'); ?>
                    </button>
                    <p><a href="<?= admin_url('login/reset'); ?>"><?= lang('admin::login.text_forgot_password'); ?></a>
                    </p>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
