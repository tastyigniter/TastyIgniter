<?php
$buttonAttributes = $this->getButtonAttributes($record, $column);
?>
<?php if (strlen($buttonAttributes)) { ?>
    <a <?= $buttonAttributes ?>>
        <?php if ($column->iconCssClass) { ?>
            <i class="<?= $column->iconCssClass ?>"></i>
        <?php } ?>
    </a>
<?php } ?>
