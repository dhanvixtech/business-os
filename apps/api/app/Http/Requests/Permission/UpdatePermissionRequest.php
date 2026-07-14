<?php

namespace App\Http\Requests\Permission;

use App\DTOs\Permission\UpdatePermissionDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
                Rule::unique('permissions', 'name')->ignore($id),
            ],

            'guard_name' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function toDto(): UpdatePermissionDTO
    {
        return UpdatePermissionDTO::fromArray(
            (int) $this->route('id'),
            $this->validated()
        );
    }
}
