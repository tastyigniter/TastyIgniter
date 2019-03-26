<div class="my-2">
    <b class="extension-name<?= (!$record->class) ? ' text-muted' : ''; ?>">
        <?php if ($record->class) { ?>
            <?= $record->title; ?>
        <?php }
        else { ?>
            <s><?= $record->title; ?></s>&nbsp;&nbsp;
        <?php } ?>
    </b>
    <p class="extension-desc mb-0 text-muted"><?= $record->meta['description']; ?></p>
</div>