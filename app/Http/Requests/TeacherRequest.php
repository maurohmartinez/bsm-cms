<?php

namespace App\Http\Requests;

use App\Enums\LanguagesEnum;
use App\Services\CountriesService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
            'email' => ['required', 'email', Rule::unique('teachers')->ignore($this->get('id'))],
            'country' => 'required|in:'.implode(',', array_keys(CountriesService::getCountries())),
            'phone' => 'required|phone',
            'language' => 'required|in:'.LanguagesEnum::toString(),
        ];
    }
}
