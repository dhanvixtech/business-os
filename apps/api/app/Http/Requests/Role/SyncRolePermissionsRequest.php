<?php

namespace App\Http\Requests\Role;

use App\DTOs\Role\SyncRolePermissionsDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SyncRolePermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'permissions' => [
                'required',
                'array',
                'min:1',
            ],

            'permissions.*' => [
                'string',
                Rule::exists('permissions', 'name'),
            ],

        ];
    }

    public function toDto(): SyncRolePermissionsDTO
    {
        return SyncRolePermissionsDTO::fromArray(
            $this->validated()
        );
    }
}
