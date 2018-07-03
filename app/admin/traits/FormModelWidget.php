<?php namespace Admin\Traits;

use Admin\Classes\FormField;
use ApplicationException;
use Exception;
use Lang;

/**
 * Form Model Widget Trait
 *
 * Special logic for for form widgets that use a database stored model.
 */
trait FormModelWidget
{
    protected $modelsToSave;

    public function createFormModel()
    {
        if (!$this->modelClass) {
            throw new ApplicationException(sprintf("Missing form field property 'modelClass' in '%s'", get_class($this)));
        }

        $class = $this->modelClass;

        return new $class;
    }

    public function findFormModel($recordId)
    {
        if (!strlen($recordId)) {
            throw new ApplicationException(lang('admin::lang.form.missing_id'));
        }

        $model = $this->createFormModel();

        // Prepare query and find model record
        $query = $model->newQuery();
        $result = $query->find($recordId);

        if (!$result)
            throw new ApplicationException(sprintf(lang('admin::lang.form.not_found'), $recordId));

        return $result;
    }

    /**
     * Returns the final model and attribute name of
     * a nested HTML array attribute.
     * Eg: list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);
     *
     * @param  string $attribute .
     *
     * @return array
     */
    public function resolveModelAttribute($attribute = null)
    {
        try {
            return $this->formField->resolveModelAttribute($this->model, $attribute);
        } catch (Exception $ex) {
            throw new ApplicationException(Lang::get('backend::lang.model.missing_relation', [
                'class'    => get_class($this->model),
                'relation' => $attribute,
            ]));
        }
    }

    /**
     * Returns the model of a relation type.
     * @return \Admin\FormWidgets\Relation
     * @throws \Exception
     */
    protected function getRelationModel()
    {
        list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new ApplicationException(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $this->valueFrom
            ));
        }

        return $model->makeRelation($attribute);
    }

    protected function getRelationObject()
    {
        list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new ApplicationException(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $this->valueFrom
            ));
        }

        return $model->{$attribute}();
    }

    protected function getRelationType()
    {
        list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);

        return $model->getRelationType($attribute);
    }

    protected function prepareModelsToSave($model, $saveData)
    {
        $this->modelsToSave = [];
        $this->setModelAttributes($model, $saveData);

        return $this->modelsToSave;
    }

    /**
     * Sets a data collection to a model attributes, relations will also be set.
     *
     * @param \Model $model Model to save to
     *
     * @param array $saveData Data to save.
     *
     * @return void
     */
    protected function setModelAttributes($model, $saveData)
    {
        if (!is_array($saveData) OR !$model) {
            return;
        }

        $this->modelsToSave[] = $model;

        $singularTypes = ['belongsTo', 'hasOne', 'morphOne'];
        foreach ($saveData as $attribute => $value) {
            $isNested = ($attribute == 'pivot' OR (
                    $model->hasRelation($attribute) AND
                    in_array($model->getRelationType($attribute), $singularTypes)
                ));

            if ($isNested AND is_array($value) AND $model->{$attribute}) {
                $this->setModelAttributes($model->{$attribute}, $value);
            }
            elseif ($value !== FormField::NO_SAVE_DATA) {
                if (!starts_with($attribute, '_'))
                    $model->{$attribute} = $value;
            }
        }
    }
}
