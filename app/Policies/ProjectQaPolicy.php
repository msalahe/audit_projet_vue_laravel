<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProjectQa;
use App\Models\AuditProject;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectQaPolicy
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
        /* isProjectMember or
        isAdmin */
        return  $user->hasRole('Admin') || $auditProject->users->contains($user)|| $auditProject->user_id == $user->id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectQa  $projectQa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProjectQa $projectQa)
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
        /* isProjectMember or
        isAdmin ) and
        isNotCompleted */
        $user->can('update',$auditProject);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectQa  $projectQa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProjectQa $projectQa)
    {
        /* isProjectMember or
        isAdmin ) and
        isNotCompleted */
        $user->can('update',$projectQa->project);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectQa  $projectQa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProjectQa $projectQa)
    {
         /* isProjectMember or
        isAdmin ) and
        isNotCompleted */
        $user->can('update',$projectQa->project);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectQa  $projectQa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProjectQa $projectQa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectQa  $projectQa
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProjectQa $projectQa)
    {
        //
    }
}
