<?php

namespace System\Traits;

use Illuminate\Support\Str;

trait RuleInjector
{
    /**
     * Returns whether or not the model will add it's unique
     * identifier to the rules when validating.
     *
     * @return bool
     */
    public function getInjectRuleParameters()
    {
        return $this->injectRuleParameters ?? true;
    }

    /**
     * Set the model to add unique identifier to rules when performing
     * validation.
     *
     * @param  bool $value
     * @return void
     */
    public function setInjectRuleParameters($value)
    {
        $this->injectRuleParameters = (bool)$value;
    }

    /**
     * If the model already exists and it has unique validations
     * it is going to fail validation unless we also pass it's
     * primary key to the rule so that it may be ignored.
     *
     * This will go through all the rules and append the model's
     * primary key to the unique rules so that the validation
     * will work as expected.
     *
     * @param  array $rules
     * @return array
     */
    protected function injectParametersToRules(array $rules)
    {
        foreach ($rules as $field => &$ruleset) {
            // If the ruleset is a pipe-delimited string, convert it to an array.
            $ruleset = is_string($ruleset) ? explode('|', $ruleset) : $ruleset;

            foreach ($ruleset as &$rule) {
                // Only treat stringy definitions and leave Rule classes and Closures as-is.
                if (is_string($rule)) {
                    $parameters = explode(':', $rule);
                    $validationRule = array_shift($parameters);

                    if ($method = $this->getRuleInjectorMethod($validationRule)) {
                        $rule = call_user_func_array(
                            [$this, $method],
                            [explode(',', head($parameters)), $field]
                        );
                    }
                }
            }
        }

        return $rules;
    }

    /**
     * Get the dynamic method name for a unique identifier or custom injector rule if it
     * exists, otherwise return false.
     *
     * @param  string $validationRule
     * @return mixed
     */
    protected function getRuleInjectorMethod($validationRule)
    {
        $method = 'prepare'.Str::studly($validationRule).'Rule';

        return method_exists($this, $method) ? $method : false;
    }

    /**
     * Prepare a rule, adding the table name, column and model identifier
     * if required.
     *
     * @param  array $parameters
     * @param  string $field
     * @return string
     */
    protected function prepareUniqueRule($parameters, $field)
    {
        // If the table name isn't set, infer it.
        if (empty($parameters[0])) {
            $parameters[0] = $this->getModel()->getTable();
        }

        // If the connection name isn't set but exists, infer it.
        if ((strpos($parameters[0], '.') === false) && (($connectionName = $this->getModel()->getConnectionName()) !== null)) {
            $parameters[0] = $connectionName.'.'.$parameters[0];
        }

        // If the field name isn't get, infer it.
        if (!isset($parameters[1])) {
            $parameters[1] = $field;
        }

        if ($this->getModel()->exists) {
            // If the identifier isn't set, infer it.
            if (!isset($parameters[2]) || strtolower($parameters[2]) === 'null') {
                $parameters[2] = $this->getModel()->getKey();
            }

            // If the primary key isn't set, infer it.
            if (!isset($parameters[3])) {
                $parameters[3] = $this->getModel()->getKeyName();
            }

            // If the additional where clause isn't set, infer it.
            // Example: unique:users,email,123,id,username,NULL
            foreach ($parameters as $key => $parameter) {
                if (strtolower((string)$parameter) === 'null') {
                    // Maintain NULL as string in case the model returns a null value
                    $value = $this->getModel()->{$parameters[$key - 1]};
                    $parameters[$key] = is_null($value) ? 'NULL' : $value;
                }
            }
        }

        return 'unique:'.implode(',', $parameters);
    }

    /**
     * Prepare a unique_with rule, adding the model identifier if required.
     *
     * @param  array $parameters
     * @param  string $field
     * @return string
     */
    protected function prepareUniqueWithRule($parameters, $field)
    {
        // Table and intermediary fields are required for this validator to work and cannot be guessed.
        // Let's just check the model identifier.
        if ($this->getModel()->exists) {
            // If the identifier isn't set, add it.
            if (count($parameters) < 3 || !preg_match('/^\d+(\s?=\s?\w*)?$/', last($parameters))) {
                $parameters[] = $this->getModel()->getKey();
            }
        }

        return 'unique_with:'.implode(',', $parameters);
    }
}
