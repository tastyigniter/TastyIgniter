<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;

final class ReversalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['reason' => ['required', 'string', 'min:3', 'max:1000']];
    }
}
