<?php

declare(strict_types = 1);

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255', 'min:4'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:4'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    #[\Override]
    public function messages()
    {
        return [
            'name.required'          => 'O campo nome é obrigatório.',
            'name.string'            => 'O nome deve ser uma string.',
            'name.max'               => 'O nome não pode ter mais de 255 caracteres.',
            'name.min'               => 'O nome deve ter pelo menos 4 caracteres.',
            'email.required'         => 'O campo e-mail é obrigatório.',
            'email.string'           => 'O e-mail deve ser uma string.',
            'email.email'            => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.max'              => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique'           => 'Este e-mail já está em uso.',
            'password.required'      => 'O campo senha é obrigatório.',
            'password.string'        => 'A senha deve ser uma string.',
            'password.min'           => 'A senha deve ter pelo menos 4 caracteres.',
            'department_id.required' => 'O campo departamento é obrigatório.',
            'department_id.integer'  => 'O departamento deve ser um número inteiro.',
            'department_id.exists'   => 'O departamento selecionado é inválido.',
        ];
    }
}
