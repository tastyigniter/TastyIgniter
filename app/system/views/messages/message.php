<div class="panel message">
    <div
        class="message-heading"
        data-toggle="collapse"
        data-parent="#<?= $field->getId('conversation'); ?>"
        href="#<?= $field->getId('message'); ?>"
        aria-expanded="true"
        aria-controls="<?= $field->getId('message'); ?>"
    >
        <time class="pull-right time">
            <i class="fa fa-clock-o"></i> <?= day_elapsed($model->date_added); ?>
        </time>
        <h5 class="panel-title">
            <i class="fa fa-user small"></i>
            <?= $model->sender->staff_name; ?>
        </h5>
    </div>
    <div
        id="<?= $field->getId('message'); ?>"
        class="panel-body message-body collapse in">
        <?= $model->body; ?>
    </div>
</div>
