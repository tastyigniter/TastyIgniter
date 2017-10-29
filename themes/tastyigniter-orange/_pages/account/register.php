---
title: main::account.login.text_register_heading
layout: default
permalink: /register

'[account]':
---
<?php
$registrationTermsUrl = TRUE;
?>
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-section">
                    <h3><?= lang('main::account.login.text_register'); ?></h3>
                </div>

                <div id="register-form" class="content-wrap col-sm-6 center-block">
                    <?= form_open(current_url(),
                        [
                            'role'         => 'form',
                            'method'       => 'POST',
                            'data-request' => 'account::onRegister',
                        ]
                    ); ?>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text"
                                       id="first-name"
                                       class="form-control input-lg"
                                       value="<?= set_value('first_name'); ?>"
                                       name="first_name"
                                       placeholder="<?= lang('main::account.label_first_name'); ?>"
                                       autofocus="">
                                <?= form_error('first_name', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text"
                                       id="last-name"
                                       class="form-control input-lg"
                                       value="<?= set_value('last_name'); ?>"
                                       name="last_name"
                                       placeholder="<?= lang('main::account.label_last_name'); ?>">
                                <?= form_error('last_name', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text"
                               id="email"
                               class="form-control input-lg"
                               value="<?= set_value('email'); ?>"
                               name="email"
                               placeholder="<?= lang('main::account.label_email'); ?>">
                        <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password"
                                       id="password"
                                       class="form-control input-lg"
                                       value=""
                                       name="password"
                                       placeholder="<?= lang('main::account.label_password'); ?>">
                                <?= form_error('password', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password"
                                       id="password-confirm"
                                       class="form-control input-lg"
                                       name="password_confirm"
                                       value=""
                                       placeholder="<?= lang('main::account.label_password_confirm'); ?>">
                                <?= form_error('password_confirm', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text"
                               id="telephone"
                               class="form-control input-lg"
                               value="<?= set_value('telephone'); ?>"
                               name="telephone"
                               placeholder="<?= lang('main::account.label_telephone'); ?>">
                        <?= form_error('telephone', '<span class="text-danger">', '</span>'); ?>
                    </div>
                    <?php if ($captchaHtml = $captcha->render()) { ?>
                    <div class="form-group">
                        <div class="input-group">
                            <span><?= $captchaHtml; ?></span>
                            <input type="text"
                                   name="captcha"
                                   class="form-control"
                                   placeholder="<?= lang('main::account.login.label_captcha'); ?>"
                                   autocomplete="off"/>
                        </div>
                        <?= form_error('captcha', '<span class="text-danger">', '</span>'); ?>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="button-checkbox">
                                <button id="newsletter"
                                        type="button"
                                        class="btn"
                                        data-color="info"
                                        tabindex="7">
                                    &nbsp;&nbsp;<?= lang('main::account.login.button_subscribe'); ?>
                                </button>
                                <input type="checkbox"
                                       name="newsletter"
                                       class="hidden"
                                       value="1" <?= set_checkbox('newsletter', '1'); ?>>
                            </span>
                            <?= lang('main::account.login.label_newsletter'); ?>
                        </div>
                        <?= form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
                    </div>
                    <br/>

                    <?php if ($registrationTermsUrl) { ?>
                        <div class="row">
                            <div class="col-md-12">
									<span class="button-checkbox">
										<button id="terms-condition"
                                                type="button"
                                                class="btn"
                                                data-color="info"
                                                tabindex="7">
                                            &nbsp;&nbsp;<?= lang('main::account.login.button_terms_agree'); ?>
                                        </button>
				                        <input type="checkbox"
                                               name="terms_condition"
                                               class="hidden"
                                               value="1" <?= set_checkbox('terms_condition', '1'); ?>>
									</span>
                                <?= sprintf(lang('main::account.login.label_terms'), $registrationTermsUrl); ?>
                            </div>
                            <?= form_error('terms_condition', '<span class="text-danger">', '</span>'); ?>
                        </div>
                        <div class="modal fade"
                             id="terms-modal"
                             tabindex="-1"
                             role="dialog"
                             aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <button type="submit"
                                    class="btn btn-primary btn-block btn-lg"><?= lang('main::account.login.button_register'); ?></button>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a href="<?= site_url('account/login'); ?>"
                               class="btn btn-default btn-block btn-lg"><?= lang('main::account.login.button_login'); ?></a>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
