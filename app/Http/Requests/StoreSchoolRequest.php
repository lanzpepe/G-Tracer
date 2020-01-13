<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
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
            'school' => ['bail', 'required', 'regex:/^[A-z\s-]+$/', 'unique:schools,name', 'max:64'],
            'logo' => ['mimes:jpeg,png']
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
            'school.required' => 'School name is required.',
            'school.regex' => 'School name format is invalid.',
            'school.unique' => 'School name already exists.',
            'school.max' => 'School name should not exceed 64 characters long.'
        ];
    }
}
