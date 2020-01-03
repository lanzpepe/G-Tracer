<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'school' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:schools,name', 'max:64'],
            'dept' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            'course' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'major' => ['regex:/^[A-z\s-]+$/', 'max:32', 'nullable']
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
            'course.required' => 'Course name is required.',
            'course.regex' => 'Course name format is invalid.',
            'course.max' => 'Course name should not exceed 64 characters long.',
            'major.regex' => 'Major name format is invalid.',
            'major.max' => 'Major name should not exceed 32 characters long.',
            'dept.required' => 'Department name is required.',
            'dept.regex' => 'Department name format is invalid.',
            'dept.max' => 'Department name should not exceed 64 characters long.',
            'dept.exists' => 'Department does not exists',
            'school.required' => 'School name is required.',
            'school.regex' => 'School name format is invalid.',
            'school.max' => 'School name should not exceed 64 characters long.',
            'school.exists' => 'School name does not exists.'
        ];
    }
}
