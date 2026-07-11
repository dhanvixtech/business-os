<?php

namespace App\Http\Requests\Role;

use App\DTOs\Common\ListQueryDTO;
use Illuminate\Foundation\Http\FormRequest;

class ListRolesRequest extends FormRequest
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
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
        ];
    }

    public function toDto(): ListQueryDTO
    {
        return ListQueryDTO::fromArray(
            $this->validated()
        );
    }
}
