<div class="dashboard-widget widget-onboarding">
    <h6 class="widget-title"><?= e(trans($this->property('title'))) ?></h6>
    <div class="list-group list-group-flush mb-3">
        <?php foreach ($onboarding->listSteps() as $step) { ?>
            <?php if ($completed = $step->completed AND $completed()) { ?>
                <div class="list-group-item">
                    <i class="fa fa-check-circle-o fa-2x text-success float-left mr-3 my-2"></i>
                    <s class="d-block text-truncate"><?= e(trans($step->label)); ?></s>
                    <s class="text-muted d-block text-truncate"><?= e(trans($step->description)); ?></s>
                </div>
            <?php } else { ?>
                <a class="list-group-item" href="<?= $step->url; ?>">
                    <span class="fa-stack float-left mr-3 my-2">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa <?= e(trans($step->icon)); ?> fa-stack-1x fa-inverse"></i>
                    </span>
                    <b class="d-block text-truncate"><?= e(trans($step->label)); ?></b>
                    <span class="text-muted d-block text-truncate"><?= e(trans($step->description)); ?></span>
                </a>
            <?php } ?>
        <?php } ?>
    </div>
</div>
