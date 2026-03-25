<?php

declare(strict_types = 1);

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:50', 'min:3'],
            'active'      => ['required', 'boolean'],
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array<string, string>
    */
    #[\Override]
    public function messages(): array
    {
        return [
            'description.required' => 'O campo de descrição é obrigatório.',
            'description.string'   => 'O campo de descrição deve ser uma string.',
            'description.max'      => 'O campo de descrição não pode ter mais de 50 caracteres.',
            'description.min'      => 'O campo de descrição deve ter pelo menos 3 caracteres.',
            'active.required'      => 'O campo ativo é obrigatório.',
            'active.boolean'       => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
