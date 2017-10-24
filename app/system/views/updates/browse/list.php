<?php if (isset($items) AND count($items)) { ?>
    <ul class="select-box">
        <?php foreach ($items['data'] as $item) { ?>
            <li class="col-xs-12 col-sm-4">
                <?= $this->makePartial('updates/browse/item', ['item' => $item]); ?>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
