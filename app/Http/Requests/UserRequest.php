<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
             'name' => 'required|min:5|max:255',
             'email' => 'required|unique:users,email|email',
        ];
    }
}
