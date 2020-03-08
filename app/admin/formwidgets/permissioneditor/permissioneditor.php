<div class="permission-editor" <?= $field->getAttributes() ?>>
    <div class="table-responsive">
        <table class="table table-border mb-0">
            <?php $index = 0;
            foreach ($groupedPermissions as $group => $permissions) {
                ++$index; ?>
                <thead>
                <tr>
                    <th class="<?= $index === 1 ? '' : 'pt-4' ?>">
                        <h5 class="panel-title"><?= e(lang($group)) ?></h5>
                    </th>
                    <th class="<?= $index === 1 ? '' : 'pt-4 ' ?>text-center">
                        <a
                            role="button"
                            data-toggle="permission-group"
                            data-permission-group="<?= str_slug($group) ?>"
                        ><?= lang('admin::lang.text_allow') ?></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($permissions as $permission) {
                    $checkedValue = array_key_exists($permission->code, $checkedPermissions) ?
                        $checkedPermissions[$permission->code] : 0;
                    ?>

                    <?= $this->makePartial('permissioneditor/permission', [
                        'permission' => $permission,
                        'checkedValue' => (int)$checkedValue,
                    ]) ?>

                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
    </div>
</div>
