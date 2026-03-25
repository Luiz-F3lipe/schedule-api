<?php

declare(strict_types = 1);

namespace App\Http\Requests\Password;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'department_id' => ['nullable', 'integer', 'exclude_if:department_id,0', 'exclude_if:department_id,null', 'exists:departments,id'],
            'product_id'    => ['nullable', 'integer', 'exclude_if:product_id,0', 'exclude_if:product_id,null', 'exists:products,id'],
            'description'   => ['required', 'string', 'max:255', 'min:3'],
            'password'      => ['required', 'string', 'max:255', 'min:3'],
            'observation'   => ['nullable', 'string', 'max:255'],
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
            'department_id.integer' => 'O campo department_id deve ser um inteiro.',
            'department_id.exists'  => 'O campo department_id deve existir na tabela departments.',
            'product_id.integer'    => 'O campo product_id deve ser um inteiro.',
            'product_id.exists'     => 'O campo product_id deve existir na tabela products.',
            'description.required'  => 'O campo description é obrigatório.',
            'description.string'    => 'O campo description deve ser uma string.',
            'description.max'       => 'O campo description não pode ter mais de 255 caracteres.',
            'description.min'       => 'O campo description deve ter pelo menos 3 caracteres.',
            'password.required'     => 'O campo password é obrigatório.',
            'password.string'       => 'O campo password deve ser uma string.',
            'password.max'          => 'O campo password não pode ter mais de 255 caracteres.',
            'password.min'          => 'O campo password deve ter pelo menos 3 caracteres.',
            'observation.string'    => 'O campo observation deve ser uma string.',
            'observation.max'       => 'O campo observation não pode ter mais de 255 caracteres.',
        ];
    }
}
