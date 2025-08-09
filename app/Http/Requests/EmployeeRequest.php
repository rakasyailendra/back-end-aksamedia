<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Izinkan semua user yang terautentikasi untuk membuat request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id', // Pastikan division_id ada di tabel divisions
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opsional, maks 2MB
        ];
    }
}
