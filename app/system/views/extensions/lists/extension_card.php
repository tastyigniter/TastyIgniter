<div class="d-flex w-100 align-items-center">
    <div
        class="flex-grow-1"
        <?php if ($record->class AND strlen($record->readme)) { ?>
            href="#"
            data-toggle="modal"
            data-target="#extension-modal-<?= $record->extension_id ?>"
            role="button"
        <?php } ?>
    >
        <span class="extension-name<?= (!$record->class) ? ' text-muted' : ''; ?>">
            <b>
                <?php if ($record->class) { ?>
                    <?= $record->title; ?>
                <?php }
                else { ?>
                    <s><?= $record->title; ?></s>&nbsp;&nbsp;
                <?php } ?>
            </b>
        </span>
        <span class="small text-muted"><?= $record->version; ?></span>
        <p class="extension-desc mb-0 text-muted"><?= $record->description; ?></p>
    </div>
    <div class="text-muted text-right small">
        <b><?= lang('system::lang.themes.text_author'); ?></b><br/>
        <?= $record->meta['author'] ?? ''; ?>
    </div>
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
                <div class="modal-body bg-light">
                    <?= $record->readme; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>