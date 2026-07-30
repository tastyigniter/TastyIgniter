<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Event;

trait FormExtendable
{
    /**
     * Called to validate create or edit form.
     */
    public function formValidate(Model $model, $form) {}

    /**
     * Called before the creation or updating form is saved.
     */
    public function formBeforeSave(Model $model) {}

    /**
     * Called after the creation or updating form is saved.
     */
    public function formAfterSave(Model $model) {}

    /**
     * Called before the creation form is saved.
     */
    public function formBeforeCreate(Model $model) {}

    /**
     * Called after the creation form is saved.
     */
    public function formAfterCreate(Model $model) {}

    /**
     * Called before the updating form is saved.
     */
    public function formBeforeUpdate(Model $model) {}

    /**
     * Called after the updating form is saved.
     */
    public function formAfterUpdate(Model $model) {}

    /**
     * Called after the form model is deleted.
     */
    public function formAfterDelete(Model $model) {}

    /**
     * Finds a Model record by its primary identifier, used by edit actions. This logic
     * can be changed by overriding it in the controller.
     */
    public function formFindModelObject(?string $recordId): Model
    {
        $recordId = strip_tags((string)$recordId); // remove html tags from url(reflective xss)
        throw_unless(strlen($recordId), new FlashException(lang('igniter::admin.form.missing_id')));

        $model = $this->controller->formCreateModelObject();

        // Prepare query and find model record
        $query = $model->newQuery();

        // @deprecated event controller.form.extendQuery, use admin.controller.extendFormQuery. Remove before v4
        $this->controller->fireEvent('controller.form.extendQuery', [$query]);
        $this->controller->fireEvent('admin.controller.extendFormQuery', [$query]);
        $this->controller->formExtendQuery($query);

        $result = $query->find($recordId);

        throw_unless($result, new FlashException(sprintf(lang('igniter::admin.form.not_found'), $recordId)));

        return $this->controller->formExtendModel($result) ?: $result;
    }

    /**
     * Creates a new instance of a form model. This logic can be changed
     * by overriding it in the controller.
     * @return\Igniter\Flame\Database\Model
     */
    public function formCreateModelObject(): Model
    {
        return $this->createModel();
    }

    /**
     * Called before the form fields are defined.
     *
     * @param Form $host The hosting form widget
     *
     * @return void
     */
    public function formExtendFieldsBefore(Form $host) {}

    /**
     * Called after the form fields are defined.
     *
     * @param Form $host The hosting form widget
     *
     * @return void
     */
    public function formExtendFields(Form $host, $fields) {}

    /**
     * Called before the form is refreshed, should return an array of additional save data.
     */
    public function formExtendRefreshData(Form $host, array $saveData) {}

    /**
     * Called when the form is refreshed, giving the opportunity to modify the form fields.
     */
    public function formExtendRefreshFields(Form $host, array $fields) {}

    /**
     * Called after the form is refreshed, should return an array of additional result parameters.
     */
    public function formExtendRefreshResults(Form $host, array $result) {}

    /**
     * Extend supplied model used by create and edit actions, the model can
     * be altered by overriding it in the controller.
     *
     * @return\Igniter\Flame\Database\Model
     */
    public function formExtendModel(Model $model) {}

    /**
     * Extend the query used for finding the form model. Extra conditions
     * can be applied to the query, for example, $query->withTrashed();
     */
    public function formExtendQuery(Builder $query) {}

    public function formExtendConfig(array $formConfig) {}

    /** Static helper for extending form fields. */
    public static function extendFormFields(callable $callback): void
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('admin.form.extendFields', function($widget) use ($calledClass, $callback) {
            if (is_a($widget->getController(), $calledClass)) {
                $callback($widget, $widget->model, $widget->getContext());
            }
        });
    }

    /**
     * Static helper for extending form fields.
     */
    public static function extendFormFieldsBefore(callable $callback): void
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('admin.form.extendFieldsBefore', function($widget) use ($calledClass, $callback) {
            if (is_a($widget->getController(), $calledClass)) {
                $callback($widget, $widget->model, $widget->getContext());
            }
        });
    }
}
