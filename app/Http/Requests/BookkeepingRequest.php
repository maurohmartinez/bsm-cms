<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookkeepingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'value' => 'required|string',
            'description' => 'required|max:1000',
        ];
    }
}
