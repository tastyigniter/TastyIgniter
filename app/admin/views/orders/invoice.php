<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= lang('text_invoice'); ?> - <?= $this->config->item('site_name'); ?></title>
    <?= get_style_tags(); ?>

    <style>
        body {
            background-color: #FFF;
            font-family: "Lato", Arial, sans-serif;
        }
        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }
        .table > tbody > tr > .no-line {
            border-top: none;
        }
        .table > thead > tr > .no-line {
            border-bottom: none;
        }
        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }
    </style>
</head>
<body>
    <div id="invoice-container" class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="invoice-title">
                            <h2><?= lang('text_invoice'); ?></h2>
                            <h3 class="pull-right"><?= lang('label_order_id'); ?><?= $order_id; ?></h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <span class="text-muted"><?= lang('text_restaurant'); ?>:</span><br>
                                    <strong><?= $location_name; ?></strong><br>
                                    <?= $location_address; ?>
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <img src="<?= $invoice_logo; ?>" style="max-width: 100%;"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <span class="text-muted"><?= lang('text_customer'); ?>:</span><br>
                                    <strong><?= $first_name; ?> <?= $last_name; ?></strong><br>
                                    <?= $email; ?>
                                </address>
                                <?php if ($check_order_type == '1') { ?>
                                    <address>
                                        <span class="text-muted"><?= lang('text_deliver_to'); ?>:</span><br>
                                        <?= $customer_address; ?>
                                    </address>
                                <?php } ?>
                            </div>
                            <div class="col-xs-3 text-left">
                                <address>
                                    <strong><?= lang('text_invoice_no'); ?>:</strong><br>
                                    <?= $invoice_no; ?>
                                </address>
                                <address>
                                    <strong><?= lang('text_invoice_date'); ?>:</strong><br>
                                    <?= $invoice_date; ?><br><br>
                                </address>
                            </div>
                            <div class="col-xs-3 text-right">
                                <address>
                                    <strong><?= lang('text_payment'); ?>:</strong><br>
                                    <?= $payment; ?>
                                </address>
                                <address>
                                    <strong><?= lang('text_order_date'); ?>:</strong><br>
                                    <?= $date_added; ?>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-left" width="65%"><?= lang('column_name_option'); ?></th>
                                    <th class="text-left"><?= lang('column_price'); ?></th>
                                    <th class="text-right"><?= lang('column_total'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($cart_items as $cart_item) { ?>
                                    <tr id="<?= $cart_item['id']; ?>">
                                        <td><?= $cart_item['qty']; ?>x</td>
                                        <td class="text-left"><?= $cart_item['name']; ?><br/>
                                            <?php if (!empty($cart_item['options'])) { ?>
                                                <div>
                                                    <small><?= lang('text_plus'); ?><?= $cart_item['options']; ?></small>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($cart_item['comment'])) { ?>
                                                <div>
                                                    <small><b><?= $cart_item['comment']; ?></b></small>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td class="text-left"><?= $cart_item['price']; ?></td>
                                        <td class="text-right"><?= $cart_item['subtotal']; ?></td>
                                    </tr>
                                <?php } ?>
                                <?php $total_count = 1; ?>
                                <?php foreach ($totals as $total) { ?>
                                    <tr>
                                        <td class="<?= ($total_count === 1) ? 'thick' : 'no'; ?>-line"></td>
                                        <td class="<?= ($total_count === 1) ? 'thick' : 'no'; ?>-line"></td>
                                        <?php if ($total['code'] === 'order_total') { ?>
                                            <td class="thick-line text-left"><b><?= $total['title']; ?></b></td>
                                            <td class="thick-line text-right"><b><?= $total['value']; ?></b></td>
                                        <?php }
                                        else { ?>
                                            <td class="<?= ($total_count === 1) ? 'thick' : 'no'; ?>-line text-left"><?= $total['title']; ?></td>
                                            <td class="<?= ($total_count === 1) ? 'thick' : 'no'; ?>-line text-right"><?= $total['value']; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php $total_count++; ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center"><?= lang('text_invoice_thank_you'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>