<?php

namespace System\Classes;

use Igniter\Flame\Exception\ValidationException;
use Igniter\Flame\Traits\EventEmitter;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Support\Arr;
use System\Helpers\ValidationHelper;
use System\Traits\RuleInjector;

class FormRequest extends BaseFormRequest
{
    use RuleInjector;
    use EventEmitter;

    protected const DATA_TYPE_FORM = 'form';
    protected const DATA_TYPE_POST = 'post';
    protected const DATA_TYPE_INPUT = 'input';

    protected $model;

    /**
     * @var \Admin\Classes\AdminController
     */
    protected $controller;

    /**
     * @var
     */
    protected $inputKey;

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     * @return self;
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return bool|string
     */
    public function getInputKey()
    {
        return $this->inputKey;
    }

    /**
     * @param bool|string $inputKey
     * @return \System\Classes\FormRequest
     */
    public function setInputKey($inputKey)
    {
        $this->inputKey = $inputKey;

        return $this;
    }

    public function getWith($key, $default = null)
    {
        if (!is_null($inputKey = $this->getInputKey()))
            $key = $inputKey.'.'.$key;

        return $this->get($key, $default);
    }

    public function inputWith($key, $default = null)
    {
        if (!is_null($inputKey = $this->getInputKey()))
            $key = $inputKey.'.'.$key;

        return $this->input($key, $default);
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_FORM;
    }

    /**
     * @return \Admin\Widgets\Form
     * @throws \Igniter\Flame\Exception\SystemException
     */
    protected function getForm()
    {
        return array_get(optional($this->getController())->widgets ?? [], 'form');
    }

    /**
     * @return \Igniter\Flame\Database\Model|mixed
     */
    protected function getModel()
    {
        if ($this->model)
            return $this->model;

        if (!$this->getController())
            return null;

        if ($this->getController()->methodExists('getFormModel'))
            return $this->getController()->getFormModel();

        if ($this->getController()->methodExists('getRestModel'))
            return $this->getController()->getRestModel();
    }

    /**
     * Create the default validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(Factory $factory)
    {
        $registeredRules = $this->container->call([$this, 'rules']);
        $parsedRules = ValidationHelper::prepareRules($registeredRules);

        $dataHolder = new \stdClass();
        $dataHolder->data = $this->validationData();
        $dataHolder->rules = Arr::get($parsedRules, 'rules', $registeredRules);
        $dataHolder->messages = Arr::get($parsedRules, 'messages', $this->messages());
        $dataHolder->attributes = Arr::get($parsedRules, 'attributes', $this->attributes());

        if ($this->getInjectRuleParameters()) {
            $dataHolder->rules = $this->injectParametersToRules($dataHolder->rules);
        }

        $this->fireSystemEvent('system.formRequest.extendValidator', [$dataHolder]);

        return $factory->make(
            $dataHolder->data,
            $dataHolder->rules,
            $dataHolder->messages,
            $dataHolder->attributes
        );
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        if ($this->getForm()) {
            switch ($this->useDataFrom()) {
                case static::DATA_TYPE_FORM:
                    return $this->getForm()->getSaveData();
                case static::DATA_TYPE_POST:
                    return post($this->getInputKey(), []);
                case static::DATA_TYPE_INPUT:
                    return $this->input($this->getInputKey(), []);
            }
        }

        return $this->all();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
