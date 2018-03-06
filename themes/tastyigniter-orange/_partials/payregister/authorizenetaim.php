<div class="radio">
    <label>
        <?php if (!$paymentMethod->isApplicable($order->total, $paymentMethod)) { ?>
            <input type="radio" name="payment" value="" disabled/>
        <?php } else { ?>
            <input
                type="radio"
                name="payment"
                value="authorizenetaim"
                <?= set_radio('payment', 'authorizenetaim') ?>
            />
        <?php } ?>
        <?= $paymentMethod->name; ?>
    </label>
    <?php if (!$paymentMethod->isApplicable($order->total, $paymentMethod)) { ?>
        <span class="text-info"><?= sprintf(
                lang('sampoyigi.payregister::default.alert_min_order_total'),
                currency_format($paymentMethod->minOrderTotal),
                $paymentMethod->name
            ); ?></span>
    <?php } ?>
</div>
<div class="payment-card-icons">
    <i class="fa fa-cc-visa fa-2x"></i>
    <i class="fa fa-cc-mastercard fa-2x"></i>
    <i class="fa fa-cc-amex fa-2x"></i>
    <i class="fa fa-cc-diners-club fa-2x"></i>
    <i class="fa fa-cc-jcb fa-2x"></i>
</div>
<div
    id="authorizeNetAim"
    class="wrap-horizontal"
    data-trigger="[name='payment']"
    data-trigger-action="show"
    data-trigger-condition="value[authorizenetaim]"
    data-trigger-closest-parent="form"
>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="input-card-number"><?= lang('sampoyigi.payregister::default.authorize_net_aim.label_card_number'); ?></label>
                <div class="input-group">
                    <input
                        type="text"
                        id="input-card-number"
                        class="form-control"
                        name="authorize_cc_number"
                        value=""
                        placeholder="<?= lang('sampoyigi.payregister::default.authorize_net_aim.text_cc_number'); ?>"
                        autocomplete="off"
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
                <label for="input-expiry-month"><?= lang('sampoyigi.payregister::default.authorize_net_aim.label_card_expiry'); ?></label>
                <div class="row">
                    <div class="col-xs-6 col-lg-6">
                        <input
                            type="text"
                            name="authorize_cc_exp_month"
                            class="form-control"
                            id="input-expiry-month"
                            value=""
                            placeholder="<?= lang('sampoyigi.payregister::default.authorize_net_aim.text_exp_month'); ?>"
                            autocomplete="off"
                            required
                        />
                    </div>
                    <div class="col-xs-6 col-lg-6">
                        <input
                            type="text"
                            name="authorize_cc_exp_year"
                            class="form-control"
                            id="input-expiry-year"
                            value=""
                            placeholder="<?= lang('sampoyigi.payregister::default.authorize_net_aim.text_exp_year'); ?>"
                            autocomplete="off"
                            required
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-md-5 pull-right">
            <div class="form-group">
                <label for="input-card-cvc"><?= lang('sampoyigi.payregister::default.authorize_net_aim.label_card_cvc'); ?></label>
                <input
                    type="text"
                    class="form-control"
                    name="authorize_cc_cvc"
                    value=""
                    placeholder="<?= lang('sampoyigi.payregister::default.authorize_net_aim.text_cc_cvc'); ?>"
                    autocomplete="off"
                    required
                />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <?php if ($orderType == 'delivery') { ?>
                    <div class="checkbox">
                        <label>
                            <input
                                type="checkbox"
                                value="1"
                                name="authorize_same_address"
                            />
                            <?= lang('sampoyigi.payregister::default.authorize_net_aim.label_same_address') ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div id="authorize-same-address">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <select name="authorize_address_id" class="form-control">
                        <option value="new"><?= lang('sampoyigi.payregister::default.authorize_net_aim.text_add_new_address'); ?></option>
                        <?php foreach ($order->listCustomerAddresses() as $address) { ?>
                            <option value="<?= $address->address_id; ?>"><?= format_address($address); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div id="authorize-hide-address">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="authorize_address_1"
                            value=""
                            placeholder="<?= lang('sampoyigi.cart::default.checkout.label_address_1'); ?>"
                            required
                        />
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="authorize_address_2"
                            value=""
                            placeholder="<?= lang('sampoyigi.cart::default.checkout.label_address_2'); ?>"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="authorize_city"
                            value=""
                            placeholder="<?= lang('sampoyigi.cart::default.checkout.label_city'); ?>"
                        />
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="authorize_state"
                            value=""
                            placeholder="<?= lang('sampoyigi.cart::default.checkout.label_state'); ?>"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control"
                            name="authorize_postcode"
                            value=""
                            placeholder="<?= lang('sampoyigi.cart::default.checkout.label_postcode'); ?>"
                        />
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <select name="authorize_country_id" class="form-control">
                            <?php foreach (countries('country_name') as $key => $value) { ?>
                                <option
                                    value="<?= $key; ?>"
                                    <?= ($key == $order->address['country_id']) ? 'selected="selected"' : '' ?>
                                ><?= e($value); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
