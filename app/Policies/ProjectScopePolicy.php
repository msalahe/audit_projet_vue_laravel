<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AuditProject;
use App\Models\ProjectScope;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectScopePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user,AuditProject  $auditProject)
    {
        return  $user->hasRole('Admin') || $auditProject->users->contains($user) || $auditProject->status == 'Completed' || $auditProject->user_id == $user->id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectScope  $projectScope
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProjectScope $projectScope)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user,AuditProject  $auditProject)
    {
        /* (isProjectMember
        or isAdmin ) and
        isNotCompleted */
        return  ($user->hasRole('Admin') || $auditProject->users->contains($user) || $auditProject->user_id == $user->id) && $auditProject->status != 'Completed';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectScope  $projectScope
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProjectScope $projectScope)
    {
        /* (isProjectMember
        or isAdmin ) and
        isNotCompleted */
        return  ($user->hasRole('Admin') || $projectScope->auditProject->users->contains($user) || $projectScope->auditProject->user_id == $user->id) && $projectScope->auditProject->status != 'Completed';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectScope  $projectScope
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProjectScope $projectScope)
    {
        /* (isProjectMember
        or isAdmin ) and
        isNotCompleted */
        return  ($user->hasRole('Admin') || $projectScope->auditProject->users->contains($user) || $projectScope->auditProject->user_id == $user->id) && $projectScope->auditProject->status != 'Completed';

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectScope  $projectScope
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProjectScope $projectScope)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectScope  $projectScope
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProjectScope $projectScope)
    {
        //
    }
}
