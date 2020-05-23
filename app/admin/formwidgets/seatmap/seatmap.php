<div
    id="<?= $this->getId() ?>"
    data-control="seat-map"
    data-alias="<?= $this->alias ?>"
>
    <div id="<?= $this->getId('seats') ?>">
        <?= $this->makePartial('seatmap/seats') ?>
    </div>
</div>
