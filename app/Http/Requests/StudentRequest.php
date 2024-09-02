<?php

namespace App\Http\Requests;

use App\Enums\LanguageLevelsEnum;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'year' => 'exists:years,id',
            'email' => 'required|email',
            'languages.*.LATVIAN' => 'required|in:' . LanguageLevelsEnum::toString(),
            'languages.*.ENGLISH' => 'required|in:' . LanguageLevelsEnum::toString(),
            'languages.*.RUSSIAN' => 'required|in:' . LanguageLevelsEnum::toString(),
            'country' => 'required|min:3',
            'city' => 'required|min:3',
            'birth' => 'required|date',
            'personal_code' => 'required|min:3',
            'passport' => 'required|min:3',
        ];
    }
}
