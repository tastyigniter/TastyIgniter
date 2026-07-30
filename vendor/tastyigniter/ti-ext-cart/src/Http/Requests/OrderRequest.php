<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
}
