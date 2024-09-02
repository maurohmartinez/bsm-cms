<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'first_period_starts_at' => 'required|date|before:first_period_ends_at',
            'first_period_ends_at' => 'required|date|after:first_period_starts_at',
            'second_period_starts_at' => 'required|date|after:first_period_ends_at',
            'second_period_ends_at' => 'required|date|after:second_period_starts_at',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
