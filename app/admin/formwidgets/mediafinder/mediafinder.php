<div
    id="<?= $this->getId() ?>"
    class="mediafinder <?= $mode ?>-mode <?= $isMulti ? 'is-multi' : '' ?> <?= $mode == 'picker' ? 'is-picker' : '' ?> <?= $value ? 'is-populated' : '' ?>"
    data-mode="<?= $mode ?>"
    data-control="mediafinder">

    <?= $this->makePartial('mediafinder/image') ?>
</div>
