<div class="radio">
    <label>
        <?php if ($minimum_order_total >= $order_total) { ?>
            <input type="radio" name="payment" value="" <?php echo set_radio('payment', ''); ?> disabled />
        <?php } else if ($payment === $code) { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code, TRUE); ?> />
        <?php } else { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code); ?> />
        <?php } ?>
        <?php echo $title; ?>
    </label>
    <?php if ($minimum_order_total >= $order_total) { ?>
        <br /><span class="text-info"><?php echo sprintf(lang('alert_min_order_total'), currency_format($minimum_order_total)); ?></span>
    <?php } ?>
</div>