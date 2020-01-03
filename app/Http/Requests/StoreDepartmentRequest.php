<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'school' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64', 'exists:schools,name'],
            'dept' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64']
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
            'dept.required' => 'Department name is required.',
            'dept.regex' => 'Department name format is invalid.',
            'dept.max' => 'Department name should not exceed 64 characters long.',
            'school.required' => 'School name is required.',
            'school.regex' => 'School name format is invalid.',
            'school.max' => 'School name should not exceed 64 characters long.',
            'school.exists' => 'School name does not exists.'
        ];
    }
}
