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
                })->ignore($this->userId, 'user_id')
            ],
            'lastname' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'midname' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'gender' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:genders,name', 'max:8'],
            'dob' => ['required', 'regex:/^\d{1,2}\/\d{1,2}\/\d{4}$/', 'size:10'],
            'school' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:schools,name', 'max:64'],
            'dept' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            'username' => ['required', 'max:32', Rule::unique('admins', 'username')->ignore($this->adminId, 'admin_id')],
            'password' => ['required', 'confirmed', 'max:255'],
            'role' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:roles,name', 'max:16']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.required' => 'First name is required.',
            'firstname.regex' => 'First name format is invalid.',
            'firstname.max' => 'First name should not exceed 64 characters long.',
            'firstname.unique' => 'Account name already exists.',
            'lastname.required' => 'Last name is required.',
            'lastname.regex' => 'Last name format is invalid.',
            'lastname.max' => 'Last name should not exceed 64 characters long.',
            'midname.required' => 'Middle name is required.',
            'midname.regex' => 'Middle name format is invalid.',
            'midname.max' => 'Middle name should not exceed 64 characters long.',
            'gender.required' => 'Gender is required.',
            'gender.regex' => 'Gender format is invalid.',
            'gender.exists' => 'Gender does not exists.',
            'gender.max' => 'Gender should not exceed 8 characters long.',
            'dob.required' => 'Birth date is required.',
            'dob.regex' => 'Birth date format is invalid.',
            'dob.size' => 'Birth date should be 10 characters long.',
            'school.required' => 'School name is required.',
            'school.regex' => 'School name format is invalid.',
            'school.unique' => 'School name already exists.',
            'school.max' => 'School name should not exceed 64 characters long.',
            'dept.required' => 'Department name is required.',
            'dept.regex' => 'Department name format is invalid.',
            'dept.exists' => 'Department name does not exists.',
            'dept.max' => 'Department name should not exceed 64 characters long.',
            'username.required' => 'Username is required.',
            'username.max' => 'Username should not exceed 32 characters long.',
            'username.unique' => 'Username already exists. Please try a different username.',
            'password.required' => 'Password is required.',
            'role.required' => 'Role is required.',
            'role.regex' => 'Role format is invalid.',
            'role.exists' => 'Role does not exists.',
            'role.max' => 'Role should not exceed 16 characters long.'
        ];
    }
}
