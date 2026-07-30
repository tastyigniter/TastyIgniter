<?php

declare(strict_types=1);

namespace Igniter\System\Helpers;

class ValidationHelper
{
    /**
     * Returns shared view variables, this should be used for simple rendering cycles.
     * Such as content blocks and mail templates.
     */
    public static function prepareRules(array $rules): array
    {
        $result = [];

        if (!isset($rules[0])) {
            return $rules;
        }

        foreach ($rules as $name => $value) {
            if (is_string($name)) {
                $result['rules'][$name] = $value;
                continue;
            }

            $name = $value[0] ?? '';
            if (isset($value[2])) {
                $result['rules'][$name] = is_string($value[2]) ? explode('|', $value[2]) : $value[2];
            }

            if (isset($value[1])) {
                $result['attributes'][$name] = is_lang_key($value[1]) ? lang($value[1]) : $value[1];
            }
        }

        return $result;
    }
}
