<?php
$itemOptions = isset($itemOptions['items']) ? $itemOptions['items'] : $itemOptions;
?>
<ul class="menu menu-lg">
    <?php if (count($itemOptions)) { ?>
        <?php foreach ($itemOptions as $activity) { ?>
            <li class="menu-item">
                <a href="<?= $activity['url']; ?>" class="menu-link">
                    <div class="menu-item-meta"><?= $activity['message']; ?></div>
                    <span class="small menu-item-meta text-muted">
                        <?= mdate('%h:%i %A', strtotime($activity['date_added'])); ?>&nbsp;-&nbsp;
                        <?= time_elapsed($activity['date_added']); ?>
                    </span>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php }
    else { ?>
        <li class="text-center"><?= lang('admin::lang.text_empty_activity'); ?></li>
    <?php } ?>
</ul>
