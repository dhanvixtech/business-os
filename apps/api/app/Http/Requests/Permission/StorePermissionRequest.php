<?php

namespace App\Http\Requests\Permission;

use App\DTOs\Permission\StorePermissionDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
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
                Rule::unique('permissions', 'name'),
            ],

            // Optional
            'guard_name' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function toDto(): StorePermissionDTO
    {
        return StorePermissionDTO::fromArray(
            $this->validated()
        );
    }
}
