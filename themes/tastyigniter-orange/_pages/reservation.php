---
title: main::default.reservation.text_heading
layout: default
permalink: /reservation
---
<?php
$customerIsLogged = false;
$redirect =  null;
?>
<div id="page-content">

    <?= component('tableFinder'); ?>

    <div class="container">

        <div class="row">

            <div class="">
                <div class="content-wrap">
                    <form
                        method="POST"
                        accept-charset="utf-8"
                        id="reservation-form"
                        role="form">
                        <p>
                            <?= $customerIsLogged
                                ? sprintf(lang('main::default.reservation.text_logout'), $reservation->first_name, site_url('account/logout'.$redirect))
                                : sprintf(lang('main::default.reservation.text_registered'), site_url('account/login'.$redirect)); ?>
                        </p>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="first_name"
                                        id="first-name"
                                        class="form-control"
                                        placeholder="<?= lang('main::default.reservation.label_first_name'); ?>"
                                        value="<?= set_value('first_name', $reservation->first_name); ?>"/>
                                    <?= form_error('first_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="last_name"
                                        id="last-name"
                                        class="form-control"
                                        placeholder="<?= lang('main::default.reservation.label_last_name'); ?>"
                                        value="<?= set_value('last_name', $reservation->last_name); ?>"/>
                                    <?= form_error('last_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        placeholder="<?= lang('main::default.reservation.label_email'); ?>"
                                        value="<?= set_value('email', $reservation->email); ?>"/>
                                    <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        name="confirm_email"
                                        id="confirm-email"
                                        class="form-control"
                                        placeholder="<?= lang('main::default.reservation.label_confirm_email'); ?>"
                                        value="<?= set_value('confirm_email', $reservation->email); ?>"/>
                                    <?= form_error('confirm_email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input
                                type="text"
                                name="telephone"
                                id="telephone"
                                class="form-control"
                                placeholder="<?= lang('main::default.reservation.label_telephone'); ?>"
                                value="<?= set_value('telephone', $reservation->telephone); ?>"/>
                            <?= form_error('telephone', '<span class="text-danger">', '</span>'); ?>
                        </div>

                        <div class="form-group">
                                <textarea
                                    name="comment"
                                    id="comment"
                                    class="form-control"
                                    rows="2"
                                    placeholder="<?= lang('main::default.reservation.label_comment'); ?>"
                                ><?= set_value('comment', $reservation->comment); ?></textarea>
                            <?= form_error('comment', '<span class="text-danger">', '</span>'); ?>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span><?= $captcha['image']; ?></span>
                                <input
                                    type="text"
                                    name="captcha"
                                    class="form-control"
                                    placeholder="<?= lang('main::default.reservation.label_captcha'); ?>"/>
                            </div>
                            <?= form_error('captcha', '<span class="text-danger">', '</span>'); ?>
                        </div>

                        <?php if ($showButtons) { ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-block btn-lg"
                                    ><?= lang('main::default.reservation.button_reservation'); ?></button>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default btn-lg text-muted"
                                       href="<?= site_url('reservation'); ?>"
                                    ><?= lang('main::default.reservation.button_find_again'); ?></a>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
