<?php

namespace App\Http\Requests\Admin\Car\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class AdminReservationUpdateRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
        ];
    }
}
