<ul class="menu activities-list">
    <?php if ($activities) {?>
        <?php foreach ($activities as $activity) { ?>
            <li class="<?php echo $activity['state']; ?>">
                <div class="clearfix">
                    <div class="activity-body"><i class="<?php echo $activity['icon']; ?> fa-fw"></i>&nbsp;
                        <?php echo $activity['message']; ?>
                    </div>
                    <span class="activity-time text-muted pull-right small">
                        <span class="small"><?php echo $activity['time']; ?>&nbsp;-&nbsp;<?php echo $activity['time_elapsed']; ?></span>
                    </span>
                </div>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php } else { ?>
        <li><?php echo lang('text_empty'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>
