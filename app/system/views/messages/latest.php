<?php
$itemOptions = isset($itemOptions['items']) ? $itemOptions['items'] : $itemOptions;
?>
<ul class="menu">
    <?php if (count($itemOptions)) { ?>
        <?php foreach ($itemOptions as $message) { ?>
            <li class="<?= $message['state']; ?>">
                <a href="<?= $message['view']; ?>">
                    <div>
                        <span class="message-subject"><?= $message['subject']; ?></span>
                        <span class="pull-right text-muted">
                            <em><?= $message['date_added']; ?></em>
                        </span>
                    </div>
                    <div><?= $message['body']; ?></div>
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