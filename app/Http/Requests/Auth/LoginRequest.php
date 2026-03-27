<?php

declare(strict_types = 1);

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:4'],
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
            'email.required'    => 'O campo de e-mail é obrigatório.',
            'email.email'       => 'O e-mail fornecido não é válido.',
            'email.exists'      => 'O e-mail fornecido não existe.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.string'   => 'A senha deve ser uma string.',
            'password.min'      => 'A senha deve ter pelo menos 4 caracteres.',
        ];
    }
}
