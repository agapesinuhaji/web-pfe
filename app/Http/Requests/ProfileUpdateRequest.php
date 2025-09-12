<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'domicile' => 'nullable|string|max:255',
            'no_whatsapp' => 'nullable|string|max:25',
            'gender' => ['nullable', 'in:L,P'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
