<div class="my-2">
    <a
        class="extension-name<?= (!$record->class) ? ' text-muted' : ''; ?>"
        <?php if ($record->class AND strlen($record->readme)) { ?>
        href="#"
        data-toggle="modal"
        data-target="#extension-modal-<?= $record->extension_id ?>"
        <?php } ?>
    >
        <b>
            <?php if ($record->class) { ?>
                <?= $record->title; ?>
            <?php }
            else { ?>
                <s><?= $record->title; ?></s>&nbsp;&nbsp;
            <?php } ?>
        </b>
    </a>
    <p class="extension-desc mb-0 text-muted"><?= $record->meta['description']; ?></p>
</div>
<?php if ($record->class AND strlen($record->readme)) { ?>
<div
    id="extension-modal-<?= $record->extension_id ?>"
    class="modal show"
    tabindex="-1"
    role="dialog"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $record->title; ?></h4>
            </div>
            <div class="modal-body">
                <?= $record->readme; ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
