<div class="message <?= $record->readState($messageLoggedUser) ?>">
    <a
        class="message-subject"
        href="<?= admin_url(parse_values($record->toArray(), $column->config['onClick'])); ?>"
    >
        <?= $record['subject']; ?>
        <div class="small text-muted"><?= $record->summary; ?></div>
    </a>
</div>