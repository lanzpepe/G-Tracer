<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64',
                Rule::unique('users', 'first_name')->where(function ($query) {
                    return $query->where('last_name', $this->lastname);
                }
            )->ignore($this->userId, 'user_id')],
            'midname' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'gender' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:genders,name', 'max:8'],
            'dob' => ['required', 'regex:/^\d{1,2}\/\d{1,2}\/\d{4}$/', 'size:10'],
            'school' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:schools,name', 'max:32'],
            'department' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            'username' => ['required', 'max:32', Rule::unique('admins', 'username')->ignore($this->adminId, 'admin_id')],
            'password' => ['required', 'confirmed', 'max:255'],
            'role' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:roles,name', 'max:16']
        ];
    }

    /**
     * Custom messages for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.unique' => 'The account name has already been taken.'
        ];
    }
}
