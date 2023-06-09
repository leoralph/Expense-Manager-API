<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
                'required',
                'string',
                'max:191'
            ],
            'value' => [
                'required',
                'numeric',
                'min:0',
                'max:2000000000'
            ],
            'date' => [
                'required',
                'date_format:Y-m-d',
                'before_or_equal:today'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => __('validation.before_or_equal_today')
        ];
    }
}
