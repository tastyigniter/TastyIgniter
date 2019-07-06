<?php
$itemOptions = $itemOptions['items'] ?? $itemOptions;
?>
<ul class="menu menu-lg">
    <?php if (count($itemOptions)) { ?>
        <?php foreach ($itemOptions as $message) { ?>
            <li class="menu-item">
                <a
                    class="menu-link"
                    href="<?= admin_url('messages/view/'.$message->message_id); ?>"
                >
                    <div class="message-subject text-nowrap text-truncate"><b><?= $message['subject']; ?></b></div>
                    <div class="message-body text-nowrap text-truncate"><?= str_limit($message['body'], 128); ?></div>
                    <span class="small menu-item-meta text-muted"><?= time_elapsed($message['date_added']); ?></span>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php }
    else { ?>
        <li class="text-center"><?= lang('admin::lang.text_empty_message'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>