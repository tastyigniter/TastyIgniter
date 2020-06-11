<div class="dashboard-widget widget-activities">
    <h6 class="widget-title"><?= e(trans($this->property('title'))) ?></h6>

    <div class="row">
        <div class="list-group list-group-flush w-100">
            <?php if ($activities) { ?>
                <?php foreach ($activities as $activity) { ?>
                    <div class="list-group-item bg-transparent">
                        <i class="<?= $activity['icon']; ?> fa-fw bg-primary"></i>
                        <b><?= $activity['causer']['staff_name'] ?? null; ?></b>
                        <?= $activity['message']; ?>
                        <em class="pull-right small"><?= time_elapsed($activity['date_added']); ?></em>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="list-group-item bg-transparent"><?= lang('admin::lang.dashboard.text_no_activity'); ?></div>
            <?php } ?>
        </div>

        <div class="text-right pt-3 px-3 w-100">
            <a href="<?= admin_url('activities'); ?>">
                <?= lang('admin::lang.text_see_all_activity'); ?>&nbsp;<i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
