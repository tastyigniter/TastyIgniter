---
title: Checkout
layout: default
permalink: /checkout

'[account]':

'[local]':

'[cartBox]':
    pageIsCheckout: true

'[checkout]':
---
<div id="page-content">

    <div class="container">

        <div class="row">
            <div class="content col-sm-8">
                <div class="row">
                    <?= component('local'); ?>
                </div>

                <p class="well">
                    <?= $customer
                        ? sprintf(lang('sampoyigi.cart::default.checkout.text_logout'), $customer->first_name, site_url('account/logout'))
                        : sprintf(lang('sampoyigi.cart::default.checkout.text_registered'), site_url('account/login')); ?>
                </p>

                <div id="checkout-container">
                    <?= partial('checkout::checkout_form'); ?>
                </div>
            </div>

            <div class="col-sm-4">
                <?= component('cartBox'); ?>
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
