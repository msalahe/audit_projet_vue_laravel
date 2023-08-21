<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectBestPracticeRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:191'],
            'description' => ['required'],
            'status' => ['nullable', 'in:Not Fixed,Fixed,Mitigated,Acknowledged,Partially Fixed'],
            'state' => ['nullable', 'in:Draft,Approved,Pending,Duplicated,Not Approved,Fixes']
        ];
    }
}
