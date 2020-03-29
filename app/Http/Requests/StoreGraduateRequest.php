<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGraduateRequest extends FormRequest
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
                Rule::unique('graduates', 'first_name')->where(function ($query) {
                    return $query->where('last_name', $this->lastname);
                })->ignore($this->temp, 'graduate_id')
            ],
            'lastname' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'midname' => ['regex:/^[A-z\s-]+$/', 'max:64', 'nullable'],
            'gender' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:genders,name', 'max:8'],
            'address' => ['required'],
            'dept' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            'school' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:schools,name', 'max:64'],
            'course' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'major' => ['regex:/^[A-z\s-]+$/', 'max:32', 'nullable'],
            'sy' => ['required', 'exists:years,year', 'size:4',
                    'regex:/^20[0-9]\d|2100$/'],
            'batch' => ['required', 'exists:batches,month', 'max:16'],
            'image' => ['file', 'mimes:jpeg,png']
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
            'firstname.unique' => 'Name of graduate already exists.',
            'firstname.required' => 'First name is required',
            'lastname.required' => 'Last name is required',
            'gender.required' => 'Gender is required.',
            'address.required' => 'Address is required.',
            'dept.required'  => 'Department is required.',
            'school.required' => 'School is required.',
            'course.required' => 'Course is required.',
            'sy.required' => 'School year is required.',
            'batch.required' => 'Batch is required.'
        ];
    }
}
