---
title: Login
layout: default
permalink: /login

'[account]':
    security: guest
---
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-section">
                    <h3><?= lang('main::account.login.text_login'); ?></h3>
                </div>

                <div id="login-form" class="content-wrap col-sm-4 center-block">
                    <?= partial('account::login'); ?>

                    <div class="row">
                        <div class="col-md-5 wrap-none">
                            <a class="btn btn-link btn-lg" href="<?= site_url('account/reset'); ?>">
                                <span class="small"><?= lang('main::account.login.text_forgot'); ?></span>
                            </a>
                        </div>
                        <div class="col-md-7">
                            <a
                                class="btn btn-default btn-block btn-lg"
                                href="<?= site_url('account/register'); ?>"
                            ><?= lang('main::account.login.button_register'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
