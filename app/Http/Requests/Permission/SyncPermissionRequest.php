<?php

declare(strict_types = 1);

namespace App\Http\Requests\Permission;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SyncPermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permission_ids' => ['required', 'exists:permissions,id'],
        ];
    }

    /**
     * Get the validation messages for the request.
     *
     * @return array<string, string>
     */
    #[\Override]
    public function messages(): array
    {
        return [
            'permission_ids.required' => 'Por favor, selecione pelo menos uma permissão.',
            'permission_ids.array'    => 'Formato de permissão inválido.',
            'permission_ids.exists'   => 'A permissão selecionada não existe.',
        ];
    }
}
