<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'surname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'training' => 'nullable|string|max:255',
            'current_status' => 'required|string|max:255',
            'current_status_other' => 'nullable|string|max:255'
        ];

        if ($this->route()->getName() === 'applicants.update') {
            $rules['token'] = 'required|string';
        }

        return $rules;
    }
}
