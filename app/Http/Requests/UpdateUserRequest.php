<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends StoreUserRequest
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
            'full_name' => ['required', 'unique:users,full_name,' . $this->id, 'max:191'],
            'email' => ['required', 'unique:users,email,' . $this->id, 'max:191'],
            'role' => ['required'],
            'skills.*.skill' => ['required_with:skills.*.percentage','string','max:191'],
            'skills.*.percentage' => ['required_with:skills.*.skill','integer','between:0,100',],
            'socialLinks' => ['nullable','array'],
            'socialLinks.*.name' => ['required_with:socialLinks.*.link','string','max:191'],
            'socialLinks.*.link' => ['required_with:socialLinks.*.name','url'],
        ];
    }
}
