<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'role' => 'required|string',
            'notification' => 'boolean'
        ];

        if ($this->route()->getName() === 'users.store') {
            $rules['email'] = 'required|email|unique:users,email,NULL,deleted_at';
            $rules['password'] = 'required|min:8';
        } else {
            $rules['email'] = 'required|email|unique:users,email,' . $this->user->id . '';
            $rules['password'] = 'sometimes|required|min:8';
        }

        return $rules;
    }
}
