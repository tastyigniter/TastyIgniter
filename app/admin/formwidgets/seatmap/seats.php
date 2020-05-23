<div class="row pt-3">
    <?php foreach ($seats as $index => $seat) { ?>
        <?= $this->makePartial('seatmap/seat', ['seat' => $seat, 'index' => $index]) ?>
    <?php } ?>
</div>