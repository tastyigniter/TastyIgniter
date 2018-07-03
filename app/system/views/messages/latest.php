<?php
$itemOptions = isset($itemOptions['items']) ? $itemOptions['items'] : $itemOptions;
?>
<ul class="menu">
    <?php if (count($itemOptions)) { ?>
        <?php foreach ($itemOptions as $message) { ?>
            <li class="menu-item">
                <a
                    class="menu-link"
                    href="<?= admin_url('messages/view/'.$message->message_id); ?>"
                >
                    <div class="message-subject text-nowrap text-truncate"><b><?= $message['subject']; ?></b></div>
                    <div class="message-body text-nowrap text-truncate"><?= str_limit($message['body'], 128); ?></div>
                    <span class="small menu-item-meta"><em><?= time_elapsed($message['date_added']); ?></em></span>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php }
    else { ?>
        <li><?= lang('admin::lang.text_empty_message'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>