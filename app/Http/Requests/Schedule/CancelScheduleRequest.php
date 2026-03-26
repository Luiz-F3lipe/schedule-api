<?php

declare(strict_types = 1);

namespace App\Http\Requests\Schedule;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CancelScheduleRequest extends FormRequest
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
            'canceled_at'     => ['required', 'date'],
            'canceled_reason' => ['required', 'string', 'max:255', 'min:10'],
        ];
    }
}
