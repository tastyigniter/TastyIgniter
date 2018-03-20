<tr id="<?= $this->getId('area-'.$areaIndex.'-condition-row-'.$index) ?>"
    data-row="<?= $index ?>">
    <td class="list-action handle">
        <a
            class="btn btn-danger btn-xs"
            onclick="confirm(
                '<?= lang('admin::default.alert_warning_confirm'); ?>')
                ? $(this).parents('#<?= $this->getId('area-'.$areaIndex.'condition-row-'.$index) ?>').remove()
                : false">
            <i class="fa fa-times-circle"></i>
        </a>
    </td>
    <td>
        <input
            type="text"
            name="<?= $field->getName() ?>[<?= $areaIndex; ?>][conditions][<?= $index; ?>][amount]"
            class="form-control input-sm"
            value="<?= isset($condition['amount']) ? $condition['amount'] : 0; ?>"/>
    </td>
    <td>
        <select
            name="<?= $field->getName() ?>[<?= $areaIndex; ?>][conditions][<?= $index; ?>][type]"
            class="form-control input-sm">
            <?php foreach ($conditionsTypes as $rule => $text) { ?>
                <option
                    value="<?= $rule; ?>"
                    <?= ($rule == $condition['type']) ? 'selected="selected"' : '' ?>>
                    <?= e(lang($text)); ?>
                </option>
            <?php } ?>
        </select>
    </td>
    <td>
        <input
            type="text"
            name="<?= $field->getName() ?>[<?= $areaIndex; ?>][conditions][<?= $index; ?>][total]"
            class="form-control input-sm"
            value="<?= isset($condition['total']) ? $condition['total'] : 0; ?>"/>
    </td>
</tr>
