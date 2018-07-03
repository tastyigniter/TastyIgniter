<?php
$menuItems = $model->getOrderMenus();
$menuItemsOptions = $model->getOrderMenuOptions();
$orderTotals = $model->getOrderTotals();
?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th width="65%"><?= lang('admin::lang.orders.column_name_option'); ?></th>
            <th class="text-left"><?= lang('admin::lang.orders.column_price'); ?></th>
            <th class="text-right"><?= lang('admin::lang.orders.column_total'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($menuItems as $menuItem) { ?>
            <tr>
                <td><?= $menuItem->quantity; ?>x</td>
                <td><?= $menuItem->name; ?><br/>
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
        <?php $totalCount = 1; ?>
        <?php foreach ($orderTotals as $total) { ?>
            <?php if ($model->isCollectionType() AND $total->code == 'delivery') continue; ?>
            <?php $thickLine = ($total->code == 'order_total' OR $total->code == 'total'); ?>
            <tr>
                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line" width="1"></td>
                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line"></td>
                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line text-left"><?= $total->title; ?></td>
                <td class="<?= ($totalCount === 1 OR $thickLine) ? 'thick' : 'no'; ?>-line text-right"><?= currency_format($total->value); ?></td>
            </tr>
            <?php $totalCount++; ?>
        <?php } ?>
        </tbody>
    </table>
</div>
