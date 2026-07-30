<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Closure;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Helpers\ValidationHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

trait ValidatesForm
{
    protected $validateAfterCallback;

    /**
     * Validate the given request with the given rules.
     */
    public function validatePasses(mixed $request, array $rules, array $messages = [], array $customAttributes = []): array|false
    {
        $validator = $this->makeValidator($request, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->flashValidationErrors($validator->errors()->toArray());

            return false;
        }

        return $validator->validated();
    }

    /**
     * Validate the given request with the given rules.
     */
    public function validate(mixed $request, array $rules, array $messages = [], array $customAttributes = []): array
    {
        $validator = $this->makeValidator($request, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->flashValidationErrors($validator->errors()->toArray());

            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function makeValidator(mixed $request, array $rules, array $messages = [], array $customAttributes = []): Validator
    {
        $parsed = ValidationHelper::prepareRules($rules);
        $rules = Arr::get($parsed, 'rules', $rules);
        $customAttributes = Arr::get($parsed, 'attributes', $customAttributes);

        $validator = validator()->make(
            $request ?? [], $rules, $messages, $customAttributes,
        );

        if ($this->validateAfterCallback instanceof Closure) {
            $validator->after($this->validateAfterCallback);
        }

        return $validator;
    }

    public function parseRules(array $rules): array
    {
        if (!isset($rules[0])) {
            return $rules;
        }

        $result = [];
        foreach ($rules as $value) {
            $result[$value[0]] = $value[2] ?? [];
        }

        return $result;
    }

    public function parseAttributes(array $rules): array
    {
        if (!isset($rules[0])) {
            return [];
        }

        $result = [];
        foreach ($rules as [$name, $attribute]) {
            $result[$name] = is_lang_key($attribute) ? lang($attribute) : $attribute;
        }

        return $result;
    }

    public function validateAfter(Closure $callback): void
    {
        $this->validateAfterCallback = $callback;
    }

    protected function flashValidationErrors(array $errors)
    {
        Session::flash(Igniter::runningInAdmin() ? 'admin_errors' : 'errors', $errors);
    }

    protected function validateFormWidget(Form $form, mixed $saveData): mixed
    {
        $validated = [];

        // for backwards support, first of all try and use a rules in the config if we have them
        if ($rules = array_get($form->config, 'rules')) {
            $validated = $this->validate($saveData, $rules,
                array_get($form->config, 'validationMessages', []),
                array_get($form->config, 'validationAttributes', []),
            );
        }

        // if we don't have in config then fallback to a FormRequest class
        if (property_exists($this, 'config') && $requestClass = array_get($this->config, 'request')) {
            $validated = array_merge($validated,
                $this->resolveFormRequest($requestClass, function($request) use ($saveData) {
                    $request->merge($saveData);
                })->validated(),
            );
        }

        return $validated ?: $saveData;
    }

    protected function validateFormRequest(?string $requestClass, callable $callback): array
    {
        return $this->resolveFormRequest($requestClass, $callback)->validated() ?? [];
    }

    protected function resolveFormRequest(string $requestClass, callable $callback): FormRequest
    {
        app()->resolving($requestClass, $callback);

        return app()->make($requestClass);
    }
}
