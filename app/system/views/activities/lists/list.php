<?php if (count($records)) {

    $groupedRecords = $records->groupBy(function ($item) {
        return day_elapsed($item->date_added);
    });
    ?>
    <ul class="timeline">
        <?php foreach ($groupedRecords as $dateAdded => $activities) { ?>
            <li class="time-label">
                <span><?= $dateAdded; ?></span>
            </li>
            <?php foreach ($activities as $activity) { ?>
                <li class="timeline-item <?= $activity->status ? 'read' : 'unread'; ?>">
                    <time class="timeline-time" datetime="">
                        <span><?= mdate('%h:%i %A', strtotime($activity->date_added)); ?></span>
                        <span><?= time_elapsed($activity->date_added); ?></span>
                    </time>
                    <div class="timeline-icon"></div>
                    <div class="timeline-body"><a href="<?= $activity->url; ?>"><?= $activity->message; ?></a></div>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
<?php }
else { ?>
    <p class="p-4 text-center"><?= lang('system::lang.activities.text_empty'); ?></p>
<?php } ?>

<?= $this->makePartial('lists/list_pagination') ?>
