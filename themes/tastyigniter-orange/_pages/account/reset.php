---
title: main::account.reset.text_heading
layout: default
permalink: /forgot-password

'[account]':
---
<div id="page-content">
    <div class="container">
        <div class="heading-section">
            <h3><?= lang('main::account.reset.text_heading'); ?></h3>
        </div>

        <div class="row">
            <div class="content-wrap col-md-6 center-block">
                <p class="text-center"><?= lang('main::account.reset.text_summary'); ?></p>
                <?= form_open(current_url(),
                    [
                        'role'         => 'form',
                        'method'       => 'POST',
                        'data-request' => 'account::onForgotPassword',
                    ]
                ); ?>
                <div class="form-group">
                    <input name="email"
                           type="text"
                           id="email"
                           class="form-control input-lg"
                           value="<?= set_value('email'); ?>"
                           placeholder="<?= lang('main::account.reset.label_email'); ?>"/>
                    <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                </div>

                <div class="clearfix">
                    <button
                        type="submit"
                        class="btn btn-primary btn-lg pull-left"
                    ><?= lang('main::account.reset.button_reset'); ?></button>

                    <a
                        class="btn btn-default btn-lg pull-right"
                        href="<?= site_url('account/login'); ?>"
                    ><?= lang('main::account.reset.button_login'); ?></a>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>