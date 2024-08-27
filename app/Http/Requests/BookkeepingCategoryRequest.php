<?php

namespace App\Http\Requests;

use App\Enums\BookkeepingTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class BookkeepingCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'type' => 'required|in:' . BookkeepingTypeEnum::toString(),
        ];
    }
}
