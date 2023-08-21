<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'full_name' => ['required','unique:users','max:191'],
            'email' => ['required','email','unique:users','max:191'],
            'role' => ['required'],
            'skills' => ['nullable','array'],
            'skills.*.skill' => ['required_with:skills.*.percentage','string','max:191'],
            'skills.*.percentage' => ['required_with:skills.*.skill','integer','between:0,100',],
            'socialLinks' => ['nullable','array'],
            'socialLinks.*.name' => ['required_with:socialLinks.*.link','string','max:191'],
            'socialLinks.*.link' => ['required_with:socialLinks.*.name','url'],
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
            'skills.*.skill.required_with' => 'The skill is empty',
            'skills.*.percentage.required_with' => 'The percentage is empty',
            'skills.*.percentage.integer' => 'The level should be between 0 and 100',
            'skills.*.percentage.between' => 'The level should be between 0 and 100',

            'socialLinks.*.name.required_with' => 'The rs is empty',
            'socialLinks.*.link.required_with' => 'The link is empty',
            'socialLinks.*.link.url' => 'The url is not valid',
        ];
    }
}
