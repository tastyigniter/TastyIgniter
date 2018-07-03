<?php namespace Admin\Controllers;

use AdminMenu;
use System\Models\Settings_model;
use Template;

class Ratings extends \Admin\Classes\AdminController
{
    protected $requiredPermissions = 'Admin.Ratings';

    public function index()
    {
        AdminMenu::setContext('ratings', 'localisation');

        if (post() AND $this->_updateRating() === TRUE) {
            return $this->redirectBack();
        }

        Template::setTitle(lang('admin::lang.ratings.text_title'));
        Template::setHeading(lang('admin::lang.ratings.text_heading'));
        Template::setButton(lang('admin::lang.button_save'), ['class' => 'btn btn-primary', 'role' => 'button', 'onclick' => '$(\'#edit-form\').submit();']);

        $this->addJs('~/app/admin/formwidgets/repeater/assets/js/jquery-sortable.js', 'jquery-sortable-js');

        $this->prepareVars();
    }

    public function prepareVars()
    {
        if (post('ratings')) {
            $results = post('ratings');
        }
        else {
            $results = Settings_model::where('sort', 'ratings')->first();
            $results = array_get($results->value, 'ratings', []);
        }

        $this->vars['ratings'] = [];
        if (is_array($results)) {
            foreach ($results as $key => $value) {
                $this->vars['ratings'][$key] = $value;
            }
        }
    }

    protected function _updateRating()
    {
        if ($this->validateForm()) {
            $update = [];
            $update['ratings'] = post('ratings');

            if ($ratings = Settings_model::where('sort', 'ratings')->first()) {
                $ratings->value = serialize($update);
                $ratings->save();
                flash()->success(sprintf(lang('admin::lang.alert_success'), 'Rating updated '));
            }
            else {
                flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), 'updated'));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        $rules[] = ['ratings.*', 'lang:admin::lang.ratings.label_name', 'required|min:2|max:32'];

        return $this->validatePasses(post(), $rules);
    }
}