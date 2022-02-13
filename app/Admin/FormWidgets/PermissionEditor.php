<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\PermissionManager;

/**
 * Staff group permission editor
 * This widget is used by the system internally on the Users / Staff Groups pages.
 */
class PermissionEditor extends BaseFormWidget
{
    public function initialize()
    {
        $this->fillFromConfig([
            'mode',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('permissioneditor/permissioneditor');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['groupedPermissions'] = $this->listPermissions();
        $this->vars['checkedPermissions'] = (array)$this->formField->value;
        $this->vars['field'] = $this->formField;
        $this->vars['tabs'] = $this->tabs;
        $this->vars['actionCssClasses'] = $this->actionCssClasses;
    }

    public function loadAssets()
    {
        $this->addJs('js/permissioneditor.js', 'permissioneditor-js');
    }

    /**
     * @return array
     */
    protected function listPermissions()
    {
        return PermissionManager::instance()->listGroupedPermissions();
    }
}
