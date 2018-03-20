<div
    class="panel panel-default<?= $component->disabled ? ' panel-danger' : '' ?> panel-component"
    data-partial="<?= $component->partial ?>"
>

    <div
        class="panel-heading handle"
        role="button"
        data-toggle="collapse"
        data-target="#<?= $component->widget->getId(); ?>"
        data-parent="#<?=
        $this->getId('partial-'.$component->partial); ?>"
        aria-expanded="false"
        aria-controls="<?= $component->widget->getId(); ?>">

        <i class="fa fa-arrows"></i>&nbsp;&nbsp;
        <b><?= e(lang($component->name)); ?></b>
        <a
            class="pull-right"
            data-confirm="<?= lang('admin::default.alert_warning_confirm'); ?>"
            data-control="remove-component"
            data-parent="#<?= $this->getId('partial-'.$component->partial); ?>"
        >
            <i class="fa fa-times-circle text-danger"></i>
        </a>
    </div>
    <div
        class="panel-body collapse"
        id="<?= $component->widget->getId(); ?>">

        <?php foreach ($component->widget->getFields() as $field) { ?>
            <?= $component->widget->renderField($field) ?>
        <?php } ?>

    </div>
</div>
