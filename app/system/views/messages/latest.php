<ul class="menu message-list">
    <?php if ($messages) { ?>
        <?php foreach ($messages as $message) { ?>
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
        <li><?= lang('admin::default.text_empty'); ?></li>
        <li class="divider"></li>
    <?php } ?>
</ul>