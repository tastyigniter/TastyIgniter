<tr class="<?= !$checkedActions ? 'disabled' : ''; ?>">
    <td role="button" class="<?= !$this->previewMode ? 'name' : ''; ?>">
        <h5>
            <a><?= $permission->name; ?></a>
        </h5>
        <p class="text-muted"><?= $permission->description; ?></p>
    </td>
    <?php foreach ($actionCssClasses as $action => $class) { ?>
        <td class="">
            <?php if (!in_array($action, $permission->action)) { ?>
                <span class="small text-muted">--</span>
            <?php } else { ?>
                <div class="custom-control custom-checkbox custom-control-<?= $class; ?>">
                    <input
                        type="checkbox"
                        class="custom-control-input"
                        id="checkbox-<?= $action; ?>"
                        value="<?= $action; ?>"
                        name="<?= $field->getName() ?>[<?= str_replace('.', '::', $permission->name); ?>][]"
                        <?= (in_array($action, $checkedActions)) ? 'checked="checked"' : ''; ?>
                        <?= ($this->previewMode) ? 'disabled="disabled"' : ''; ?>/>
                    <label class="custom-control-label" for="checkbox-<?= $action; ?>"></label>
                </div>
            <?php } ?>
        </td>
    <?php } ?>
</tr>