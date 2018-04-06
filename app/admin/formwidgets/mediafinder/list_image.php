<div class="image-list">
    <?php if (!is_array($value)) $value = [$value]; ?>
    <?php if (count($value)) { ?>
        <?php $index = 0;
        foreach ($value as $key => $item) { ?>
            <?php if (!$item) continue;
            $index++; ?>
            <?= $this->makePartial('mediafinder/image_'.$mode, ['value' => !is_string($item) ? null : $item]) ?>
        <?php } ?>
    <?php } ?>

    <?= $this->makePartial('mediafinder/image_'.$mode, ['value' => null]) ?>
</div>
