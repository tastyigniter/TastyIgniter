<div class="media-image">
    <?php if ($isMulti) { ?>
        <?= $this->makePartial('mediafinder/list_image') ?>
    <?php } else { ?>
        <?= $this->makePartial('mediafinder/image_'.$mode) ?>
    <?php } ?>
</div>

<script type="text/template" data-blank-template>
    <?= $this->makePartial('mediafinder/image_'.$mode, ['value' => null]) ?>
</script>

<script type="text/template" data-image-template>
    <?= $this->makePartial('mediafinder/image_'.$mode, ['value' => $blankImage]) ?>
</script>
