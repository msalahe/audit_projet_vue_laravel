<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'projet_name' => ['required','string','max:191'],
            'client_name' => ['required','string','max:191'],
            'start_date' => ['required','date'],
            'finish_date' => ['required','date','after:start_date'],
            'description' => ['required']
        ];
    }
}
