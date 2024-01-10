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
            'items.*.id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'min:1'],
        ];
    }
}
