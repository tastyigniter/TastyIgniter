<div class="my-2">
    <h5 class="extension-name<?= (!$record->class) ? ' text-muted' : ''; ?>">
        <?php if ($record->class) { ?>
            <?= $record->title; ?>
        <?php }
        else { ?>
            <s><?= $record->title; ?></s>&nbsp;&nbsp;
        <?php } ?>
    </h5>
    <span class="extension-desc text-muted"><?= $record->meta['description']; ?></span>
</div>