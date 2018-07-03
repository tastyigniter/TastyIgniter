<?php
$itemOptions = isset($itemOptions['items']) ? $itemOptions['items'] : $itemOptions;
?>
<ul class="menu">
    <?php if (count($itemOptions)) { ?>
        <?php foreach ($itemOptions as $activity) { ?>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <div class="menu-item-meta">
                        <b><?= isset($activity['causer']['staff_name']) ? $activity['causer']['staff_name'] : null; ?></b>
                        <?= $activity['message']; ?>
                    </div>
                    <span class="small menu-item-meta">
                        <?= mdate('%h:%i %A', strtotime($activity['date_added'])); ?>&nbsp;-&nbsp;
                        <?= time_elapsed($activity['date_added']); ?>
                    </span>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php }
    else { ?>
        <li><a><?= lang('admin::lang.text_empty_activity'); ?></a></li>
    <?php } ?>
</ul>