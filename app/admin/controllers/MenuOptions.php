<?php namespace Admin\Controllers;

use Admin\Models\Menu_options_model;
use AdminMenu;

class MenuOptions extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Menu_options_model',
            'title'        => 'lang:admin::menu_options.text_title',
            'emptyMessage' => 'lang:admin::menu_options.text_empty',
            'defaultSort'  => ['option_id', 'DESC'],
            'configFile'   => 'menu_options_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::menu_options.text_form_name',
        'model'      => 'Admin\Models\Menu_options_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'menu_options/edit/{option_id}',
            'redirectClose' => 'menu_options',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'menu_options/edit/{option_id}',
            'redirectClose' => 'menu_options',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'menu_options',
        ],
        'delete'     => [
            'redirect' => 'menu_options',
        ],
        'configFile' => 'menu_options_model',
    ];

    protected $requiredPermissions = 'Admin.MenuOptions';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menu_options', 'kitchen');
    }

    public function autocomplete()
    {
        $json = [];

        if (get('term')) {
            $results = Menu_options_model::getAutoComplete(['option_name' => get('term')]);
            if ($results) {
                foreach ($results as $result) {
                    $json['results'][] = [
                        'id'            => $result['option_id'],
                        'text'          => utf8_encode($result['option_name']),
                        'display_type'  => utf8_encode($result['display_type']),
                        'priority'      => $result['priority'],
                        'option_values' => $result['option_values'],
                    ];
                }
            }
            else {
                $json['results'] = ['id' => '0', 'text' => lang('admin::menu_options.text_no_match')];
            }
        }

        return $json;
    }

    public function formExtendQuery($query)
    {
        $query->with('option_values');
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['option_name', 'lang:admin::menu_options.label_option_name', 'required|min:2|max:32'];
        $rules[] = ['display_type', 'lang:admin::menu_options.label_display_type', 'required|alpha'];

        if (post($form->arrayName.'.option_values')) {
            foreach (post($form->arrayName.'.option_values') as $key => $value) {
                $rules[] = ['option_values.'.$key.'.value', '['.$key.'] '.lang('admin::menu_options.label_option_value'), 'required|min:2|max:128'];
                $rules[] = ['option_values.'.$key.'.price', '['.$key.'] '.lang('admin::menu_options.label_option_price'), 'required|numeric'];
            }
        }

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}