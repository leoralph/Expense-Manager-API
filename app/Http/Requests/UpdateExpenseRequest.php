<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => [
                'string',
                'max:191'
            ],
            'value' => [
                'numeric',
                'min:0',
                'max:2000000000'
            ],
            'date' => [
                'date_format:Y-m-d',
                'before_or_equal:today'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => __('validation.before_or_equal_today')
        ];
    }
}
