<?php
$itemOptions = isset($itemOptions['items']) ? $itemOptions['items'] : $itemOptions;
?>
<ul class="menu">
    <?php if (count($itemOptions)) { ?>
        <?php foreach ($itemOptions as $message) { ?>
            <li>
                <a
                    class="menu-item"
                   href="<?= admin_url('messages/view/'.$message->message_id); ?>"
                >
                    <p><span class="message-subject"><b><?= str_limit($message['subject'], 25); ?></b></span></p>
                    <p><?= str_limit($message['body'], 35); ?></p>
                    <span class="small menu-item-meta"><em><?= time_elapsed($message['date_added']); ?></em></span>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php }
    else { ?>
        <li><?= lang('admin::default.text_empty_message'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>