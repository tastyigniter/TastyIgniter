<?php

declare(strict_types=1);

/**
 * Form helper functions
 */

use Igniter\Flame\Html\FormBuilder;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

if (!function_exists('form_open')) {
    /**
     * Form Declaration
     * Creates the opening portion of the form.
     *
     * @param string $action the URI segments of the form destination
     * @param array $attributes a key/value a pair of attributes
     */
    function form_open(string|array $action = '', array $attributes = []): string
    {
        if (is_string($action)) {
            $attributes['url'] = $action;
        } else {
            $attributes = $action;
        }

        $handler = null;
        if (isset($attributes['handler'])) {
            $handler = app(FormBuilder::class)->hidden('_handler', $attributes['handler']);
        }

        return app(FormBuilder::class)->open($attributes).$handler;
    }
}

if (!function_exists('form_open_multipart')) {
    /**
     * Form Declaration - Multipart type
     * Creates the opening portion of the form, but with "multipart/form-data".
     *
     * @param string $action the URI segments of the form destination
     * @param array $attributes a key/value pair of attributes
     */
    function form_open_multipart(string|array $action = '', array $attributes = []): string
    {
        $attributes['enctype'] = 'multipart/form-data';

        return form_open($action, $attributes);
    }
}

if (!function_exists('form_close')) {
    /**
     * Form Close Tag
     */
    function form_close(string $extra = ''): string
    {
        return app(FormBuilder::class)->close().$extra;
    }
}

if (!function_exists('set_value')) {
    /**
     * Form Value
     * Grabs a value from the POST array for the specified field so you can
     * re-populate an input field or textarea. If Form Validation
     * is active it retrieves the info from the validation class
     *
     * @param string $field Field name
     * @param bool|string $default Default value
     *
     * @return    string
     */
    function set_value($field, $default = '')
    {
        return app(FormBuilder::class)->getValueAttribute($field, $default);
    }
}

if (!function_exists('set_select')) {
    /**
     * Set Select
     * Lets you set the selected value of a <select> menu via data in the POST array.
     * If Form Validation is active it retrieves the info from the validation class
     *
     * @param $field string
     * @param $value string
     * @param $default bool
     */
    function set_select($field, $value = '', $default = false): string
    {
        if (($input = set_value($field, false)) === null) {
            return ($default === true) ? ' selected="selected"' : '';
        }

        $value = (string)$value;
        if (is_array($input)) {
            if (in_array($value, $input, true)) {
                return ' selected="selected"';
            }

            return '';
        }

        return ($input === $value) ? ' selected="selected"' : '';
    }
}

if (!function_exists('set_checkbox')) {
    /**
     * Set Checkbox
     * Lets you set the selected value of a checkbox via the value in the POST array.
     * If Form Validation is active it retrieves the info from the validation class
     *
     * @param $field string
     * @param $value string
     * @param $default bool
     */
    function set_checkbox($field, $value = '', $default = false): string
    {
        // Form inputs are always strings ...
        $value = (string)$value;
        $input = set_value($field, false);

        if (is_array($input)) {
            if (in_array($value, $input, true)) {
                return ' checked="checked"';
            }

            return '';
        } elseif (is_string($input)) {
            return ($input === $value) ? ' checked="checked"' : '';
        }

        return ($default === true) ? ' checked="checked"' : '';
    }
}

if (!function_exists('set_radio')) {
    /**
     * Set Radio
     * Let's you set the selected value of a radio field via info in the POST array.
     * If Form Validation is active it retrieves the info from the validation class
     *
     * @param string $field
     * @param string $value
     * @param bool $default
     */
    function set_radio($field, $value = '', $default = false): string
    {
        // Form inputs are always strings ...
        $value = (string)$value;
        $input = set_value($field, false);

        if (is_array($input)) {
            if (in_array($value, $input, true)) {
                return ' checked="checked"';
            }

            return '';
        } elseif (is_string($input)) {
            return ($input === $value) ? ' checked="checked"' : '';
        }

        return ($default === true) ? ' checked="checked"' : '';
    }
}

if (!function_exists('form_error')) {
    /**
     * Form Error
     * Returns the error for a specific form field. This is a helper for the
     * form validation class.
     */
    function form_error($field = null, string $prefix = '', string $suffix = '', $bag = 'default')
    {
        $errorsKey = Igniter::runningInAdmin() ? 'admin_errors' : 'errors';
        $errors = (Config::get('session.driver') && Session::has($errorsKey))
            ? Session::get($errorsKey)
            : array_get(app('view')->getShared(), $errorsKey, new ViewErrorBag);

        $errors = $errors instanceof ViewErrorBag ? $errors->getBag($bag) : new MessageBag($errors);

        if (is_null($field)) {
            return $errors;
        }

        if (!$errors->has($field)) {
            return null;
        }

        return $prefix.$errors->first($field).$suffix;
    }
}

if (!function_exists('has_form_error')) {
    /**
     * Form Error
     * Returns the error for a specific form field. This is a helper for the
     * form validation class.
     *
     * @return    string
     */
    function has_form_error($field = null, $bag = 'default')
    {
        $errors = (Config::get('session.driver') && Session::has('errors'))
            ? Session::get('errors')
            : array_get(app('view')->getShared(), 'errors', new ViewErrorBag);

        $errors = $errors->getBag($bag);

        if (is_null($field)) {
            return $errors;
        }

        return $errors->has($field);
    }
}
