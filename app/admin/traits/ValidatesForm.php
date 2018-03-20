<?php

namespace Admin\Traits;

use Closure;
use Igniter\Flame\Exception\ValidationException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Str;
use Session;

trait ValidatesForm
{
//    protected $validateAfterCallback;

    /**
     * Validate the given request with the given rules.
     *
     * @param  $request
     * @param  array $rules
     * @param  array $messages
     * @param  array $customAttributes
     *
     * @return array|bool
     */
    public function validatePasses($request, array $rules, array $messages = [], array $customAttributes = [])
    {
        if (!$customAttributes)
            $customAttributes = $this->parseAttributes($rules);

        $rules = $this->parseRules($rules);

        $validator = $this->getValidationFactory()->make(
            $request, $rules, $messages, $customAttributes
        );

        if ($this->validateAfterCallback instanceof Closure)
            $validator->after($this->validateAfterCallback);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());

            return FALSE;
        }

        return $this->extractInputFromRules($request, $rules);
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  $request
     * @param  array $rules
     * @param  array $messages
     * @param  array $customAttributes
     *
     * @return array
     */
    public function validate($request, array $rules, array $messages = [], array $customAttributes = [])
    {
        if (!$customAttributes)
            $customAttributes = $this->parseAttributes($rules);

        $rules = $this->parseRules($rules);

        $validator = $this->getValidationFactory()
                          ->make($request, $rules, $messages, $customAttributes);

        if ($this->validateAfterCallback instanceof Closure)
            $validator->after($this->validateAfterCallback);

        if ($this->validateAfterCallback instanceof Closure)
            $validator->after($this->validateAfterCallback);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            throw new ValidationException($validator);
        }

        return $this->extractInputFromRules($request, $rules);
    }

    protected function parseRules($rules)
    {
        if (!isset($rules[0]))
            return $rules;

        $result = [];
        foreach ($rules as $key => $value) {
            $result[$value[0]] = isset($value[2]) ? $value[2] : [];
        }

        return $result;
    }

    protected function parseAttributes($rules)
    {
        if (!isset($rules[0]))
            return $rules;

        $result = [];
        foreach ($rules as $key => $value) {
            list($name, $attribute,) = $value;
            $result[$name] = (sscanf($attribute, 'lang:%s', $line) === 1) ? lang($line) : $attribute;
        }

        return $result;
    }

    /**
     * Get the request input based on the given validation rules.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $rules
     *
     * @return array
     */
    protected function extractInputFromRules($request, array $rules)
    {
        return collect($request)->only(
            collect($rules)->keys()->map(function ($rule) {
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
}
