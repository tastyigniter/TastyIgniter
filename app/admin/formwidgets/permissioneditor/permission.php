<tr class="<?= !$checkedValue ? 'text-muted' : ''; ?>">
    <td role="button" data-toggle="permission">
        <span><?= e(lang($permission->label)); ?></span>&nbsp;-&nbsp;
        <em class="small">[<?= e($permission->code); ?>]</em>&nbsp;&nbsp;
        <span><?= e($permission->description); ?></span>
    </td>
    <td class="text-center">
        <div class="custom-control custom-checkbox d-inline-block">
            <input
                type="checkbox"
                class="custom-control-input"
                id="checkbox-<?= str_replace('.', '-', $permission->code); ?>"
                value="<?= $checkedValue; ?>"
                name="<?= $field->getName() ?>[<?= $permission->code; ?>]"
                data-permission-group="<?= str_slug($permission->group) ?>"
                <?= ($checkedValue == 1) ? 'checked="checked"' : ''; ?>
                <?= ($this->previewMode) ? 'disabled="disabled"' : ''; ?>
            />
            <label class="custom-control-label" for="checkbox-<?= str_replace('.', '-', $permission->code); ?>"></label>
        </div>
    </td>
</tr>