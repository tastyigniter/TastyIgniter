<?php
$menuItems = $model->getOrderMenus();
$menuItemsOptions = $model->getOrderMenuOptions();
$orderTotals = $model->getOrderTotals();
?>
<div class="table-responsive">
    <table class="table">
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
                <td><b><?= $menuItem->name; ?></b>
                    <?php if ($menuItemOptions = $menuItemsOptions->get($menuItem->order_menu_id)) { ?>
                        <ul class="list-unstyled">
                            <?php foreach ($menuItemOptions as $menuItemOption) { ?>
                                <li>
                                    <?= $menuItemOption->quantity; ?>x
                                    <?= $menuItemOption->order_option_name; ?>&nbsp;
                                    <?php if ($menuItemOption->order_option_price > 0) { ?>
                                        (<?= currency_format($menuItemOption->quantity*$menuItemOption->order_option_price); ?>)
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <?php if (!empty($menuItem->comment)) { ?>
                        <p class="font-weight-bold"><?= $menuItem->comment; ?></p>
                    <?php } ?>
                </td>
                <td class="text-left"><?= currency_format($menuItem->price); ?></td>
                <td class="text-right"><?= currency_format($menuItem->subtotal); ?></td>
            </tr>
        <?php } ?>
        <?php $totalCount = 1; ?>
        <tr>
            <td class="border-top p-0" colspan="99999"></td>
        </tr>
        <?php foreach ($orderTotals as $total) { ?>
            <?php if ($model->isCollectionType() AND $total->code == 'delivery') continue; ?>
            <?php $thickLine = ($total->code == 'order_total' OR $total->code == 'total'); ?>
            <tr>
                <td
                    class="<?= ($totalCount === 1 OR $thickLine) ? 'lead font-weight-bold' : 'text-muted'; ?>" width="1"
                ></td>
                <td
                    class="<?= ($totalCount === 1 OR $thickLine) ? 'lead font-weight-bold' : 'text-muted'; ?>"
                ></td>
                <td
                    class="<?= ($totalCount === 1 OR $thickLine) ? 'lead font-weight-bold' : 'text-muted'; ?> text-left"
                ><?= $total->title; ?></td>
                <td
                    class="<?= ($totalCount === 1 OR $thickLine) ? 'lead font-weight-bold' : ''; ?> text-right"
                ><?= currency_format($total->value); ?></td>
            </tr>
            <?php $totalCount++; ?>
        <?php } ?>
        </tbody>
    </table>
</div>
