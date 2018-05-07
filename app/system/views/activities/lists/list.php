<?php if (count($records)) {

    $groupedRecords = $records->groupBy(function ($item, $key) {
        return day_elapsed($item->date_added);
    });
    $activities = $groupedRecords->toArray();
    ?>
    <ul class="timeline">
        <?php foreach ($groupedRecords as $date_added => $activities) { ?>
            <li class="time-label">
                <span><?= $date_added; ?></span>
            </li>
            <?php foreach ($activities as $activity) { ?>
                <li class="timeline-item <?= ($activity['status'] == '1') ? 'read' : 'unread'; ?>">
                    <time class="timeline-time" datetime="">
                        <span><?= mdate('%h:%i %A', strtotime($activity['date_added'])); ?></span>
                        <span><?= time_elapsed($activity['date_added']); ?></span>
                    </time>
                    <div class="timeline-icon"></div>
                    <div class="timeline-body">
                        <b><?= isset($activity['causer']['staff_name']) ? $activity['causer']['staff_name'] : null; ?></b>
                        <?= $activity['message']; ?>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
<?php }
else { ?>
    <p><?= lang('system::activities.text_empty'); ?></p>
<?php } ?>

<?= $this->makePartial('lists/list_pagination') ?>
