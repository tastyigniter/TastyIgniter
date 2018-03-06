<div class="form-group">
    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-default <?= ($area['type'] == 'circle') ? 'active' : '' ?>">
            <input
                type="radio"
                name="<?= $field->getName() ?>[<?= $index; ?>][type]"
                value="circle" <?= ($area['type'] == 'circle') ? 'checked="checked"' : '' ?>
                data-toggle="map-shape">
            <?= lang('admin::locations.text_circle'); ?>
        </label>
        <label class="btn btn-default <?= ($area['type'] == 'polygon') ? 'active' : '' ?>">
            <input
                type="radio"
                name="<?= $field->getName() ?>[<?= $index; ?>][type]"
                value="polygon" <?= ($area['type'] == 'polygon') ? 'checked="checked"' : '' ?>
                data-toggle="map-shape">
            <?= lang('admin::locations.text_shape'); ?>
        </label>
    </div>
</div>
<div class="form-group">
    <label for="" class="control-label"><?= lang('admin::locations.label_area_name'); ?></label>
    <input
        type="text"
        name="<?= $field->getName() ?>[<?= $index; ?>][name]"
        class="form-control"
        value="<?= $area['name']; ?>">
</div>
<input
    type="hidden"
    name="<?= $field->getName() ?>[<?= $index; ?>][area_id]"
    value="<?= e($area['area_id']); ?>"/>
<input
    type="hidden"
    data-shape-value="polygon"
    name="<?= $field->getName() ?>[<?= $index; ?>][boundaries][polygon]"
    value="<?= e($area['boundaries']['polygon']); ?>"/>
<input
    type="hidden"
    data-shape-value="vertices"
    name="<?= $field->getName() ?>[<?= $index; ?>][boundaries][vertices]"
    value="<?= e($area['boundaries']['vertices']); ?>"/>
<input
    type="hidden"
    data-shape-value="circle"
    name="<?= $field->getName() ?>[<?= $index; ?>][boundaries][circle]"
    value="<?= e($area['boundaries']['circle']); ?>"/>
