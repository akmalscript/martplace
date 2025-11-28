<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:product_categories,id',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'weight' => 'required|integer|min:1',
            'condition' => 'required|in:new,used',
            'main_photo' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'variations' => 'nullable|array',
        ];
    }
}
