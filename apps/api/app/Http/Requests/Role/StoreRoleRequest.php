<?php

namespace App\Http\Requests\Role;

use App\DTOs\Role\StoreRoleDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name'),
            ],

            'guard_name' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function toDto(): StoreRoleDTO
    {
        return StoreRoleDTO::fromArray(
            $this->validated()
        );
    }
}
