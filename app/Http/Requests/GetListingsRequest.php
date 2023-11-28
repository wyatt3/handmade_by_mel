<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetListingsRequest extends FormRequest
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
            'offset' => 'nullable|integer|min:0',
            'limit' => 'nullable|integer|min:1|max:100',
            'category_id' => 'nullable|integer|min:1',
            'search' => 'nullable|string',
        ];
    }
}
