<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id'=>'required|exists:products,id',
            'quantity' => 'required|numeric|gt:0',
            'weight' => 'required|numeric|gt:0',
            'expiring_date'=>'required|date'
        ];
    }
    public function messages(): array
    {
        return [
            'product_id.required' => 'Product is required.',
            'quantity.required' => 'Quantity is required.',
            'quantity.gt' => 'Quantity must be at least 1',
            'weight.required' => 'Weight is required.',
            'weight.gt' => 'Weight must be at least 1',
            'expiring_date.required' => 'expiring_date is required.',
            'expiring_date.date' => 'The expiring date is not a valid date.',
        ];
    }
}

