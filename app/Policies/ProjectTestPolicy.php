<?php

namespace App\Policies;

use App\Models\AuditProject;
use App\Models\ProjectTest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectTestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, AuditProject $auditProject)
    {
        /* isProjectMember or
        isAdmin ) and
        isNotCompleted */
        return $user->can('update',$auditProject);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectTest  $projectTest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProjectTest $projectTest)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AuditProject $auditProject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, AuditProject $auditProject)
    {
       /*  isProjectMember or
        isAdmin ) or
        isCompleted   */
        return $user->can('view',$auditProject);

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectTest  $projectTest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProjectTest $projectTest)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectTest  $projectTest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProjectTest $projectTest)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectTest  $projectTest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProjectTest $projectTest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProjectTest  $projectTest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProjectTest $projectTest)
    {
        //
    }
}
