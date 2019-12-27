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
            'department' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64']
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
            'department.required' => 'Department name is required.',
            'department.regex' => 'Department name format is invalid.',
            'department.max' => 'Department name should not exceed 64 characters long.',
            'school.required' => 'School name is required.',
            'school.regex' => 'School name format is invalid.',
            'school.max' => 'School name should not exceed 64 characters long.',
            'school.exists' => 'School name does not exists.'
        ];
    }
}
