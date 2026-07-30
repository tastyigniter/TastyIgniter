<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Igniter\Flame\Traits\EventEmitter;
use Igniter\System\Helpers\ValidationHelper;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Override;
use stdClass;

class FormRequest extends BaseFormRequest
{
    use EventEmitter;

    /**
     * Create the default validator instance.
     */
    #[Override]
    protected function createDefaultValidator(Factory $factory): Validator
    {
        $registeredRules = $this->container->call([$this, 'rules']);
        $parsedRules = ValidationHelper::prepareRules($registeredRules);

        $dataHolder = new stdClass;
        $dataHolder->data = $this->validationData();
        $dataHolder->rules = Arr::get($parsedRules, 'rules', $registeredRules);
        $dataHolder->messages = array_merge(Arr::get($parsedRules, 'messages', []), $this->messages());
        $dataHolder->attributes = array_merge(Arr::get($parsedRules, 'attributes', []), $this->attributes());

        $this->fireSystemEvent('system.formRequest.extendValidator', [$dataHolder]);

        return $factory->make(
            $dataHolder->data,
            $dataHolder->rules,
            $dataHolder->messages,
            $dataHolder->attributes,
        );
    }

    /**
     * Handle a failed validation attempt.
     */
    #[Override]
    protected function failedValidation(Validator $validator): never
    {
        throw new ValidationException($validator);
    }

    protected function getRecordId(): int|string|null
    {
        return ($slug = $this->route('slug'))
            ? str_after($slug, '/') : null;
    }
}
