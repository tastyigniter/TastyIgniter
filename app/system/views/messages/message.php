<div class="panel conversation-message">
    <div
        class="conversation-message-heading"
        data-toggle="collapse"
        data-parent="#<?= $field->getId('conversation'); ?>"
        href="#<?= $field->getId('message'); ?>"
        aria-expanded="true"
        aria-controls="<?= $field->getId('message'); ?>"
    >
        <time class="pull-right time text-muted">
            <i class="fa fa-clock-o"></i> <?= time_elapsed($model->date_added); ?>
        </time>
        <span>
            <i class="fa fa-user small"></i>
            <?= $model->sender->staff_name; ?>
        </span>
    </div>
    <div
        id="<?= $field->getId('message'); ?>"
        class="panel-body conversation-message-body collapse show">
        <?= $model->body; ?>
    </div>
</div>
