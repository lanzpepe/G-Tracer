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
            'school' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:schools,name', 'max:64'],
            'dept' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:departments,name', 'max:64'],
            'sy' => ['required', 'regex:/^20[0-9]\d-20[0-9]\d|2100$/', 'size:9'],
            'batch' => ['required', 'regex:/^[A-z\s-]+$/', 'exists:batches,name'],
            'file' => ['required', 'mimes:csv,txt']
        ];
    }
}
