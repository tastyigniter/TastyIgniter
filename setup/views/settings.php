<?php
$settings = $setup->getSettingsDetails();
?>
<h5><?= lang('text_restaurant_details'); ?></h5>
<hr>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-site-location-mode"
                   class="control-label"><?= lang('label_site_location_mode'); ?>
            </label>
            <div class="cleafix">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default <?= ($settings->site_location_mode == 'single') ? 'active' : '' ?>">
                        <input type="radio"
                               name="site_location_mode"
                               value="single" <?= $settings->site_location_mode == 'single' ? 'checked' : ''; ?>>
                        <?= lang('text_single_location'); ?>
                    </label>
                    <label class="btn btn-default <?= ($settings->site_location_mode != 'single') ? 'active' : '' ?>">
                        <input type="radio"
                               name="site_location_mode"
                               value="multiple" <?= $settings->site_location_mode != 'single' ? 'checked' : ''; ?>>
                        <?= lang('text_multi_location'); ?>
                    </label>
                </div>
            </div>
            <span class="help-block"><?= lang('help_site_location_mode'); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-demo-data" class="control-label"><?= lang('label_demo_data'); ?>
            </label>
            <div class="clearfix">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default <?= ($settings->demo_data == '1') ? 'active' : '' ?>">
                        <input type="radio"
                               name="demo_data"
                               value="1" <?= $settings->demo_data == '1' ? 'checked' : ''; ?>>
                        <?= lang('text_yes'); ?>
                    </label>
                    <label class="btn btn-default <?= ($settings->demo_data != '1') ? 'active' : '' ?>">
                        <input type="radio"
                               name="demo_data"
                               value="0" <?= $settings->demo_data != '1' ? 'checked' : ''; ?>>
                        <?= lang('text_no'); ?>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-site-name" class="control-label"><?= lang('label_site_name'); ?></label>
            <input type="text"
                   name="site_name"
                   id="input-site-name"
                   class="form-control"
                   value="<?= $settings->site_name; ?>"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-site-email" class="control-label"><?= lang('label_site_email'); ?></label>
            <input type="text"
                   name="site_email"
                   id="input-site-email"
                   class="form-control"
                   value="<?= $settings->site_email; ?>"/>
        </div>
    </div>
</div>

<h5><?= lang('text_admin_details'); ?></h5>
<hr>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-staff-name" class="control-label"><?= lang('label_staff_name'); ?></label>
            <input type="text"
                   name="staff_name"
                   id="input-staff-name"
                   class="form-control"
                   value="<?= $settings->staff_name; ?>"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-username" class="control-label"><?= lang('label_admin_username'); ?></label>
            <input type="text"
                   name="username"
                   id="input-username"
                   class="form-control"
                   value="<?= $settings->username; ?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-password" class="control-label"><?= lang('label_admin_password'); ?></label>
            <input type="password"
                   name="password"
                   id="input-password"
                   class="form-control"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="input-confirm-password"
                   class="control-label"><?= lang('label_confirm_password'); ?>
            </label>
            <input type="password"
                   name="confirm_password"
                   id="input-confirm-password"
                   class="form-control"
                   value=""/>
        </div>
    </div>
</div>

<input type="hidden" name="disableLog" value="1">
<div class="buttons">
    <button type="submit" class="btn btn-success pull-right"><?= lang('button_continue'); ?></button>
</div>
