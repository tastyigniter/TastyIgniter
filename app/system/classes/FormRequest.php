<?php

namespace System\Classes;

use Admin\Actions\FormController;
use Admin\Classes\AdminController;
use Igniter\Flame\Exception\SystemException;
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
        if (!$this->controller instanceof AdminController)
            throw new SystemException('Missing controller in: '.get_class($this));

        if (!$this->controller->isClassExtendedWith(FormController::class))
            throw new SystemException('Missing FormController class in: '.get_class($this));

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

    /**
     * @return bool|string
     */
    public function getInputKey()
    {
        if (is_null($this->inputKey))
            $this->setInputKey(strip_class_basename($this));

        return $this->inputKey;
    }

    /**
     * @param bool|string $inputKey
     */
    public function setInputKey($inputKey)
    {
        $this->inputKey = $inputKey;

        return $this;
    }

    public function getWith($key, $default = null)
    {
        return $this->get($this->getInputKey().'.'.$key, $default);
    }

    public function inputWith($key = null, $default = null)
    {
        return $this->input($this->getInputKey().'.'.$key, $default);
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
        return array_get($this->getController()->widgets, 'form');
    }

    /**
     * @return \Igniter\Flame\Database\Model|mixed
     */
    protected function getModel()
    {
        return $this->getController()->getFormModel();
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
        switch ($this->useDataFrom()) {
            case static::DATA_TYPE_FORM:
                return $this->getForm()->getSaveData();
            case static::DATA_TYPE_POST:
                return post($this->getInputKey(), []);
            case static::DATA_TYPE_INPUT:
                return $this->input($this->getInputKey(), []);
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