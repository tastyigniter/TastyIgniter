<div class="dashboard-widget widget-activities">
    <h6 class="widget-title"><?= e(trans($this->property('title'))) ?></h6>

    <div class="list-group list-group-flush">
        <?php if ($activities) { ?>
            <?php foreach ($activities as $activity) { ?>
                <div class="list-group-item px-0">
                    <i class="<?= $activity['icon']; ?> fa-fw bg-primary"></i>
                    <b><?= $activity['causer']['staff_name'] ?? null; ?></b>
                    <?= $activity['message']; ?>
                    <em class="pull-right small"><?= time_elapsed($activity['date_added']); ?></em>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="list-group-item"><?= lang('admin::lang.dashboard.text_no_activity'); ?></div>
        <?php } ?>
    </div>

    <div class="text-right py-2">
        <a href="<?= admin_url('activities'); ?>">
            <?= lang('admin::lang.text_see_all_activity'); ?>&nbsp;<i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>
