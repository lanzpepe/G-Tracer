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
            'department' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            'course' => ['required', 'regex:/^[A-z\s-]+$/', 'max:64'],
            'major' => ['regex:/^[A-z\s-]+$/', 'max:32', 'nullable']
        ];
    }
}
