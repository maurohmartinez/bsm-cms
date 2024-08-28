<?php

namespace App\Http\Requests;

use App\Enums\BookkeepingTypeEnum;
use App\Models\BookkeepingCategory;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Backpack\CRUD\app\Library\Validation\Rules\ValidUploadMultiple;

class BookkeepingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required',
            'bookkeepingCategory' => 'required|exists:bookkeeping_categories,id',
            'customer' => [function (string $attribute, mixed $value, Closure $fail) {
                /** @var BookkeepingCategory $category */
                $category = BookkeepingCategory::query()->find($this->get('bookkeepingCategory'));
                if ($category?->type === BookkeepingTypeEnum::INCOME && empty($value)) {
                    $fail('The customer field is required.');
                }
            }],
            'vendor' => [function (string $attribute, mixed $value, Closure $fail) {
                /** @var BookkeepingCategory $category */
                $category = BookkeepingCategory::query()->find($this->get('bookkeepingCategory'));
                if ($category?->type === BookkeepingTypeEnum::EXPENSE && empty($value)) {
                    $fail('The vendor field is required.');
                }
            }],
            'account' => 'required|max:1000',
            'images' => ValidUploadMultiple::field('sometimes|nullable|max:5')
                ->file('file|mimes:jpeg,png,jpg,gif,svg|max:2048'),
            'when' => 'required|date',
            'description' => 'sometimes|nullable|max:1000',
            'type' => 'required|in:' . BookkeepingTypeEnum::toString(),
        ];
    }
}
