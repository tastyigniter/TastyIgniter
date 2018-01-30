<?php
$themeFiles = $field->options['list'];
$currentFile = $field->options['currentFile'];
$currentDir = dirname($currentFile);
?>
<div
    class="panel panel-group panel-files"
    role="tablist"
    aria-multiselectable="true">

    <div
        id="<?= $this->getId('file-group') ?>"
        class="panel-body">
        <?php $index = 0;
        foreach ($themeFiles as $directory => $files) { ?>
            <?php $index++; ?>
            <div class="panel">
                <div class="panel-heading <?= ($currentDir == $directory) ? '' : 'collapsed' ?>"
                     role="button"
                     data-toggle="collapse"
                     data-parent="#<?= $this->getId('file-group') ?>"
                     data-target="#<?= $this->getId('file-group-'.$index) ?>"
                     aria-expanded="true"
                     aria-controls="<?= $this->getId('file-group-'.$index) ?>"
                >
                    <h4 class="panel-title"><?= e($directory) ?></h4>
                </div>
                <div
                    id="<?= $this->getId('file-group-'.$index) ?>"
                    class="panel-collapse collapse <?= ($currentDir == $directory) ? 'in' : '' ?>"
                    role="tabpanel"
                >
                    <div class="list-group">
                        <?php foreach ($files as $file) { ?>
                            <a
                                class="list-group-item <?= $file->path == $currentFile ? 'active' : '' ?>"
                                data-request="onSave"
                                data-request-form="#edit-form"
                                data-request-data="file: '<?= $file->path ?>'"
                            >
                                <?= $file->name; ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<input type="hidden" name="file" value="<?= $currentFile; ?>">
<input type="hidden" name="<?= $field->arrayName; ?>[file]" value="<?= $currentFile; ?>">
