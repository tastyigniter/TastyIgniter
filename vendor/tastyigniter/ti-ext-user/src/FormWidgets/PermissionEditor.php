<?php

declare(strict_types=1);

namespace Igniter\User\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\User\Classes\PermissionManager;
use Override;

/**
 * User group permission editor
 * This widget is used by the system internally on the Users / User Groups pages.
 */
class PermissionEditor extends BaseFormWidget
{
    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'mode',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('permissioneditor/permissioneditor');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars(): void
    {
        $this->vars['groupedPermissions'] = $this->listPermissions();
        $this->vars['checkedPermissions'] = (array)$this->formField->value;
        $this->vars['field'] = $this->formField;
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('permissioneditor.js', 'permissioneditor-js');
    }

    /**
     * @return array
     */
    protected function listPermissions()
    {
        return resolve(PermissionManager::class)->listGroupedPermissions();
    }
}
