<div class="permission-editor" <?= $field->getAttributes() ?>>
    <div class="tab-heading">
        <ul class="nav nav-tabs">
            <?php $index = 0;
            foreach ($tabs as $name => $tab) { ?>
                <li class="nav-item<?= $index++ == 0 ? ' active' : '' ?>">
                    <a class="nav-link" href="#<?= $name.'-tab-'.$index ?>" data-toggle="tab"><?= e(lang($tab)) ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="tab-content wrap-none">
        <?php $index = 0;
        foreach ($permissions as $tab => $tabPermissions) { ?>
            <div
                class="tab-pane <?= $index++ == 0 ? 'active' : '' ?>"
                id="<?= $tab.'-tab-'.$index ?>">

                <div class="table-responsive wrap-none">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <?php foreach ($actionCssClasses as $action => $class) { ?>
                                <th class="text-center <?= $class != 'default' ? 'bg-'.$class : ''; ?>">
                                    <?php if (!$this->previewMode) { ?>
                                        <a role="button"
                                           class="action<?= $class != 'default' ? ' text-white' : ''; ?>"
                                           data-action="<?= $action; ?>">
                                            <b><?= lang('admin::lang.staff_groups.column_'.$action); ?></b>
                                        </a>
                                    <?php } else { ?>
                                        <span class="<?= $class != 'default' ? 'text-white' : ''; ?>">
                                            <b><?= lang('admin::lang.staff_groups.column_'.$action); ?></b>
                                        </span>
                                    <?php } ?>
                                </th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tabPermissions as $key => $permission) {
                            $checkedActions = array_key_exists($permission->name, $permissionsData) ?
                                $permissionsData[$permission->name] : [];
                            ?>

                            <?= $this->makePartial('permissioneditor/permission', [
                                'permission'     => $permission,
                                'checkedActions' => $checkedActions,
                            ]) ?>

                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
