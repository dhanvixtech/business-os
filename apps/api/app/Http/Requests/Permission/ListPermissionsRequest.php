<?php

namespace App\Http\Requests\Permission;

use App\DTOs\Common\ListQueryDTO;
use Illuminate\Foundation\Http\FormRequest;

class ListPermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'sort' => ['nullable', 'string'],
            'direction' => ['nullable'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function toDto(): ListQueryDTO
    {
        return ListQueryDTO::fromArray(
            $this->validated()
        );
    }
}
