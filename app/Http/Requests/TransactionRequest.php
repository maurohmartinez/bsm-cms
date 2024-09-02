<?php

namespace App\Http\Requests;

use App\Enums\TransactionTypeEnum;
use App\Models\TransactionCategory;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Backpack\CRUD\app\Library\Validation\Rules\ValidUploadMultiple;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required',
            'transactionCategory' => 'required|exists:transaction_categories,id',
            'customer' => [function (string $attribute, mixed $value, Closure $fail) {
                /** @var TransactionCategory $category */
                $category = TransactionCategory::query()->find($this->get('transactionCategory'));
                if ($category?->type === TransactionTypeEnum::INCOME && $category?->type === 3 && empty($value)) {
                    $fail('The customer field is required.');
                }
            }],
            'student' => [function (string $attribute, mixed $value, Closure $fail) {
                /** @var TransactionCategory $category */
                $category = TransactionCategory::query()->find($this->get('transactionCategory'));
                if ($category?->id === 3 && empty($value)) {
                    $fail('The student field is required.');
                }
            }],
            'vendor' => [function (string $attribute, mixed $value, Closure $fail) {
                /** @var TransactionCategory $category */
                $category = TransactionCategory::query()->find($this->get('transactionCategory'));
                if ($category?->type === TransactionTypeEnum::EXPENSE && empty($value)) {
                    $fail('The vendor field is required.');
                }
            }],
            'account' => 'required|max:1000',
            'images' => ValidUploadMultiple::field('sometimes|nullable|max:5')
                ->file('file|mimes:jpeg,png,jpg,gif,svg|max:2048'),
            'when' => 'required|date',
            'description' => 'sometimes|nullable|max:1000',
            'type' => 'required|in:' . TransactionTypeEnum::toString(),
        ];
    }
}
