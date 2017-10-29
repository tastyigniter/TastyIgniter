---
title: main::default.checkout.text_tab_gallery
layout: default
permalink: /checkout
---
<?php
$order_times = null;
?>
<div id="page-content">

    <?= component('local'); ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-9" data-control="checkout">
                <?= form_open(current_url(),
                    [
                        'id'   => 'checkout-form',
                        'role' => 'form',
                        'method'  => 'POST',
                        'handler' => 'onConfirm',
                    ]
                ); ?>

                <div id="checkout" class="content-wrap">
                    <p>
                        <?= $customerIsLogged
                            ? sprintf(lang('text_logout'), $order->first_name, site_url('account/logout'.$redirect))
                            : sprintf(lang('text_registered'), site_url('account/login'.$redirect)); ?>
                    </p>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first-name"><?= lang('label_first_name'); ?></label>
                                <input
                                    type="text"
                                    name="first_name"
                                    id="first-name"
                                    class="form-control"
                                    value="<?= set_value('first_name', $order->first_name); ?>"/>
                                <?= form_error('first_name', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last-name"><?= lang('label_last_name'); ?></label>
                                <input
                                    type="text"
                                    name="last_name"
                                    id="last-name"
                                    class="form-control"
                                    value="<?= set_value('last_name', $order->last_name); ?>"/>
                                <?= form_error('last_name', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email"><?= lang('label_email'); ?></label>
                                <input
                                    type="text"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="<?= set_value('email', $order->email); ?>"
                                    <?= $customerIsLogged ? 'disabled' : ''; ?> />
                                <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telephone"><?= lang('label_telephone'); ?></label>
                                <input
                                    type="text"
                                    name="telephone"
                                    id="telephone"
                                    class="form-control"
                                    value="<?= set_value('telephone', $order->telephone); ?>"/>
                                <?= form_error('telephone', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="order-time">
                                    <?= sprintf(lang('label_order_time'), $order->isDeliveryType()
                                        ? lang('label_delivery') : lang('label_collection')); ?>
                                </label>
                                <?php if ($orderTimes = $order->listAvailableTimes()) { ?>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php if (!empty($order_times['asap'])) { ?>
                                            <label class="btn btn-default <?= ($order_time_type === 'asap') ? 'btn-primary active' : ''; ?>"
                                                   data-btn="btn-primary">
                                                <input type="hidden"
                                                       name="order_asap_time"
                                                       value="<?= $order_times['asap']; ?>">
                                                <input type="radio"
                                                       name="order_time_type"
                                                       value="asap" <?= ($order_time_type === 'asap') ? 'checked="checked"' : ''; ?>>
                                                <?= lang('text_asap'); ?>
                                            </label>
                                        <?php } ?>
                                        <label
                                            class="btn btn-default <?= ($order_time_type === 'later') ? 'btn-primary active' : ''; ?>"
                                            data-btn="btn-primary">
                                            <input
                                                type="radio"
                                                name="order_time_type"
                                                value="later" <?= ($order_time_type === 'later') ? 'checked="checked"' : ''; ?>
                                            ><?= lang('text_later'); ?>
                                        </label>
                                    </div>
                                <?php }
                                else { ?>
                                    <br/><?= lang('text_location_closed'); ?><br/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ($orderTimes = $order->listAvailableTimes()) { ?>
                            <div id="choose-order-time"
                                 class="col-sm-6"
                                 style="display: <?= ($order_time_type === 'later') ? 'block' : 'none'; ?>;">
                                <div class="form-group">
                                    <label for="choose-order-time"><?= sprintf(lang('label_choose_order_time'), $order_type_text); ?></label>
                                    <div class="row order-time-group">
                                        <div class="col-xs-12 col-sm-6 order-later date-input-addon">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <select name="order_date"
                                                        id="order-date"
                                                        class="form-control">
                                                    <?php foreach ($order_times as $date => $times) { ?>
                                                        <?php if ($date === 'asap' OR empty($times)) continue; ?>

                                                        <?php if (!empty($order_date) AND $date == $order_date) { ?>
                                                            <option value="<?= $date; ?>"
                                                                    selected="selected"><?= mdate(lang('text_date_format'), strtotime($date)); ?></option>
                                                        <?php }
                                                        else { ?>
                                                            <option value="<?= $date; ?>"><?= mdate(lang('text_date_format'), strtotime($date)); ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <input type="hidden"
                                                       name="order_hour"
                                                       value="<?= $order_hour; ?>">
                                                <input type="hidden"
                                                       name="order_minute"
                                                       value="<?= $order_minute; ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 order-later time-input-addon">
                                            <?php foreach ($order_times as $date => $times) { ?>
                                                <?php if ($date === 'asap' OR empty($times)) continue; ?>
                                                <div id="order-time-<?= $date; ?>"
                                                     class="input-group"
                                                     style="display: <?= ($date == $order_date) ? 'table' : 'none'; ?>">
                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    <select id="hours-for-<?= $date; ?>"
                                                            data-parent="#order-time-<?= $date; ?>"
                                                            class="form-control hours">
                                                        <?php foreach ($times as $hour => $minutes) { ?>
                                                            <?php if ($hour == $order_hour) { ?>
                                                                <option value="<?= $hour; ?>"
                                                                        selected="selected"><?= $hour; ?>:
                                                                </option>
                                                            <?php }
                                                            else { ?>
                                                                <option value="<?= $hour; ?>"><?= $hour; ?>:</option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                    <?php $count = 1; ?>
                                                    <?php foreach ($times as $hour => $minutes) { ?>
                                                        <select data-parent="#order-time-<?= $date; ?>"
                                                                class="form-control minutes minutes-for-<?= $hour; ?> <?= ($hour == $order_hour) ? '' : 'hide'; ?>">
                                                            <?php foreach ($minutes as $minute) { ?>
                                                                <?php if ($minute == $order_minute) { ?>
                                                                    <option value="<?= $minute; ?>"
                                                                            selected="selected"><?= $minute; ?></option>
                                                                <?php }
                                                                else { ?>
                                                                    <option value="<?= $minute; ?>"><?= $minute; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <?php $count++; ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php } ?>
                        <div class="col-sm-12">
                            <?= form_error('order_asap_time', '<span class="text-danger">', '</span>'); ?>
                            <?= form_error('order_hour', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>

                    <?php if ($order->isDeliveryType()) { ?>
                        <div id="checkout-delivery"
                             class="row wrap-bottom"
                        >
                            <div id="address-labels">
                                <div class="btn-group btn-group-md col-xs-12" data-toggle="buttons">
                                    <?php $index = 0;
                                    foreach ($order->listAddresses() as $address) { ?>
                                        <?php
                                        $isDefaultAddress = ($order->address_id == $address->address_id);
                                        ?>
                                        <label
                                            class="btn <?= $isDefaultAddress ? 'btn-primary active' : 'btn-default'; ?>"
                                            data-btn="btn-primary"
                                        >
                                                            <span
                                                                class="edit-address pull-right"
                                                                data-form="#address-form-<?= $index; ?>"
                                                            ><?= lang('text_edit'); ?></span>
                                            <input
                                                type="radio"
                                                name="address_id"
                                                value="<?= $address->address_id; ?>"
                                                <?= $isDefaultAddress ? 'checked="checked"' : ''; ?> />
                                            <address class="text-left"><?= $address->formatted; ?></address>
                                        </label>
                                        <?php $index++; ?>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-12">
                                    <?= form_error('address_id', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>

                            <div id="address-forms">
                                <div
                                    id="address-form-<?= $index; ?>" class="col-xs-12 wrap-horizontal">
                                    <input
                                        type="hidden"
                                        name="address[<?= $index; ?>][address_id]"
                                        value="<?= set_value('address['.$index.'][address_id]', $order->address['address_id']); ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""><?= lang('label_address_1'); ?></label>
                                                <input
                                                    type="text"
                                                    name="address[<?= $index; ?>][address_1]"
                                                    class="form-control"
                                                    value="<?= set_value('address['.$index.'][address_1]', $order->address['address_1']); ?>"/>
                                                <?= form_error('address['.$index.'][address_1]', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for=""><?= lang('label_address_2'); ?></label>
                                                <input
                                                    type="text"
                                                    name="address[<?= $index; ?>][address_2]"
                                                    class="form-control"
                                                    value="<?= set_value('address['.$index.'][address_2]', $order->address['address_2']); ?>"/>
                                                <?= form_error('address['.$index.'][address_2]', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for=""><?= lang('label_city'); ?></label>
                                                <input
                                                    type="text"
                                                    name="address[<?= $index; ?>][city]"
                                                    class="form-control"
                                                    value="<?= set_value('address['.$index.'][city]', $order->address['city']); ?>"/>
                                                <?= form_error('address['.$index.'][city]', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for=""><?= lang('label_state'); ?></label>
                                                <input
                                                    type="text"
                                                    name="address[<?= $index; ?>][state]"
                                                    class="form-control"
                                                    value="<?= set_value('address['.$index.'][state]', $order->address['state']); ?>"/>
                                                <?= form_error('address['.$index.'][state]', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for=""><?= lang('label_postcode'); ?></label>
                                                <input
                                                    type="text"
                                                    name="address[<?= $index; ?>][postcode]"
                                                    class="form-control"
                                                    value="<?= set_value('address['.$index.'][postcode]', $order->address['postcode']); ?>"/>
                                                <?= form_error('address['.$index.'][postcode]', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?= lang('label_country'); ?></label>
                                        <select
                                            name="address[<?= $index; ?>][country_id]"
                                            class="form-control"
                                        >
                                            <?php foreach ($order->listCountries() as $key => $value) { ?>
                                                <option
                                                    value="<?= $key; ?>"
                                                    <?= ($key == $order->address['country_id']) ? 'selected="selected"' : '' ?>
                                                ><?= $value; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?= form_error('address['.$index.'][country_id]', '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div id="payment" class="wrap-top">
                        <div class="form-group">
                            <label for=""><?= lang('label_payment_method'); ?></label><br/>
                            <div class="list-group">
                                <?php foreach ($order->listPayments() as $payment) { ?>
                                    <div class="list-group-item"><?= $payment->renderPaymentForm(); ?></div>
                                <?php } ?>
                            </div>
                            <?= form_error('payment', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>

                    <div class="form-group wrap-top">
                        <label for=""><?= lang('label_comment'); ?></label>
                        <textarea
                            name="comment"
                            id="comment"
                            rows="3"
                            class="form-control"><?= set_value('comment', $order->comment); ?></textarea>
                        <?= form_error('comment', '<span class="text-danger">', '</span>'); ?>
                    </div>

                    <?php if ($showAgreeTerms) { ?>
                        <div class="form-group">
                            <div class="input-group">
                                                    <span class="input-group-addon button-checkbox">
                                                        <button
                                                            type="button"
                                                            class="btn"
                                                            data-color="info"
                                                            tabindex="7">&nbsp;&nbsp;<?= lang('button_agree_terms'); ?></button>
                                                        <input
                                                            type="checkbox"
                                                            name="terms_condition"
                                                            id="terms-condition"
                                                            class="hidden"
                                                            value="1" <?= set_checkbox('terms_condition', '1'); ?>>
                                                    </span>
                                <span class="form-control"><?= sprintf(lang('label_terms'), $agreeTermsUrl); ?></span>
                            </div>
                            <?= form_error('terms_condition', '<span class="text-danger col-xs-12">', '</span>'); ?>
                        </div>
                        <div
                            class="modal fade"
                            id="terms-modal"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="agreeTermsModal"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for=""><?= lang('label_ip'); ?></label>
                        <?= $loggedIp; ?><br/>
                        <small><?= lang('text_ip_warning'); ?></small>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>

            <div class="col-sm-4 col-md-3">
                <?= component('cart'); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"><!--
    //        $(document).ready(function () {
    //            $("#choose-order-time select.form-control").select2({
    //                minimumResultsForSearch: Infinity
    //            })
    //
    //            $('input[name="order_time_type"]').on('change', function () {
    //                $('#choose-order-time').fadeOut()
    //
    //                if (this.value === 'later') {
    //                    $('#choose-order-time').fadeIn()
    //                }
    //            })
    //
    //            $('select[name="order_date"]').on('change', function () {
    //                $('#choose-order-time .time-input-addon .input-group').css("display", "none")
    //
    //                var timeAddonId = "#order-time-" + this.value
    //                if ($(timeAddonId).length) {
    //                    $(timeAddonId).css("display", "table")
    //                    $(timeAddonId + ' select.hours, ' + timeAddonId + ' select.minutes:not(.hide)').trigger("change")
    //                }
    //            })
    //
    //            $('select.hours').on('change', function () {
    //                var minutesAddonId = ".minutes-for-" + this.value
    //
    //                $('#choose-order-time .time-input-addon .minutes').addClass("hide")
    //                $('input[name="order_hour"]').val(this.value)
    //
    //                if ($(this).parent().find(minutesAddonId).length) {
    //                    $(minutesAddonId).removeClass("hide")
    //                    $(minutesAddonId).css("display", "table-cell")
    //                    $(minutesAddonId).trigger("change")
    //                }
    //            })
    //
    //            $('select.minutes').on('change', function () {
    //                $('input[name="order_minute"]').val(this.value)
    //            })
    //
    //            $('#address-labels input[name="address_id"]').on('change', function () {
    //                var formToggle = $(this).parent().parent().find('.edit-address')
    //                formToggle.text('<?//= lang('text_edit'); ?>//')
    //                $('#address-forms > div').slideUp()
    //            })
    //
    //
    //            $('#address-labels .edit-address').on('click', function () {
    //                var formDiv = $(this).attr('data-form')
    //                $('#address-forms > div').slideUp()
    //
    //                if ($(formDiv).is(':visible')) {
    //                    $(this).text('<?//= lang('text_edit'); ?>//')
    //                    $(formDiv).slideUp()
    //                } else {
    //                    $(this).text('<?//= lang('text_close'); ?>//')
    //                    $(formDiv).slideDown()
    //                }
    //            })
    //
    //            $('.step-one.link a').on('click', function () {
    //                $(this).removeClass('link')
    //                $('.step-two').removeClass('active').addClass('disabled')
    //                $('.step-one').addClass('active')
    //                $('input[name="checkout_step"]').val('one')
    //                $('#checkout').fadeIn()
    //                $('#payment').fadeOut()
    //                $('#cart-box .btn-order').text('<?//= lang('button_payment'); ?>//')
    //            })
    //        })
    //--></script>
