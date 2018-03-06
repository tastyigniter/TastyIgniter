<div class="radio">
    <label>
        <?php if (!$paymentMethod->isApplicable($order->total, $paymentMethod)) { ?>
            <input type="radio" name="payment" value="" disabled/>
        <?php } else { ?>
            <input
                type="radio"
                name="payment"
                value="stripe"
                <?= set_radio('payment', 'stripe') ?>
            />
        <?php } ?>
        <?= e($paymentMethod->name); ?> - <?= $paymentMethod->description; ?>
    </label>
    <?php if (!$paymentMethod->isApplicable($order->total, $paymentMethod)) { ?>
        <span class="text-info"><?= sprintf(
                lang('sampoyigi.payregister::default.stripe.sampoyigi.payregister::default.alert_min_order_total'),
                currency_format($paymentMethod->minOrderTotal),
                $paymentMethod->name
            ); ?></span>
    <?php } ?>
</div>
<div
    id="stripePaymentForm"
    class="wrap-horizontal"
    data-trigger="[name='payment']"
    data-trigger-action="show"
    data-trigger-condition="value[stripe]"
    data-trigger-closest-parent="form"
>
    <?php foreach ($paymentMethod->getHiddenFields() as $name => $value) { ?>
        <input type="hidden" name="<?= $name; ?>" value="<?= $value; ?>"/>
    <?php } ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="input-card-number"><?= lang('sampoyigi.payregister::default.stripe.label_card_number'); ?></label>
                <div class="input-group">
                    <input
                        type="text"
                        id="input-card-number"
                        class="form-control"
                        name="stripe_cc_number"
                        value=""
                        placeholder="<?= lang('sampoyigi.payregister::default.stripe.text_cc_number'); ?>"
                        autocomplete="cc-number"
                        size="20"
                        data-stripe="number"
                        required
                    />
                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-7 col-md-7">
            <div class="form-group">
                <label for="input-expiry-month"><?= lang('sampoyigi.payregister::default.stripe.label_card_expiry'); ?></label>
                <div class="row">
                    <div class="col-xs-6 col-lg-6">
                        <input
                            type="tel"
                            class="form-control"
                            id="input-expiry-month"
                            name="stripe_cc_exp_month"
                            value=""
                            placeholder="<?= lang('sampoyigi.payregister::default.stripe.text_exp_month'); ?>"
                            autocomplete="off"
                            size="2"
                            data-stripe="exp-month"
                            required
                            data-numeric
                        />
                    </div>
                    <div class="col-xs-6 col-lg-6">
                        <input
                            type="tel"
                            class="form-control"
                            id="input-expiry-year"
                            name="stripe_cc_exp_year"
                            value=""
                            placeholder="<?= lang('sampoyigi.payregister::default.stripe.text_exp_year'); ?>"
                            autocomplete="off"
                            size="4"
                            data-stripe="exp-year"
                            required
                            data-numeric
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-md-5 pull-right">
            <div class="form-group">
                <label for="input-card-cvc"><?= lang('sampoyigi.payregister::default.stripe.label_card_cvc'); ?></label>
                <input
                    type="tel"
                    class="form-control"
                    name="stripe_cc_cvc"
                    value=""
                    placeholder="<?= lang('sampoyigi.payregister::default.stripe.text_cc_cvc'); ?>"
                    autocomplete="off"
                    size="4"
                    data-stripe="cvc"
                    required
                />
            </div>
        </div>
    </div>
</div>
