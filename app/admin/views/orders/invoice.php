<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= $model->invoice_id.' - '.lang('admin::lang.orders.text_invoice'); ?>
        - <?= setting('site_name'); ?></title>
    <?= get_style_tags(); ?>
    <style>
        body {
            background-color: #FFF;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col">
                <div class="invoice-title">
                    <h3 class="pull-right"><?= lang('admin::lang.orders.label_order_id'); ?><?= $model->order_id; ?></h3>
                    <h2><?= lang('admin::lang.orders.text_invoice'); ?></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col py-3">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <strong><?= lang('admin::lang.orders.text_restaurant'); ?></strong><br>
                <span><?= $model->location->getName(); ?></span><br>
                <address><?= format_address($model->location->getAddress(), TRUE); ?></address>
            </div>
            <div class="col-6 text-right">
                <img class="img-responsive" src="<?= uploads_url(setting('site_logo')); ?>"/>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <p>
                    <strong><?= lang('admin::lang.orders.text_customer'); ?></strong><br>
                    <?= $model->first_name; ?> <?= $model->last_name; ?><br>
                    <?= $model->email; ?>
                </p>
                <?php if ($model->isDeliveryType()) { ?>
                    <span class="text-muted"><?= lang('admin::lang.orders.text_deliver_to'); ?></span><br>
                    <address><?= $model->formatted_address; ?></address>
                <?php } ?>
            </div>
            <div class="col-3 text-left">
                <p>
                    <strong><?= lang('admin::lang.orders.text_invoice_no'); ?></strong><br>
                    <?= $model->invoice_id; ?>
                </p>
                <p>
                    <strong><?= lang('admin::lang.orders.text_invoice_date'); ?></strong><br>
                    <?= $model->invoice_date->format(setting('date_format')); ?><br><br>
                </p>
            </div>
            <div class="col-3 text-right">
                <p>
                    <strong><?= lang('admin::lang.orders.text_payment'); ?></strong><br>
                    <?= $model->payment_method->name; ?>
                </p>
                <p>
                    <strong><?= lang('admin::lang.orders.text_order_date'); ?></strong><br>
                    <?= $model->order_date->setTimeFromTimeString($model->order_time)->format(setting('date_format').' - '.setting('time_format')); ?>
                </p>
            </div>
        </div>

        <?php
        $menuItems = $model->getOrderMenus();
        $menuItemsOptions = $model->getOrderMenuOptions();
        $orderTotals = $model->getOrderTotals();
        ?>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="2%"></th>
                            <th class="text-left" width="65%">
                                <b><?= lang('admin::lang.orders.column_name_option'); ?></b>
                            </th>
                            <th class="text-left"><b><?= lang('admin::lang.orders.column_price'); ?></b></th>
                            <th class="text-right"><b><?= lang('admin::lang.orders.column_total'); ?></b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($menuItems as $menuItem) { ?>
                            <tr>
                                <td><?= $menuItem->quantity; ?>x</td>
                                <td class="text-left"><?= $menuItem->name; ?><br/>
                                    <?php if ($menuItemOptions = $menuItemsOptions->get($menuItem->menu_id)) { ?>
                                        <div>
                                            <?php foreach ($menuItemOptions as $menuItemOption) { ?>
                                                <small>
                                                    <?= $menuItemOption->order_option_name; ?>
                                                    =
                                                    <?= currency_format($menuItemOption->order_option_price); ?>
                                                </small><br>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($menuItem->comment)) { ?>
                                        <div>
                                            <small><b><?= $menuItem->comment; ?></b></small>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="text-left"><?= currency_format($menuItem->price); ?></td>
                                <td class="text-right"><?= currency_format($menuItem->subtotal); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <?php $totalCount = 1; ?>
                        <?php foreach ($orderTotals as $total) { ?>
                            <?php if ($model->isCollectionType() AND $total->code == 'delivery') continue; ?>
                            <?php $thickLine = ($total->code == 'order_total' OR $total->code == 'total'); ?>
                            <tr>
                                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line"
                                    width="1"></td>
                                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line"></td>
                                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line text-left"><?= $total->title; ?></td>
                                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line text-right"><?= currency_format($total->value); ?></td>
                            </tr>
                            <?php $totalCount++; ?>
                        <?php } ?>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p class="text-center"><?= lang('admin::lang.orders.text_invoice_thank_you'); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
