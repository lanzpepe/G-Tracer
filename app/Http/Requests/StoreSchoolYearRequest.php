<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolYearRequest extends FormRequest
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
            'sy' => ['required', 'unique:academic_years,school_year', 'size:9',
                    'regex:/^20[0-9]\d-20[0-9]\d|2100$/']
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
            'sy.required' => 'School year is required.',
            'sy.unique' => 'School year already exists.',
            'sy.size' => 'School year must be of 9 characters long.',
            'sy.regex' => 'School year format is invalid.'
        ];
    }
}
