<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectGradesRequest extends FormRequest
{
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'studentGrades.*.student' => 'required',
            'studentGrades.*.participation' => 'required|min:0|max:100',
            'studentGrades.*.exam' => 'required|min:0|max:100',
        ];
    }
}
