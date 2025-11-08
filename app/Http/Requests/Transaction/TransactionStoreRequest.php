<?php

namespace App\Http\Requests\Transaction;

use App\Enums\TransactionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'wallet_id' => ['required', 'exists:wallets,id'],
            'category_id' => ['required', 'exists:user_categories,id'],
            'type' => ['required', Rule::enum(TransactionTypeEnum::class)],
            'store_name' => ['required', 'string', 'max:50'],
            'date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:255'],
            'tax_amount' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],

            // Transaction Items
            'items' => ['nullable', 'array'],
            'items.*.name' => ['required_with:items', 'string', 'max:50'],
            'items.*.quantity' => ['required_with:items', 'numeric', 'min:0'],
            'items.*.price' => ['required_with:items', 'numeric', 'min:0'],
            'items.*.total_amount' => ['required_with:items', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.*.name.required_with' => 'The item name field is required when items are present.',
            'items.*.quantity.required_with' => 'The item quantity field is required when items are present.',
            'items.*.price.required_with' => 'The item price field is required when items are present.',
            'items.*.total_amount.required_with' => 'The item total amount field is required when items are present.',
        ];
    }
}
