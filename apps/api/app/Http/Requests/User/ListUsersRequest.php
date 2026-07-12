<?php

namespace App\Http\Requests\User;

use App\DTOs\Common\ListQueryDTO;
use App\Enums\SortDirection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ListUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],

            'sort' => [
                'nullable',
                'in:id,name,email,created_at',
            ],

            'direction' => [
                'nullable',
                new Enum(SortDirection::class),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }

    public function toDto(): ListQueryDTO
    {
        return ListQueryDTO::fromArray(
            $this->validated()
        );
    }
}
