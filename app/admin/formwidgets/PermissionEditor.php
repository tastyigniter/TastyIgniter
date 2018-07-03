<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use System\Models\Permissions_model;

/**
 * Staff group permission editor
 * This widget is used by the system internally on the Users / Staff Groups pages.
 *
 * @package Admin
 */
class PermissionEditor extends BaseFormWidget
{
    public $actionCssClasses = [
        'access' => 'default',
        'manage' => 'info',
        'add'    => 'success',
        'delete' => 'danger',
    ];

    public $tabs = [
        'site'    => 'lang:admin::lang.staff_groups.text_site',
        'module'  => 'lang:admin::lang.staff_groups.text_module',
        'payment' => 'lang:admin::lang.staff_groups.text_payment',
        'admin'   => 'lang:admin::lang.staff_groups.text_admin',
    ];

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
        $this->vars['permissions'] = $this->listPermissions();
        $permissionsData = $this->getLoadValue();

        $this->vars['permissionsData'] = is_array($permissionsData) ? $permissionsData : [];
        $this->vars['field'] = $this->formField;
        $this->vars['tabs'] = $this->tabs;
        $this->vars['actionCssClasses'] = $this->actionCssClasses;
    }

    public function getSaveValue($value)
    {
        if (!is_array($value)) {
            return [];
        }

        $result = [];
        foreach ($value as $name => $permission) {
            $name = str_replace('::', '.', $name);
            $result[$name] = $permission;
        }

        return $result;
    }

    public function getLoadValue()
    {
        $permissionsIds = Permissions_model::all()->keyBy('permission_id');
        $permissions = parent::getLoadValue();

        $result = [];
        if (!is_array($permissions))
            return $result;

        foreach ($permissions as $name => $permission) {
            if (is_numeric($name) AND isset($permissionsIds[$name]))
                $name = $permissionsIds[$name]->name;

            $name = str_replace('::', '.', $name);
            $result[$name] = $permission;
        }

        return $result;
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
        $result = [];
        $permissions = Permissions_model::listTabbedPermissions();
        foreach ($this->tabs as $name => $tab) {
            $result[$name] = isset($permissions[$name]) ? $permissions[$name] : [];
        }

        return $result;
    }
}