<?php

namespace System\Helpers;

class ValidationHelper
{
    /**
     * Returns shared view variables, this should be used for simple rendering cycles.
     * Such as content blocks and mail templates.
     *
     * @param $rules
     * @return array
     */
    public static function prepareRules($rules)
    {
        $result = [];

        if (!isset($rules[0]))
            return $result;

        foreach ($rules as $key => $value) {
            $name = $value[0] ?? '';
            if (isset($value[2]))
                $result['rules'][$name] = explode('|', $value[2]);

            if (isset($value[1]))
                $result['attributes'][$name] = is_lang_key($value[1]) ? lang($value[1]) : $value[1];
        }

        return $result;
    }
}
