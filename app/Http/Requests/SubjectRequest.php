<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'color' => 'required|string',
            'year_id' => 'required|exists:years,id',
            'hours' => 'required|numeric',
            'notes' => 'sometimes|nullable|max:2000',
            'files.*' => 'sometimes|nullable|file',
            'is_official' => 'required|boolean',
            'teacher_id' => 'required|exists:teachers,id',
//            'studentGrades.*.student' => 'required_with:id',
            'studentGrades.*.participation' => 'required_with|numeric|min:0|max:100',
            'studentGrades.*.exam' => 'required_with|numeric|min:0|max:100',
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
