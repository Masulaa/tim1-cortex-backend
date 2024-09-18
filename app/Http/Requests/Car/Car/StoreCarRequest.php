<?php

namespace App\Http\Requests\Car\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'transmission' => 'required|string|max:255',
            'fuel_type' => 'required|string|max:255',
            'doors' => 'required|integer|min:1|max:6',
            'price_per_day' => 'required|numeric|min:0|max:999999.99',
            'availability' => 'required|boolean',
            'status' => 'required|string|in:available,in use,returned',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
