<ul class="menu message-list">
    <?php if ($messages) {?>
        <?php foreach ($messages as $message) { ?>
            <li class="<?php echo $message['state']; ?>">
                <a href="<?php echo $message['view']; ?>">
                    <div>
                        <span class="message-subject"><?php echo $message['subject']; ?></span>
                        <span class="pull-right text-muted">
                            <em><?php echo $message['date_added']; ?></em>
                        </span>
                    </div>
                    <div><?php echo $message['body']; ?></div>
                </a>
            </li>
            <li class="divider"></li>
        <?php } ?>
    <?php } else { ?>
        <li><?php echo lang('text_empty'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>