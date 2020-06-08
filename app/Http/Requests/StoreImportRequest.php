<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImportRequest extends FormRequest
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
            '_school' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:schools,name', 'max:64'],
            '_dept' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            '_course' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:courses,name', 'max:64'],
            '_major' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:courses,major', 'max:32'],
            '_sy' => ['required', 'regex:/^20[0-9]\d|2100$/', 'size:4'],
            '_batch' => ['required', 'exists:batches,month', 'max:16'],
            '_file' => ['required', 'file', 'mimes:csv,txt']
        ];
    }
}
