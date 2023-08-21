<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Skill;
use App\Models\ProjectUser;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct()
    {
    }

    public function create(StoreUserRequest $request)
    {

        try {
            $role = $this->getRole($request->role);
            $this->validateRole($role);

            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'role_id' => $role->id,
            ]);

            if ($request->has('skills')) {
                $this->syncUserSkills($user, $request->skills);
            }

            if ($request->has('socialLinks')) {
                $this->updateOrCreateSocialLinks($user, $request->socialLinks);
            }

            return response()->json([
                'status' => 'success',
                'user' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            logger(' Error storing user ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing ' . $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $user = User::with(['skills', 'socialLinks', 'role', 'userIssues'])
                ->withCount([
                    'userIssues' => function (Builder $query) {
                        $query->approved();
                    },
                ])
                ->findOrFail($id)
                ->append('stats');
            $projects =  ProjectUser::with(['user', 'role'])
                ->whereHas('user', function ($q) use ($id) {
                    $q->where('id', $id);
                })
                ->whereHas('role', function ($q) {
                    $q->whereIn('name', ['Auditor', 'Lead Auditor']);
                })
                ->get()
                ->groupBy('role.name');
            foreach ($projects as $key => $value) {
                $p[$key] = $value->map(function ($item) {
                    return [
                        'id' => $item->rp->id,
                        'name' => $item->rp->name,
                    ];
                })->toArray();
            }

            return response()->json([
                'status' => 'success',
                'user' => new UserResource($user),
                'projects' => $p ?? []
            ]);
        } catch (\Exception $e) {
            logger(' Error finding user ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'User not found ' . $e->getMessage(),
            ], 400);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $role = $this->getRole($request->role);
            $this->validateRole($role);

            $user = User::findOrFail($id);
            $user->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'role_id' => $role->id,
            ]);

            if ($request->has('skills')) {
                $this->syncUserSkills($user, $request->skills);
            }

            if ($request->has('socialLinks')) {
                $this->updateOrCreateSocialLinks($user, $request->socialLinks);
            }

            return response()->json([
                'status' => 'success',
                'user' => new UserResource($user->load('skills', 'socialLinks'))
            ]);
        } catch (\Exception $e) {
            logger(' Error updating user ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating user ' . $e->getMessage(),
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id)->delete();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            logger(' Error deleting user ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting',
            ], 400);
        }
    }

    private function syncUserSkills($user, $skills): void
    {
        $dbSkills = Skill::whereIn('name', array_column($skills, 'skill'))->select('id', 'name')->distinct('name')->get()->pluck('id', 'name')->toArray();
        $skills = collect($skills);
        $pivotData = $skills->mapWithKeys(function ($value, $key) use ($dbSkills) {
            return [$dbSkills[$value['skill']] => ['level' => $value['percentage']]];
        });
        $user->skills()->sync($pivotData->toArray());
    }

    private function updateOrCreateSocialLinks($user, $socialLinks): void
    {
        foreach ($socialLinks as $key => $value) {
            $user->socialLinks()->updateOrCreate(
                ['rs_name' => $value['name'], 'rs_link' => $value['link']],
                ['rs_name' => $value['name'], 'rs_link' => $value['link']]
            );
        };
    }

    private function getRole($role): Role|bool
    {

        $role = Role::find($role);
        if (!$role) {
            return false;
        }
        return $role;
    }

    private function validateRole($role)
    {
        if (!$role) {
            throw ValidationException::withMessages(['role' => 'Role not found']);
        }
    }
}
