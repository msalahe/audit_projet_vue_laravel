<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class SyncProjectUsersRequest extends FormRequest
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
        // Validate that 'users' array is present and not empty
        $rules = [
            'users' => ['required', 'array', 'min:1'],
        ];

        // Validate each user ID in the 'users' array
        foreach ($this->input('users', []) as $key => $userId) {
            $rules["users.$key"] = ['required', 'exists:users,id'];
        }

        // Validate that only one 'Leader' role is assigned
        $leaderCount = 0;
        $leaderRoleId = Role::where('name', 'Lead Auditor')->value('id');

        foreach ($this->input('roles', []) as $key => $roleId) {
            $rules["roles.$key"] = ['required', 'exists:roles,id'];

            if ($roleId == $leaderRoleId) {
                $leaderCount++;
            }
        }

        if ($leaderCount > 1) {
            $rules['roles'] = ['required', "Leader roles can't be more than 1."];
        }

        return $rules;
    }
}
