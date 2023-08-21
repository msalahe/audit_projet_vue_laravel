<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIssueRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:191'],
            'description' => ['required'],
            'recommendation' => ['required'],
            'likelihood' => ['required','in:1,2,3'],
            'impact' => ['required','in:-1,0,1,2,3'],
            'category' => ['required_without:new_category'],
            'new_category' => ['required_without:category'],
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
            'category.required_without' => 'Category should be present',
            'new_category.required_without' => 'Category should be present',
        ];
    }
}
