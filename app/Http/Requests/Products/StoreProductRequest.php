<?php

declare(strict_types = 1);

namespace App\Http\Requests\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'system_id'   => ['required', 'integer', 'exists:systems,id'],
            'description' => ['required', 'string', 'max:50', 'min:3'],
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
            'system_id.required'   => 'O campo system_id é obrigatório.',
            'system_id.integer'    => 'O campo system_id deve ser um número inteiro.',
            'system_id.exists'     => 'O system_id fornecido não existe.',
            'description.required' => 'O campo de descrição é obrigatório.',
            'description.string'   => 'O campo de descrição deve ser uma string.',
            'description.max'      => 'O campo de descrição não pode ter mais de 50 caracteres.',
            'description.min'      => 'O campo de descrição deve ter pelo menos 3 caracteres.',
        ];
    }
}
