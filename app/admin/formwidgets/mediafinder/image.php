<div class="media-image<?= $isMulti ? ' image-list' : '' ?>">
    <?php if (count($value)) { ?>
        <?php $index = 0;
        foreach ($value as $key => $mediaItem) { ?>
            <?php $index++; ?>
            <?= $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => $mediaItem]) ?>
        <?php } ?>
    <?php } else { ?>
        <?= $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => null]) ?>
    <?php } ?>
</div>

<script type="text/template" data-blank-template>
    <?= $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => null]) ?>
</script>

<script type="text/template" data-image-template>
    <?= $this->makePartial('mediafinder/image_'.$mode, ['mediaItem' => '']) ?>
</script>
