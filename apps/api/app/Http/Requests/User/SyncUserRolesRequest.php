<?php

namespace App\Http\Requests\User;

use App\DTOs\User\SyncUserRolesDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SyncUserRolesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'roles' => [
                'required',
                'array',
                'min:1',
            ],

            'roles.*' => [
                'string',
                Rule::exists('roles', 'name'),
            ],

        ];
    }

    public function toDto(): SyncUserRolesDTO
    {
        return SyncUserRolesDTO::fromArray(
            $this->validated()
        );
    }
}
