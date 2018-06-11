<?php
$type = $tabs->section;
?>
<div id="<?= $this->getId() ?>">
    <div class="tab-heading">
        <ul class="form-nav nav nav-tabs">
            <?php $index = 0;
            foreach ($tabs as $name => $fields) { ?>
                <?php $index++; ?>
                <li class="nav-item">
                    <a
                        class="nav-link<?= $index == 1 ? ' active' : '' ?>"
                        href="#<?= $this->getId('section-'.$index) ?>"
                        data-toggle="tab"
                    ><?= e((strpos($name, 'lang:') !== FALSE) ? lang($name) : $name) ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="tab-content">
        <?php $index = 0;
        foreach ($tabs as $name => $fields) { ?>
            <?php $index++; ?>
            <div
                id="<?= $this->getId('section-'.$index) ?>"
                class="tab-pane<?= $index == 1 ? ' active' : '' ?>"
            >
                <div class="form-fields">
                    <?= $this->makePartial('form/form_fields', ['fields' => $fields]) ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
