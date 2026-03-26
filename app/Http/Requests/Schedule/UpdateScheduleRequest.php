<?php

declare(strict_types = 1);

namespace App\Http\Requests\Schedule;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'client_id'          => ['required', 'integer'],
            'client_name'        => ['required', 'string', 'max:255', 'min:3'],
            'product_id'         => ['required', 'integer', 'exists:products,id'],
            'department_id'      => ['required', 'integer', 'exists:departments,id'],
            'responsible_by'     => ['required', 'integer', 'exists:users,id'],
            'scheduled_at'       => ['required', 'date', 'date_format:Y-m-d'],
            'initial_time'       => ['required', 'string'],
            'final_time'         => ['nullable', 'string'],
            'schedule_status_id' => ['required', 'integer', 'exists:schedule_status,id'],
            'description'        => ['nullable', 'string'],
            'created_by'         => ['required', 'integer', 'exists:users,id'],
        ];
    }

    /**
    * Get custom messages for validator errors.
    *
    * @return array<string, string>
    */
    public function messages(): array
    {
        return [
            'client_id.required'          => 'O campo client_id é obrigatório.',
            'client_id.integer'           => 'O campo client_id deve ser um número inteiro.',
            'client_name.required'        => 'O campo client_name é obrigatório.',
            'client_name.string'          => 'O campo client_name deve ser uma string.',
            'client_name.max'             => 'O campo client_name deve ter no máximo 255 caracteres.',
            'client_name.min'             => 'O campo client_name deve ter no mínimo 3 caracteres.',
            'product_id.required'         => 'O campo product_id é obrigatório.',
            'product_id.integer'          => 'O campo product_id deve ser um número inteiro.',
            'product_id.exists'           => 'O campo product_id deve existir na tabela products.',
            'department_id.required'      => 'O campo department_id é obrigatório.',
            'department_id.integer'       => 'O campo department_id deve ser um número inteiro.',
            'department_id.exists'        => 'O campo department_id deve existir na tabela departments.',
            'responsible_by.required'     => 'O campo responsible_by é obrigatório.',
            'responsible_by.integer'      => 'O campo responsible_by deve ser um número inteiro.',
            'responsible_by.exists'       => 'O campo responsible_by deve existir na tabela users.',
            'scheduled_at.required'       => 'O campo scheduled_at é obrigatório.',
            'scheduled_at.date_format'    => 'O campo scheduled_at deve estar no formato Y-m-d.',
            'initial_time.required'       => 'O campo initial_time é obrigatório.',
            'initial_time.date_format'    => 'O campo initial_time deve estar no formato H:i.',
            'final_time.date_format'      => 'O campo final_time deve estar no formato H:i.',
            'final_time.after'            => 'O campo final_time deve ser uma hora posterior a initial_time.',
            'schedule_status_id.required' => 'O campo schedule_status_id é obrigatório.',
            'schedule_status_id.integer'  => 'O campo schedule_status_id deve ser um número inteiro.',
            'schedule_status_id.exists'   => 'O campo schedule_status_id deve existir na tabela schedule_status.',
            'description.string'          => 'O campo description deve ser uma string.',
            'created_by.required'         => 'O campo created_by é obrigatório.',
            'created_by.integer'          => 'O campo created_by deve ser um número inteiro.',
            'created_by.exists'           => 'O campo created_by deve existir na tabela users.',
        ];
    }
}
