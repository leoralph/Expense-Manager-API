<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensePaginationRequest extends FormRequest
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
            'page' => ['required', 'integer', 'min:1'],
            'per_page' => ['required', 'integer', 'min:1', 'max:100'],
            'sort_by' => ['nullable', 'string', 'in:value,date,description'],
            'sort_direction' => ['nullable', 'string', 'in:asc,desc'],
            'search' => ['nullable', 'string', 'max:191']
        ];
    }
}
