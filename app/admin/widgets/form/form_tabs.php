<?php
$type = $tabs->section;
$activeTab = $activeTab ? $activeTab : '#'.$type.'tab-1';
?>
<div class="tab-heading">
    <ul class="nav nav-tabs">
        <?php $index = 0; foreach ($tabs as $name => $fields) { ?>
            <?php $index++; $tabName = '#'.$type.'tab-'.$index ?>
            <li class="<?= ($tabName == $activeTab)?'active':''?>">
                <a href="<?= $tabName ?>" data-toggle="tab"><?= e(lang($name)) ?></a>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="tab-content">
    <?php $index = 0; foreach ($tabs as $name => $fields) { ?>
        <?php $index++; $tabName = '#'.$type.'tab-'.$index ?>
        <div
            class="tab-pane <?= ($tabName == $activeTab)?'active':''?>"
            id="<?= $type.'tab-'.$index ?>">
            <div class="tabs-form">
                <?= $this->makePartial('form/form_fields', ['fields' => $fields]) ?>
            </div>
        </div>
    <?php } ?>
</div>
