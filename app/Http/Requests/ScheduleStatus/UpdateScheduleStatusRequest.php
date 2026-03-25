<?php

declare(strict_types = 1);

namespace App\Http\Requests\ScheduleStatus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleStatusRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:30', 'min:3'],
            'color'       => ['required', 'string', 'size:7'],
            'active'      => ['required', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'description.string'   => 'A descrição deve ser uma string.',
            'description.max'      => 'A descrição deve ter no máximo 30 caracteres.',
            'description.min'      => 'A descrição deve ter no mínimo 3 caracteres.',
            'color.required'       => 'A cor é obrigatória.',
            'color.string'         => 'A cor deve ser uma string.',
            'color.size'           => 'A cor deve ter exatamente 7 caracteres.',
            'active.required'      => 'O status ativo é obrigatório.',
            'active.boolean'       => 'O status ativo deve ser verdadeiro ou falso.',
        ];
    }
}
