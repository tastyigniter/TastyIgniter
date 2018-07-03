<?php

namespace Admin\Traits;

use Event;
use Exception;

trait FormExtendable
{
    /**
     * Called to validate create or edit form.
     */
    public function formValidate($model, $form)
    {
    }

    /**
     * Called before the creation or updating form is saved.
     */
    public function formBeforeSave($model)
    {
    }

    /**
     * Called after the creation or updating form is saved.
     */
    public function formAfterSave($model)
    {
    }

    /**
     * Called before the creation form is saved.
     */
    public function formBeforeCreate($model)
    {
    }

    /**
     * Called after the creation form is saved.
     */
    public function formAfterCreate($model)
    {
    }

    /**
     * Called before the updating form is saved.
     */
    public function formBeforeUpdate($model)
    {
    }

    /**
     * Called after the updating form is saved.
     */
    public function formAfterUpdate($model)
    {
    }

    /**
     * Called after the form model is deleted.
     */
    public function formAfterDelete($model)
    {
    }

    /**
     * Finds a Model record by its primary identifier, used by edit actions. This logic
     * can be changed by overriding it in the controller.
     *
     * @param string $recordId
     *
     * @return \Model
     * @throws \Exception
     */
    public function formFindModelObject($recordId)
    {
        if (!strlen($recordId)) {
            throw new Exception(lang('admin::lang.form.missing_id'));
        }

        $model = $this->controller->formCreateModelObject();

        // Prepare query and find model record
        $query = $model->newQuery();
        $this->controller->formExtendQuery($query);
        $result = $query->find($recordId);

        if (!$result) {
            throw new Exception(sprintf(lang('admin::lang.form.not_found'), $recordId));
        }

        $result = $this->controller->formExtendModel($result) ?: $result;

        return $result;
    }

    /**
     * Creates a new instance of a form model. This logic can be changed
     * by overriding it in the controller.
     * @return \Model
     */
    public function formCreateModelObject()
    {
        return $this->createModel();
    }

    /**
     * Called before the form fields are defined.
     *
     * @param \Admin\Widgets\Form $host The hosting form widget
     *
     * @return void
     */
    public function formExtendFieldsBefore($host)
    {
    }

    /**
     * Called after the form fields are defined.
     *
     * @param \Admin\Widgets\Form $host The hosting form widget
     *
     * @return void
     */
    public function formExtendFields($host, $fields)
    {
    }

    /**
     * Called before the form is refreshed, should return an array of additional save data.
     *
     * @param \Admin\Widgets\Form $host The hosting form widget
     * @param array $saveData Current save data
     *
     * @return array
     */
    public function formExtendRefreshData($host, $saveData)
    {
    }

    /**
     * Called when the form is refreshed, giving the opportunity to modify the form fields.
     *
     * @param \Admin\Widgets\Form $host The hosting form widget
     * @param array $fields Current form fields
     *
     * @return array
     */
    public function formExtendRefreshFields($host, $fields)
    {
    }

    /**
     * Called after the form is refreshed, should return an array of additional result parameters.
     *
     * @param \Admin\Widgets\Form $host The hosting form widget
     * @param array $result Current result parameters.
     *
     * @return array
     */
    public function formExtendRefreshResults($host, $result)
    {
    }

    /**
     * Extend supplied model used by create and edit actions, the model can
     * be altered by overriding it in the controller.
     *
     * @param \Model $model
     *
     * @return \Model
     */
    public function formExtendModel($model)
    {
    }

    /**
     * Extend the query used for finding the form model. Extra conditions
     * can be applied to the query, for example, $query->withTrashed();
     *
     * @param \Igniter\Flame\Database\Builder $query
     *
     * @return void
     */
    public function formExtendQuery($query)
    {
    }

    /**
     * Static helper for extending form fields.
     *
     * @param  callable $callback
     *
     * @return void
     */
    public static function extendFormFields($callback)
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('admin.form.extendFields', function ($widget) use ($calledClass, $callback) {
            if (!is_a($widget->getController(), $calledClass)) {
                return;
            }
            call_user_func_array($callback, [$widget, $widget->model, $widget->getContext()]);
        });
    }
}