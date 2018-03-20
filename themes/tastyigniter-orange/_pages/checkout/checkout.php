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
                        ? sprintf(lang('sampoyigi.cart::default.checkout.text_logout'), $customer->first_name, 'account::onLogout')
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
