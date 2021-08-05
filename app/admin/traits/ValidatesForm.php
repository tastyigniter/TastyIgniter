<?php

namespace Admin\Traits;

use Closure;
use Igniter\Flame\Exception\ValidationException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use System\Helpers\ValidationHelper;

trait ValidatesForm
{
    protected $validateAfterCallback;

    /**
     * Validate the given request with the given rules.
     *
     * @param  $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     *
     * @return array|bool
     */
    public function validatePasses($request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->makeValidator($request, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->flashValidationErrors($validator->errors());

            return FALSE;
        }

        return $this->extractInputFromRules($request, $rules);
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     *
     * @return array
     */
    public function validate($request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->makeValidator($request, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->flashValidationErrors($validator->errors());
            throw new ValidationException($validator);
        }

        return $this->extractInputFromRules($request, $rules);
    }

    public function makeValidator($request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $parsed = ValidationHelper::prepareRules($rules);
        $rules = Arr::get($parsed, 'rules', $rules);
        $customAttributes = Arr::get($parsed, 'attributes', $customAttributes);

        $validator = $this->getValidationFactory()->make(
            $request ?? [], $rules, $messages, $customAttributes
        );

        if ($this->validateAfterCallback instanceof Closure)
            $validator->after($this->validateAfterCallback);

        return $validator;
    }

    public function parseRules(array $rules)
    {
        if (!isset($rules[0]))
            return $rules;

        $result = [];
        foreach ($rules as $key => $value) {
            $result[$value[0]] = $value[2] ?? [];
        }

        return $result;
    }

    public function parseAttributes(array $rules)
    {
        if (!isset($rules[0]))
            return [];

        $result = [];
        foreach ($rules as $key => [$name, $attribute]) {
            $result[$name] = is_lang_key($attribute) ? lang($attribute) : $attribute;
        }

        return $result;
    }

    /**
     * Get the request input based on the given validation rules.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $rules
     *
     * @return array
     */
    protected function extractInputFromRules($request, array $rules)
    {
        return collect($request)->only(
            collect($this->parseRules($rules))->keys()->map(function ($rule) {
                return Str::contains($rule, '.') ? explode('.', $rule)[0] : $rule;
            })->unique()->toArray()
        )->toArray();
    }

    /**
     * Get a validation factory instance.
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

    public function validateAfter(Closure $callback)
    {
        $this->validateAfterCallback = $callback;
    }

    protected function flashValidationErrors($errors)
    {
        $sessionKey = 'errors';

        if (App::runningInAdmin())
            $sessionKey = 'admin_errors';

        return Session::flash($sessionKey, $errors);
    }

    protected function validateFormWidget($form, $saveData)
    {
        if (!$rules = array_get($form->config, 'rules'))
            return;

        return $this->validate($saveData, $rules);
    }
}
