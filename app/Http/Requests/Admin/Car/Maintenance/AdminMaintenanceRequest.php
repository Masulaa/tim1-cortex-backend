<?php

namespace App\Http\Requests\Admin\Car\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class AdminMaintenanceRequest extends FormRequest
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
            'car_id' => 'required|exists:cars,id',
            'scheduled_date' => 'required|date|after:today',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,under maintenance,completed',
        ];
    }
}
