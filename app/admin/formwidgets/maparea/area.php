<div id="<?= $this->getId('area-panel-'.$index) ?>">
    <input type="hidden" name="<?= $field->getName() ?>[<?= $index; ?>][shape]" value="<?= $area['shape']; ?>"/>
    <input type="hidden" name="<?= $field->getName() ?>[<?= $index; ?>][vertices]" value="<?= $area['vertices']; ?>"/>
    <input type="hidden" name="<?= $field->getName() ?>[<?= $index; ?>][circle]" value="<?= $area['circle']; ?>"/>

    <?= $this->makePartial('maparea/area_panel', ['area' => $area, 'index' => $index]) ?>
</div>
