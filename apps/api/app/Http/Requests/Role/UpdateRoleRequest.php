<?php

namespace App\Http\Requests\Role;

use App\DTOs\Role\UpdateRoleDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($id),
            ],

            'guard_name' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function toDto(): UpdateRoleDTO
    {
        return UpdateRoleDTO::fromArray(
            $this->validated()
        );
    }
}
