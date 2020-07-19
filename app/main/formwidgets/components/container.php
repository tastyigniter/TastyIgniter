<?php if (count($components)) { ?>
    <?php foreach ($components as $component) { ?>
        <?= $this->makePartial('component', [
            'component' => $component,
        ]) ?>
    <?php } ?>
<?php } ?>