<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],

            'shipping_address' => ['required', 'array'],
            'shipping_address.line_1' => ['required', 'string'],
            'shipping_address.line_2' => ['nullable', 'string'],
            'shipping_address.line_3' => ['nullable', 'string'],
            'shipping_address.line_4' => ['nullable', 'string'],
            'shipping_address.city' => ['required', 'string'],
            'shipping_address.state' => ['required', 'string'],
            'shipping_address.postal_code' => ['required', 'string'],

            'billing_address' => ['required', 'array'],
            'billing_address.line_1' => ['required', 'string'],
            'billing_address.line_2' => ['nullable', 'string'],
            'billing_address.line_3' => ['nullable', 'string'],
            'billing_address.line_4' => ['nullable', 'string'],
            'billing_address.city' => ['required', 'string'],
            'billing_address.state' => ['required', 'string'],
            'billing_address.postal_code' => ['required', 'string'],

            'items' => ['required', 'array'],
            'items.*.quantity' => ['required', 'min:1'],
            'items.*.product.id' => ['required', 'exists:products,id', function ($attribute, $productId, $fail) {

                $index = str_replace('.product.id', '', str_replace('items.', '', $attribute));
                $variations = request()->input("items.$index.variations.*.product_id") ?? [];

                foreach ($variations as $variation) {
                    if ($variation !== $productId) {
                        $fail('Product variation does not match product.');
                    }
                }
            }],
            'items.*.variations' => ['nullable', 'array'],
            'items.*.variations.*.id' => ['required', 'exists:product_variations,id'],
            'items.*.variations.*.product_id' => ['required', 'exists:products,id',],

        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors' => 'An error occurred while processing your order. Please try again.'
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
