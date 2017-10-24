<?php namespace Admin\Controllers;

use System\Classes\ComponentManager;
use AdminMenu;

class Layouts extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Layouts_model',
            'title'        => 'lang:admin::layouts.text_title',
            'emptyMessage' => 'lang:admin::layouts.text_empty',
            'defaultSort'  => ['layout_id', 'DESC'],
            'configFile'   => 'layouts_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::layouts.text_form_name',
        'model'      => 'Admin\Models\Layouts_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'layouts/edit/{layout_id}',
            'redirectClose' => 'layouts',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'layouts/edit/{layout_id}',
            'redirectClose' => 'layouts',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'layouts',
        ],
        'delete'     => [
            'redirect' => 'layouts',
        ],
        'configFile' => 'layouts_model',
    ];

    protected $requiredPermissions = 'Site.Layouts';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('layouts', 'design');
    }

    public function index()
    {
        $this->vars['componentManager'] = ComponentManager::instance();
        $this->asExtension('ListController')->index();
    }

    public function listExtendQuery($query)
    {
        $query->with(['components']);
    }

    public function formExtendQuery($query)
    {
        $query->with(['routes', 'components']);
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['name', 'lang:admin::layouts.label_name', 'required|min:2|max:128'],
            ['routes[]', 'lang:admin::layouts.label_routes', 'required'],
        ];

        if (post($form->arrayName.'[routes]')) {
            foreach (post($form->arrayName.'[routes]') as $key => $value) {
                $rules[] = ['routes['.$key.'][uri_route]', '['.$key.'] '.lang('label_route'), 'required'];
            }
        }

        if (post($form->arrayName.'[components]')) {
            foreach (post($form->arrayName.'[components]') as $partial => $layout_components) {
                foreach ($layout_components as $key => $value) {
                    $rules[] = ['components['.$partial.']['.$key.'][module_code]', '['.$partial.'] '.'['.$key.'] '.lang('label_module_code'), 'required|alpha_dash'];
                    $rules[] = ['components['.$partial.']['.$key.'][partial]', '['.$partial.'] '.'['.$key.'] '.lang('label_module_partial'), 'required|alpha_dash'];
                    $rules[] = ['components['.$partial.']['.$key.'][options][title]', '['.$partial.'] '.'['.$key.'] '.lang('label_module_title'), 'min:2'];
                    $rules[] = ['components['.$partial.']['.$key.'][options][fixed]', '['.$partial.'] '.'['.$key.'] '.lang('label_module_fixed'), 'required|integer'];

                    if (post('components['.$partial.']['.$key.'][options][fixed]') == '1') {
                        $rules[] = ['components['.$partial.']['.$key.'][options][fixed_top_offset]', '['.$partial.'] '.'['.$key.'] '.lang('label_fixed_offset'), 'required|integer'];
                        $rules[] = ['components['.$partial.']['.$key.'][options][fixed_bottom_offset]', '['.$partial.'] '.'['.$key.'] '.lang('label_fixed_offset'), 'required|integer'];
                    }

                    $rules[] = ['components['.$partial.']['.$key.'][status]', '['.$partial.'] '.'['.$key.'] '.lang('label_module_status'), 'required|integer'];
                }
            }
        }

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}