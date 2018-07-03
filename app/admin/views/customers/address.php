<?php $fieldName = $field->arrayName.'['.$field->fieldName.']'; ?>
<div
    class="tab-pane <?= $index == 1 ? 'active' : '' ?>"
    id="<?= $field->getId('address').'-'.$index; ?>">
    <input
        type="hidden" name="<?= $fieldName; ?>[<?= $index; ?>][address_id]"
        value="<?= set_value($fieldName.'['.$index.'][address_id]', $address['address_id']); ?>"/>
    <input
        type="hidden" name="<?= $fieldName; ?>[<?= $index; ?>][customer_id]"
        value="<?= set_value($fieldName.'['.$index.'][customer_id]', isset($address['customer_id']) ? $address['customer_id'] : null); ?>"/>

    <div class="form-group span-left <?= form_error($fieldName.'['.$index.'][address_1]') != '' ? 'has-error' : ''; ?>">
        <label class="control-label"><?= lang('admin::lang.customers.label_address_1'); ?></label>
        <input type="text"
               name="<?= $fieldName; ?>[<?= $index; ?>][address_1]"
               class="form-control"
               value="<?= set_value($fieldName.'['.$index.'][address_1]', $address['address_1']); ?>"/>
    </div>
    <div class="form-group span-right <?= form_error($fieldName.'['.$index.'][address_2]') != '' ? 'has-error' : ''; ?>">
        <label class="control-label"><?= lang('admin::lang.customers.label_address_2'); ?></label>
        <input type="text"
               name="<?= $fieldName; ?>[<?= $index; ?>][address_2]"
               class="form-control"
               value="<?= set_value($fieldName.'['.$index.'][address_2]', $address['address_2']); ?>"/>
    </div>
    <div class="form-group span-left <?= form_error($fieldName.'['.$index.'][city]') != '' ? 'has-error' : ''; ?>">
        <label class="control-label"><?= lang('admin::lang.customers.label_city'); ?></label>
        <input type="text"
               name="<?= $fieldName; ?>[<?= $index; ?>][city]"
               class="form-control"
               value="<?= set_value($fieldName.'['.$index.'][city]', $address['city']); ?>"/>
    </div>
    <div class="form-group span-right <?= form_error($fieldName.'['.$index.'][state]') != '' ? 'has-error' : ''; ?>">
        <label class="control-label"><?= lang('admin::lang.customers.label_state'); ?></label>
        <input type="text"
               name="<?= $fieldName; ?>[<?= $index; ?>][state]"
               class="form-control"
               value="<?= set_value($fieldName.'['.$index.'][state]', $address['state']); ?>"/>
    </div>
    <div class="form-group span-left <?= form_error($fieldName.'['.$index.'][postcode]') != '' ? 'has-error' : ''; ?>">
        <label class="control-label"><?= lang('admin::lang.customers.label_postcode'); ?></label>
        <input type="text"
               name="<?= $fieldName; ?>[<?= $index; ?>][postcode]"
               class="form-control"
               value="<?= set_value($fieldName.'['.$index.'][postcode]', $address['postcode']); ?>"/>
    </div>
    <div class="form-group span-right <?= form_error($fieldName.'['.$index.'][country_id]') != '' ? 'has-error' : ''; ?>">
        <label class="control-label"><?= lang('admin::lang.customers.label_country'); ?></label>
        <select name="<?= $fieldName; ?>[<?= $index; ?>][country_id]" class="form-control">
            <?php foreach ($countries as $key => $value) { ?>
                <?php if ($key == $address['country_id']) { ?>
                    <option value="<?= $key; ?>" selected="selected"><?= $value; ?></option>
                <?php }
                else { ?>
                    <option value="<?= $key; ?>"><?= $value; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>