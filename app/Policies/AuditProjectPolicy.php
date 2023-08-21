<?php

namespace App\Policies;

use App\Models\AuditProject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuditProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AuditProject $auditProject)
    {
        /* isProjectMember or
        isCompleted or
        isAdmin */
        //return  $user->hasRole('Admin') || $auditProject->users->contains($user) || $auditProject->status == 'Completed' || $auditProject->user_id == $user->id;
       return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //isAdmin or isJira
        return  $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AuditProject $auditProject)
    {
        /* (isProjectMember
            or isAdmin ) and
            isNotCompleted */
      //  return  ($user->hasRole('Admin') || $auditProject->users->contains($user) || $auditProject->user_id == $user->id) && $auditProject->status != 'Completed';
    
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AuditProject $auditProject)
    {
       return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AuditProject $auditProject)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject  $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AuditProject $auditProject)
    {
        return false;
    }
}
