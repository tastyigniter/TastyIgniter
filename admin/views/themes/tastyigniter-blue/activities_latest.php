<ul class="menu activities-list">
    <?php if ($activities) {?>
        <?php foreach ($activities as $activity) { ?>
            <li class="<?php echo $activity['state']; ?>">
                <div class="clearfix">
                    <div class="activity-body"><i class="<?php echo $activity['icon']; ?> fa-fw bg-primary"></i>
                        <?php echo $activity['message']; ?>
                        <span class="activity-time text-muted small">
                            <span class="small"><?php echo $activity['time']; ?>&nbsp;-&nbsp;<?php echo $activity['time_elapsed']; ?></span>
                        </span>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php } else { ?>
        <li><?php echo lang('text_empty'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>
