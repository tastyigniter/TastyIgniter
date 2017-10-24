<?php namespace Admin\Controllers;

use AdminMenu;

class Banners extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Banners_model',
            'title'        => 'lang:admin::banners.text_title',
            'emptyMessage' => 'lang:admin::banners.text_empty',
            'defaultSort'  => ['order_id', 'DESC'],
            'configFile'   => 'banners_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::banners.text_form_name',
        'model'      => 'Admin\Models\Banners_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'banners/edit/{banner_id}',
            'redirectClose' => 'banners',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'banners/edit/{banner_id}',
            'redirectClose' => 'banners',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'banners',
        ],
        'delete'     => [
            'redirect' => 'banners',
        ],
        'configFile' => 'banners_model',
    ];

    protected $requiredPermissions = 'Admin.Banners';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('banners', 'marketing');
    }

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['name', 'lang:admin::banners.label_name', 'required|min:2|max:255'],
            ['type', 'lang:admin::banners.label_type', 'required|alpha|max:8'],
            ['click_url', 'lang:admin::banners.label_click_url', 'required|min:2|max:255'],
            ['custom_code', 'lang:admin::banners.label_custom_code', 'required_if:type,custom'],
            ['alt_text', 'lang:admin::banners.label_alt_text', 'required_if:type,image|min:2|max:255'],
            ['image_code', 'lang:admin::banners.label_image', 'required_if:type,image'],
            ['carousels.*', 'lang:admin::banners.label_alt_text', 'required_if:type,carousel'],
            ['language_id', 'lang:admin::banners.label_images', 'required|integer'],
            ['status', 'lang:admin::banners.label_language', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}
