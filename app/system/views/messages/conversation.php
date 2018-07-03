<?php
$participants = $model->listRecipients();
?>
<div
    class="conversation-heading"
>
    <h4 class="panel-title message-title"><?= $model->subject; ?></h4>
    <div class="message-meta">
        <h6><?= e(lang('system::lang.messages.label_to')); ?> : <?= e(lang($model->recipient_label)); ?></h6>
        <div class="collapse">
            <?= $participants ? implode(', ', $participants->pluck('staff_name')->all()) : '--'; ?>
        </div>
    </div>
</div>

<div
    id="<?= $field->getId('conversation'); ?>"
    class="conversation-body"
    role="tablist"
    aria-multiselectable="true"
>
    <?= $this->makePartial('messages/message', ['model' => $model, 'field' => $field]); ?>

    <div class="divider"></div>

    <?php
    $descendants = $model->descendants()->get();
    ?>
    <?php if (count($descendants)) { ?>
        <?php foreach ($descendants as $descendant) { ?>
            <?= $this->makePartial('messages/message', ['model' => $descendant, 'field' => $field]); ?>
        <?php } ?>
    <?php } ?>
</div>
