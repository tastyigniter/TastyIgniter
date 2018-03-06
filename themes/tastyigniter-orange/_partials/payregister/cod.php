<div
    class="radio"
>
    <label>
        <?php if (!$paymentMethod->isApplicable($order->total, $paymentMethod)) { ?>
            <input type="radio" name="payment" value="" disabled/>
        <?php } else { ?>
            <input
                type="radio"
                name="payment"
                value="cod"
                <?= set_radio('payment', 'cod') ?>
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