<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
                'in:id,name,email,created_at'
            ],

            'direction' => [
                'nullable',
                'in:asc,desc'
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100'
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }
}
